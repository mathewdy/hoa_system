<?php
ob_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';

if (!isset($_SESSION['user_id'])) {
    json_error('Unauthorized access.', 401);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_error('Invalid request method.', 405);
}

$required = ['fee_ids', 'total_amount_paid', 'payment_method', 'reference_number'];
foreach ($required as $field) {
    if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
        json_error(ucwords(str_replace('_', ' ', $field)) . ' is required.');
    }
}

$fee_ids            = $_POST['fee_ids'];  
$amount_paid         = (float)$_POST['total_amount_paid'];
$payment_method      = trim($_POST['payment_method']);
$reference_number    = trim($_POST['reference_number']);
$notes               = trim($_POST['notes'] ?? '');
$created_by          = $_SESSION['user_id'];
$is_walk_in          = $_POST['is_walk_in'] ?? 0;

$fee_ids = array_map('intval', $fee_ids);
if (empty($fee_ids)) {
    json_error('No fees selected.');
}

$attachment_path = null;
if ($is_walk_in != 1) {
    if (!isset($_FILES['attachment']) || $_FILES['attachment']['error'] == UPLOAD_ERR_NO_FILE) {
        json_error('Proof of payment is required for online payments.');
    }

    $file = $_FILES['attachment'];
    if ($file['error'] !== UPLOAD_ERR_OK) {
        json_error('File upload error.');
    }

    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) {
        json_error('Invalid file type. Only JPG, PNG, GIF, PDF allowed.');
    }
    if ($file['size'] > 10 * 1024 * 1024) { 
        json_error('File too large. Max 10MB.');
    }

    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/assets/img/proofs/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

    $filename = 'proof_' . time() . '_' . rand(1000,9999) . '.' . $ext;
    $filepath = $upload_dir . $filename;

    if (!move_uploaded_file($file['tmp_name'], $filepath)) {
        json_error('Failed to save attachment.');
    }
    $attachment_path = '/hoa_system/uploads/proofs/' . $filename;
}

$placeholders = str_repeat('?,', count($fee_ids) - 1) . '?';
$sql = "SELECT SUM(amount) AS total_due FROM fees WHERE id IN ($placeholders) AND status IN (0,2)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, str_repeat('i', count($fee_ids)), ...$fee_ids);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$db_total = (float)($row['total_due'] ?? 0);

if ($amount_paid < $db_total * 0.95) {
    json_error("Amount paid (₱" . number_format($amount_paid,2) . ") is less than total due (₱" . number_format($db_total,2) . ").");
}

mysqli_begin_transaction($conn);

try {
    foreach ($fee_ids as $fee_id) {
        $sql = "INSERT INTO payment_verification 
                (fee_id, created_by, payment_method, reference_number, amount_paid, 
                 attachment, notes, is_walk_in, is_approved, date_created)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, NOW())";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param(
            $stmt, 'iisssssi',
            $fee_id,
            $created_by,
            $payment_method,
            $reference_number,
            $amount_paid_per_fee = $amount_paid / count($fee_ids),
            $attachment_path,
            $notes,
            $is_walk_in
        );
        mysqli_stmt_execute($stmt);

        $update_sql = "UPDATE fees SET status = 3 WHERE id = ?";
        $ustmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($ustmt, 'i', $fee_id);
        mysqli_stmt_execute($ustmt);
    }

    mysqli_commit($conn);
    

    json_success([
        'message' => 'All payments submitted for verification!',
        'total_fees' => count($fee_amount),
        'total_paid' => $amount_paid,
        'user_id' => $fee_ids[0] ? get_user_id_from_fee($fee_ids[0]) : null
    ]);

} catch (Exception $e) {
    mysqli_rollback($conn);
    if ($attachment_path && file_exists($_SERVER['DOCUMENT_ROOT'] . $attachment_path)) {
        unlink($_SERVER['DOCUMENT_ROOT'] . $attachment_path);
    }
    json_error('Transaction failed. Please try again.');
}