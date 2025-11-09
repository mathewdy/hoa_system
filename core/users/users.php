<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/connection/connection.php');

header('Content-Type: application/json');

$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10; 
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;  

if ($page < 1) $page = 1;

$offset = ($page - 1) * $limit;

$totalQuery = "SELECT COUNT(*) AS total FROM users";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalRecords = $totalRow['total'];

$totalPages = ceil($totalRecords / $limit);

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
  LIMIT ? OFFSET ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $limit, $offset);
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
?>
