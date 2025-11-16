<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';

if (!isset($_SESSION['user_id'])) {
    json_error('Unauthorized', 401);
}
$user_id = $_SESSION['user_id'];

$sql = "SELECT u.user_id, u.email_address, u.status,
        i.first_name, 
        i.last_name,
        CONCAT(i.first_name, ' ', i.middle_name, ' ', i.last_name) AS fullName,
        
        r.name AS role
        FROM users u
        LEFT JOIN user_info i ON u.user_id = i.user_id
        LEFT JOIN hoa_info h ON u.user_id = h.user_id
        LEFT JOIN roles r ON u.role_id = r.id
        WHERE u.user_id = ? LIMIT 1";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    json_success([
        'data' => [
            'user_id'    => $row['user_id'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'fullName'   => $row['fullName'],
            'email'      => $row['email_address'],
            'role'       => $row['role'],
            'status'     => $row['status'],
            // 'avatar'     => BASE_URL . '/assets/img/user-alt-64.png'
        ]
    ]);
} else {
    json_error('User not found', 404);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
