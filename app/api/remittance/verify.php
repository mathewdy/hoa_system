<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';
require_once $root . 'config.php';
include_once($root . 'app/core/init.php');

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

if (!isset($_POST['remittance_id']) || !isset($_POST['action'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required parameters.']);
    exit;
}

$remittance_id = intval($_POST['remittance_id']);
$action = $_POST['action']; 

try {
    $conn->begin_transaction();


    if ($action === "approve") {
        $stmt = $conn->prepare("UPDATE remittance SET is_approved = 1 WHERE id = ?");
        $stmt->bind_param("i", $remittance_id);
        if (!$stmt->execute()) throw new Exception("Failed to approve remittance.");

        $tables = [
            "homeowner_fees",
            "toda_fees",
            "stall_renter_fees",
            "court_fees"
        ];

        foreach ($tables as $table) {
            $q = $conn->prepare("UPDATE $table SET is_remitted = 1 WHERE id = ?");
            $q->bind_param("i", $remittance_id);
            if (!$q->execute()) throw new Exception("Failed to update $table.");
        }

        $conn->commit();

        echo json_encode([
            'success' => true,
            'message' => 'Remittance approved successfully!'
        ]);
        exit;
    }

    elseif ($action === "reject") {

        $stmt = $conn->prepare("UPDATE remittance SET status = 2 WHERE id = ?");
        $stmt->bind_param("i", $remittance_id);

        if (!$stmt->execute()) {
            throw new Exception("Failed to reject remittance.");
        }

        $conn->commit();

        echo json_encode([
            'success' => true,
            'message' => 'Remittance has been rejected.'
        ]);
        exit;
    }

    // Invalid action
    else {
        throw new Exception("Invalid action value.");
    }

} catch (Exception $e) {

    $conn->rollback();

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
    exit;
}
?>
