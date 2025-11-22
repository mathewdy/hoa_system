<?php 
function assignMonthlyFeesToUser($conn, $user_id) {
  $next_due_date = date('Y-m-d', strtotime('first day of next month'));
  $query = "SELECT id, due_name, amount 
  FROM monthly_dues";
  
  $result = $conn->query($query);
  $fee_id = "2025".rand('1','10') . substr(str_shuffle(str_repeat("0123456789", 5)), 0, 3);

  if ($result->num_rows === 0) {
    return true;
  }

  $stmt = $conn->prepare("
    INSERT INTO fees
    (fee_id, user_id, due_id, fee_type_id, fee_name, amount, status, next_due_date, date_created)
    VALUES (?, ?, ?, 1, ?, ?, 0, ?, NOW())
  ");
  
  while ($fee = $result->fetch_assoc()) {
    $stmt->bind_param(
      "ssisds",
      $fee_id,
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