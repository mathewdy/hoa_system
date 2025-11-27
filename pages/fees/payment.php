<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';
require_once $root . 'config.php';
require_once $root . 'app/core/init.php';

$user_id = isset($_GET['id']) ? intval($_GET['id']) : null;
if (!$user_id) {
    die('User ID is required');
}

$fee_details = [];

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
  WHERE f.user_id = ?
";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$fee_details = mysqli_fetch_all($result, MYSQLI_ASSOC);
$total_amount = 0;
foreach ($fee_details as $fee) {
    $total_amount += floatval($fee['amount']);
}

$user_full_name = $fee_details[0]['full_name'] ?? '';

$pageTitle = 'Record Payment Verification';
ob_start();
?>

<div class="">
    <div class="rounded-lg shadow-sm">
        <div class="mb-5 border-b-2 border-gray-300 pb-4">
            <h3 class="text-2xl font-medium text-gray-900 leading-none">Record Payment Verification</h3>
            <p class="text-gray-600">Submit payment verification for the selected fee(s).</p>
        </div>

        <form method="POST" enctype="multipart/form-data" class="space-y-4">

            <input type="hidden" name="created_by" value="<?= htmlspecialchars($user_id) ?>">

            <div class="border-2 border-gray-200 px-8 py-6 rounded-lg shadow-sm">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Fee Details</h2>

                <?php if (empty($fee_details)) : ?>
                    <p class="text-gray-500">No fees found for this user.</p>
                <?php else: ?>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="border-b px-4 py-2">Fee Name</th>
                                <th class="border-b px-4 py-2">Amount</th>
                                <th class="border-b px-4 py-2">Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($fee_details as $fee): ?>
                                <tr>
                                    <td class="border-b px-4 py-2"><?= htmlspecialchars($fee['fee_name']) ?></td>
                                    <td class="border-b px-4 py-2">₱<?= number_format($fee['amount'], 2) ?></td>
                                    <td class="border-b px-4 py-2"><?= htmlspecialchars($fee['next_due_date']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>

                <div class="grid grid-cols-2 items-center mt-6">
                    <label class="block text-sm font-medium text-gray-700">Payment Method <span class="text-red-500">*</span></label>
                    <select name="payment_method" required
                            class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm px-3 py-2">
                        <option value="">Select Method</option>
                        <option value="Cash">Cash</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Online Payment">Online Payment</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 items-center mt-4">
                    <label class="block text-sm font-medium text-gray-700">Total Amount</label>
                    <input type="text" name="amount" value="<?= $total_amount ?>" readonly
                           class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm px-3 py-2">
                </div>
                <div class="grid grid-cols-2 items-center mt-4">
                    <label class="block text-sm font-medium text-gray-700">Reference Number</label>
                    <input type="text" name="reference_number"
                           class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm px-3 py-2">
                </div>

                <div class="grid grid-cols-2 items-center mt-4">
                    <label class="block text-sm font-medium text-gray-700">Attachment</label>
                    <input type="file" name="attachment" accept=".jpg,.png,.pdf" class="mt-1">
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-4">
                <a href="list.php" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Cancel</a>
                <button type="submit" class="px-8 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition font-medium">
                    Submit Payment
                </button>
            </div>

        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once BASE_PATH . '/pages/layout.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $created_by       = intval($_POST['created_by']); 
    $payment_method   = trim($_POST['payment_method']);
    $reference_number = trim($_POST['reference_number']);
    $is_walk_in       = 1;
    $is_submitted     = 0;
    $is_approve       = 0;
    $date_created     = date('Y-m-d H:i:s');
    $amount = trim($_POST['amount']);
    $attachment = null;
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
        $upload_dir = $root . 'uploads/payments/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $filename = time() . '_' . basename($_FILES['attachment']['name']);
        $target_file = $upload_dir . $filename;

        if (move_uploaded_file($_FILES['attachment']['tmp_name'], $target_file)) {
            $attachment = 'uploads/payments/' . $filename;
        }
    }

    $sql = "INSERT INTO payment_verification 
            (created_by, payment_method, reference_number, is_walk_in, attachment, is_approve, is_submitted, date_created) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "isssisss",
        $created_by,
        $payment_method,
        $reference_number,
        $is_walk_in,
        $attachment,
        $is_approve,
        $is_submitted,
        $date_created
    );

    if (mysqli_stmt_execute($stmt)) {
      echo "<script>alert('Payment Success')</script>";
      echo "<script>window.location.href='list.php'</script>";
      exit;
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
}
?>
