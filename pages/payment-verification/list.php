<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';
require_once $root . 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';


$pageTitle = 'Payment Verification';

// REAL QUERY – EXACT SA FIELDS MO!
$sql = "
    SELECT 
        pv.id,
        pv.fee_id,
        pv.created_by,
        pv.payment_method,
        pv.reference_number,
        pv.is_walk_in,
        pv.attachment,
        pv.is_approve,
        pv.date_created,
        
        CONCAT(TRIM(CONCAT(ui.first_name, ' ', COALESCE(ui.middle_name, ''), ' ', ui.last_name))) AS full_name,
        f.fee_name,
        f.amount
    FROM payment_verification pv
    LEFT JOIN fees f ON pv.fee_id = f.id
    LEFT JOIN user_info ui ON f.user_id = ui.user_id
    ORDER BY pv.date_created DESC
";

$result = mysqli_query($conn, $sql);
if (!$result) die("Query error: " . mysqli_error($conn));

ob_start();
?>

<div class="min-h-screen">
    <div class="">

        <div class="shadow-xl p-8 mb-0">
            <h1 class="text-5xl font-extrabold text-center text-gray-800">Payment Verification</h1>
            <p class="text-center text-xl text-gray-600 mt-3">Review and approve homeowner payments</p>
        </div>

        <div class="bg-white rounded-b-2xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white">
                        <tr>
                            <th class="px-6 py-5 text-left text-xs font-bold uppercase tracking-wider">Date</th>
                            <th class="px-6 py-5 text-left text-xs font-bold uppercase tracking-wider">Homeowner</th>
                            <th class="px-6 py-5 text-left text-xs font-bold uppercase tracking-wider">Fee</th>
                            <th class="px-6 py-5 text-center text-xs font-bold uppercase tracking-wider">Method</th>
                            <th class="px-6 py-5 text-center text-xs font-bold uppercase tracking-wider">Reference</th>
                            <th class="px-6 py-5 text-center text-xs font-bold uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-5 text-center text-xs font-bold uppercase tracking-wider">Proof</th>
                            <th class="px-6 py-5 text-center text-xs font-bold uppercase tracking-wider">Status</th>
                            <th class="px-6 py-5 text-center text-xs font-bold uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php while ($row = mysqli_fetch_assoc($result)): 
                            $date = date('M j, Y • g:i A', strtotime($row['date_created']));
                            $method = strtoupper($row['payment_method']);
                            $is_walk_in = $row['is_walk_in'] == 1;
                            
                            if ($row['is_approve'] == 1) {
                                $status = '<span class="px-4 py-2 bg-green-100 text-green-800 rounded-full font-bold text-xs">APPROVED</span>';
                            } elseif ($row['is_approve'] == 2) {
                                $status = '<span class="px-4 py-2 bg-red-100 text-red-800 rounded-full font-bold text-xs">REJECTED</span>';
                            } else {
                                $status = '<span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full font-bold text-xs">PENDING</span>';
                            }
                        ?>
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <td class="px-6 py-5 text-sm text-gray-600"><?= $date ?></td>
                            <td class="px-6 py-5 font-bold text-gray-900"><?= htmlspecialchars($row['full_name'] ?? '—') ?></td>
                            <td class="px-6 py-5 text-sm"><?= htmlspecialchars($row['fee_name'] ?? 'Custom Fee') ?></td>
                            <td class="px-6 py-5 text-center">
                                <span class="px-3 py-1 <?= $is_walk_in ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800' ?> rounded-full text-xs font-bold">
                                    <?= $is_walk_in ? 'WALK-IN' : $method ?>
                                </span>
                            </td>
                            <td class="px-6 py-5 text-center font-mono text-sm font-semibold"><?= htmlspecialchars($row['reference_number']) ?></td>
                            <td class="px-6 py-5 text-center font-bold text-green-600 text-lg">₱<?= number_format($row['amount'], 2) ?></td>
                            <td class="px-6 py-5 text-center">
                                <?php if ($row['attachment'] && !$is_walk_in): ?>
                                    <a href="<?= htmlspecialchars($row['attachment']) ?>" target="_blank" 
                                       class="text-blue-600 hover:underline font-bold text-sm">
                                        View Proof
                                    </a>
                                <?php else: ?>
                                    <span class="text-gray-400 italic text-sm">Walk-in</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-5 text-center"><?= $status ?></td>
                            <td class="px-6 py-5 text-center space-x-3">
                                <?php if ($row['is_approve'] == 0): ?>
                                    <button onclick="approve(<?= $row['id'] ?>, <?= $row['fee_id'] ?>)"
                                            class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-bold text-sm transition shadow">
                                        Approve
                                    </button>
                                    <button onclick="reject(<?= $row['id'] ?>)"
                                            class="px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-bold text-sm transition shadow">
                                        Reject
                                    </button>
                                <?php else: ?>
                                    <span class="text-gray-500 text-sm">—</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <?php if (mysqli_num_rows($result) == 0): ?>
                    <div class="text-center py-20 text-gray-500 text-xl">
                        No payment submissions yet.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function approve(pv_id, fee_id) {
    if (!confirm('Approve this payment?')) return;
    fetch('/hoa_system/app/api/payments/approve.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + pv_id + '&fee_id=' + fee_id
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            alert('Payment approved!');
            location.reload();
        } else {
            alert(res.message || 'Error');
        }
    });
}

function reject(pv_id) {
    if (!confirm('Reject this payment?')) return;
    fetch('/hoa_system/app/api/payments/reject.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + pv_id
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            alert('Payment rejected.');
            location.reload();
        }
    });
}
</script>

<?php
$content = ob_get_clean();
require_once BASE_PATH . '/pages/layout.php';
?>