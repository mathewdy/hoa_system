<?php
// File: /hoa_system/app/api/users/put.accountSettings.php

require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';

if (!isset($_POST['update']) || !isset($_POST['user_id'])) {
    json_error('Invalid request', 400);
}

$user_id       = $_POST['user_id'];
$email         = trim($_POST['email_address'] ?? '');
$password      = $_POST['password'] ?? '';  // can be empty
$role_id       = $_POST['role_id'] ?? null; // optional (only admin should change)

$sql = "UPDATE users SET email_address = ?";
$params = [$email];
$types  = "s";

// Only update password if provided and not empty
if (!empty($password)) {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $sql .= ", password = ?";
    $params[] = $hashed;
    $types .= "s";
}

// Only update role if provided (and you're admin)
if ($role_id !== null && in_array($_SESSION['role'], [1, 3])) { // 1=Admin, 3=President
    $sql .= ", role_id = ?";
    $params[] = $role_id;
    $types .= "i";
}

$sql .= " WHERE user_id = ?";
$params[] = $user_id;
$types .= "s";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    json_success([], 'Account settings updated successfully!');
} else {
    json_error('Failed to update account');
}

$stmt->close();
?>