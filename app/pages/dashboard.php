<?php
  include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/config.php');
  include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/connection/connection.php');
  include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/session.php');
  $id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/page-icon.php'); ?>
  <?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/styles.php'); ?>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
</head>
<body>
  <div class="h-screen flex">
    <?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/sidebar.php'); ?>
    <div class="flex flex-col flex-1">
      <?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/header.php'); ?>
      <main class="flex-1 overflow-y-auto p-6">
      <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
          <!-- Total Users -->
          <a href="registered-homeowners.html" class="block">
            <div class="bg-white rounded-lg shadow p-6 cursor-pointer">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-gray-500">Total Users</p>
                  <p class="text-2xl font-bold text-gray-900">156</p>
                </div>
                <div class="bg-teal-100 p-3 rounded-full text-teal-600">
                  <i class="fas fa-users"></i>
                </div>
              </div>
            </div>
          </a>

          <!-- Total Events -->
          <a href="president-calendar.html" class="block">
            <div class="bg-white rounded-lg shadow p-6 cursor-pointer">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-gray-500">Total Events</p>
                  <p class="text-2xl font-bold text-gray-900">24</p>
                </div>
                <div class="bg-teal-100 p-3 rounded-full text-teal-600">
                  <i class="fas fa-calendar-alt"></i>
                </div>
              </div>
            </div>
          </a>

          <!-- Total Collected Fees -->
          <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-medium text-gray-500">Total Collected Fees</p>
                <p class="text-2xl font-bold text-gray-900">₱179,400</p>
              </div>
              <div class="bg-green-100 p-3 rounded-full text-green-600">
                <i class="fas fa-money-bill-wave"></i>
              </div>
            </div>
          </div>

          <!-- Pending Approvals -->
          <a href="president-projectproposal.html" class="block">
            <div class="bg-white rounded-lg shadow p-6 cursor-pointer">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-gray-500">Pending Approvals</p>
                  <p class="text-2xl font-bold text-gray-900">5</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full text-yellow-600">
                  <i class="fas fa-clipboard-check"></i>
                </div>
              </div>
            </div>
          </a>
        </div>

        <!-- Fee Collection Chart -->
        <div class="bg-white rounded-lg shadow mb-8">
          <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Fee Collection Overview</h2>
          </div>
          <div class="p-6">
            <div class="flex justify-between mb-6">
              <div class="flex space-x-2">
                <button id="dailyBtn" class="px-3 py-1 bg-gray-200 text-gray-700 text-sm rounded-md">Daily</button>
                <button id="weeklyBtn" class="px-3 py-1 bg-gray-200 text-gray-700 text-sm rounded-md">Weekly</button>
                <button id="monthlyBtn" class="px-3 py-1 bg-teal-600 text-white text-sm rounded-md">Monthly</button>
                <button id="annualBtn" class="px-3 py-1 bg-gray-200 text-gray-700 text-sm rounded-md">Annual</button>
              </div>
              <div>
                <select id="yearSelect" class="border border-gray-300 rounded-md shadow-sm py-1 px-3 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-sm">
                  <option value="2025" selected>2025</option>
                  <option value="2023">2023</option>
                  <option value="2022">2022</option>
                  <option value="2021">2021</option>
                </select>
              </div>
            </div>
            <!-- Chart Canvas -->
            <div class="h-64">
              <canvas id="feeCollectionChart"></canvas>
            </div>
            <div class="mt-6 grid grid-cols-4 gap-4 text-center">
              <div>
                <p class="text-sm font-medium text-gray-500">Today</p>
                <p class="text-lg font-semibold text-gray-900">₱3,450</p>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-500">This Week</p>
                <p class="text-lg font-semibold text-gray-900">₱12,800</p>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-500">This Month</p>
                <p class="text-lg font-semibold text-gray-900">₱45,600</p>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-500">This Year</p>
                <p class="text-lg font-semibold text-gray-900">₱179,400</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Today's Payments -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
          <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900">Today's Payments</h2>
            <a href="president-payment-history.html" class="bg-teal-600 text-white px-3 py-1 rounded hover:bg-teal-800 text-sm font-medium">
              View All
            </a>
          </div>
          <div class="overflow-x-auto">
            <table id="paymentTable" class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Name
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Email
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr data-user-id="USER001">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">Maria Santos</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">maria.santos@example.com</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button onclick="openPaymentHistoryModal('USER001', 'Maria Santos', 'maria.santos@example.com')"
                      class="bg-teal-600 text-white px-2 py-1 rounded hover:bg-teal-800">
                      View
                    </button>
                  </td>
                </tr>
                <tr data-user-id="USER002">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">Juan Cruz</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">juan.cruz@example.com</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button onclick="openPaymentHistoryModal('USER002', 'Juan Cruz', 'juan.cruz@example.com')"
                      class="bg-teal-600 text-white px-2 py-1 rounded hover:bg-teal-800">
                      View
                    </button>
                  </td>
                </tr>
                <tr data-user-id="USER003">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">Ana Reyes</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">ana.reyes@example.com</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button onclick="openPaymentHistoryModal('USER003', 'Ana Reyes', 'ana.reyes@example.com')"
                      class="bg-teal-600 text-white px-2 py-1 rounded hover:bg-teal-800">
                      View
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <div class="flex items-center justify-between">
              <div id="paginationText" class="text-sm text-gray-700">
                Showing <span class="font-medium">1</span> to <span class="font-medium">3</span> of <span class="font-medium">3</span> results
              </div>
              <div class="flex space-x-2">
                <button class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                  Previous
                </button>
                <button class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                  Next
                </button>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <!-- Payment History Modal -->
  <div id="paymentHistoryModal"
    class="hidden fixed inset-0 z-50 justify-center items-center w-full h-full overflow-y-auto overflow-x-hidden">
    <div class="relative p-4 w-full max-w-4xl">
      <div class="relative bg-white rounded-lg shadow">
        <div class="flex items-center justify-between p-4 border-b border-gray-200 rounded-t">
          <h3 class="text-xl font-semibold text-gray-900">Payment History</h3>
          <button type="button"
            class="text-gray-400 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex justify-center items-center"
            data-modal-hide="paymentHistoryModal">
            <i class="ri-close-line text-lg"></i>
          </button>
        </div>
        <div class="p-6 space-y-4">
          <div id="paymentHistoryContent" class="overflow-x-auto"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Proof View Modal -->
  <div id="proofViewModal"
    class="hidden fixed inset-0 z-50 justify-center items-center w-full h-full overflow-y-auto overflow-x-hidden">
    <div class="relative p-4 w-full max-w-3xl">
      <div class="relative bg-white rounded-lg shadow">
        <div class="flex items-center justify-between p-4 border-b border-gray-200 rounded-t">
          <h3 class="text-xl font-semibold text-gray-900">Payment Proof</h3>
          <button type="button"
            class="text-gray-400 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex justify-center items-center"
            data-modal-hide="proofViewModal">
            <i class="ri-close-line text-lg"></i>
          </button>
        </div>
        <div class="p-6 flex justify-center">
          <img id="proofImage" src="" alt="Payment Proof" class="max-h-[70vh] rounded-md shadow">
        </div>
      </div>
    </div>
  </div>

  <?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/scripts.php'); ?>
  <?= '<script src="'. BASE_PATH .'/assets/js/dashboard/dashboard.js"></script>' ?>
</body>
</html>
