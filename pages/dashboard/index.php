<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';

require_once $root . 'config.php';
require_once $root . 'app/includes/session.php';

$userRole = $_SESSION['role'] ?? 0;
$isAdminOrPresident = in_array($userRole, [1, 3]);
$pageTitle = 'Users';
$a = $_GET['a'] ?? '0';
ob_start();

?>
  <h1>Dashboard works!</h1>

<?php
$content = ob_get_clean();

$pageScripts = '

';

require_once $root . '/pages/layout.php';
?>