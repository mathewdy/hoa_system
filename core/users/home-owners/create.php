<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/connection/connection.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['create_account'])) {
    $user_id = "2025" . rand(1, 10) . substr(str_shuffle(str_repeat("0123456789", 5)), 0, 3);
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $name_suffix = $_POST['name_suffix'];
    $role = intval($_POST['role']);
    $email = $_POST['email'];
    $age = intval($_POST['age']);
    $phone = '+639' . $_POST['phone'];
    $date_of_birth = $_POST['date_of_birth'];
    $citizenship = $_POST['citizenship'];
    $civil_status = $_POST['civil_status'];
    $home_address = $_POST['home_address'];
    $lot_number = $_POST['lot_number'];
    $block_number = $_POST['block_number'];
    $phase_number = $_POST['phase_number'];
    $village_name = $_POST['village_name'];
    $hoa_number = NULL;
    $password = 'MabuhayHomes@2025';
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $sql_create_account = "INSERT INTO users (
        role_id, user_id, first_name, middle_name, last_name, suffix,
        email_address, `password`, hoa_number, phone_number, age, date_of_birth, citizenship,
        civil_status, account_status, home_address, lot_number, block_number,
        phase_number, village_name, is_first_time, date_created, date_updated
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, ?, ?, ?, ?, ?, 1, NOW(), NOW())";

    $stmt = mysqli_prepare($conn, $sql_create_account);

    if ($stmt) {
        mysqli_stmt_bind_param(
            $stmt,
            "issssssssissssssss",
            $role,
            $user_id,
            $first_name,
            $middle_name,
            $last_name,
            $name_suffix,
            $email,
            $hashed,
            $hoa_number,
            $phone,
            $age,
            $date_of_birth,
            $citizenship,
            $civil_status,
            $home_address,
            $lot_number,
            $block_number,
            $phase_number,
            $village_name
        );

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true, 'message' => 'Account created successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error creating account: ' . mysqli_stmt_error($stmt)]);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare statement: ' . mysqli_error($conn)]);
    }
}

