<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';

if (!isset($_POST['update']) || !isset($_POST['user_id'])) {
    json_error('Invalid request', 400);
}

$user_id      = $_POST['user_id'];
$hoa_number   = trim($_POST['hoa_number'] ?? '');
$home_address = trim($_POST['home_address'] ?? '');
$lot          = trim($_POST['lot'] ?? '');
$block        = trim($_POST['block'] ?? '');
$phase        = trim($_POST['phase'] ?? '');
$village      = trim($_POST['village'] ?? '');

// Step 1: Check if record exists
$check = $conn->prepare("SELECT user_id FROM hoa_info WHERE user_id = ?");
$check->bind_param("s", $user_id);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    // Record exists → UPDATE
    $stmt = $conn->prepare("
        UPDATE hoa_info 
        SET hoa_number = ?, home_address = ?, lot = ?, block = ?, phase = ?, village = ?
        WHERE user_id = ?
    ");
    $stmt->bind_param("sssssss", $hoa_number, $home_address, $lot, $block, $phase, $village, $user_id);
    $action = "updated";
} else {
    // No record → INSERT
    $stmt = $conn->prepare("
        INSERT INTO hoa_info 
        (user_id, hoa_number, home_address, lot, block, phase, village)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("sssssss", $user_id, $hoa_number, $home_address, $lot, $block, $phase, $village);
    $action = "created";
}

$check->close();

if ($stmt->execute()) {
    json_success([], "Home details $action successfully!");
} else {
    json_error('Failed to save home details');
}

$stmt->close();
?>