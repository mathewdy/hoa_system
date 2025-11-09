<?php
include('../connection/connection.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['mark_as_paid'])) {

    $user_id = $_POST['user_id'] ?? '';
    $selected_fees = $_POST['selected_fees'] ?? [];
    $payment_method = $_POST['payment_method'];
    $payment_receipt_name = $_POST['payment_receipt_name'] ;
    $remarks = $_POST['remarks'] ;

    if(empty($user_id)) {
        echo "<script>alert('Missing user ID.'); window.history.back();</script>";
        exit;
    }

    if(empty($selected_fees)) {
        echo "<script>alert('Please select at least one fee to pay.'); window.history.back();</script>";
        exit;
    }

    $ids = implode(',', array_map('intval', $selected_fees));

    $update_sql = "UPDATE fee_assignation 
                   SET is_paid = 1, payment_method = '$payment_method', payment_receipt_name = '$payment_receipt_name', remarks = '$remarks', date_updated = NOW() 
                   WHERE id IN ($ids) AND user_id = '$user_id'";
    $update_result = mysqli_query($conn, $update_sql);
    if(!$update_result) {
        die("Update failed: " . mysqli_error($conn));
    }

    $sum_sql = "SELECT SUM(ft.amount) AS total_balance
                FROM fee_assignation fa
                JOIN fee_type ft ON fa.fee_type_id = ft.fee_type_id
                WHERE fa.user_id='$user_id' AND fa.is_paid = 0";
    $sum_res = mysqli_query($conn, $sum_sql);
    $sum_row = mysqli_fetch_assoc($sum_res);
    $total_balance = $sum_row['total_balance'] ?? 0;

    $check_unpaid = mysqli_query($conn, "SELECT 1 FROM unpaid_fees WHERE user_id='$user_id'");
    if(mysqli_num_rows($check_unpaid) > 0) {
        mysqli_query($conn, "UPDATE unpaid_fees 
                             SET total_balance='$total_balance', date_updated=NOW() 
                             WHERE user_id='$user_id'");
    } else {
        mysqli_query($conn, "INSERT INTO unpaid_fees (user_id, total_balance, date_created, date_updated)
                             VALUES ('$user_id', '$total_balance', NOW(), NOW())");
    }

    echo "<script>alert('Selected fees marked as paid successfully!'); window.location.href='../Users/admin/fee-assignation.php?user_id=$user_id';</script>";
    exit;
}
?>
