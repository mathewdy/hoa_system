<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';
require_once $root . 'config.php';
// require_once $root . 'app/includes/session.php';
include_once($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php');
$pageTitle = 'Homeowners';
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
<div id="project-proposals" class="mb-8"> 
                <!-- Header Row with Title + Search/Filters -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                  <h2 class="text-xl font-semibold text-gray-900">Ongoing Projects Table</h2>
                  
                  <!-- Search and Filters -->
                  <div class="flex flex-col sm:flex-row sm:space-x-4 mt-4 sm:mt-0">
                    <div class="w-full sm:w-64">
                      <label for="search" class="sr-only">Search</label>
                      <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                          <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input id="search" type="text" placeholder="Search by title"
                          class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm" />
                      </div>
                    </div>
                    <div class="flex space-x-4 mt-4 sm:mt-0">
                      <div>
                        <label for="statusFilter" class="sr-only">Filter by Status</label>
                        <select id="statusFilter"
                          class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                          <option value="">All Statuses</option>
                          <option value="Approved">Approved</option>
                          <option value="Waiting for Approval">Waiting for Approval</option>
                          <option value="Rejected">Rejected</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>


              <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                  <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PARTICULARS</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STATUS</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TOTAL EXPENSES</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">AUDIT RESULT</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ACTIONS</th>
                      </tr>
                    </thead>
                    <tbody id="liquidationsTableBody" class="bg-white divide-y divide-gray-200">
                             
                        </tbody>
                    </table>
                </div>
            </div>

             <div id="viewLiquidationModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-5xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800">Expense Liquidation Details</h2>
                <button onclick="closeViewModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="p-6">
                 
                <div class="mb-6 bg-teal-50 p-4 rounded-lg">
                    <div class="mb-3">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Audit Project:</label>
                        <input type="text" id="viewProjectTitle" readonly class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md text-gray-800 font-medium">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Released Budget:</label>
                        <input type="text" id="viewReleasedBudget" readonly class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md text-gray-800 font-medium">
                    </div>
                </div>

                 
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Expenses</h3>
                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700 border-b">Particular</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700 border-b">Amount</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700 border-b">Receipt</th>
                                </tr>
                            </thead>
                            <tbody id="viewExpensesTableBody">
                                
                            </tbody>
                        </table>
                    </div>
                </div>

                 
                <div class="mb-4 bg-gray-50 p-4 rounded-lg">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-800">Total Expenses:</span>
                        <span id="viewTotalExpenses" class="text-2xl font-bold text-teal-600">₱0.00</span>
                    </div>
                </div>

                <div class="mb-6 p-4 rounded-lg border-2" id="viewAuditResultContainer">
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-semibold text-gray-800">Audit Result:</span>
                        <span id="viewAuditResult" class="text-2xl font-bold">-</span>
                    </div>
                    <div class="mt-2 text-sm text-gray-600" id="viewAuditDetails"></div>
                </div>

                 
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Remarks:</label>
                    <textarea id="viewRemarks" readonly rows="3" class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md text-gray-800"></textarea>
                </div>

                <!-- Notes for Rejection Field - Only for Waiting for Approval and Rejected -->
                <div id="notesForRejectionContainer" class="mb-6 hidden">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Notes for Rejection:</label>
                    <textarea id="notesForRejection" rows="3" placeholder="Enter notes for rejection..." class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-red-500 focus:border-red-500"></textarea>
                </div>

                
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button onclick="closeViewModal()" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                        Close
                    </button>
                    <button onclick="rejectLiquidation()" id="rejectBtn" class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors flex items-center hidden">
                        <i class="fas fa-times mr-2"></i>
                        Reject
                    </button>
                    <button onclick="approveLiquidation()" id="approveBtn" class="px-6 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition-colors flex items-center hidden">
                        <i class="fas fa-check mr-2"></i>
                        Approve
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sample liquidation data
        const liquidations = [
            {
                id: 1,
                particular: 'Basketball Court Renovation',
                status: 'Approved',
                budgetReleased: 150000,
                totalExpenses: 148500,
                auditResult: 'Underspent',
                expenses: [
                    { particular: 'Court Flooring Materials', amount: 85000, receipt: 'receipt1.pdf' },
                    { particular: 'Paint and Coating', amount: 25000, receipt: 'receipt2.pdf' },
                    { particular: 'Basketball Hoops and Equipment', amount: 28500, receipt: 'receipt3.pdf' },
                    { particular: 'Labor Costs', amount: 10000, receipt: 'receipt4.pdf' }
                ],
                remarks: 'Project completed within budget. Remaining funds can be allocated to maintenance.',
                notesForRejection: ''
            },
            {
                id: 2,
                particular: 'Street Lighting Upgrade',
                status: 'Waiting for Approval',
                budgetReleased: 85000,
                totalExpenses: 87200,
                auditResult: 'Overspent',
                expenses: [
                    { particular: 'LED Light Fixtures', amount: 45000, receipt: 'receipt5.pdf' },
                    { particular: 'Electrical Wiring', amount: 18000, receipt: 'receipt6.pdf' },
                    { particular: 'Installation Labor', amount: 15000, receipt: 'receipt7.pdf' },
                    { particular: 'Additional Poles', amount: 9200, receipt: 'receipt8.pdf' }
                ],
                remarks: 'Additional poles were required due to spacing requirements. Requesting approval for overspent amount.',
                notesForRejection: ''
            },
            {
                id: 3,
                particular: 'Community Garden Setup',
                status: 'Waiting for Approval',
                budgetReleased: 45000,
                totalExpenses: 45000,
                auditResult: 'Balanced',
                expenses: [
                    { particular: 'Soil and Fertilizer', amount: 12000, receipt: 'receipt9.pdf' },
                    { particular: 'Garden Tools and Equipment', amount: 8000, receipt: 'receipt10.pdf' },
                    { particular: 'Irrigation System', amount: 15000, receipt: 'receipt11.pdf' },
                    { particular: 'Plants and Seeds', amount: 10000, receipt: 'receipt12.pdf' }
                ],
                remarks: 'All expenses match the released budget perfectly.',
                notesForRejection: ''
            },
            {
                id: 4,
                particular: 'Admin Payroll - Month of August',
                status: 'Rejected',
                budgetReleased: 120000,
                totalExpenses: 125000,
                auditResult: 'Overspent',
                expenses: [
                    { particular: 'Staff Salaries', amount: 95000, receipt: 'receipt13.pdf' },
                    { particular: 'Benefits and Allowances', amount: 20000, receipt: 'receipt14.pdf' },
                    { particular: 'Overtime Pay', amount: 10000, receipt: 'receipt15.pdf' }
                ],
                remarks: 'Overtime was necessary due to additional workload. Requesting approval for excess amount.',
                notesForRejection: 'Overtime pay exceeds approved budget without prior authorization.'
            }
        ];

        let currentLiquidation = null;

        // Render liquidations table
        function renderLiquidations() {
            const tbody = document.getElementById('liquidationsTableBody');
            tbody.innerHTML = '';

            liquidations.forEach(liquidation => {
                const statusColors = {
                    'Waiting for Approval': 'bg-orange-100 text-orange-800',
                    'Approved': 'bg-teal-100 text-teal-800',
                    'Rejected': 'bg-red-100 text-red-800'
                };

                const auditColors = {
                    'Underspent': 'text-green-600',
                    'Balanced': 'text-blue-600',
                    'Overspent': 'text-red-600'
                };

                const row = document.createElement('tr');
                row.className = 'border-b border-gray-200 hover:bg-gray-50';
                row.innerHTML = `
                    <td class="py-3 px-4 text-gray-800">${liquidation.particular}</td>
                    <td class="py-3 px-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold ${statusColors[liquidation.status]}">
                            ${liquidation.status}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-gray-800 font-medium">₱${liquidation.totalExpenses.toLocaleString()}</td>
                    <td class="py-3 px-4">
                        <span class="font-semibold ${auditColors[liquidation.auditResult]}">
                            ${liquidation.auditResult}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        <button onclick="openViewModal(${liquidation.id})" class="bg-teal-600 text-white px-4 py-2 rounded-md hover:bg-teal-700 transition-colors text-sm">
                            View
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
            });
        }

        // Open view modal
        function openViewModal(liquidationId) {
            currentLiquidation = liquidations.find(l => l.id === liquidationId);
            if (!currentLiquidation) return;

            // Populate project info
            document.getElementById('viewProjectTitle').value = currentLiquidation.particular;
            document.getElementById('viewReleasedBudget').value = `₱${currentLiquidation.budgetReleased.toLocaleString()}`;
            
            // Populate expenses table
            const tbody = document.getElementById('viewExpensesTableBody');
            tbody.innerHTML = '';
            
            currentLiquidation.expenses.forEach(expense => {
                const row = document.createElement('tr');
                row.className = 'border-b border-gray-100';
                row.innerHTML = `
                    <td class="py-3 px-4 text-gray-800">${expense.particular}</td>
                    <td class="py-3 px-4 text-gray-800 font-medium">₱${expense.amount.toLocaleString()}</td>
                    <td class="py-3 px-4">
                        <a href="#" class="text-teal-600 hover:text-teal-800 text-sm">
                            <i class="fas fa-file-pdf mr-1"></i>
                            ${expense.receipt}
                        </a>
                    </td>
                `;
                tbody.appendChild(row);
            });

            // Display total expenses
            document.getElementById('viewTotalExpenses').textContent = `₱${currentLiquidation.totalExpenses.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;

            // Display audit result
            const difference = currentLiquidation.budgetReleased - currentLiquidation.totalExpenses;
            const auditResultContainer = document.getElementById('viewAuditResultContainer');
            const auditResult = document.getElementById('viewAuditResult');
            const auditDetails = document.getElementById('viewAuditDetails');

            if (Math.abs(difference) < 0.01) {
                // Balanced
                auditResultContainer.className = 'mb-6 p-4 rounded-lg border-2 border-blue-500 bg-blue-50';
                auditResult.className = 'text-2xl font-bold text-blue-600';
                auditResult.textContent = 'Balanced';
                auditDetails.textContent = 'The expenses match the released budget perfectly.';
            } else if (difference > 0) {
                // Underspent
                auditResultContainer.className = 'mb-6 p-4 rounded-lg border-2 border-green-500 bg-green-50';
                auditResult.className = 'text-2xl font-bold text-green-600';
                auditResult.textContent = 'Underspent';
                auditDetails.textContent = `Remaining budget: ₱${difference.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            } else {
                // Overspent
                auditResultContainer.className = 'mb-6 p-4 rounded-lg border-2 border-red-500 bg-red-50';
                auditResult.className = 'text-2xl font-bold text-red-600';
                auditResult.textContent = 'Overspent';
                auditDetails.textContent = `Over budget by: ₱${Math.abs(difference).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            }

            // Display remarks
            document.getElementById('viewRemarks').value = currentLiquidation.remarks;

            // Handle Notes for Rejection field
            const notesContainer = document.getElementById('notesForRejectionContainer');
            const notesField = document.getElementById('notesForRejection');
            
            if (currentLiquidation.status === 'Waiting for Approval' || currentLiquidation.status === 'Rejected') {
                notesContainer.classList.remove('hidden');
                notesField.value = currentLiquidation.notesForRejection || '';
            } else {
                notesContainer.classList.add('hidden');
                notesField.value = '';
            }

            // Show/hide action buttons based on status
            const rejectBtn = document.getElementById('rejectBtn');
            const approveBtn = document.getElementById('approveBtn');
            
            if (currentLiquidation.status === 'Waiting for Approval') {
                rejectBtn.classList.remove('hidden');
                approveBtn.classList.remove('hidden');
            } else {
                rejectBtn.classList.add('hidden');
                approveBtn.classList.add('hidden');
            }

            // Show modal
            document.getElementById('viewLiquidationModal').classList.remove('hidden');
        }

        // Close view modal
        function closeViewModal() {
            document.getElementById('viewLiquidationModal').classList.add('hidden');
            currentLiquidation = null;
        }

        // Approve liquidation
        function approveLiquidation() {
            if (!currentLiquidation) return;

            if (confirm(`Are you sure you want to approve the liquidation for "${currentLiquidation.particular}"?`)) {
                // Update status
                currentLiquidation.status = 'Approved';
                currentLiquidation.notesForRejection = '';
                
                // Re-render table
                renderLiquidations();
                
                // Close modal
                closeViewModal();
                
                alert('Liquidation approved successfully!');
            }
        }

        // Reject liquidation
        function rejectLiquidation() {
            if (!currentLiquidation) return;

            const notesField = document.getElementById('notesForRejection');
            const notes = notesField.value.trim();
            
            if (!notes) {
                alert('Please provide notes for rejection.');
                return;
            }

            if (confirm(`Are you sure you want to reject the liquidation for "${currentLiquidation.particular}"?\n\nNotes: ${notes}`)) {
                // Update status and notes
                currentLiquidation.status = 'Rejected';
                currentLiquidation.notesForRejection = notes;
                
                // Re-render table
                renderLiquidations();
                
                // Close modal
                closeViewModal();
                
                alert('Liquidation rejected. The auditor will be notified.');
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            renderLiquidations();
        });
    </script>

<?php
$content = ob_get_clean();

$pageScripts = '
  <script type="module" src="/hoa_system/ui/modules/users/get.homeowners.js"></script>
';

require_once BASE_PATH . '/pages/layout.php';
?>