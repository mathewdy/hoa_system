<?php 
  session_start();

  if(session_destroy()) {
    unset($_SESSION['user_id']);
    header("Location: /hoa_system/index.php");
    exit();
  }
?>