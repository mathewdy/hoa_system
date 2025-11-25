<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$required = [
    'toda_name',
    'no_of_tricycles',
    'date_start',
    'date_end',
    'representative',
    'contact_no'
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

$toda_name        = trim($_POST['toda_name']);
$no_of_tricycles  = intval($_POST['no_of_tricycles']);
$date_start       = $_POST['date_start'];
$date_end         = $_POST['date_end'];
$representative   = trim($_POST['representative']);
$contact_no       = trim($_POST['contact_no']);

try {

    $stmt = $conn->prepare("
        INSERT INTO tricycle 
        (toda_name, no_of_tricycles, status, date_start, date_end, representative, contact_no, date_created)
        VALUES (?, ?, 1, ?, ?, ?, ?, NOW())
    ");

    $stmt->bind_param(
        "sissss",
        $toda_name,
        $no_of_tricycles,
        $date_start,
        $date_end,
        $representative,
        $contact_no
    );

    $stmt->execute();
    $new_id = $stmt->insert_id;
    $stmt->close();

    echo json_encode([
        'success' => true,
        'message' => 'TODA record created successfully!',
        'data' => ['id' => $new_id]
    ]);

} catch (Exception $e) {

    echo json_encode([
        'success' => false,
        'message' => 'DB Error: ' . $e->getMessage()
    ]);
}
?>
