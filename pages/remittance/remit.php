<?php 
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';
require_once $root . 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';

if (isset($_GET['action'])) {

    // Fetch all approved, unsubmitted payments
    $sql_fetch = "SELECT * FROM payment_verification WHERE is_submitted = 0 AND is_approve = 1";
    $result_fetch = mysqli_query($conn, $sql_fetch);

    if ($result_fetch && mysqli_num_rows($result_fetch) > 0) {

        $secretary_name = "Secretary Name"; // replace with dynamic value if available

        while ($row = mysqli_fetch_assoc($result_fetch)) {

            $user_id = intval($row['created_by']); // or $row['user_id'] if available
            $particular = "Monthly Fees"; // adjust if you have fee_name
            $amount = floatval($row['amount_paid']);
            $date = date('Y-m-d H:i:s');
            $transaction_type = "Collection";
            $is_approved = 1;

            // Insert into remittance table
            $sql_insert = "INSERT INTO remittance 
                (user_id, particular, amount, date, transaction_type, secretary_name, is_approved)
                VALUES ('$user_id', '$particular', '$amount', '$date', '$transaction_type', '$secretary_name', '$is_approved')";

            mysqli_query($conn, $sql_insert);

            // Update is_submitted in payment_verification
            $sql_update = "UPDATE payment_verification SET is_submitted = 1 WHERE id = ".$row['id'];
            mysqli_query($conn, $sql_update);
        }

        echo "<script>alert('Fees Remitted')</script>";
        echo "<script>window.location.href='index.php'</script>";

    } else {
        echo "<script>alert('No approved payments to remit.')</script>";
        echo "<script>window.location.href='index.php'</script>";
    }
}
?>
