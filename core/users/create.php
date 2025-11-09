<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/connection/connection.php');
header('Content-Type: application/json');
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', $_SERVER['DOCUMENT_ROOT'].'/hoa_system/error.log');

function sendResponse($success, $message) {
    echo json_encode([
        'success' => $success,
        'message' => $message
    ]);
    exit;
}

function generateUserId() { 
    return '2025' . rand(1, 10) . substr(str_shuffle(str_repeat('0123456789', 5)), 0, 3);
}

if (isset($_POST['create_account'])) {
    $user_id       = generateUserId();
    $first_name    = $_POST['first_name'] ?? '';
    $middle_name   = $_POST['middle_name'] ?? '';
    $last_name     = $_POST['last_name'] ?? '';
    $name_suffix   = $_POST['name_suffix'] ?? '';
    $email         = $_POST['email'] ?? '';
    $age           = $_POST['age'] ?? '';
    $phone         = '+63' . ($_POST['phone'] ?? '');
    $date_of_birth = $_POST['date_of_birth'] ?? '';
    $citizenship   = $_POST['citizenship'] ?? '';
    $civil_status  = $_POST['civil_status'] ?? '';
    $lot_number    = $_POST['lot_number'] ?? '';
    $block_number  = $_POST['block_number'] ?? '';
    $phase_number  = $_POST['phase_number'] ?? '';
    $village_name  = $_POST['village_name'] ?? '';
    $hoa_number    = $_POST['hoa_number'] ?? '';
    $role_id       = $_POST['role'];
    $sql = "INSERT INTO users (
                role_id, user_id, first_name, middle_name, last_name, suffix,
                email_address, hoa_number, phone_number, age, date_of_birth,
                citizenship, civil_status, account_status, home_address,
                lot_number, block_number, phase_number, village_name,
                date_created
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, NULL, ?, ?, ?, ?, NOW()
            )";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        sendResponse(false, 'Prepare failed: ' . mysqli_error($conn));
    }

    mysqli_stmt_bind_param(
        $stmt,
        "issssssssissssssss",
        $roleHandler, $user_id, $first_name, $middle_name, $last_name, $name_suffix,
        $email, $hoa_number, $phone, $age, $date_of_birth, $citizenship,
        $civil_status, $lot_number, $block_number,
        $phase_number, $village_name
    );

    if (mysqli_stmt_execute($stmt)) {
        sendResponse(true, 'Admin account created successfully!');
    } else {
        sendResponse(false, 'Error creating admin account: ' . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

// sendResponse(false, 'Invalid request.');
