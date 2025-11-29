<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';

header('Content-Type: application/json');

// Must be logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized access.'
    ]);
    exit;
}

$user_id = (int)$_SESSION['user_id'];

// Optional filters
$status = $_GET['status'] ?? 'all'; // 'all', 'unpaid', 'paid'
$limit  = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 20;
$page   = max(1, (int)($_GET['page'] ?? 1));
$search = trim($_GET['search'] ?? '');
$offset = ($page - 1) * $limit;

// Build WHERE
$where = ["fa.user_id = ?"];
$params = [$user_id];
$types = 'i';

if ($status === 'unpaid') {
    $where[] = "fa.status = 0";
} elseif ($status === 'paid') {
    $where[] = "fa.status = 1";
}

if ($search !== '') {
    $where[] = "(ft.fee_name LIKE ? OR fa.due_date LIKE ?)";
    $like = "%$search%";
    $params[] = $like;
    $params[] = $like;
    $types .= 'ss';
}

$whereClause = 'WHERE ' . implode(' AND ', $where);

// Total count
$totalSql = "SELECT COUNT(*) AS total 
             FROM fee_assignments fa
             LEFT JOIN fee_type ft ON fa.fee_type_id = ft.id
             $whereClause";

$totalStmt = $conn->prepare($totalSql);
$totalStmt->bind_param($types, ...$params);
$totalStmt->execute();
$total = $totalStmt->get_result()->fetch_assoc()['total'];

// Main data
$sql = "SELECT 
            fa.id,
            fa.amount,
            fa.due_date,
            fa.status,
            fa.date_created,
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
    $row['due_date'] = $row['due_date'];
    $row['is_overdue'] = ($row['status'] == 0 && strtotime($row['due_date']) < time());

    $fees[] = $row;
}

echo json_encode([
    'success' => true,
    'data' => $fees,
    'pagination' => [
        'totalRecords' => (int)$total,
        'totalPages'   => max(1, ceil($total / $limit)),
        'currentPage'  => $page,
        'limit'        => $limit
    ]
]);

$conn->close();
?>