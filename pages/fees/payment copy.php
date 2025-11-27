<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';
require_once $root . 'config.php';
// require_once $root . 'app/includes/session.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';

$pageTitle = 'Record Payment';

$user_id = $_GET['id'] ?? 0;
if (!$user_id || !is_numeric($user_id)) {
    die('<div class="flex items-center justify-center min-h-screen"><h2 class="text-3xl text-red-600">Invalid User ID</h2></div>');
}
$user_id = (int)$user_id;

$sql = "SELECT f.*, 
          CONCAT(TRIM(CONCAT(ui.first_name, ' ', COALESCE(ui.middle_name, ''), ' ', ui.last_name))) AS full_name,
          u.email_address
        FROM fees f
        LEFT JOIN user_info ui ON f.user_id = ui.user_id
        LEFT JOIN users u ON f.user_id = u.user_id
        WHERE f.user_id = ? AND f.status IN (0, 2)
        ORDER BY f.next_due_date ASC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$dues = [];
$total_due = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $row['amount_formatted'] = number_format((float)$row['amount'], 2);
    $row['due_display'] = $row['next_due_date'] ? date('M j, Y', strtotime($row['next_due_date'])) : '—';
    $row['status_badge'] = $row['status'] == 2 ? '<span class="text-red-600 font-bold">Overdue</span>' : 'Pending';
    $dues[] = $row;
    $total_due += (float)$row['amount'];
}

if (empty($dues)) {
    die('<div class="flex items-center justify-center min-h-screen"><h2 class="text-2xl text-green-600">No pending dues. All paid!</h2></div>');
}

$total_formatted = number_format($total_due, 2);
ob_start();
?>
<div class="min-h-screen">
    <div class="">

        <div class="bg-white rounded-t-xl shadow-md p-8 text-center border-b-4 border-blue-600">
            <h1 class="text-4xl font-bold text-gray-800">Record Payment</h1>
            <p class="text-xl text-gray-600 mt-2">Homeowner: <strong><?= htmlspecialchars($dues[0]['full_name']) ?></strong></p>
            <p class="text-lg text-gray-500">Email: <?= htmlspecialchars($dues[0]['email_address'] ?? '—') ?></p>
        </div>

        <div class="bg-white rounded-b-xl shadow-md p-8">

            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-300 rounded-xl p-6 mb-8">
                <div class="grid md:grid-cols-3 gap-6 text-center">
                    <div>
                        <p class="text-sm font-bold text-blue-700">Total Dues</p>
                        <p class="text-4xl font-extrabold text-blue-900"><?= count($dues) ?></p>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-blue-700">Total Amount Due</p>
                        <p class="text-5xl font-extrabold text-red-600">₱<?= $total_formatted ?></p>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-blue-700">Pay All at Once</p>
                        <p class="text-2xl font-bold text-green-600">Recommended</p>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Dues to be Paid</h3>
                <div class="space-y-3">
                    <?php foreach ($dues as $d): ?>
                    <div class="flex justify-between items-center bg-gray-50 p-4 rounded-lg border">
                        <div>
                            <p class="font-semibold text-gray-900"><?= htmlspecialchars($d['fee_name']) ?> (#<?= $d['id'] ?>)</p>
                            <p class="text-sm text-gray-600">Due: <?= $d['due_display'] ?> • <?= $d['status_badge'] ?></p>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">₱<?= $d['amount_formatted'] ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <form id="payment-form" enctype="multipart/form-data" class="space-y-6">

                <?php foreach ($dues as $d): ?>
                    <input type="hidden" name="fee_ids[]" value="<?= $d['id'] ?>">
                <?php endforeach; ?>
                <input type="hidden" name="created_by" value="<?= $_SESSION['user_id'] ?? '' ?>">
                <input type="hidden" name="is_walk_in" id="is_walk_in" value="0">

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-lg font-medium text-gray-700 mb-2">Total Amount Paid <span class="text-red-600">*</span></label>
                        <input type="number" step="0.01" name="total_amount_paid" value="<?= $total_due ?>" required
                               class="w-full px-6 py-4 text-3xl font-bold text-center border-2 border-green-600 rounded-xl focus:outline-none focus:ring-4 focus:ring-green-200">
                    </div>
                    <div>
                        <label class="block text-lg font-medium text-gray-700 mb-2">Payment Method <span class="text-red-600">*</span></label>
                        <select name="payment_method" required class="w-full px-6 py-4 text-xl border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-200">
                            <option value="">— Select Method —</option>
                            <option value="cash">Cash (Walk-in)</option>
                            <option value="gcash">GCash</option>
                            <option value="maya">Maya</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="check">Check</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-lg font-medium text-gray-700 mb-2">Reference / OR Number <span class="text-red-600">*</span></label>
                    <input type="text" name="reference_number" required placeholder="e.g. GCash Ref #1234567890"
                           class="w-full px-6 py-4 text-xl border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-200">
                </div>

                <div>
                    <label class="block text-lg font-medium text-gray-700 mb-2">Proof of Payment <span class="text-red-600">*</span></label>
                    <input type="file" name="attachment" id="attachment" accept="image/*,.pdf" required
                           class="block w-full text-sm file:mr-4 file:py-3 file:px-6 file:rounded-lg file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                </div>

                <div class="bg-yellow-50 border-2 border-yellow-400 rounded-xl p-6">
                    <label class="flex items-center space-x-4 cursor-pointer">
                        <input type="checkbox" id="walk_in_checkbox" class="w-6 h-6 text-yellow-600 rounded">
                        <span class="text-xl font-bold text-yellow-900">Walk-in Payment (Cash/Check at Office)</span>
                    </label>
                    <p class="text-yellow-700 mt-2 ml-10">Attachment optional if walk-in</p>
                </div>

                <div>
                    <label class="block text-lg font-medium text-gray-700 mb-2">Notes (Optional)</label>
                    <textarea name="notes" rows="4" placeholder="e.g. Paid all dues for 2025"
                              class="w-full px-6 py-4 border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-200 resize-none"></textarea>
                </div>

                <div class="flex justify-end space-x-6 pt-8 border-t-4 border-gray-200">
                    <a href="homeowner-fees.php?id=<?= $user_id ?>" class="px-10 py-4 bg-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-400 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-12 py-4 bg-gradient-to-r from-green-600 to-emerald-700 text-white font-bold text-xl rounded-xl hover:from-green-700 hover:to-emerald-800 transition shadow-lg flex items-center gap-3">
                        Submit Payment for All Dues
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
$content = ob_get_clean();

$pageScripts = `<script>
$(document).ready(function() {
    $('#walk_in_checkbox').change(function() {
        $('#is_walk_in').val(this.checked ? '1' : '0');
        $('#attachment').prop('required', !this.checked);
    });

    $('#payment-form').submit(function(e) {
        e.preventDefault();
        const btn = $(this).find('button[type="submit"]');
        const txt = btn.html();
        btn.prop('disabled', true).html('Submitting...');

        $.ajax({
            url: '/hoa_system/app/api/fees/post.payment.php',
            method: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(res) {
                if (res.success) {
                    alert('Payment recorded successfully!');
                    window.location.href = 'list.php';
                } else {
                    alert(res.message || 'Failed to submit payment.');
                }
            },
            error: function() {
                alert('Connection error. Please try again.');
            },
            complete: function() {
                btn.prop('disabled', false).html(txt);
            }
        });
    });
});
</script>`;
require_once BASE_PATH . '/pages/layout.php';
?>