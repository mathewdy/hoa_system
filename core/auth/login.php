<?php
session_start();
include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/connection/connection.php');
header('Content-Type: application/json');

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
  echo json_encode(['success' => false, 'message' => 'Please fill in all fields.']);
  exit;
}

$sql = "SELECT * FROM users WHERE email_address = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($user = mysqli_fetch_assoc($result)) {
  $_SESSION['user_id'] = $user['user_id'];
  echo json_encode(['success' => true, 'message' => 'User Found.']);
} else {
  echo json_encode(['success' => false, 'message' => 'User not found.']);
}

mysqli_close($conn);
?>
