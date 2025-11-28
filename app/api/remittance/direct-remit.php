<?php
// app/api/remittance/direct-remit.php
require_once $_SERVER['DOCUMENT_ROOT'].'/hoa_system/app/core/init.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$amount           = (float)($data['amount'] ?? 0);
$date             = $data['date'] ?? '';
$transaction_type = $data['transaction_type'] ?? 'Credit';
$particular       = $data['particular'] ?? "Today's HOA Collected Fee"; // ← safe na kahit may 's
$user_id          = $_SESSION['user_id'];

if ($amount <= 0 || empty($date)) {
    echo json_encode(['success' => false, 'message' => 'Invalid amount or date']);
    exit;
}

$stmt = $conn->prepare("
    INSERT INTO remittance
    (user_id, particular, amount, date, transaction_type, is_approved, date_created) 
    VALUES (?, ?, ?, ?, ?, 0, NOW())
");

$stmt->bind_param(
    "ssdss", 
    $user_id,
    $particular,
    $amount,
    $date,
    $transaction_type,
);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Remitted successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>