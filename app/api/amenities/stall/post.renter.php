<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$required = [
    'renter_name',
    'contact_no',
    'stall_id',
    'date_start',
    'date_end',
    'amount',
    'status'
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

$renter       = trim($_POST['renter_name']);
$contact_no   = trim($_POST['contact_no']);
$stall_id     = intval($_POST['stall_id']);
$date_start   = $_POST['date_start'];
$date_end     = $_POST['date_end'];
$amount       = floatval($_POST['amount']);
$status       = trim($_POST['status']);

try {

    $stmt = $conn->prepare("
        INSERT INTO stall_rent
        (renter, contact_no, stall_id, date_start, date_end, amount, status, date_created)
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
    ");

    $stmt->bind_param(
        "ssissds",
        $renter,
        $contact_no,
        $stall_id,
        $date_start,
        $date_end,
        $amount,
        $status
    );

    $stmt->execute();
    $new_id = $stmt->insert_id;
    $stmt->close();

    echo json_encode([
        'success' => true,
        'message' => 'Stall rental record created successfully!',
        'data' => ['id' => $new_id]
    ]);

} catch (Exception $e) {

    echo json_encode([
        'success' => false,
        'message' => 'DB Error: ' . $e->getMessage()
    ]);
}
?>
