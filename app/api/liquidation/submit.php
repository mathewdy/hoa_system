<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$response = ['success' => false, 'message' => 'Something went wrong'];
$in_transaction = false;

try {
    if (!isset($_POST['project_id'])) {
        throw new Exception("Missing project ID");
    }

    $project_id     = intval($_POST['project_id']);
    $remarks        = trim($_POST['remarks'] ?? '');
    $particulars    = $_POST['expense_particular'] ?? [];
    $amounts        = $_POST['expense_amount'] ?? [];

    if (empty($particulars)) {
        throw new Exception("Please add at least one expense");
    }

    $total_expenses = 0;
    foreach ($amounts as $amt) {
        $total_expenses += floatval($amt);
    }

    $stmt = $conn->prepare("SELECT estimated_budget FROM resolution WHERE id = ? AND is_budget_released = 1");
    $stmt->bind_param("i", $project_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("Project not found or budget not released");
    }
    $project = $result->fetch_assoc();
    $released_budget = $project['estimated_budget'];
    $remaining_budget = $released_budget - $total_expenses;

    if ($total_expenses > $released_budget) {
        $audit_result = 'Overspent';
    } elseif ($total_expenses < $released_budget) {
        $audit_result = 'Underspent';
    } else {
        $audit_result = 'Balanced';
    }

    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/uploads/liquidation_expenses/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

    $conn->autocommit(FALSE);
    $in_transaction = true;

    $stmt = $conn->prepare("
        INSERT INTO liquidation_of_expenses 
        (project_resolution_id, status, total_expenses, date_created) 
        VALUES (?, 0, ?, NOW())
    ");
    $stmt->bind_param("id", $project_id, $total_expenses);
    if (!$stmt->execute()) {
        throw new Exception("Failed to create liquidation record");
    }
    $liquidation_id = $conn->insert_id;

    $stmt_detail = $conn->prepare("
        INSERT INTO liquidation_expenses_details 
        (liquidation_id, particular, amount, receipt, total_expenses, remaning_budget, audit_result, remarks, date_created)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");

    for ($i = 0; $i < count($particulars); $i++) {
        $particular = trim($particulars[$i]);
        $amount     = floatval($amounts[$i]);
        $receipt    = '';

        if (!empty($_FILES['expense_receipt']['name'][$i]) && $_FILES['expense_receipt']['error'][$i] === UPLOAD_ERR_OK) {
            $file_name = $_FILES['expense_receipt']['name'][$i];
            $tmp_name  = $_FILES['expense_receipt']['tmp_name'][$i];
            $ext       = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'pdf'])) {
                throw new Exception("Invalid file: $file_name");
            }
            if ($_FILES['expense_receipt']['size'][$i] > 10*1024*1024) {
                throw new Exception("File too large: $file_name");
            }

            $new_filename = "liq_{$liquidation_id}_{$i}_" . time() . ".$ext";
            $destination  = $upload_dir . $new_filename;

            if (!move_uploaded_file($tmp_name, $destination)) {
                throw new Exception("Upload failed: $file_name");
            }
            $receipt = $new_filename;
        }

        $stmt_detail->bind_param(
            "isdssdss",
            $liquidation_id,
            $particular,
            $amount,
            $receipt,
            $total_expenses,
            $remaining_budget,
            $audit_result,
            $remarks
        );

        if (!$stmt_detail->execute()) {
            throw new Exception("Failed to save expense item");
        }
    }

    $conn->commit();
    $in_transaction = false;
    $conn->autocommit(TRUE);

    $response = [
        'success' => true,
        'message' => 'Liquidation submitted successfully! Waiting for approval.'
    ];

} catch (Exception $e) {
    if ($in_transaction) {
        $conn->rollback();
        $conn->autocommit(TRUE);
    }
    $response['message'] = $e->getMessage();
} catch (Throwable $e) {
    if ($in_transaction) {
        $conn->rollback();
        $conn->autocommit(TRUE);
    }
    $response['message'] = 'System error.';
}

echo json_encode($response);
exit;
?>