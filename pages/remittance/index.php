<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';
require_once $root . 'config.php';
// require_once $root . 'app/includes/session.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';
$today = date('Y-m-d');

$total_collected = 0;
$tables = ['homeowner_fees', 'court_fees', 'stall_renter_fees', 'toda_fees'];

foreach ($tables as $table) {
    $sql = "SELECT COALESCE(SUM(amount_paid), 0) FROM $table WHERE status='1' AND DATE(date_created)='$today'";
    $result = $conn->query($sql);
    $total_collected += $result->fetch_row()[0];
}

$pageTitle = 'Remittance Table';
ob_start();

?>

<div class="mt-1">
  <div class="flex flex-col sm:flex-row items-center justify-between mb-4 gap-3">
    <h3 class="text-2xl font-medium text-gray-900 mb-4"><?= $pageTitle ?></h3>
    <div class="flex items-center space-x-6 bg-teal-50 border border-teal-200 rounded-xl px-6 py-3 shadow-sm">
      <div>
        <p class="text-sm font-medium text-teal-700">Total Collected (₱)</p>
        <p id="totalCollected" class="text-2xl font-bold text-black-900">₱<?= number_format($total_collected, 2) ?></p>
      </div>
      <button type="button" id="openRemitModal" data-fee="<?= $total_collected; ?>"
        class="bg-teal-700 hover:bg-teal-800 text-white px-6 py-3 rounded-lg font-bold text-lg shadow-lg transition transform hover:scale-105">
        Remit
      </button>
    </div>
  </div>
  <div class="flex flex-col sm:flex-row items-center mb-4 gap-3">
    <form class="flex flex-1 w-full">
      <div class="relative w-full">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
          <i class="ri-search-line text-gray-400"></i>
        </div>
        <input type="text" id="simple-search"
          class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-1 focus:ring-teal-600 focus:border-teal-600 block w-full ps-10 p-2.5 
                  bg-white placeholder-gray-400" 
          placeholder="Search <?= strtolower($pageTitle) ?>..." />
      </div>
    </form>
  </div>

  <div class="relative overflow-x-auto shadow-md sm:rounded-lg border">
    <table id="dataTable" class="w-full text-sm text-left text-gray-500">
      <thead class="text-xs text-gray-700 uppercase bg-gray-100">
        <tr>
          <th class="px-6 py-3">Particular</th>
          <th class="px-6 py-3">Amount (₱)</th>
          <th class="px-6 py-3">Status</th>
          <th class="px-6 py-3">Action</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>

    <nav class="flex items-center justify-between p-4 text-sm">
      <span class="text-gray-500">
        Showing <span id="rangeStart">1</span>-<span id="rangeEnd">10</span>
        of <span id="totalRecords">0</span>
      </span>
      <ul id="paginationList" class="inline-flex -space-x-px h-8"></ul>
    </nav>
  </div>

  <!-- Modal -->
  <div id="remittanceModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 relative">
      <button id="closeModal" class="absolute top-4 end-4 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
      <h3 class="text-xl font-semibold mb-4">Payment Details</h3>
      <div id="modalContent" class="space-y-2">
        <!-- Details will be injected here -->
      </div>
      <div class="mt-4 flex justify-end gap-2">
        <button id="cancelBtn" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Cancel</button>
        <button id="approveBtn" class="bg-teal-700 text-white px-4 py-2 rounded-lg hover:bg-teal-800">Approve</button>
        <button id="rejectBtn" class="bg-red-700 text-white px-4 py-2 rounded-lg hover:bg-red-800">Reject</button>
      </div>
    </div>
  </div>

  <div data-module="remittanceTable"></div>
</div>
<!-- REMIT MODAL -->
<div id="remitModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
  <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4">
    <div class="flex justify-between items-center p-6 border-b">
      <h3 class="text-xl font-bold text-gray-900">Remit Payment</h3>
      <button id="closeModal" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
    </div>

    <div class="p-6 space-y-5">

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Particular</label>
        <input type="text" id="particular" value="Today's HOA Collected Fee" readonly
          class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-gray-50">
        <input type="hidden" id="user_id" value="<?= $_SESSION['user_id']?>" readonly>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Amount (₱)</label>
        <input type="text" id="amount" value="<?= $total_collected; ?>" readonly
          class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-green-50 font-bold text-green-700 text-lg">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
        <input type="date" id="remitDate" value="<?= date('Y-m-d') ?>"
          class="w-full border border-gray-300 rounded-lg px-4 py-3">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Transaction Type</label>
        <select id="transType" class="w-full border border-gray-300 rounded-lg px-4 py-3">
          <option value="Credit">Credit</option>
          <option value="Debit">Debit</option>
        </select>
      </div>
      <div class="flex justify-end gap-3 pt-4">
        <button id="cancelRemit" class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 font-medium">
          Cancel
        </button>
        <button id="confirmRemit" class="px-8 py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700 font-bold shadow-lg">
          Confirm Remit
        </button>
      </div>
    </div>
  </div>
</div>
<?php
$content = ob_get_clean();

$pageScripts = '
<script type="module" src="/hoa_system/ui/modules/remittance/get.remittance.js"></script>
';

require_once BASE_PATH . '/pages/layout.php';
?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("remitModal");
  const openBtn = document.getElementById("openRemitModal");
  const closeBtn = document.getElementById("closeModal");
  const cancelBtn = document.getElementById("cancelRemit");
  const confirmBtn = document.getElementById("confirmRemit");

  openBtn.onclick = () => modal.classList.remove("hidden");
  closeBtn.onclick = cancelBtn.onclick = () => modal.classList.add("hidden");

  confirmBtn.onclick = async () => {
    const amount =  document.getElementById("openRemitModal").dataset.fee;
    const date = document.getElementById("remitDate").value;
    const formatted = new Date(date).toLocaleDateString('en-PH', {
      month: 'short',
      day: 'numeric',
      year: 'numeric'
    });
    const transType = document.getElementById("transType").value;

    if (!date) return alert("Please select date");

    if (!confirm(`Confirm remittance of ₱${amount.toLocaleString()} on ${formatted}?`)) return;

    const res = await fetch("/hoa_system/app/api/remittance/direct-remit.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        amount: amount,
        date: date,
        transaction_type: transType,
        particular: "Today's HOA Collected Fee",
        remitted_by: <?= $_SESSION['user_id'] ?? 0 ?>
      })
    });

    const result = await res.json();

    if (result.success) {
      alert("Payment successfully remitted to bank!");
      modal.classList.add("hidden");
      location.reload();
    } else {
      alert("Error: " + result.message);
    }
  };
});
</script>
