<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/connection/connection.php');

header('Content-Type: application/json');

if (!isset($_GET['user_id'])) {
  echo json_encode(['success' => false, 'message' => 'Missing user_id']);
  exit;
}

$user_id = mysqli_real_escape_string($conn, $_GET['user_id']);

$sql = "SELECT * FROM users WHERE user_id = '$user_id' LIMIT 1";
$result = mysqli_query($conn, $sql);

if (!$result) {
  echo json_encode(['success' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
  exit;
}

if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  echo json_encode(['success' => true, 'data' => $row]);
} else {
  echo json_encode(['success' => false, 'message' => 'User not found']);
}
