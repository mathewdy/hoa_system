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
  $where = "AND (full_name LIKE ? OR email_address LIKE ?)";
  $params = ["%$search%", "%$search%", "%$search%"];
  $types = 'sss';
}

$totalSql = "SELECT COUNT(*) AS total 
  FROM users u 
  LEFT JOIN user_info i ON u.user_id = i.user_id 
  LEFT JOIN roles r ON u.role_id = r.id
  WHERE u.role_id = 6 $where";

$totalStmt = mysqli_prepare($conn, $totalSql);
if ($types) {
    $refs = []; foreach ($params as $k => $v) $refs[$k] = &$params[$k];
    call_user_func_array([$totalStmt, 'bind_param'], array_merge([$types], $refs));
}
mysqli_stmt_execute($totalStmt);
$total = mysqli_fetch_assoc(mysqli_stmt_get_result($totalStmt))['total'];
$totalPages = ceil($total / $limit);

$sql = "
  SELECT 
    u.id, 
    u.user_id, 
    CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) AS fullName,
    us.email_address,
    SUM(fa.amount) AS total_unpaid_amount,
    CASE 
        WHEN COUNT(CASE WHEN fa.status = 0 THEN 1 END) > 0 THEN 0
        ELSE 1
    END AS status,
    fa.due_date
  FROM fee_assignments fa
  LEFT JOIN user_info u ON fa.user_id = u.user_id
  LEFT JOIN users us ON u.user_id = us.user_id
  $where
  GROUP BY u.user_id, u.first_name, u.middle_name, u.last_name, u.suffix
  ORDER BY u.last_name, u.first_name
  LIMIT ? 
  OFFSET ?";

$stmt = mysqli_prepare($conn, $sql);

$bindParams = array_merge($params, [$limit, $offset]);
$bindTypes = $types . 'ii';
$refs = []; foreach ($bindParams as $k => $v) $refs[$k] = &$bindParams[$k];

call_user_func_array(
    [$stmt, 'bind_param'],
    array_merge([$bindTypes], $refs)
);

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

json_success([
    'data' => $users,
    'pagination' => [
        'totalRecords' => (int)$total,
        'totalPages' => $totalPages,
        'currentPage' => $page,
        'limit' => $limit
    ]
]);