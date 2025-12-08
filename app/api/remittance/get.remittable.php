<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';
header('Content-Type: application/json');

$today = date('Y-m-d');

$tables = [
    "homeowner_fees",
    "court_fees",
    "stall_renter_fees",
    "toda_fees"
];

$totalCollected = 0;

foreach ($tables as $table) {
    $sql = "SELECT COALESCE(SUM(amount_paid), 0) AS total 
            FROM $table 
            WHERE status = 1 AND is_remitted = 0 AND DATE(date_created) = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $today);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    $totalCollected += (float)$result['total'];
    $stmt->close();
}

echo json_encode([
    "success" => true,
    "data" => [
        [
            "total" => $totalCollected
        ]
    ]
]);

$conn->close();
