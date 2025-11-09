<?php

include('../../connection/connection.php'); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$user_id = $_SESSION['user_id'];


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Payment History</h1>

    <?php

    if(isset($_GET['user_id'])){
        $user_id = $_GET['user_id'];
        $sql_history = " SELECT fa.user_id, fa.next_due, fa.is_paid, ft.fee_name, ft.cadence, fa.payment_method, fa.payment_receipt_name, fa.remarks
        FROM fee_assignation fa
        JOIN fee_type ft 
            ON fa.fee_type_id = ft.fee_type_id
        WHERE fa.user_id = '$user_id'
        AND fa.is_paid = 1
        ORDER BY fa.next_due DESC;";
        $run_history = mysqli_query($conn, $sql_history);

        if(mysqli_num_rows($run_history) > 0) {
            foreach($run_history as $row_history){
                ?>

                    <span><?php 
                    if($row_history['cadence'] == 1) {
                        echo "Cadence: Monthly";
                    } else {
                        echo "Cadence: One-time";
                    }
                    ?>
                    </span>
                    <br>

                    <label for="">Fee Name:</label>
                    <span><?php echo $row_history['fee_name']; ?></span>
                    <br>
                    <label for="">Due Date:</label>
                    <span><?php echo (date('M d, Y', strtotime($row_history['next_due']))); ?></span>
                    <br>
                    <label for="">Payment Method:</label>
                    <span><?php echo $row_history['payment_method']; ?></span>
                    <br>
                    <label for="">Receipt Name:</label>
                    <span><?php echo $row_history['payment_receipt_name']; ?></span>
                    <br>
                    <label for="">Remarks:</label>
                    <span><?php echo $row_history['remarks']; ?></span>
                    <br>
                    <hr>
                    <span>
                  
                    <br><br>
                <?php
            }
        }else{
            echo "<p>No payment history found for this user.</p>";
        }
    }

    

    ?>
</body>
</html>