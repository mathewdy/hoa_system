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
<div id="walkInPaymentModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg w-96 p-6">
        <h2 class="text-xl font-medium text-gray-900 mb-4">Upload Proof of Payment</h2>

        <div id="selected-fees-details" class="space-y-3"></div>

        <form id="walk-in-payment-form" class="space-y-4">
            <div>
                <label for="full-name" class="text-sm font-medium">Full Name</label>
                <input type="text" id="full-name" class="input input-bordered w-full" value="<?= htmlspecialchars($userName) ?>" readonly />
                <input type="hidden" id="user-id" readonly />
            </div>

            <div>
                <label for="amount" class="text-sm font-medium">Amount</label>
                <input type="text" id="amount" class="input input-bordered w-full" readonly />
            </div>

            <div>
                <label for="payment-method" class="text-sm font-medium">Payment Method</label>
                <select id="payment-method" class="border border-gray-200 py-2 px-4 rounded-lg w-full">
                    <option value="Cash">Cash</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                    <option value="Check">Check</option>
                </select>
            </div>

            <div>
                <label for="payment-date" class="text-sm font-medium">Date</label>
                <input type="date" id="payment-date" class="border border-gray-200 py-2 px-4 rounded-lg w-full" />
            </div>

            <div>
                <label for="receipt-name" class="text-sm font-medium">Payment Receipt Name</label>
                <input type="text" id="receipt-name" class="border border-gray-200 py-2 px-4 rounded-lg w-full" />
            </div>

            <div>
                <label for="remarks" class="text-sm font-medium">Remarks (Optional)</label>
                <textarea id="remarks" rows="2" class="border border-gray-200 py-2 px-4 rounded-lg w-full"></textarea>
            </div>

            <div class="flex justify-end gap-4 pt-4">
                <button type="button" id="closeModal" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Cancel</button>
                <button type="submit" class="px-6 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition">Submit</button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
$pageScripts = '
<script type="module" src="/hoa_system/ui/modules/fee-assignation/payment-form.js"></script>
';
require_once BASE_PATH . '/pages/layout.php';
?>
