<?php 
  session_start();

  include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/config.php');
  
  if(!empty($_SESSION)) {
    header('Location:' . BASE_PATH . 'app/pages/dashboard.php');
  }else{
    header('Location:' . BASE_PATH . 'app/public/index.php');
  } 

?>