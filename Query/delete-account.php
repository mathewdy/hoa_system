<?php

include('../connection/connection.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_GET['user_id'])){
    $user_id = $_GET['user_id'];

    $sql_delete_account = "DELETE FROM users WHERE user_id = '$user_id'";
    $run_sql_delete_account = mysqli_query($conn, $sql_delete_account);

    if(!$run_sql_delete_account){
      die("Query failed: " . mysqli_error($conn));
    }

    if($run_sql_delete_account){
      echo "<script>alert('Account deleted successfully!');</script>";
      echo"<script>window.location.href='../Users/president/president-create-accounts.php';</script> ";
    }else{
      echo "<script>alert('Error deleting account: " . mysqli_error($conn) . "');</script>";
    }
}
?>