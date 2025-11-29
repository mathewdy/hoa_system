<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';

require_once $root . 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';


$role = $_SESSION['role'] ?? 0;
$pageTitle = 'Users';
$a = $_GET['a'] ?? '0';

$today = date('Y-m-d');
$month = date('M Y');
$total_collected = 0;
$tables = ['homeowner_fees', 'court_fees', 'stall_renter_fees', 'toda_fees'];

foreach ($tables as $table) {
    $sql = "SELECT COALESCE(SUM(amount_paid), 0) FROM $table WHERE status='1' AND DATE(date_created)='$today'";
    $result = $conn->query($sql);
    $total_collected += $result->fetch_row()[0];
}

$sql = "SELECT COUNT(*) AS users_today 
        FROM news_feed";

$result = $conn->query($sql);
$row = $result->fetch_assoc();

$users = $row['users_today'];

$post_sql = "SELECT COUNT(*) AS posts 
        FROM news_feed";

$feed_res = $conn->query($post_sql);
$feed_row = $feed_res->fetch_assoc();

$total_post = $feed_row['posts'];
ob_start();

?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <!-- Added jsPDF autotable plugin for table PDF generation -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
 <style>
    /* Minimal styles for the card and modal */
    .payment-details p {
      margin-bottom: 8px;
    }
    .payment-details label {
      font-weight: 500;
      color: #374151;
    }
    .payment-details span {
      color: #1f2937;
    }
    .payment-card {
      border: 2px solid #14b8a6; /* Teal-500 border */
      background-color: #ccfbf1; /* Teal-50 background */
      border-radius: 4px;
      padding: 16px;
      margin-bottom: 16px;
    }
    .modal-content {
      background-color: white;
      border-radius: 8px;
      width: 100%;
      max-width: 900px; /* Increased max-width for table */
      max-height: 90vh; /* Increased max-height */
      overflow: hidden; /* Changed to hidden, inner div will scroll */
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
    }
    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 16px 24px;
      border-bottom: 1px solid #e5e7eb;
    }
    .modal-header h3 {
      font-size: 18px;
      font-weight: 600;
      color: #1f2937;
      padding-left: 16px; /* Added left padding */
    }
    .modal-header button {
      color: #6b7280;
      font-size: 18px;
      padding-right: 16px; /* Added right padding */
    }
    .modal-body {
      padding: 24px;
      flex-grow: 1;
      overflow-y: auto; /* Make body scrollable */
    }
    /* Excel-like table styles */
    .excel-table {
      border-collapse: collapse;
      width: 100%;
      font-size: 12px;
    }
    .excel-table th,
    .excel-table td {
      border: 1px solid #d1d5db;
      padding: 8px;
      text-align: left;
    }
    .excel-table th {
      background-color: #f3f4f6;
      font-weight: bold;
    }
    .excel-table tr:nth-child(even) {
      background-color: #f9fafb;
    }
    .modal-footer {
      display: flex;
      justify-content: flex-end;
      gap: 8px;
      padding: 16px 24px;
      border-top: 1px solid #e5e7eb;
    }
    .modal-footer button {
      padding: 8px 16px;
      font-size: 14px;
      font-weight: 500;
      border-radius: 4px;
      transition: background-color 0.2s;
    }
    .modal-footer .close-btn {
      background-color: white;
      border: 1px solid #d1d5db;
      color: #374151;
    }
    .modal-footer .close-btn:hover {
      background-color: #f3f4f6;
    }
    .modal-footer .download-btn,
    .modal-footer .print-btn {
      background-color: #14b8a6;
      border: none;
      color: white;
    }
    .modal-footer .download-btn:hover,
    .modal-footer .print-btn:hover {
      background-color: #0d9488;
    }
  </style>
