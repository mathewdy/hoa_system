<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php');

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
  if (password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['role'] = $user['role_id'];

    if ($user['is_first_time']) {
        echo json_encode([
            'success' => true,
            'firstTime' => true,
            'message' => 'First time login. Please change your password.'
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'firstTime' => false,
            'message' => 'Login successful.'
        ]);
    }
  } else {
    echo json_encode(['success' => false, 'message' => 'Incorrect password.']);
  }
} else {
  echo json_encode(['success' => false, 'message' => 'User does not exist.']);
}

mysqli_close($conn);
?>
