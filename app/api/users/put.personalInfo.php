<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';


if (isset($_POST['update'])) {
    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $birthdate = $_POST['birthdate'];
    $citizenship = $_POST['citizenship'];
    $civil_status = $_POST['civil_status'];

    $update_query = "UPDATE user_info SET
        first_name = '$first_name',
        middle_name = '$middle_name',
        last_name = '$last_name',
        phone_number = '$phone',
        date_of_birth = '$birthdate',
        citizenship = '$citizenship',
        civil_status = '$civil_status'
        WHERE user_id = '$user_id'";

    $result = $conn->query($update_query);

    if ($result) {
        $updated_data = [
            'first_name' => $first_name,
            'middle_name' => $middle_name,
            'last_name' => $last_name,
            'phone' => $phone,
            'date_of_birth' => $birthdate,
            'citizenship' => $citizenship,
            'civil_status' => $civil_status
        ];

        echo json_encode([
            'success' => true,
            'message' => 'Personal information updated successfully.',
            'data' => $updated_data,
            'user_id' => $user_id
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to update user information.',
            'error' => 'Database update error'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No update request found.',
        'error' => 'Missing update parameter'
    ]);
}
?>
