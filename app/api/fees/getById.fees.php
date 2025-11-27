<?php
ob_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    json_error('Invalid or missing user ID', 400);
}

$user_id = (int)$_GET['id'];
$limit   = min(100, max(1, (int)($_GET['limit'] ?? 10))); 
$page    = max(1, (int)($_GET['page'] ?? 1));
$search  = trim($_GET['search'] ?? '');
$offset  = ($page - 1) * $limit;

$whereClause = "WHERE f.user_id = ?";
$params = [$user_id];
$types  = 'i';

if ($search !== '') {
    $whereClause .= " AND (CONCAT(i.first_name, ' ', COALESCE(i.middle_name, ''), ' ', i.last_name) LIKE ? 
                        OR i.email_address LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types .= 'ss';
}

$totalSql = "SELECT COUNT(*) AS total 
    FROM fees f 
    LEFT JOIN user_info i ON f.user_id = i.user_id 
    $whereClause";

$totalStmt = mysqli_prepare($conn, $totalSql);
mysqli_stmt_bind_param($totalStmt, $types, ...$params);
mysqli_stmt_execute($totalStmt);
$totalResult = mysqli_stmt_get_result($totalStmt);
$total = mysqli_fetch_assoc($totalResult)['total'];
$totalPages = ceil($total / $limit);

$sql = "
  SELECT 
    f.id,
    f.user_id,
    f.fee_name,
    f.status,
    f.amount,
    f.next_due_date,
    f.date_created,
    m.due_name,
    m.amount AS monthly_amount,
    CONCAT(
        TRIM(CONCAT(i.first_name, ' ', COALESCE(i.middle_name, ''), ' ', i.last_name))
    ) AS full_name,
    u.email_address
  FROM fees f 
  LEFT JOIN monthly_dues m ON f.due_id = m.id
  LEFT JOIN user_info i ON f.user_id = i.user_id
  LEFT JOIN users u ON i.user_id = u.user_id
  $whereClause
  ORDER BY 
      FIELD(f.status, 2, 0, 3, 4, 1), 
      f.next_due_date DESC
  LIMIT ? OFFSET ?";

$params[] = $limit;
$params[] = $offset;
$types .= 'ii';

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, $types, ...$params);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$fees = [];
while ($row = mysqli_fetch_assoc($result)) {
    $row['status_text'] = match ((int)$row['status']) {
        0 => 'Pending',
        1 => 'Paid',
        2 => 'Overdue',
        3 => 'Waived',
        4 => 'Cancelled',
        default => 'Unknown',
    };

    if ($row['next_due_date']) {
        $row['next_due_date_formatted'] = date('M j, Y', strtotime($row['next_due_date']));
    }
    if ($row['date_created']) {
        $row['date_created_formatted'] = date('M j, Y', strtotime($row['date_created']));
    }

    $row['amount_formatted'] = '₱' . number_format((float)$row['amount'], 2);

    $fees[] = $row;
}

json_success([
    'homeowner' => [
        'user_id' => $user_id,
        'full_name' => $fees[0]['full_name'] ?? 'Unknown Homeowner',
        'email'     => $fees[0]['email_address'] ?? '—'
    ],
    'summary' => [
        'total_due' => array_sum(array_column($fees, 'amount')),
        'overdue_count' => count(array_filter($fees, fn($f) => $f['status'] == 2)),
        'pending_count' => count(array_filter($fees, fn($f) => $f['status'] == 0)),
        'paid_count'    => count(array_filter($fees, fn($f) => $f['status'] == 1))
    ],
    'data' => $fees,
    'pagination' => [
        'totalRecords' => (int)$total,
        'totalPages'   => $totalPages,
        'currentPage'  => $page,
        'limit'        => $limit
    ]
]);