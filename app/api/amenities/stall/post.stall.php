<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$required = ['stall_no', 'status'];
foreach ($required as $field) {
    if (empty(trim($_POST[$field] ?? ''))) {
        echo json_encode(['success' => false, 'message' => ucfirst(str_replace('_', ' ', $field)) . ' is required']);
        exit;
    }
}

$stall_no = trim($_POST['stall_no']);
$status   = trim($_POST['status']); 

try {
    $conn->begin_transaction();

    $stmt = $conn->prepare("
        INSERT INTO stalls (stall_no, status)
        VALUES (?, ?)
    ");
    $stmt->bind_param("ss", $stall_no, $status);
    $stmt->execute();
    $stmt->close();

    $conn->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Stall created successfully!',
        'data' => ['stall_no' => $stall_no]
    ]);

} catch (Exception $e) {
    $conn->rollback();

    echo json_encode([
        'success' => false,
        'message' => 'DB Error: ' . $e->getMessage()
    ]);
}
?>
