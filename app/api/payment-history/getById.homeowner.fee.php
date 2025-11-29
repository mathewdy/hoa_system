<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Login required']);
    exit;
}

$user_id = (int)$_SESSION['user_id'];
$status  = $_GET['status'] ?? 'all'; // all, unpaid, paid
$limit   = max(1, (int)($_GET['limit'] ?? 15));
$page    = max(1, (int)($_GET['page'] ?? 1));
$search  = trim($_GET['search'] ?? '');
$offset  = ($page - 1) * $limit;

// WHERE conditions
$where = ["fa.user_id = ?"];
$params = [$user_id];
$types = 'i';

if ($status === 'unpaid') $where[] = "fa.status = 0";
if ($status === 'paid')   $where[] = "fa.status = 1";

if ($search !== '') {
    $where[] = "(ft.fee_name LIKE ? OR fa.due_date LIKE ?)";
    $like = "%$search%";
    $params[] = $like;
    $params[] = $like;
    $types .= 'ss';
}

$whereClause = 'WHERE ' . implode(' AND ', $where);

// Total
$totalStmt = $conn->prepare("SELECT COUNT(*) AS total FROM fee_assignments fa 
                             LEFT JOIN fee_type ft ON fa.fee_type_id = ft.id $whereClause");
$totalStmt->bind_param($types, ...$params);
$totalStmt->execute();
$total = $totalStmt->get_result()->fetch_assoc()['total'];

// Data
$sql = "SELECT 
            fa.id,
            fa.amount,
            fa.due_date,
            fa.status,
            fa.date_created,
            fa.date_paid,
            ft.fee_name,
            ft.description
        FROM fee_assignments fa
        LEFT JOIN fee_type ft ON fa.fee_type_id = ft.id
        $whereClause
        ORDER BY fa.due_date DESC, fa.id DESC
        LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);
$params[] = $limit;
$params[] = $offset;
$types .= 'ii';
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$fees = [];
while ($row = $result->fetch_assoc()) {
    $row['amount'] = (float)$row['amount'];
    $row['is_overdue'] = ($row['status'] == 0 && strtotime($row['due_date']) < time());
    $fees[] = $row;
}

// Summary
$sumStmt = $conn->prepare("SELECT 
    SUM(CASE WHEN status = 0 THEN amount ELSE 0 END) AS unpaid,
    SUM(CASE WHEN status = 1 THEN amount ELSE 0 END) AS paid
    FROM fee_assignments WHERE user_id = ?");
$sumStmt->bind_param("i", $user_id);
$sumStmt->execute();
$summary = $sumStmt->get_result()->fetch_assoc();

echo json_encode([
    'success' => true,
    'data' => $fees,
    'summary' => [
        'total_unpaid' => (float)($summary['unpaid'] ?? 0),
        'total_paid'   => (float)($summary['paid'] ?? 0),
        'total_due'    => (float)($summary['unpaid'] ?? 0)
    ],
    'pagination' => [
        'totalRecords' => (int)$total,
        'totalPages'   => max(1, ceil($total / $limit)),
        'currentPage'  => $page,
        'limit'        => $limit
    ]
]);
?>