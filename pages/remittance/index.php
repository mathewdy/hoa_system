<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';
require_once $root . 'config.php';
// require_once $root . 'app/includes/session.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';

$pageTitle = 'Remittance Table';
ob_start();

// Get total collected
$sql_total_collected = "
    SELECT SUM(amount) AS total_collected
    FROM remittance
    WHERE is_approved = 1
";
$result_total = mysqli_query($conn, $sql_total_collected);
$total_collected = 0;
if ($row_total = mysqli_fetch_assoc($result_total)) {
    $total_collected = $row_total['total_collected'] ?? 0;
}
?>

<div class="mt-1">
  <div class="flex flex-col sm:flex-row items-center justify-between mb-4 gap-3">
    <h3 class="text-2xl font-medium text-gray-900 mb-4"><?= $pageTitle ?></h3>
    <div class="flex items-center space-x-6 bg-teal-50 border border-teal-200 rounded-xl px-6 py-3 shadow-sm">
      <div>
        <p class="text-sm font-medium text-teal-700">Total Collected (₱)</p>
        <p id="totalCollected" class="text-2xl font-bold text-black-900">₱<?= number_format($total_collected,2) ?></p>
      </div>
      <a href="remit.php?action=remit" class="bg-teal-700 text-white px-4 py-2 rounded-lg hover:bg-teal-800">
        Remit
      </a>
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
      <div class="mt-4 flex justify-end gap-3">
        <button id="approveBtn" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Approve</button>
        <button id="rejectBtn" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">Reject</button>
        <button id="cancelBtn" class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500">Cancel</button>
      </div>
    </div>
  </div>

  <div data-module="remittanceTable"></div>
</div>

<?php
$content = ob_get_clean();

$pageScripts = '
<script type="module" src="/hoa_system/ui/modules/remittance/get.remittance.js"></script>
';

require_once BASE_PATH . '/pages/layout.php';
?>
