<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';
require_once $root . 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';

if (isset($_GET['action']) && isset($_GET['id'])) {
    $payment_id = intval($_GET['id']);
    $action = $_GET['action'];

    $val = $_GET['action'] == 'approve' ? 1 : 3;
    $mess = $_GET['action'] == 'approve' ? 'Approved' : 'Rejected';
  
    $sql = "UPDATE payment_verification SET is_approve = $val WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $payment_id);
    mysqli_stmt_execute($stmt);
    echo "<script>alert('Payment {$mess}')</script>";
    echo "<script>window.location.href='list.php'</script>";
    exit;
}
?>
