<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';

header('Content-Type: application/json');

$limit  = (int)($_GET['limit'] ?? 10);
$page   = max(1, (int)($_GET['page'] ?? 1));
$search = trim($_GET['search'] ?? '');
$offset = ($page - 1) * $limit;

$where = " WHERE pv.is_approve = 0 "; // Always filter by is_approve = 0
$params = [];
$types = '';

if ($search !== '') {
    // Add search condition with AND (because WHERE already has is_approve = 0)
    $where .= " AND (CONCAT(u.first_name, ' ', COALESCE(u.middle_name,''), ' ', u.last_name) LIKE ? 
                   OR pv.reference_number LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types .= 'ss';
}

// 1) Get total count of filtered records
$totalSql = "SELECT COUNT(*) AS total 
             FROM payment_verification pv
             LEFT JOIN user_info u ON pv.created_by = u.user_id
             $where";

$totalStmt = mysqli_prepare($conn, $totalSql);

if ($types !== '') {
    // Bind search params if any
    $refs = [];
    foreach ($params as $k => $v) {
        $refs[$k] = &$params[$k];
    }
    call_user_func_array([$totalStmt, 'bind_param'], array_merge([$types], $refs));
}

mysqli_stmt_execute($totalStmt);
$totalResult = mysqli_stmt_get_result($totalStmt);
$totalRow = mysqli_fetch_assoc($totalResult);
$total = (int)$totalRow['total'];
$totalPages = max(1, ceil($total / $limit));

// 2) Select actual data with pagination
$sql = "
    SELECT 
        pv.id,
        pv.created_by,
        pv.payment_method,
        pv.reference_number,
        pv.is_walk_in,
        pv.attachment,
        pv.date_created,
        CONCAT(u.first_name, ' ', COALESCE(u.middle_name,''), ' ', u.last_name) AS full_name,
        COALESCE(SUM(f.amount), 0) AS total_amount
    FROM payment_verification pv
    LEFT JOIN user_info u ON pv.created_by = u.user_id
    LEFT JOIN fees f ON f.user_id = pv.created_by
    $where
    GROUP BY pv.id
    ORDER BY pv.id DESC
    LIMIT ? OFFSET ?";

$stmt = mysqli_prepare($conn, $sql);

// Bind parameters: existing search params + limit and offset
$bindParams = $params;
$bindParams[] = $limit;
$bindParams[] = $offset;

// Types: existing + 'ii' for limit and offset
$bindTypes = $types . 'ii';

$refs = [];
foreach ($bindParams as $k => $v) {
    $refs[$k] = &$bindParams[$k];
}

call_user_func_array([$stmt, 'bind_param'], array_merge([$bindTypes], $refs));

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$records = [];
while ($row = mysqli_fetch_assoc($result)) {
    $row['is_walk_in'] = (bool)$row['is_walk_in'];
    $row['total_amount'] = (float)$row['total_amount'];
    $records[] = $row;
}

echo json_encode([
    'success' => true,
    'data' => $records,
    'pagination' => [
        'totalRecords' => $total,
        'totalPages' => $totalPages,
        'currentPage' => $page,
        'limit' => $limit
    ]
]);
