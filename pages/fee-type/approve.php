<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';
require_once $root . 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('Invalid request.'); window.location.href='list.php';</script>";
    exit;
}

$feeId = intval($_GET['id']);

$conn->begin_transaction();

try {
    $approveSql = "UPDATE fee_type SET `status` = 1 WHERE id = ? AND `status` = 0";
    $stmt = $conn->prepare($approveSql);
    $stmt->bind_param("i", $feeId);
    
    if (!$stmt->execute()) {
        throw new Exception("Failed to approve fee type.");
    }
    $stmt->close();

    if ($conn->affected_rows === 0) {
        throw new Exception("Fee type already approved or not found.");
    }

    $feeInfoSql = "SELECT fee_name, amount FROM fee_type WHERE id = ?";
    $stmt = $conn->prepare($feeInfoSql);
    $stmt->bind_param("i", $feeId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception("Fee type not found after approval.");
    }
    
    $fee = $result->fetch_assoc();
    $feeAmount = $fee['amount'];
    $stmt->close();

    $usersSql = "SELECT user_id FROM users WHERE role_id = 6";
    $usersResult = $conn->query($usersSql);
    
    if ($usersResult->num_rows === 0) {
        throw new Exception("No TODA members (role 6) found.");
    }

    $insertSql = "INSERT INTO fee_assignments 
                  (user_id, fee_type_id, amount, due_date, status, date_created) 
                  VALUES (?, ?, ?, DATE_FORMAT(NOW(), '%Y-%m-01') + INTERVAL 1 MONTH, 0, NOW())";
                  
    $insertStmt = $conn->prepare($insertSql);

    while ($user = $usersResult->fetch_assoc()) {
        $userId = $user['user_id'];
        $insertStmt->bind_param("iid", $userId, $feeId, $feeAmount);
        
        if (!$insertStmt->execute()) {
            throw new Exception("Failed to assign fee to user ID: $userId");
        }
    }
    
    $insertStmt->close();

    $conn->commit();
    
    echo "<script>
            alert('Fee type approved and successfully assigned to all TODA members!');
            window.location.href='list.php';
          </script>";

} catch (Exception $e) {
    $conn->rollback();
    
    echo "<script>
            alert('Error: " . addslashes($e->getMessage()) . "');
            window.location.href='list.php';
          </script>";
}

$conn->close();
exit;
?>