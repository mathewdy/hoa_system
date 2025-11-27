<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$required = [
    'due_name',
    'amount',
];

foreach ($required as $field) {
    if (empty(trim($_POST[$field] ?? ''))) {
        echo json_encode([
            'success' => false, 
            'message' => ucfirst(str_replace('_', ' ', $field)) . ' is required'
        ]);
        exit;
    }
}

$due_name     = trim($_POST['due_name']);
$amount       = floatval($_POST['amount']);
$status       = 1;  

try {

    $stmt = $conn->prepare("
        INSERT INTO monthly_dues 
        (due_name, amount, status, date_created)
        VALUES (?, ?, ?, NOW())
    ");

    $stmt->bind_param(
        "sdi", 
        $due_name,
        $amount,
        $status,
    );

    $stmt->execute();
    $new_id = $stmt->insert_id;
    $stmt->close();

    echo json_encode([
        'success' => true,
        'message' => 'Due created successfully!',
        'data' => ['id' => $new_id]
    ]);

} catch (Exception $e) {

    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>