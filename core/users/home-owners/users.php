<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/connection/connection.php');

header('Content-Type: application/json');

$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

$where = '';
$roleQuery = 'WHERE role_id = 6';
$params = [];
$types = '';

if (!empty($search)) {
    $where = "WHERE CONCAT(first_name, ' ', middle_name, ' ', last_name) LIKE ? OR email_address LIKE ?";
    $roleQuery = "AND role_id = 6";
    $searchParam = "%$search%";
    $params = [$searchParam, $searchParam];
    $types = "ss";
}

// Total records
$totalQuery = "SELECT COUNT(*) AS total FROM users $where $roleQuery";
$totalStmt = mysqli_prepare($conn, $totalQuery);

if (!empty($params)) {
    $refs = [];
    foreach ($params as $key => $value) {
        $refs[$key] = &$params[$key];
    }
    call_user_func_array([$totalStmt, 'bind_param'], array_merge([$types], $refs));
}

mysqli_stmt_execute($totalStmt);
$totalResult = mysqli_stmt_get_result($totalStmt);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $limit);

// Fetch users
$sql = "SELECT 
    u.id, 
    u.user_id, 
    u.role_id, 
    CONCAT(first_name, ' ', middle_name, ' ', last_name) as fullName, 
    u.email_address,
    u.account_status,
    r.id,
    r.name as role_name,
    CASE 
      WHEN account_status = 1 THEN 'Active'
      ELSE 'Inactive'
    END AS status
  FROM users u 
  LEFT JOIN roles r ON u.role_id = r.id
  $where
  $roleQuery
  LIMIT ? OFFSET ?";

$stmt = mysqli_prepare($conn, $sql);

$paramsForBind = array_merge($params, [$limit, $offset]);
$refs = [];
foreach ($paramsForBind as $key => $value) {
    $refs[$key] = &$paramsForBind[$key];
}

call_user_func_array(
    [$stmt, 'bind_param'],
    array_merge([$types . "ii"], $refs)
);

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

echo json_encode([
    'success' => true,
    'data' => $users,
    'pagination' => [
        'totalRecords' => $totalRecords,
        'totalPages' => $totalPages,
        'currentPage' => $page,
        'limit' => $limit
    ]
]);

mysqli_close($conn);
