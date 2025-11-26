<?php
ob_clean();

require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';

$limit  = (int)($_GET['limit'] ?? 10);
$page   = max(1, (int)($_GET['page'] ?? 1));
$search = trim($_GET['search'] ?? '');
$offset = ($page - 1) * $limit;

// if (!isset($_GET['id']) || empty(trim($_GET['id']))) {
//     json_error('User ID required', 400);
// }

$id = trim($_GET['id']);

$where = '';
$params = [];
$types = '';

if ($search !== '') {
    $where = "AND (CONCAT(i.first_name, ' ', i.middle_name, ' ', i.last_name) LIKE ? OR u.email_address LIKE ?)";
    $params = ["%$search%", "%$search%"];
    $types = 'ss';
}

// Count total homeowners (not fees)
$totalSql = "SELECT COUNT(*) AS total 
    FROM fees f 
    WHERE user_id = $id $where";

$totalStmt = mysqli_prepare($conn, $totalSql);
if ($types) {
    $refs = [];
    foreach ($params as $k => $v) $refs[$k] = &$params[$k];
    call_user_func_array([$totalStmt, 'bind_param'], array_merge([$types], $refs));
}
mysqli_stmt_execute($totalStmt);
$total = mysqli_fetch_assoc(mysqli_stmt_get_result($totalStmt))['total'];
$totalPages = ceil($total / $limit);

$sql = "SELECT 
          f.id,
          f.user_id,
          f.fee_name,
          f.status,
          f.next_due_date,
          f.date_created,
          m.due_name,
          m.amount,
          CONCAT(i.first_name, ' ', COALESCE(i.middle_name,''), ' ', i.last_name) AS full_name
        FROM fees f 
        LEFT JOIN monthly_dues m ON f.due_id = m.id
        LEFT JOIN user_info i ON f.user_id = i.user_id
        WHERE f.user_id = $id $where
        ORDER BY `status` DESC
        LIMIT ? OFFSET ?";

$stmt = mysqli_prepare($conn, $sql);

$bindParams = array_merge($params, [$limit, $offset]);
$bindTypes = $types . 'ii';
$refs = [];
foreach ($bindParams as $k => $v) $refs[$k] = &$bindParams[$k];

call_user_func_array([$stmt, 'bind_param'], array_merge([$bindTypes], $refs));
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$homeowners = [];

$fees = [];
while ($row = mysqli_fetch_assoc($result)) {
  $row['status'] = match ((int)$row['status']) {
      0 => 'Pending',
      1 => 'Paid',
      2 => 'Overdue',
      3 => 'Waived',
      4 => 'Cancelled',
      default => 'Unknown',
  };
  $fees[] = $row;
}


json_success([
    'data' => $fees,
    'pagination' => [
        'totalRecords' => (int)$total,
        'totalPages'   => $totalPages,
        'currentPage'  => $page,
        'limit'        => $limit
    ]
]);