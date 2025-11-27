<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';

header('Content-Type: application/json');

// Must be POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
    exit;
}

// Validate required fields
$required = ['booking_id', 'renter', 'contact_no', 'amount', 'date_start', 'date_end'];

foreach ($required as $field) {
    if (empty($_POST[$field])) {
        echo json_encode([
            'success' => false,
            'message' => ucfirst(str_replace('_', ' ', $field)) . ' is required.'
        ]);
        exit;
    }
}

// Sanitize / Collect data
$booking_id          = intval($_POST['booking_id']);
$renter              = trim($_POST['renter']);
$contact_no          = trim($_POST['contact_no']);
$amount              = floatval($_POST['amount']);
$date_start          = $_POST['date_start'];
$date_end            = $_POST['date_end'];
$participants        = !empty($_POST['no_of_participants']) ? intval($_POST['no_of_participants']) : null;
$purpose             = !empty($_POST['purpose']) ? trim($_POST['purpose']) : null;

try {
    // Prepare SQL
    $sql = "
        UPDATE court SET 
            renter = ?, 
            contact_no = ?, 
            amount = ?, 
            date_start = ?, 
            date_end = ?, 
            no_of_participants = ?, 
            purpose = ?
        WHERE id = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssdssisi",
        $renter,
        $contact_no,
        $amount,
        $date_start,
        $date_end,
        $participants,
        $purpose,
        $booking_id
    );
    
    $result = $stmt->execute();

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Court booking updated successfully!'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to update booking.'
        ]);
    }

    $stmt->close();
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>
