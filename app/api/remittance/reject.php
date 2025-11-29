<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';
require_once $root . 'config.php';
include_once($root . 'app/core/init.php');

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

if (!isset($_POST['remittance_id'])) {
    echo json_encode(['success' => false, 'message' => 'Missing remittance ID.']);
    exit;
}

$remittance_id = intval($_POST['remittance_id']);

try {
    $conn->begin_transaction();

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

} catch (Exception $e) {
    $conn->rollback();

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
    exit;
}
?>
