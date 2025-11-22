<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}
$action = $_POST['action'] ?? 1;
$user_id = $_POST['user_id'] ?? null;
if (!$user_id || !is_numeric($user_id)) {
    echo json_encode(['success' => false, 'message' => 'Invalid user ID']);
    exit;
}

$sql = "UPDATE users SET `status` = ? WHERE user_id";
$params = [$action, $user_id];
$types = "si";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
    exit;
}

$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Account settings updated successfully!',
        'data' => ['email_address' => $email]
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to update account'
    ]);
}

$stmt->close();
$conn->close();
exit;
?>