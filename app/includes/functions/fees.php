<?php 
function assignMonthlyFeesToUser($conn, $user_id) {
  $due_date = date('Y-m-d', strtotime('first day of next month'));
  $query = "SELECT id, fee_name, amount 
  FROM fee_type WHERE `status` = 1";
  
  $result = $conn->query($query);

  if ($result->num_rows === 0) {
    return true;
  }
  $status = 0;
  $stmt = $conn->prepare("
    INSERT INTO fee_assignments
    (user_id, fee_type_id, amount, status, due_date, date_created)
    VALUES (?, ?, ?, ?, ?, NOW())
  ");
  
  while ($fee = $result->fetch_assoc()) {
    $stmt->bind_param(
      "sidis",
      $user_id,
      $fee['id'],
      $fee['amount'],
      $status,
      $due_date
    );
    $stmt->execute();
  }

  $stmt->close();
  $result->free();
  return true;
}
?>