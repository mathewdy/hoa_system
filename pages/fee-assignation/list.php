<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';
require_once $root . 'config.php';
require_once $root . 'app/includes/session.php';

$pageTitle = 'Homeowner Fees';
ob_start();
?>

<div class="mt-1">
  <h3 class="text-2xl font-medium text-gray-900 mb-4"><?= $pageTitle ?></h3>

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

  <div class="relative shadow-md sm:rounded-lg border">
    <table id="dataTable" class="w-full text-sm text-left text-gray-500">
      <thead class="text-xs text-gray-700 uppercase bg-gray-100">
        <tr>
          <th class="px-6 py-3">Name</th>
          <th class="px-6 py-3">Amount Due</th>
          <th class="px-6 py-3">Status</th>
          <th class="px-6 py-3">Due Date</th>
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

  <!-- MODULE TRIGGER -->
  <div data-module="homeowners"></div>
</div>

<!-- Modal -->
<div id="paymentModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center">
  <div class="bg-white rounded-lg w-96 p-6 relative">
    <button id="closeModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-900">
      <i class="ri-close-line text-2xl"></i>
    </button>

    <h2 class="text-xl font-medium text-gray-900 mb-4">Payment Details</h2>
    
    <div id="paymentDetails" class="space-y-2 text-sm text-gray-700">
      <p><strong>Name:</strong> <span id="detailName"></span></p>
      <p><strong>Payment For:</strong> <span id="detailFor"></span></p>
      <p><strong>Amount Paid:</strong> <span id="detailAmount"></span></p>
      <p><strong>Ref. No.:</strong> <span id="detailRef"></span></p>
      <p><strong>Payment Method:</strong> <span id="detailMethod"></span></p>
      <!-- <p><strong>Attachment:</strong> <a href="#" id="detailAttachment" target="_blank">View</a></p> -->
    </div>

    <div class="flex justify-end gap-2 mt-6">
      <button id="cancelBtn" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Cancel</button>
      <button id="rejectBtn" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Reject</button>
      <button id="approveBtn" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700">Walk-in Payment</button>
    </div>
  </div>
</div>
<?php
$content = ob_get_clean();

$pageScripts = '
<script type="module" src="/hoa_system/ui/modules/fee-assignation/get.homeowners.js"></script>

';

require_once BASE_PATH . '/pages/layout.php';
?>
