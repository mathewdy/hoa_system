<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';
require_once $root . 'config.php';
require_once $root . 'app/core/init.php';

if (!isset($_GET['id'])) {
    die("Invalid request — Missing user ID.");
}

$user = intval($_GET['id']);

// Get user info and unpaid fees
$sql = "
    SELECT 
        fa.id AS fee_id,
        fa.amount,
        fa.due_date,
        fa.status,
        ft.fee_name,
        ft.description,
        CONCAT(TRIM(CONCAT(i.first_name, ' ', COALESCE(i.middle_name, ''), ' ', i.last_name))) AS full_name
    FROM fee_assignments fa
    LEFT JOIN fee_type ft ON fa.fee_type_id = ft.id
    LEFT JOIN user_info i ON fa.user_id = i.user_id
    WHERE fa.user_id = ? AND fa.status = 0
    ORDER BY fa.due_date DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user);
$stmt->execute();
$result = $stmt->get_result();

$userName = '';
$fees = [];

while ($row = $result->fetch_assoc()) {
    $fees[] = $row;
    $userName = $row['full_name'];
}

$pageTitle = 'Unpaid Fees';
ob_start();
?>

<div class="mt-1">
    <h3 class="text-2xl font-medium text-gray-900 mb-4"><?= $pageTitle ?></h3>
    <div class="p-2 mb-4">
        <p class="text-sm text-gray-500">
            Viewing fees for: <?= $userName ?: 'Unknown User' ?>
        </p>
    </div>

    <div class="overflow-x-auto bg-gray-100 p-5 rounded-lg">
        <?php if (!empty($fees)): ?>
        <table class="w-full text-sm text-left text-gray-500">
            <thead>
                <tr class="justify-between flex py-0 rounded-lg mb-2">
                    <th>Fee Name</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fees as $fee): ?>
                <tr class="justify-between flex p-5 bg-gray-200 rounded-lg mb-2">
                    <td class="text-lg text-black flex items-center gap-2">
                        <input 
                            type="checkbox" 
                            class="selectFee bg-gray-100"
                            value="<?= $fee['fee_id'] ?>"
                            data-fee-name="<?= htmlspecialchars($fee['fee_name']) ?>"
                            data-fee-amount="<?= $fee['amount'] ?>"
                            data-user="<?= $user ?>"
                        >
                        <?= htmlspecialchars($fee['fee_name']) ?>
                    </td>
                    <td class="text-lg text-black"><?= htmlspecialchars($fee['description']) ?></td>
                    <td class="text-lg text-green-600">₱<?= number_format($fee['amount'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p>No unpaid fees for this user.</p>
        <?php endif; ?>
    </div>

    <hr class="my-5">

    <div class="flex justify-end gap-2 pt-4 items-center">
        <a href="list.php" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Back</a>
        <div id="walk-in-payment-btn" class="hidden">
            <button 
                type="button" 
                class="px-6 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition"
            >
                Walk-In Payment
            </button>
        </div>
    </div>
</div>
<!-- Walk-In Payment Modal -->
<div id="walkInPaymentModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg w-full max-w-2xl shadow-2xl flex flex-col max-h-screen">
        
        <div class="border-b border-gray-200 px-6 py-4">
            <h2 class="text-2xl font-semibold text-gray-900">Walk-In Payment</h2>
            <p class="text-sm text-gray-600 mt-1">Upload proof of payment for selected fees</p>
        </div>

        <div class="flex-1 overflow-y-auto px-6 py-5">
            
            <div id="selected-fees-details" class="space-y-3 mb-6">
            </div>

            <form id="walk-in-payment-form" class="space-y-5">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" id="full-name" class="mt-1 input input-bordered w-full bg-gray-50" 
                               value="<?= htmlspecialchars($userName) ?>" readonly />
                        <input type="hidden" id="user-id" value="<?= $user ?>">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">Total Amount</label>
                        <input type="text" id="amount" class="mt-1 input input-bordered w-full font-bold text-lg text-green-600 bg-gray-50" readonly />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Payment Method</label>
                        <select id="payment-method" class="mt-1 border border-gray-300 py-2.5 px-4 rounded-lg w-full focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            <option value="Cash">Cash</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Check">Check</option>
                            <option value="GCash">GCash</option>
                            <option value="Maya">Maya</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">Payment Date</label>
                        <input type="date" id="payment-date" class="mt-1 border border-gray-300 py-2.5 px-4 rounded-lg w-full focus:ring-2 focus:ring-teal-500" 
                               value="<?= date('Y-m-d') ?>" required />
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Receipt / Reference Name</label>
                    <input type="text" id="receipt-name" placeholder="e.g. OR#12345, GCash Ref#..." 
                           class="mt-1 border border-gray-300 py-2.5 px-4 rounded-lg w-full focus:ring-2 focus:ring-teal-500" required />
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Remarks (Optional)</label>
                    <textarea id="remarks" rows="3" placeholder="Any additional notes..."
                              class="mt-1 border border-gray-300 py-2.5 px-4 rounded-lg w-full focus:ring-2 focus:ring-teal-500"></textarea>
                </div>

            </form>
        </div>

        <div class="border-t border-gray-200 px-6 py-4 bg-gray-50 rounded-b-lg">
            <div class="flex justify-end gap-3">
                <button type="button" id="closeModal" 
                        class="px-6 py-2.5 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition font-medium">
                    Cancel
                </button>
                <button type="submit" form="walk-in-payment-form"
                        class="px-8 py-2.5 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition font-medium shadow-md">
                    Submit Payment
                </button>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
$pageScripts = '
<script type="module" src="/hoa_system/ui/modules/fee-assignation/payment-form.js"></script>
';
require_once BASE_PATH . '/pages/layout.php';
?>
