<?php 
  include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/config.php');

  echo '
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="'. BASE_PATH . '/assets/js/utils/pw-toggle.js" type="module"></script>
    <script src="'. BASE_PATH . '/assets/js/utils/toast.js" type="module"></script>
  ';

  if(!empty($_SESSION['user_id'])) {
    echo '
      <script src="'. BASE_PATH .'/assets/js/profile/fetch.js"></script>
      <script src="'. BASE_PATH .'/assets/js/sidebar.js"></script>
    ';
  }
?>