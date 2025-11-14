<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/connection/connection.php');

header('Content-Type: application/json');

$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

$where = '';
$params = [];
$types = '';

if (!empty($search)) {
    $where = "WHERE fee_name LIKE ? OR amount LIKE ? OR start_date LIKE ?)";
    $searchParam = "%$search%";
    $params = [$searchParam, $searchParam];
    $types = "ss";
}

$totalQuery = "SELECT COUNT(*) AS total FROM fee_type $where";
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

$sql = "SELECT *
  FROM fee_type
  $where
  LIMIT ? 
  OFFSET ?";

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

$feeTypes = [];
while ($row = mysqli_fetch_assoc($result)) {
    $feeTypes[] = $row;
}

echo json_encode([
    'success' => true,
    'data' => $feeTypes,
    'pagination' => [
        'totalRecords' => $totalRecords,
        'totalPages' => $totalPages,
        'currentPage' => $page,
        'limit' => $limit
    ]
]);

mysqli_close($conn);