<?php 
  if($role != 6){
    ?>
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">

  <!-- CARD 1: Total Users -->
  <div class="bg-white rounded-2xl shadow-2xl p-8 border border-gray-200 hover:shadow-3xl transition duration-300">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-gray-600 text-lg font-semibold">Total Registered Users</p>
        <p class="text-6xl font-extrabold text-black mt-4"><?= $users ?></p>
        <p class="text-gray-500 text-sm mt-2">Active homeowners</p>
      </div>
      <div class="bg-gray-100 p-6 rounded-2xl">
        <i class="fas fa-users text-5xl text-blue-600"></i>
      </div>
    </div>
  </div>

  <!-- CARD 2: Total Posts -->
  <div class="bg-white rounded-2xl shadow-2xl p-8 border border-gray-200 hover:shadow-3xl transition duration-300">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-gray-600 text-lg font-semibold">Total Community Posts</p>
        <p class="text-6xl font-extrabold text-black mt-4"><?= $total_post ?></p>
        <p class="text-gray-500 text-sm mt-2">Announcements & updates</p>
      </div>
      <div class="bg-gray-100 p-6 rounded-2xl">
        <i class="ri-sticky-note-fill text-5xl text-yellow-400"></i>
      </div>
    </div>
  </div>

  <!-- CARD 3: Total Collected Fees -->
  <div class="bg-white rounded-2xl shadow-2xl p-8 border border-gray-200 hover:shadow-3xl transition duration-300">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-gray-600 text-lg font-semibold">Total Collected Fees</p>
        <p class="text-6xl font-extrabold text-black mt-4">₱<?= number_format($total_collected, 2) ?></p>
        <p class="text-gray-500 text-sm mt-2">All time collection</p>
      </div>
      <div class="bg-gray-100 p-6 rounded-2xl">
        <i class="fas fa-money-bill-wave text-5xl text-teal-600"></i>
      </div>
    </div>
  </div>

  <!-- CARD 4: Pending Approvals -->
  <div class="bg-white rounded-2xl shadow-2xl p-8 border border-gray-200 hover:shadow-3xl transition duration-300">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-gray-600 text-lg font-semibold">Pending Approvals</p>
        <p class="text-6xl font-extrabold text-black mt-4"><?= $pending_approvals ?? 0 ?></p>
        <p class="text-gray-500 text-sm mt-2">Waiting for review</p>
      </div>
      <div class="bg-gray-100 p-6 rounded-2xl">
        <i class="fas fa-clock text-5xl text-orange-400"></i>
      </div>
    </div>
  </div>

</div>

<div id="paymentHistoryModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="modal-content">
      <div class="modal-header">
        <h3 id="modal-user-name" class="text-lg font-semibold text-gray-900"></h3>
        <button onclick="closePaymentHistoryModal()">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <!-- Added filtering controls section -->
      <div class="p-4 border-b border-gray-200 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center space-x-2">
          <label for="filterMonth" class="text-sm font-medium text-gray-700">Month:</label>
          <select id="filterMonth" class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-teal-500" onchange="filterPaymentsInModal()">
            <option value="">All</option>
            <option value="01">January</option>
            <option value="02">February</option>
            <option value="03">March</option>
            <option value="04">April</option>
            <option value="05">May</option>
            <option value="06">June</option>
            <option value="07">July</option>
            <option value="08">August</option>
            <option value="09">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
          </select>
          <label for="filterYear" class="text-sm font-medium text-gray-700">Year:</label>
          <select id="filterYear" class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-teal-500" onchange="filterPaymentsInModal()">
            <option value="">All</option>
            <option value="2023">2023</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
          </select>
          <label for="filterDay" class="text-sm font-medium text-gray-700">Day:</label>
          <input type="number" id="filterDay" placeholder="Day" min="1" max="31" class="w-20 px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-teal-500" oninput="filterPaymentsInModal()">
        </div>
        <div class="flex items-center space-x-4">
          <button onclick="selectAllPayments()" class="text-teal-600 hover:text-teal-800 text-sm">
            <i class="fas fa-check-square mr-1"></i> Select All
          </button>
          <button onclick="deselectAllPayments()" class="text-gray-600 hover:text-gray-800 text-sm">
            <i class="fas fa-square mr-1"></i> Deselect All
          </button>
          <span id="selectedPaymentsCount" class="text-sm text-gray-600">0 selected</span>
        </div>
      </div>
      <div class="modal-body" id="paymentHistoryBody">
        <!-- Payment table will be dynamically inserted here -->
      </div>
      <div class="modal-footer">
        <button onclick="closePaymentHistoryModal()" class="close-btn">Close</button>
        <button onclick="downloadPDF()" class="download-btn">Download PDF</button>
        <button onclick="printPaymentHistory()" class="print-btn">Print</button>
      </div>
    </div>
  </div>

  <!-- Proof View Modal -->
  <div id="proofViewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl mx-4 max-h-[90vh] overflow-hidden">
      <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900 pl-4">Proof of Payment</h3>
        <button onclick="closeProofViewModal()" class="text-gray-400 hover:text-gray-600 pr-4">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="p-6 overflow-y-auto max-h-[70vh]">
        <div id="proofViewContent" class="text-center">
          <!-- Proof content will be displayed here -->
        </div>
      </div>
    </div>
  </div>



   <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Sidebar functionality
      const sidebarLinks = document.querySelectorAll('nav a');
      const currentPath = window.location.pathname.split('/').pop();

      sidebarLinks.forEach(link => {
        if (link.getAttribute('href') === currentPath) {
          sidebarLinks.forEach(l => l.classList.remove('bg-teal-700', 'bg-teal-900'));
          link.classList.add('bg-teal-700');
        }

        link.addEventListener('mouseenter', function() {
          if (!link.classList.contains('bg-teal-700')) {
            link.classList.add('bg-teal-600');
          }
        });

        link.addEventListener('mouseleave', function() {
          if (!link.classList.contains('bg-teal-700')) {
            link.classList.remove('bg-teal-600');
          }
        });

        link.addEventListener('click', function(e) {
          if (link.getAttribute('href') === currentPath) {
            e.preventDefault();
            sidebarLinks.forEach(l => l.classList.remove('bg-teal-700', 'bg-teal-900'));
            link.classList.add('bg-teal-700');
          }
        });
      });

      // Sample payment data for each user
      const paymentData = {
        USER001: [
          { paymentId: 'PAY001', paymentFor: 'Monthly Dues', amount: '50', date: '2025-01-01', time: '10:00 AM', method: 'Bank Transfer', status: 'paid', address: 'Block 5, Lot 12', proofType: 'image', proofUrl: '/placeholder.svg?height=300&width=400', type: 'Resident' },
          { paymentId: 'PAY006', paymentFor: 'Monthly Dues', amount: '50', date: '2025-02-15', time: '02:30 PM', method: 'GCash', status: 'paid', address: 'Block 5, Lot 12', proofType: 'image', proofUrl: '/placeholder.svg?height=300&width=400', type: 'Resident' },
          { paymentId: 'PAY007', paymentFor: 'Monthly Dues', amount: '50', date: '2025-03-20', time: '01:00 PM', method: 'GCash', status: 'paid', address: 'Block 5, Lot 12', proofType: 'image', proofUrl: '/placeholder.svg?height=300&width=400', type: 'Resident' },
          { paymentId: 'PAY008', paymentFor: 'Monthly Dues', amount: '50', date: '2024-12-05', time: '09:00 AM', method: 'Bank Transfer', status: 'paid', address: 'Block 5, Lot 12', proofType: 'pdf', proofUrl: '/placeholder.svg?height=300&width=400', type: 'Resident' }
        ],
        USER002: [
          { paymentId: 'PAY002', paymentFor: 'Monthly Dues', amount: '50', date: '2025-01-02', time: '11:15 AM', method: 'GCash', status: 'paid', address: 'Block 2, Lot 8', proofType: 'image', proofUrl: '/placeholder.svg?height=300&width=400', type: 'Resident' }
        ],
        USER003: [
          { paymentId: 'PAY003', paymentFor: 'Monthly Dues', amount: '50', date: '2025-02-03', time: '09:45 AM', method: 'GCash', status: 'paid', address: 'Block 3, Lot 15', proofType: 'image', proofUrl: '/placeholder.svg?height=300&width=400', type: 'Non-Resident' }
        ]
      };

      // Added variables for tracking current payments and selections
      let currentPayments = []; // Stores the payments for the currently open modal
      let selectedPaymentIds = new Set(); // Stores IDs of selected payments

      window.openPaymentHistoryModal = function(userId, name, email) {
        const modal = document.getElementById('paymentHistoryModal');
        const modalUserName = document.getElementById('modal-user-name');

        modalUserName.textContent = `${name} (${userId}) - Payment History`;
        
        // Reset filters and selections
        document.getElementById('filterMonth').value = '';
        document.getElementById('filterYear').value = '';
        document.getElementById('filterDay').value = '';
        selectedPaymentIds.clear();

        currentPayments = paymentData[userId] || [];
        renderPaymentTable(currentPayments);
        updateSelectedPaymentsCount();

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
      };

      // Added renderPaymentTable function to create Excel-style table
      function renderPaymentTable(paymentsToRender) {
        const modalBody = document.getElementById('paymentHistoryBody');
        modalBody.innerHTML = `
          <table class="excel-table">
            <thead>
              <tr>
                <th width="30">
                  <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this.checked)">
                </th>
                <th>Fee Name</th>
                <th>Amount</th>
                <th>Due Date</th>
                <th>Status Paid</th>
                <th>Payment Method (GCash or Bank Transfer Only)</th>
                <th>Reference Number</th>
                <th>Uploaded Receipt</th>
              </tr>
            </thead>
            <tbody id="paymentTableBody">
            </tbody>
          </table>
        `;

        const tbody = document.getElementById('paymentTableBody');
        paymentsToRender.forEach(payment => {
          const referenceNumber = `REF-${new Date(payment.date).getFullYear()}-${String(payment.paymentId.slice(-3)).padStart(4, '0')}`;
          
          const isSelected = selectedPaymentIds.has(payment.paymentId);

          tbody.innerHTML += `
            <tr data-payment-id="${payment.paymentId}" class="${isSelected ? 'bg-teal-50' : ''}">
              <td>
                <input type="checkbox" class="payment-checkbox" value="${payment.paymentId}" ${isSelected ? 'checked' : ''} onchange="updateSelectedPayments()">
              </td>
              <td>${payment.paymentFor}</td>
              <td>₱${payment.amount}</td>
              <td>${payment.date}</td>
              <td>${payment.status.charAt(0).toUpperCase() + payment.status.slice(1)}</td>
              <td>${payment.method}</td>
              <td>${referenceNumber}</td>
              <td>
                <button onclick="viewProof('${payment.paymentId}')" class="bg-teal-600 text-white px-3 py-1 rounded hover:bg-teal-800 text-sm">
                  View
                </button>
              </td>
            </tr>
          `;
        });
        // Ensure selectAllCheckbox state is correct after rendering
        const allCheckboxes = document.querySelectorAll('#paymentTableBody .payment-checkbox');
        document.getElementById('selectAllCheckbox').checked = allCheckboxes.length > 0 && selectedPaymentIds.size === allCheckboxes.length;
      }

      // Added filtering, selection, and proof viewing functions
      window.filterPaymentsInModal = function() {
        const monthFilter = document.getElementById('filterMonth').value;
        const yearFilter = document.getElementById('filterYear').value;
        const dayFilter = document.getElementById('filterDay').value;

        const filtered = currentPayments.filter(payment => {
          const paymentDate = new Date(payment.date);
          const paymentMonth = String(paymentDate.getMonth() + 1).padStart(2, '0');
          const paymentYear = String(paymentDate.getFullYear());
          const paymentDay = String(paymentDate.getDate());

          const matchesMonth = !monthFilter || paymentMonth === monthFilter;
          const matchesYear = !yearFilter || paymentYear === yearFilter;
          const matchesDay = !dayFilter || paymentDay === dayFilter.padStart(2, '0');

          return matchesMonth && matchesYear && matchesDay;
        });
        
        renderPaymentTable(filtered);
        updateSelectedPaymentsCount();
      };

      window.selectAllPayments = function() {
        const checkboxes = document.querySelectorAll('#paymentTableBody .payment-checkbox');
        selectedPaymentIds.clear();
        checkboxes.forEach(cb => {
          cb.checked = true;
          selectedPaymentIds.add(cb.value);
          cb.closest('tr').classList.add('bg-teal-50');
        });
        document.getElementById('selectAllCheckbox').checked = true;
        updateSelectedPaymentsCount();
      };

      window.deselectAllPayments = function() {
        const checkboxes = document.querySelectorAll('#paymentTableBody .payment-checkbox');
        selectedPaymentIds.clear();
        checkboxes.forEach(cb => {
          cb.checked = false;
          cb.closest('tr').classList.remove('bg-teal-50');
        });
        document.getElementById('selectAllCheckbox').checked = false;
        updateSelectedPaymentsCount();
      };

      window.updateSelectedPayments = function() {
        selectedPaymentIds.clear();
        const checkboxes = document.querySelectorAll('#paymentTableBody .payment-checkbox');
        checkboxes.forEach(cb => {
          const row = cb.closest('tr');
          if (cb.checked) {
            selectedPaymentIds.add(cb.value);
            row.classList.add('bg-teal-50');
          } else {
            selectedPaymentIds.delete(cb.value);
            row.classList.remove('bg-teal-50');
          }
        });
        document.getElementById('selectAllCheckbox').checked = selectedPaymentIds.size === checkboxes.length && checkboxes.length > 0;
        updateSelectedPaymentsCount();
      };

      function updateSelectedPaymentsCount() {
        document.getElementById('selectedPaymentsCount').textContent = `${selectedPaymentIds.size} selected`;
      }

      window.viewProof = function(paymentId) {
        const payment = currentPayments.find(p => p.paymentId === paymentId);
        if (!payment || !payment.proofUrl) {
          alert('No proof available for this payment.');
          return;
        }

        const proofViewContent = document.getElementById('proofViewContent');
        proofViewContent.innerHTML = '';

        if (payment.proofType === 'image') {
          proofViewContent.innerHTML = `<img src="${payment.proofUrl}" class="max-w-full h-auto mx-auto" alt="Proof of Payment">`;
        } else if (payment.proofType === 'pdf') {
          proofViewContent.innerHTML = `<embed src="${payment.proofUrl}" type="application/pdf" width="100%" height="600px">`;
        } else {
          proofViewContent.innerHTML = `<p class="text-gray-500">Cannot preview this file type. <a href="${payment.proofUrl}" download="${paymentId}_proof" class="text-blue-600 hover:underline">Download to view</a></p>`;
        }
        document.getElementById('proofViewModal').classList.remove('hidden');
      };

      window.closeProofViewModal = function() {
        document.getElementById('proofViewModal').classList.add('hidden');
      };

      window.closePaymentHistoryModal = function() {
        const modal = document.getElementById('paymentHistoryModal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
      };

      window.downloadPDF = function() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('landscape');
        const modalUserName = document.getElementById('modal-user-name').textContent;
        
        const paymentsToPrint = selectedPaymentIds.size > 0
          ? currentPayments.filter(p => selectedPaymentIds.has(p.paymentId))
          : currentPayments;

        if (paymentsToPrint.length === 0) {
          alert('No payments selected or available to download.');
          return;
        }

        const tableData = paymentsToPrint.map(payment => [
          payment.paymentFor,
          `₱${payment.amount}`,
          payment.date,
          payment.status.charAt(0).toUpperCase() + payment.status.slice(1),
          payment.method,
          `REF-${new Date(payment.date).getFullYear()}-${String(payment.paymentId.slice(-3)).padStart(4, '0')}`
        ]);

        doc.setFontSize(18);
        doc.text(modalUserName, 14, 20);
        doc.autoTable({
          startY: 30,
          head: [['Fee Name', 'Amount', 'Due Date', 'Status Paid', 'Payment Method', 'Reference Number']],
          body: tableData,
          theme: 'grid',
          styles: { fontSize: 8, cellPadding: 2, overflow: 'linebreak' },
          headStyles: { fillColor: [243, 244, 246], textColor: [75, 85, 99], fontStyle: 'bold' },
          columnStyles: {
            0: { cellWidth: 40 },
            1: { cellWidth: 20 },
            2: { cellWidth: 25 },
            3: { cellWidth: 20 },
            4: { cellWidth: 25 },
            5: { cellWidth: 40 }
          }
        });

        doc.save(`${modalUserName.replace(/ /g, '_')}_payment_history.pdf`);
      };

      window.printPaymentHistory = function() {
        const originalContent = document.body.innerHTML;
        
        const paymentsToPrint = selectedPaymentIds.size > 0
          ? currentPayments.filter(p => selectedPaymentIds.has(p.paymentId))
          : currentPayments;

        if (paymentsToPrint.length === 0) {
          alert('No payments selected or available to print.');
          return;
        }

        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = `
          <h3 class="text-lg font-semibold text-gray-900 mb-4">${document.getElementById('modal-user-name').textContent}</h3>
          <table class="excel-table">
            <thead>
              <tr>
                <th>Fee Name</th>
                <th>Amount</th>
                <th>Due Date</th>
                <th>Status Paid</th>
                <th>Payment Method</th>
                <th>Reference Number</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        `;
        const tbody = tempDiv.querySelector('tbody');
        paymentsToPrint.forEach(payment => {
          const referenceNumber = `REF-${new Date(payment.date).getFullYear()}-${String(payment.paymentId.slice(-3)).padStart(4, '0')}`;
          tbody.innerHTML += `
            <tr>
              <td>${payment.paymentFor}</td>
              <td>₱${payment.amount}</td>
              <td>${payment.date}</td>
              <td>${payment.status.charAt(0).toUpperCase() + payment.status.slice(1)}</td>
              <td>${payment.method}</td>
              <td>${referenceNumber}</td>
            </tr>
          `;
        });

        document.body.innerHTML = `
          <div style="padding: 20px;">${tempDiv.innerHTML}</div>
          <style>
            body { background: white; }
            .excel-table { border-collapse: collapse; width: 100%; font-size: 12px; }
            .excel-table th, .excel-table td { border: 1px solid #d1d5db; padding: 8px; text-align: left; }
            .excel-table th { background-color: #f3f4f6; font-weight: bold; }
            .excel-table tr:nth-child(even) { background-color: #f9fafb; }
          </style>
        `;
        window.print();
        document.body.innerHTML = originalContent;
      };

      // Button event listeners
      const buttons = {
        daily: document.getElementById('dailyBtn'),
        weekly: document.getElementById('weeklyBtn'),
        monthly: document.getElementById('monthlyBtn'),
        annual: document.getElementById('annualBtn')
      };
      let currentView = 'monthly';
      let currentYear = '2025';

      Object.keys(buttons).forEach(view => {
        buttons[view].addEventListener('click', () => {
          currentView = view;
          Object.values(buttons).forEach(btn => {
            btn.classList.remove('bg-teal-600', 'text-white');
            btn.classList.add('bg-gray-200', 'text-gray-700');
          });
          buttons[view].classList.remove('bg-gray-200', 'text-gray-700');
          buttons[view].classList.add('bg-teal-600', 'text-white');
          updateChart(currentView, currentYear);
        });
      });

      // Year dropdown event listener
      const yearSelect = document.getElementById('yearSelect');
      yearSelect.addEventListener('change', (e) => {
        currentYear = e.target.value;
        updateChart(currentView, currentYear);
      });
    });
  </script>

      <?php
  } else {
  ?>
 <main class="py-6 px-4 sm:px-6 lg:px-8">
          <!-- Welcome Banner -->
          <div
            class="bg-gradient-to-r from-teal-500 to-teal-700 rounded-lg shadow-lg mb-8"
          >
            <div
              class="p-6 md:p-8 flex flex-col md:flex-row items-center justify-between"
            >
              <div class="mb-4 md:mb-0">
                <?php 
                $user_id = $_SESSION['user_id']; 

                $sql = "SELECT * FROM user_info WHERE user_id = $user_id";
                $result_user = $conn->query($sql);
                $row_user = $result_user->fetch_assoc();

                ?>
                <h2 class="text-2xl font-bold">
                  Welcome, <?= $row_user['first_name'] . ' ' . $row_user['last_name'] ?>
                </h2>
                <p class="text-gray-900 mt-1">
                  Block 5 Lot 12, Phase 1, Mabuhay Homes 2000
                </p>
              </div>
              <div
                class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2"
              ></div>
            </div>
          </div>

          
          <!-- Stats Cards -->

  <!-- Total Collected Fees Card -->
  <div class="bg-gradient-to-br from-white to-teal-50 rounded-2xl shadow-lg p-6 border border-teal-100 hover:shadow-2xl transition-shadow duration-300">
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-lg font-semibold text-gray-800">Total Collected Fees</h3>
      <span class="bg-teal-100 text-teal-800 text-xs font-medium px-3 py-1 rounded-full shadow-sm">
        Community Fund
      </span>
    </div>
    <div class="flex items-center">
      <div class="p-4 rounded-full bg-teal-500 text-white shadow-md">
        <i class="fas fa-money-bill-wave text-2xl"></i>
      </div>
      <div class="ml-5">
        <p class="text-4xl font-extrabold text-gray-900">₱<?= number_format($total_collected, 2) ?></p>
        <p class="text-sm text-teal-600 mt-1">as of <?= $month ?></p>
      </div>
    </div>
    <div class="mt-6">
      <a href="#" class="inline-flex items-center text-teal-600 hover:text-teal-800 text-sm font-medium transition-colors">
        View breakdown <i class="fas fa-arrow-right ml-1"></i>
      </a>
    </div>
  </div>


    <!-- Pay Now Modal -->
    <div id="payNowModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
      <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
          <h3 class="text-lg font-medium">Make a Payment</h3>
          <button onclick="closePayNowModal()" class="text-gray-400 hover:text-gray-500">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="p-6">
          <div class="mb-4">
            <h4 class="text-sm font-medium text-gray-700 mb-2">Payment Details</h4>
            <p class="text-sm text-gray-900">Payment ID: <span id="payNowPaymentId"></span></p>
            <p class="text-sm text-gray-900">Fee ID: <span id="payNowUserId"></span></p>
            <p class="text-sm text-gray-900">Fee Name: <span id="payNowFeeName"></span></p>
            <p class="text-sm text-gray-900">Amount: <span id="payNowAmount"></span></p>
            <p class="text-sm text-gray-900">Due Date: <span id="payNowDate"></span></p>
            <p class="text-sm text-gray-900">Status: <span id="payNowStatus"></span></p>
          </div>
          <h4 class="text-sm font-medium text-gray-700 mb-2">Payment Method</h4>
          <div class="flex justify-center space-x-6">
            <button onclick="showGCashModal()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-28">GCash</button>
            <button onclick="showBankTransferModal()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-28">Bank Transfer</button>
          </div>
        </div>
      </div>
    </div>

    <!-- GCash Payment Modal -->
    <div id="gcashModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
      <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
          <h3 class="text-lg font-medium">GCash Payment</h3>
          <button onclick="closeGCashModal()" class="text-gray-400 hover:text-gray-500">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="p-6">
          <form id="gcashForm">
            <div class="mb-4">
              <h4 class="text-sm font-medium text-gray-700 mb-2">Payment Details</h4>
              <p class="text-sm text-gray-900">Payment ID: <span id="gcashPaymentId"></span></p>
              <p class="text-sm text-gray-900">Fee ID: <span id="gcashUserId"></span></p>
              <p class="text-sm text-gray-900">Fee Name: <span id="gcashFeeName"></span></p>
              <p class="text-sm text-gray-900">Amount: <span id="gcashAmount"></span></p>
            </div>
            <div class="mb-4 bg-gray-100 p-4 rounded-md shadow-sm">
              <h4 class="text-sm font-medium text-gray-700 mb-2">GCash Details</h4>
              <p class="text-sm text-gray-900">GCash Number: 0917 123 4567</p>
              <p class="text-sm text-gray-900">GCash Name: Mabuhay Homes 2000 HOA</p>
              <div class="mt-2">
                <p class="text-sm font-medium text-gray-700">Scan GCash QR Code</p>
                <img src="https://via.placeholder.com/150" alt="GCash QR Code" class="w-32 h-32 mt-2">
              </div>
            </div>
            <div class="mb-4">
              <h4 class="text-sm font-medium text-gray-700 mb-2">Proof of Payment</h4>
              <div class="mb-2">
                <label for="gcashReceipt" class="block text-sm font-medium text-gray-700 mb-1">Upload Receipt</label>
                <input type="file" id="gcashReceipt" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-md">
              </div>
            </div>
            <div class="mt-6">
              <button type="submit" class="w-full bg-teal-600 hover:bg-teal-500 text-white font-medium py-2 px-4 rounded">Submit Receipt</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Bank Transfer Payment Modal -->
    <div id="bankTransferModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
      <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
          <h3 class="text-lg font-medium">Bank Transfer Payment</h3>
          <button onclick="closeBankTransferModal()" class="text-gray-400 hover:text-gray-500">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="p-6">
          <form id="bankTransferForm">
            <div class="mb-4">
              <h4 class="text-sm font-medium text-gray-700 mb-2">Payment Details</h4>
              <p class="text-sm text-gray-900">Payment ID: <span id="bankPaymentId"></span></p>
              <p class="text-sm text-gray-900">Fee ID: <span id="bankUserId"></span></p>
              <p class="text-sm text-gray-900">Fee Name: <span id="bankFeeName"></span></p>
              <p class="text-sm text-gray-900">Amount: <span id="bankAmount"></span></p>
            </div>
            <div class="mb-4 bg-gray-100 p-4 rounded-md shadow-sm">
              <h4 class="text-sm font-medium text-gray-700 mb-2">Bank Details</h4>
              <p class="text-sm text-gray-900">Bank Name: BDO</p>
              <p class="text-sm text-gray-900">Account Number: 1234 5678 9012</p>
              <p class="text-sm text-gray-900">Account Name: Mabuhay Homes 2000 HOA</p>
            </div>
            <div class="mb-4">
              <h4 class="text-sm font-medium text-gray-700 mb-2">Proof of Payment</h4>
              <div class="mb-2">
                <label for="bankReceipt" class="block text-sm font-medium text-gray-700 mb-1">Upload Receipt</label>
                <input type="file" id="bankReceipt" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-md">
              </div>
            </div>
            <div class="mt-6">
              <button type="submit" class="w-full bg-teal-600 hover:bg-teal-500 text-white font-medium py-2 px-4 rounded">Submit Receipt</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script>
      // Mock database to store payment data and proofs
      const paymentData = {
        'PAY001': { paymentId: 'PAY001', feeId: 'FEE001', feeName: 'Monthly Dues Fee - March 2025', amount: '50', dueDate: '2025-03-31', status: 'Overdue', proof: '', paymentMethod: '' },
        'PAY002': { paymentId: 'PAY002', feeId: 'FEE002', feeName: 'Monthly Dues Fee - April 2025', amount: '50', dueDate: '2025-04-30', status: 'Overdue', proof: '', paymentMethod: '' },
        'PAY003': { paymentId: 'PAY003', feeId: 'FEE003', feeName: 'Monthly Dues Fee - May 2025', amount: '50', dueDate: '2025-05-31', status: 'Pending', proof: 'https://via.placeholder.com/150', paymentMethod: 'GCash' },
        'PAY004': { paymentId: 'PAY004', feeId: 'FEE004', feeName: 'Monthly Dues Fee - February 2025', amount: '50', dueDate: '2025-02-28', status: 'Paid', proof: '', paymentMethod: 'GCash' },
        'PAY005': { paymentId: 'PAY005', feeId: 'FEE005', feeName: 'Monthly Dues Fee - January 2025', amount: '50', dueDate: '2025-01-31', status: 'Paid', proof: '', paymentMethod: 'Bank Transfer' }
      };

      // Show Pay Now modal with details
      function showPayNowModal(paymentId, feeId, feeName, amount, dueDate, status) {
        document.getElementById('payNowPaymentId').textContent = paymentId;
        document.getElementById('payNowUserId').textContent = feeId;
        document.getElementById('payNowFeeName').textContent = feeName;
        document.getElementById('payNowAmount').textContent = `₱${amount}`;
        document.getElementById('payNowDate').textContent = dueDate;
        document.getElementById('payNowStatus').textContent = status;
        document.getElementById('payNowModal').classList.remove('hidden');
      }

      function closePayNowModal() {
        document.getElementById('payNowModal').classList.add('hidden');
      }

      // Modal functions for payment methods
      function showGCashModal() {
        document.getElementById('payNowModal').classList.add('hidden');
        document.getElementById('gcashModal').classList.remove('hidden');
      }

      function closeGCashModal() {
        document.getElementById('gcashModal').classList.add('hidden');
        document.getElementById('payNowModal').classList.remove('hidden');
      }

      function showBankTransferModal() {
        document.getElementById('payNowModal').classList.add('hidden');
        document.getElementById('bankTransferModal').classList.remove('hidden');
      }

      function closeBankTransferModal() {
        document.getElementById('bankTransferModal').classList.add('hidden');
        document.getElementById('payNowModal').classList.remove('hidden');
      }

      // Handle form submissions
      document.getElementById('gcashForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const paymentId = document.getElementById('gcashPaymentId').textContent;
        const fileInput = document.getElementById('gcashReceipt');
        if (fileInput.files[0]) {
          const reader = new FileReader();
          reader.onload = function(e) {
            paymentData[paymentId].status = 'Pending';
            paymentData[paymentId].proof = e.target.result;
            paymentData[paymentId].paymentMethod = 'GCash';
            updateTable();
            closePayNowModal();
            closeGCashModal();
          };
          reader.readAsDataURL(fileInput.files[0]);
        }
      });

      document.getElementById('bankTransferForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const paymentId = document.getElementById('bankPaymentId').textContent;
        const fileInput = document.getElementById('bankReceipt');
        if (fileInput.files[0]) {
          const reader = new FileReader();
          reader.onload = function(e) {
            paymentData[paymentId].status = 'Pending';
            paymentData[paymentId].proof = e.target.result;
            paymentData[paymentId].paymentMethod = 'Bank Transfer';
            updateTable();
            closePayNowModal();
            closeBankTransferModal();
          };
          reader.readAsDataURL(fileInput.files[0]);
        }
      });

      // Update table
      function updateTable() {
        const tbody = document.getElementById('paymentTableBody');
        tbody.innerHTML = '';
        const sortedPayments = Object.values(paymentData)
          .filter(payment => payment.status !== 'Paid')
          .sort((a, b) => new Date(b.dueDate) - new Date(a.dueDate));

        sortedPayments.forEach(payment => {
          const row = document.createElement('tr');
          row.setAttribute('data-payment-id', payment.paymentId);
          row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">${payment.feeId}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">${payment.feeName}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">₱${payment.amount}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">${payment.dueDate}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                ${payment.status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 
                  payment.status === 'Unpaid' ? 'bg-red-100 text-red-800' : 'bg-orange-100 text-orange-800'}">
                ${payment.status}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              ${payment.status === 'Pending' ? 
                `<button onclick="viewPayment('${payment.paymentId}', '${payment.feeId}', '${payment.feeName}', '${payment.amount}', '${payment.dueDate}', '${payment.status}', '${payment.paymentMethod || ''}')" class="bg-teal-600 text-white px-3 py-1 rounded hover:bg-teal-500 w-20">View</button>` :
                `<button onclick="showPayNowModal('${payment.paymentId}', '${payment.feeId}', '${payment.feeName}', '${payment.amount}', '${payment.dueDate}', '${payment.status}')" class="bg-teal-600 text-white px-3 py-1 rounded hover:bg-teal-500 w-20">Pay Now</button>`}
            </td>
          `;
          tbody.appendChild(row);
        });

        const totalEntries = sortedPayments.length;
        document.getElementById('totalEntries').textContent = totalEntries;
        const showingFrom = 1;
        const showingTo = Math.min(2, totalEntries);
        document.getElementById('showingFrom').textContent = showingFrom;
        document.getElementById('showingTo').textContent = showingTo;
      }

      // Pagination controls
      let currentPage = 1;
      const itemsPerPage = 2;
      const prevPageBtn = document.getElementById('prevPage');
      const nextPageBtn = document.getElementById('nextPage');

      function paginateTable() {
        const tbody = document.getElementById('paymentTableBody');
        const sortedPayments = Object.values(paymentData)
          .filter(payment => payment.status !== 'Paid')
          .sort((a, b) => new Date(b.dueDate) - new Date(a.dueDate));
        const totalPages = Math.ceil(sortedPayments.length / itemsPerPage);
        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const paginatedData = sortedPayments.slice(start, end);

        tbody.innerHTML = '';
        paginatedData.forEach(payment => {
          const row = document.createElement('tr');
          row.setAttribute('data-payment-id', payment.paymentId);
          row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">${payment.feeId}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">${payment.feeName}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">₱${payment.amount}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">${payment.dueDate}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                ${payment.status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 
                  payment.status === 'Unpaid' ? 'bg-red-100 text-red-800' : 'bg-orange-100 text-orange-800'}">
                ${payment.status}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              ${payment.status === 'Pending' ? 
                `<button onclick="viewPayment('${payment.paymentId}', '${payment.feeId}', '${payment.feeName}', '${payment.amount}', '${payment.dueDate}', '${payment.status}', '${payment.paymentMethod || ''}')" class="bg-teal-600 text-white px-3 py-1 rounded hover:bg-teal-500 w-20">View</button>` :
                `<button onclick="showPayNowModal('${payment.paymentId}', '${payment.feeId}', '${payment.feeName}', '${payment.amount}', '${payment.dueDate}', '${payment.status}')" class="bg-teal-600 text-white px-3 py-1 rounded hover:bg-teal-500 w-20">Pay Now</button>`}
            </td>
          `;
          tbody.appendChild(row);
        });

        const totalEntries = sortedPayments.length;
        const showingFrom = start + 1;
        const showingTo = Math.min(end, totalEntries);
        document.getElementById('showingFrom').textContent = showingFrom;
        document.getElementById('showingTo').textContent = showingTo;
        document.getElementById('totalEntries').textContent = totalEntries;

        prevPageBtn.disabled = currentPage === 1;
        nextPageBtn.disabled = currentPage === totalPages;
      }

      prevPageBtn.addEventListener('click', () => {
        if (currentPage > 1) {
          currentPage--;
          paginateTable();
        }
      });

      nextPageBtn.addEventListener('click', () => {
        const totalPages = Math.ceil(Object.values(paymentData).filter(payment => payment.status !== 'Paid').length / itemsPerPage);
        if (currentPage < totalPages) {
          currentPage++;
          paginateTable();
        }
      });

      // Sidebar Navigation Highlighting
      document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname.split('/').pop();
        const sidebarLinks = document.querySelectorAll('nav a');

        sidebarLinks.forEach(link => {
          const href = link.getAttribute('href');
          // Highlight only the current page
          if (href === currentPath) {
            link.classList.add('bg-teal-600');
          }

          link.addEventListener('click', function(e) {
            // Prevent default if already on the same page
            if (href === currentPath) {
              e.preventDefault();
            }
            // Only highlight if not a dropdown item on dashboard
            if (currentPath !== 'homeowner-dashboard.html' || !link.closest('[x-show]')) {
              sidebarLinks.forEach(l => l.classList.remove('bg-teal-600'));
              link.classList.add('bg-teal-600');
            }
          });
        });

        paginateTable();
      });
    </script>
  <?php
  }
?>
<?php
$content = ob_get_clean();

$pageScripts = '

';

require_once $root . '/pages/layout.php';
?>