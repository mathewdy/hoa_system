<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/connection/connection.php');

header('Content-Type: application/json');

$sql = "SELECT * FROM roles";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$roles = [];
while ($row = mysqli_fetch_assoc($result)) {
    $roles[] = $row;
}

echo json_encode([
    'success' => true,
    'data' => $roles,
    'pagination' => [
        'totalRecords' => $totalRecords,
        'totalPages' => $totalPages,
        'currentPage' => $page,
        'limit' => $limit
    ]
]);

mysqli_close($conn);
?>
