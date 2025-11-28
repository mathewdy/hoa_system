<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';
require_once $root . 'config.php';
include_once($root . 'app/core/init.php');

if (!isset($_GET['id'])) {
    die("Invalid request — Missing ID.");
}
$toda_id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM toda WHERE id = ?");
$stmt->bind_param("i", $toda_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) die("TODA not found.");
$toda = $result->fetch_assoc();
$pageTitle = 'Pay TODA Fee';
ob_start();
?>

<div class="">
    <div class="rounded-lg shadow-sm">
        <div class="mb-5 border-b-2 border-gray-300 pb-4">
            <h3 class="text-2xl font-medium text-gray-900 leading-none">Pay TODA Franchise Fee</h3>
            <p class="text-gray-600">Record TODA fee payment</p>
        </div>

        <form id="todaPaymentForm" method="POST" class="space-y-4">
            
            <input type="hidden" name="id" value="<?= $toda['id'] ?>">

            <div class="border-2 border-gray-200 px-8 py-6 rounded-lg shadow-sm">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Payment Details</h2>

                <div class="grid grid-cols-1 md:grid-cols-1 gap-6">

                    <div class="grid grid-cols-2 items-center">
                        <label class="block text-sm font-medium text-gray-700">TODA Name</label>
                        <input type="text" value="<?= htmlspecialchars($toda['toda_name']) ?>" 
                               class="mt-1 block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2" readonly>
                    </div>

                    <div class="grid grid-cols-2 items-center">
                        <label class="block text-sm font-medium text-gray-700">Amount Paid <span class="text-red-500">*</span></label>
                        <input type="number" name="amount_paid" step="0.01" min="0" required
                               class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 px-3 py-2">
                    </div>

                    <div class="grid grid-cols-2 items-center">
                        <label class="block text-sm font-medium text-gray-700">Due Date <span class="text-red-500">*</span></label>
                        <input type="date" name="due_date" required
                               class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 px-3 py-2">
                    </div>

                </div>
            </div>

            <div class="flex justify-end gap-4 pt-4">
                <a href="list.php" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Cancel</a>
                <button type="submit" class="px-8 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition font-medium">
                    Record Payment
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById("todaPaymentForm").addEventListener("submit", async (e) => {
    e.preventDefault();
    const fd = new FormData(e.target);
    const res = await fetch("/hoa_system/pages/amenities/tricycle/new-payment.php", { method: "POST", body: fd });
    const data = await res.json();
    alert(data.success ? "TODA fee recorded!" : "Error: " + data.message);
    if (data.success) location.href = "list.php";
});
</script>

<?php
$content = ob_get_clean();
require_once BASE_PATH . '/pages/layout.php';
?>