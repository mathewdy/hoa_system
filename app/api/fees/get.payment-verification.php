<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';

header('Content-Type: application/json');

$limit  = (int)($_GET['limit'] ?? 10);
$page   = max(1, (int)($_GET['page'] ?? 1));
$search = trim($_GET['search'] ?? '');
$offset = ($page - 1) * $limit;

$where = " WHERE pv.status = 0 ";
$params = [];
$types = '';

if ($search !== '') {
    $where .= " AND (CONCAT(u.first_name, ' ', COALESCE(u.middle_name,''), ' ', u.last_name) LIKE ? 
                   OR pv.payment_for LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types .= 'ss';
}

$totalSql = "
    SELECT COUNT(*) AS total
    FROM payment_verification pv
    LEFT JOIN user_info u ON pv.user_id = u.user_id
    $where
";
$totalStmt = mysqli_prepare($conn, $totalSql);

if ($types !== '') {
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

$sql = "
    SELECT 
        pv.id,
        pv.user_id,
        pv.payment_for,
        pv.amount AS pv_amount,
        pv.status AS pv_status,
        pv.date_created AS pv_date_created,
        hf.id AS hf_id,
        hf.amount_paid,
        hf.payment_method,
        hf.ref_no,
        hf.attachment,
        hf.status AS hf_status,
        hf.remarks,
        hf.date_created AS hf_date_created,
        CONCAT(u.first_name, ' ', COALESCE(u.middle_name,''), ' ', u.last_name) AS full_name
    FROM payment_verification pv
    LEFT JOIN homeowner_fees hf ON hf.user_id = pv.user_id
    LEFT JOIN user_info u ON u.user_id = pv.user_id
    $where
    ORDER BY pv.id DESC
    LIMIT ? OFFSET ?
";

$stmt = mysqli_prepare($conn, $sql);

$bindParams = $params;
$bindParams[] = $limit;
$bindParams[] = $offset;
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
    $row['pv_status'] = (int)$row['pv_status'];
    $row['hf_status'] = (int)$row['hf_status'];
    $row['pv_amount'] = (float)$row['pv_amount'];
    $row['amount_paid'] = isset($row['amount_paid']) ? (float)$row['amount_paid'] : 0;
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
