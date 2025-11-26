<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';

$limit  = (int)($_GET['limit'] ?? 10);
$page   = max(1, (int)($_GET['page'] ?? 1));
$search = trim($_GET['search'] ?? '');
$offset = ($page - 1) * $limit;

$where = '';
$params = [];
$types = '';

if ($search !== '') {
    $where = "AND (renter LIKE ? OR contact_no LIKE ?)";
    $params = ["%$search%", "%$search%"];
    $types = 'ss';
}

$totalSql = "SELECT COUNT(*) AS total FROM stall_rent WHERE 1=1 $where";
$totalStmt = mysqli_prepare($conn, $totalSql);
if ($types) {
    $refs = []; foreach ($params as $k => $v) $refs[$k] = &$params[$k];
    call_user_func_array([$totalStmt, 'bind_param'], array_merge([$types], $refs));
}
mysqli_stmt_execute($totalStmt);
$total = mysqli_fetch_assoc(mysqli_stmt_get_result($totalStmt))['total'];
$totalPages = ceil($total / $limit);

$sql = "SELECT 
  sr.id, 
  sr.renter, 
  sr.contact_no, 
  sr.stall_id,
  sr.date_start,
  sr.date_end,
  sr.amount,
  sr.status,
  si.stall_no,
  si.status
  FROM stall_rent sr
  INNER JOIN stalls si ON sr.stall_id = si.id
  WHERE 1=1 $where 
  ORDER BY id DESC 
  LIMIT ? 
  OFFSET ?";
$stmt = mysqli_prepare($conn, $sql);

$bindParams = array_merge($params, [$limit, $offset]);
$bindTypes = $types . 'ii';
$refs = []; foreach ($bindParams as $k => $v) $refs[$k] = &$bindParams[$k];
call_user_func_array([$stmt, 'bind_param'], array_merge([$bindTypes], $refs));

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$rentals = [];
while ($row = mysqli_fetch_assoc($result)) {
    $row['status'] = match((int)$row['status']) {
      0 => 'Pending', 
      1 => 'Paid', 
      2 => 'Overdue', 
      3 => 'Waived', 
      4 => 'Cancelled'
    };
    $rentals[] = $row;
}

json_success([
    'data' => $rentals,
    'pagination' => [
        'totalRecords' => (int)$total,
        'totalPages' => $totalPages,
        'currentPage' => $page,
        'limit' => $limit
    ]
]);
