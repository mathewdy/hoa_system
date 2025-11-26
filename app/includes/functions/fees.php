<?php 
function assignMonthlyFeesToUser($conn, $user_id) {
  $next_due_date = date('Y-m-d', strtotime('first day of next month'));
  $query = "SELECT id, due_name, amount 
  FROM monthly_dues WHERE `status` = 1";
  
  $result = $conn->query($query);

  if ($result->num_rows === 0) {
    return true;
  }

  $stmt = $conn->prepare("
    INSERT INTO fees
    (user_id, due_id, fee_type_id, fee_name, amount, status, next_due_date, date_created)
    VALUES (?, ?, 1, ?, ?, 0, ?, NOW())
  ");
  
  while ($fee = $result->fetch_assoc()) {
    $stmt->bind_param(
      "sisds",
      $user_id,
      $fee['id'],
      $fee['due_name'],
      $fee['amount'],
      $next_due_date
    );
    $stmt->execute();
  }

  $stmt->close();
  $result->free();
  return true;
}
?>