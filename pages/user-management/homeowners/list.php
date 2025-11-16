<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';

require_once $root . 'config.php';
require_once $root . 'app/includes/session.php';

$userRole = $_SESSION['role'] ?? 0;
$isAdminOrPresident = in_array($userRole, [1, 3]);
$pageTitle = 'Users';
ob_start();

?>
<div class="mt-1">
  <h3 class="text-2xl font-medium text-gray-900 mb-4"></h3>
  
  <div class="flex flex-col sm:flex-row items-center mb-4 gap-3">
    <form class="flex flex-1 w-full">
      <label for="simple-search" class="sr-only">Search</label>
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

    <?php if ($isAdminOrPresident): ?>
      <a href="<?= 'create.php' ?>" 
         class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 text-sm font-medium transition whitespace-nowrap">
        Add Homeowner
      </a>
    <?php endif; ?>
  </div>

  <div class="relative overflow-x-auto shadow-md sm:rounded-lg border border-gray-200">
    <table id="dataTable" class="w-full text-sm text-left text-gray-500">
      <thead class="text-xs text-gray-700 uppercase bg-gray-100">
        <tr>
          <th class="px-6 py-3">Name</th>
          <th class="px-6 py-3">Status</th>
          <th class="px-6 py-3">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr class="border-b"><td colspan="4" class="px-6 py-4"><div class="h-4 bg-gray-200 rounded animate-pulse"></div></td></tr>
        <tr class="border-b"><td colspan="4" class="px-6 py-4"><div class="h-4 bg-gray-200 rounded animate-pulse"></div></td></tr>
        <tr class="border-b"><td colspan="4" class="px-6 py-4"><div class="h-4 bg-gray-200 rounded animate-pulse"></div></td></tr>
      </tbody>
    </table>

    <nav id="paginationNav" class="flex flex-col sm:flex-row items-center justify-between p-4 text-sm gap-3">
      <span id="pageInfo" class="text-gray-500">
        Showing <span id="rangeStart" class="font-semibold text-gray-900">1</span>-
        <span id="rangeEnd" class="font-semibold text-gray-900">10</span>
        of <span id="totalRecords" class="font-semibold text-gray-900">0</span>
      </span>
      <ul id="paginationList" class="inline-flex -space-x-px h-8"></ul>
    </nav>
  </div>

  <div data-module="users"></div>
</div>

<?php
$content = ob_get_clean();

$pageScripts = '
  <script src="' . BASE_URL . 'ui/modules/users/get.homeowners.js"></script>
';

require_once BASE_PATH . '/pages/layout.php';
?>