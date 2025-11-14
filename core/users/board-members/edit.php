<?php
// update.php
include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/config.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/connection/connection.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/session.php');

if (isset($_POST['create_account'])) {
  $user_id = intval($_POST['user_id']);
  $first_name = $_POST['first_name'];
  $middle_name = $_POST['middle_name'];
  $last_name = $_POST['last_name'];
  $suffix = $_POST['name_suffix'];
  $role_id = intval($_POST['role']);
  $email = $_POST['email'];
  $age = intval($_POST['age']);
  $phone = $_POST['phone'];
  $dob = $_POST['date_of_birth'];
  $citizenship = $_POST['citizenship'];
  $civil_status = $_POST['civil_status'];
  $home_address = $_POST['home_address'];
  $lot_number = $_POST['lot_number'];
  $block_number = $_POST['block_number'];
  $phase_number = $_POST['phase_number'];
  $village_name = $_POST['village_name'];

  if (empty($user_id) || empty($first_name) || empty($last_name) || empty($email)) {
      $_SESSION['error'] = "Please fill in all required fields.";
      header("Location: edit.php?user_id=$user_id");
      exit;
  }
  $sql = "UPDATE users SET
    first_name = ?,
    middle_name = ?,
    last_name = ?,
    suffix = ?,
    role_id = ?,
    email_address = ?,
    age = ?,
    phone_number = ?,
    date_of_birth = ?,
    citizenship = ?,
    civil_status = ?,
    home_address = ?,
    lot_number = ?,
    block_number = ?,
    phase_number = ?,
    village_name = ?
  WHERE user_id = ?";

  $stmt = mysqli_prepare($conn, $sql);

  if ($stmt) {
      mysqli_stmt_bind_param(
          $stmt,
          "sssisissssssssssi", 
          $first_name,
          $middle_name,
          $last_name,
          $suffix,
          $role_id,
          $email,
          $age,
          $phone,
          $dob,
          $citizenship,
          $civil_status,
          $home_address,
          $lot_number,
          $block_number,
          $phase_number,
          $village_name,
          $user_id
      );

      if (mysqli_stmt_execute($stmt)) {
          $_SESSION['success'] = "User updated successfully.";
      } else {
          $_SESSION['error'] = "Error updating user: " . mysqli_stmt_error($stmt);
      }

      mysqli_stmt_close($stmt);
  } else {
      $_SESSION['error'] = "Failed to prepare the statement: " . mysqli_error($conn);
  }
  header("Location: edit.php?user_id=$user_id");
  exit;
} else {
    header("Location: /hoa_system/app/pages/user-management/accounts.php");
    exit;
}
