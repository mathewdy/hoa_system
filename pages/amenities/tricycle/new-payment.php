<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$required = ['id', 'amount_paid', 'due_date'];
foreach ($required as $field) {
    if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
        echo json_encode([
            'success' => false,
            'message' => ucfirst(str_replace('_', ' ', $field)) . ' is required.'
        ]);
        exit;
    }
}

$toda_id     = (int)$_POST['id'];
$amount_paid = (float)$_POST['amount_paid'];
$due_date    = $_POST['due_date'];

if ($toda_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid TODA ID.']);
    exit;
}
if ($amount_paid <= 0) {
    echo json_encode(['success' => false, 'message' => 'Amount must be greater than zero.']);
    exit;
}
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $due_date)) {
    echo json_encode(['success' => false, 'message' => 'Invalid due date format.']);
    exit;
}

try {
    $check = $conn->prepare("SELECT id FROM toda WHERE id = ?");
    $check->bind_param("i", $toda_id);
    $check->execute();
    $check->store_result();
    if ($check->num_rows === 0) {
        $check->close();
        echo json_encode(['success' => false, 'message' => 'TODA not found.']);
        exit;
    }
    $check->close();

    $sql = "INSERT INTO toda_fees 
            (toda_id, amount_paid, status, due_date, date_created) 
            VALUES (?, ?, 1, ?, NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ids", $toda_id, $amount_paid, $due_date);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'TODA fee recorded successfully!'
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to record payment.']);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'DB Error: ' . $e->getMessage()]);
}

$conn->close();
?>