<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$required = [
    'renter',
    'contact_no',
    'amount',
    'date_start',
    'date_end',
    'no_of_participants',
    'purpose'
];

foreach ($required as $field) {
    if (empty(trim($_POST[$field] ?? ''))) {
        echo json_encode(['success' => false, 'message' => ucfirst(str_replace('_', ' ', $field)) . ' is required']);
        exit;
    }
}

$renter             = trim($_POST['renter']);
$contact_no         = trim($_POST['contact_no']);
$amount             = floatval($_POST['amount']);
$date_start         = $_POST['date_start'];
$date_end           = $_POST['date_end'];
$no_of_participants = intval($_POST['no_of_participants']);
$purpose            = trim($_POST['purpose']);

try {
    $stmt = $conn->prepare("
        INSERT INTO court 
        (renter, contact_no, amount, date_start, date_end, no_of_participants, purpose, date_created)
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
    ");

    $stmt->bind_param(
        "ssdssis",
        $renter,
        $contact_no,
        $amount,
        $date_start,
        $date_end,
        $no_of_participants,
        $purpose
    );

    $stmt->execute();
    $new_id = $stmt->insert_id;
    $stmt->close();

    echo json_encode([
        'success' => true,
        'message' => 'Record added successfully!',
        'data' => ['id' => $new_id]
    ]);

} catch (Exception $e) {

    echo json_encode([
        'success' => false,
        'message' => 'DB Error: ' . $e->getMessage()
    ]);
}
?>
