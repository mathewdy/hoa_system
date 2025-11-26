<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';
require_once $root . 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';

$pageTitle = 'Record Payment';

$user_id = $_GET['id'] ?? 0;
if (!$user_id || !is_numeric($user_id)) {
    die('<h2 class="text-center text-red-600 mt-20 text-4xl">Invalid User ID</h2>');
}
$user_id = (int)$user_id;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fee_ids          = $_POST['fee_ids'] ?? [];
    $amount_paid      = (float)($_POST['total_amount_paid'] ?? 0);
    $payment_method   = trim($_POST['payment_method'] ?? '');
    $reference_number = trim($_POST['reference_number'] ?? '');
    $notes            = trim($_POST['notes'] ?? '');
    $is_walk_in       = isset($_POST['is_walk_in']) ? 1 : 0;
    $created_by       = $_SESSION['user_id'] ?? 0;

    if (empty($fee_ids) || $amount_paid <= 0 || empty($payment_method) || empty($reference_number)) {
        $error = "All required fields must be filled.";
    } else {
        $attachment = null;

        if ($is_walk_in != 1 && isset($_FILES['attachment']) && $_FILES['attachment']['error'] === 0) {
            $file = $_FILES['attachment'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg','jpeg','png','pdf'];
            if (in_array($ext, $allowed) && $file['size'] <= 10*1024*1024) {
                $dir = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/assets/img/uploads/proofs/';
                if (!is_dir($dir)) mkdir($dir, 0755, true);
                $filename = 'proof_' . time() . '_' . rand(1000,9999) . '.' . $ext;
                $path = $dir . $filename;
                if (move_uploaded_file($file['tmp_name'], $path)) {
                    $attachment = '/hoa_system/uploads/proofs/' . $filename;
                }
            }
        }

        $success = 0;
        foreach ($fee_ids as $fee_id) {
            $fee_id = (int)$fee_id;

            $sql = "INSERT INTO payment_verification 
                    (fee_id, created_by, payment_method, reference_number, 
                     is_walk_in, attachment, is_approve, date_created)
                    VALUES (?, ?, ?, ?, ?, ?, 0, NOW())";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 'iissis', 
                $fee_id,
                $created_by,
                $payment_method,
                $reference_number,
                $is_walk_in,
                $attachment
            );

            if (mysqli_stmt_execute($stmt)) {
                mysqli_query($conn, "UPDATE fees SET status = 3 WHERE id = $fee_id"); 
                $success++;
            }
        }

        if ($success > 0) {
            header("Location: list.php");
            exit;
        } else {
            $error = "Failed to record payment. Please try again.";
        }
    }
}

$sql = "SELECT f.*, 
        CONCAT(TRIM(CONCAT(ui.first_name, ' ', COALESCE(ui.middle_name, ''), ' ', ui.last_name))) AS full_name
        FROM fees f
        LEFT JOIN user_info ui ON f.user_id = ui.user_id
        WHERE f.user_id = ? AND f.status IN (0,2)
        ORDER BY f.next_due_date ASC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$dues = [];
$total_due = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $row['amount_fmt'] = number_format($row['amount'], 2);
    $row['due_date'] = $row['next_due_date'] ? date('M j, Y', strtotime($row['next_due_date'])) : '—';
    $dues[] = $row;
    $total_due += (float)$row['amount'];
}

ob_start();
?>

<div class="min-h-screen bg-gray-100 py-12 px-6">
    <?php 
    if (empty($dues)) {
      die('<h2 class="text-center text-green-600 mt-20 text-4xl">No pending dues!</h2>');
    }
    ?>
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white p-8 text-center">
            <h1 class="text-4xl font-bold">Record Payment</h1>
            <p class="text-2xl mt-2"><?= htmlspecialchars($dues[0]['full_name']) ?></p>
        </div>

        <div class="p-10">

            <?php if (isset($_GET['msg']) && $_GET['msg'] === 'success'): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg text-center text-xl mb-6">
                    Payment recorded successfully!
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg mb-6"><?= $error ?></div>
            <?php endif; ?>

            <div class="bg-yellow-50 border-2 border-yellow-300 rounded-xl p-6 text-center mb-8">
                <p class="text-6xl font-extrabold text-yellow-700">₱<?= number_format($total_due, 2) ?></p>
                <p class="text-2xl font-bold text-gray-700 mt-2">Total Amount Due (<?= count($dues) ?> item<?= count($dues)>1?'s':'' ?>)</p>
            </div>

            <form method="POST" enctype="multipart/form-data" class="space-y-8">

                <?php foreach ($dues as $d): ?>
                    <input type="hidden" name="fee_ids[]" value="<?= $d['id'] ?>">
                <?php endforeach; ?>

                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-xl font-bold text-gray-700 mb-3">Amount Paid <span class="text-red-600">*</span></label>
                        <input type="number" step="0.01" name="total_amount_paid" value="<?= $total_due ?>" required
                               class="w-full px-6 py-5 text-3xl text-center font-bold border-4 border-blue-500 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-200">
                    </div>
                    <div>
                        <label class="block text-xl font-bold text-gray-700 mb-3">Payment Method <span class="text-red-600">*</span></label>
                        <select name="payment_method" required class="w-full px-6 py-5 text-2xl border-4 border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-200">
                            <option value="">— Choose —</option>
                            <option value="cash">Cash</option>
                            <option value="gcash">GCash</option>
                            <option value="maya">Maya</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="check">Check</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xl font-bold text-gray-700 mb-3">Reference / OR Number <span class="text-red-600">*</span></label>
                    <input type="text" name="reference_number" required placeholder="e.g. GCash Ref #1234567890"
                           class="w-full px-6 py-5 text-2xl border-4 border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-200">
                </div>

                <div>
                    <label class="block text-xl font-bold text-gray-700 mb-3">Proof of Payment <?= $is_walk_in ?? true ? '<span class="text-red-600">*</span>' : '' ?></label>
                    <input type="file" name="attachment" accept="image/*,.pdf" <?= !isset($_POST['is_walk_in']) ? 'required' : '' ?>
                           class="block w-full text-lg file:mr-6 file:py-5 file:px-10 file:rounded-xl file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                </div>

                <div class="bg-amber-50 border-2 border-amber-400 rounded-xl p-6">
                    <label class="flex items-center space-x-4 cursor-pointer">
                        <input type="checkbox" name="is_walk_in" value="1" <?= isset($_POST['is_walk_in']) ? 'checked' : '' ?>
                               onchange="this.form.querySelector('input[name=attachment]').required = !this.checked">
                        <span class="text-2xl font-bold text-amber-900">Walk-in Payment (Cash/Check)</span>
                    </label>
                    <p class="text-amber-700 mt-2 ml-12">Attachment optional if checked</p>
                </div>

                <div>
                    <label class="block text-xl font-bold text-gray-700 mb-3">Notes (Optional)</label>
                    <textarea name="notes" rows="4" class="w-full px-6 py-5 text-xl border-4 border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-200 resize-none"></textarea>
                </div>

                <div class="flex justify-center gap-8 pt-8">
                    <a href="homeowner-fees.php?id=<?= $user_id ?>" class="px-12 py-5 bg-gray-500 text-white text-xl font-bold rounded-xl hover:bg-gray-600 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-16 py-5 bg-gradient-to-r from-green-600 to-emerald-700 text-white text-2xl font-bold rounded-xl hover:from-green-700 hover:to-emerald-800 transition shadow-xl">
                        Submit Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once BASE_PATH . '/pages/layout.php';
?>