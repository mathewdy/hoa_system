<?php

session_start();
include('../../connection/connection.php'); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
    

    <h1>Release Budget </h1>

    <?php


    if(isset($_GET['id'])){
        $id = $_GET['id'];

        $query_project = "SELECT * FROM resolution WHERE id = '$id'";
        $run_project = mysqli_query($conn,$query_project);

        if(mysqli_num_rows($run_project) > 0){
            foreach($run_project  as $row_project){
                ?>

                <form action="../../Query/approve-budget-release.php" method="POST" enctype="multipart/form-data">

                <label for="">Project Resolution Title:</label>
                <input type="text" name="project_resolution_title" value="<?php echo $row_project['project_resolution_title']?>" readonly>
                <label for="">Amount Requested</label>
                <input type="text" name="estimated_budget" value="<?php echo $row_project['estimated_budget']?>" readonly>
                <label for="">Recipient</label>
                <input type="text" name="recipient">
                <label for="">Release Date</label>
                <input type="date" name="release_date">
                <label for="">Payment Method</label>
                <select name="payment_method" id="">
                    <option value="">-Select-</option>
                    <option value="Cash">Cash</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                    <option value="Check">Check</option>
                </select>
                <label for="">Reference Number</label>
                <input type="text" name="reference_number">
                <label for="">Acknowledgement Receipt</label>
                <input type="file" name="acknowledgement_receipt" id="">
                <label for="">Purpose</label>
                <input type="text" name="purpose">
                <label for="">Approval Notes</label>
                <input type="text" name="approval_notes">

                <input type="submit" value="Submit Budget Release" name="budget_release">
                <input type="hidden" name="id" value="<?php echo $row_project['id']?>">

                </form>

                <?php
            }
        }
    }


    ?>


</body>
</html>