<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/connection/connection.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/session.php');

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT u.first_name, 
    u.middle_name, 
    u.last_name, 
    u.email_address, 
    r.name AS role
  FROM users u
  JOIN roles r ON u.role_id = r.id
  WHERE u.user_id = ? LIMIT 1";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $full_name = trim($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']);

    echo json_encode([
        'status' => 'success',
        'data' => [
            'first_name'  =>  $row['first_name'],
            'last_name'   =>  $row['last_name'],
            'full_name'   =>  $full_name,
            'email'       =>  $row['email_address'],
            'role'        =>  $row['role'],
            'avatar'      =>  BASE_PATH . '/assets/img/user-alt-64.png'
        ]
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'User not found']);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
