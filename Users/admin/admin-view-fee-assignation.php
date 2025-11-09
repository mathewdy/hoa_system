<?php
include('../../connection/connection.php'); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Assignation</title>
    <style>
        input[readonly] { background-color: #f0f0f0; border: 1px solid #ccc; }
        label { display: inline-block; width: 100px; }
        .fee-row { margin-bottom: 15px; }
    </style>
</head>
<body>

<h2>Fee Assignation</h2>

<?php
if(!isset($_GET['user_id'])) {
    echo "<p>No user selected.</p>";
    exit;
}

$user_id = $_GET['user_id'];

$sql_total = "SELECT total_balance FROM unpaid_fees WHERE user_id = '$user_id'";
$res_total = mysqli_query($conn, $sql_total);
$total_balance = 0;
if($res_total && mysqli_num_rows($res_total) > 0) {
    $row_total = mysqli_fetch_assoc($res_total);
    $total_balance = $row_total['total_balance'];
}

$sql_fees = "SELECT fa.id, fa.fee_type_id, fa.next_due, fa.is_paid,
                    ft.fee_name, ft.amount
             FROM fee_assignation fa
             JOIN fee_type ft ON fa.fee_type_id = ft.fee_type_id
             WHERE fa.user_id = '$user_id'
             ORDER BY ft.fee_name ASC";
$res_fees = mysqli_query($conn, $sql_fees);

if(mysqli_num_rows($res_fees) == 0) {
    echo "<p>No fees found for this user.</p>";
} else {
?>

<form action="../../Query/pay-balance.php" method="POST">
    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

    <?php while($row = mysqli_fetch_assoc($res_fees)): ?>
        <div class="fee-row">
            <input type="checkbox" name="selected_fees[]" value="<?php echo $row['id']; ?>" <?php echo $row['is_paid'] ? 'disabled' : ''; ?>>

            <label>Fee Name:</label>
            <input type="text" value="<?php echo $row['fee_name']; ?>" readonly>

            <label>Date:</label>
            <input type="text" value="<?php echo date('M d, Y', strtotime($row['next_due'])); ?>" readonly>

            <label>Amount:</label>
            <input type="text" value="<?php echo $row['amount']; ?>" readonly>

            <label>Status:</label>
            <input type="text" value="<?php echo $row['is_paid'] ? 'Paid' : 'Unpaid'; ?>" readonly>
        </div>
    <?php endwhile; ?>

    <label for="">Payment Method:</label>
    <select name="payment_method" required>
        <option value="">Select Payment Method</option>
        <option value="Cash">Cash</option>
        <option value="Bank Transfer">Bank Transfer</option>
        <option value="Check">Check</option>
    </select>

    <label for="">Payment Receipt Name</label>
    <input type="text" name="payment_receipt_name" required><br><br>
    <label for="">Remarks:</label>
    <input type="text" name="remarks"><br><br>

    <label>Total Unpaid Fees:</label>
    <input type="text" value="<?php echo $total_balance; ?>" readonly><br><br>

    <button type="submit" name="mark_as_paid">Mark Selected as Paid</button>
</form>

<?php } ?>

</body>
</html>
