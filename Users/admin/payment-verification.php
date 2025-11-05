<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HOAConnect - Payment Verification</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <style>
    [x-cloak] {
      display: none !important;
    }
    .modal-content {
      background-color: white;
      border-radius: 8px;
      width: 100%;
      max-width: 600px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
    }
    .modal-header button {
      color: #6b7280;
      font-size: 18px;
    }
    .modal-body {
      padding: 24px;
    }
    .modal-body h4 {
      font-size: 16px;
      font-weight: 600;
      color: #1f2937;
      margin-bottom: 16px;
    }
    .modal-body .form-row {
      display: flex;
      gap: 16px;
      margin-bottom: 16px;
    }
    .modal-body .form-row > div {
      flex: 1;
    }
    .modal-body label {
      font-size: 14px;
      font-weight: 500;
      color: #1f2937;
      margin-bottom: 4px;
      display: block;
    }
    .modal-body input,
    .modal-body select,
    .modal-body textarea {
      width: 100%;
      padding: 8px 12px;
      font-size: 14px;
      color: #6b7280;
      background-color: #f9fafb;
      border: 1px solid #e5e7eb;
      border-radius: 4px;
      outline: none;
    }
    .modal-body textarea {
      border: 1px solid #374151;
    }
    .modal-body select {
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 8px center;
      background-size: 16px;
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
    .modal-footer .cancel-btn {
      background-color: white;
      border: 1px solid #d1d5db;
      color: #374151;
    }
    .modal-footer .cancel-btn:hover {
      background-color: #f3f4f6;
    }
    .modal-footer .save-btn {
      background-color: #14b8a6;
      border: none;
      color: white;
    }
    .modal-footer .save-btn:hover {
      background-color: #0d9488;
    }
    .modal-footer .reject-btn {
      background-color: #ef4444;
      border: none;
      color: white;
    }
    .modal-footer .reject-btn:hover {
      background-color: #dc2626;
    }
    .payment-card {
      border: 2px solid #14b8a6;
      background-color: #ccfbf1;
      padding: 16px;
      border-radius: 8px;
      margin: 0 auto;
      max-width: 400px;
    }
    .payment-card p {
      margin: 4px 0;
    }
  </style>
</head>
<body class="bg-gray-50">
  <div class="min-h-screen flex">
    <!-- Sidebar -->
    <div class="bg-teal-800 text-white w-64 py-6 flex flex-col">
      <div class="px-6 mb-8">
        <h1 class="text-2xl font-bold">HOAConnect</h1>
        <p class="text-sm text-teal-200">Mabuhay Homes 2000</p>
      </div>
      <nav class="flex-1">
        <a href="admin-dashboard.php" class="flex items-center px-6 py-3 hover:bg-teal-700">
          <i class="fas fa-tachometer-alt mr-3"></i>
          <span>Dashboard</span>
        </a>
        <a href="admin-accounts.php" class="flex items-center px-6 py-3 hover:bg-teal-700">
          <i class="fas fa-users mr-3"></i>
          <span>User Management</span>
        </a>
        <!-- Payment Management Dropdown -->
        <div x-data="{ open: true }">
          <button @click="open = !open" :aria-expanded="open" class="flex items-center w-full px-6 py-3 hover:bg-teal-600 focus:outline-none">
            <i class="fas fa-credit-card mr-3"></i>
            <span class="flex-1 text-left">Payment Management</span>
            <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div x-show="open" x-cloak class="bg-teal-800 text-sm">
            <a href="fee-types.php" class="flex items-center px-10 py-2 hover:bg-teal-600">
              <i class="fas fa-tag mr-2" title="Fee Type"></i>
              Fee Type
            </a>
            <a href="fee-assignation.php" class="flex items-center px-10 py-2 hover:bg-teal-600">
              <i class="fas fa-clipboard-list mr-2" title="Fee Assignation"></i>
              Fee Assignation
            </a>
            <a href="payment-verification.php" class="flex items-center px-10 py-2 bg-teal-700">
              <i class="fas fa-check-circle mr-2" title="Payment Verification"></i>
              Payment Verification
            </a>
            <a href="admin-remittance.php" class="flex items-center px-10 py-2 hover:bg-teal-600">
              <i class="fas fa-money-check mr-3"></i>
              Remittance
            </a>
            <a href="payment-history.php" class="flex items-center px-10 py-2 hover:bg-teal-600">
              <i class="fas fa-history mr-2" title="Payment History"></i>
              Payment History
            </a>
          </div>
        </div>
        <!-- Amenities Dropdown -->
        <div x-data="{ open: false }">
          <button @click="open = !open" :aria-expanded="open" class="flex items-center w-full px-6 py-3 hover:bg-teal-600 focus:outline-none">
            <i class="fas fa-swimming-pool mr-3"></i>
            <span class="flex-1 text-left">Amenities</span>
            <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div x-show="open" x-cloak class="bg-teal-800 text-sm">
            <div class="relative">
              <button @click="window.location.href='admin-tricycle.php'" class="flex items-center w-full px-10 py-2 hover:bg-teal-600 focus:outline-none">
                <i class="fas fa-bicycle mr-2" title="Tricycle"></i>
                <span class="flex-1 text-left">Tricycle</span>
              </button>
            </div>
            <div class="relative">
              <button @click="window.location.href='admin-court.php'" class="flex items-center w-full px-10 py-2 hover:bg-teal-600 focus:outline-none">
                <i class="fas fa-basketball-ball mr-2" title="Court"></i>
                <span class="flex-1 text-left">Court</span>
              </button>
            </div>
            <div class="relative">
              <button @click="window.location.href='admin-stall.php'" class="flex items-center w-full px-10 py-2 hover:bg-teal-600 focus:outline-none">
                <i class="fas fa-store mr-2" title="Stall"></i>
                <span class="flex-1 text-left">Stall</span>
              </button>
            </div>
          </div>
        </div>
        <a href="admin-hoaprojects.php" class="flex items-center px-6 py-3 hover:bg-teal-700">
          <i class="fas fa-gavel mr-3"></i>
          <span>Project Resolution</span>
        </a>
        <a href="admin-ledger.php" class="flex items-center px-6 py-3 hover:bg-teal-600">
          <i class="fas fa-book mr-3"></i>
          <span>Ledger</span>
        </a>
        <a href="admin-projects.php" class="flex items-center px-6 py-3 hover:bg-teal-700">
          <i class="fas fa-newspaper mr-3"></i>
          <span>News Feed</span>
        </a>
        <a href="admin-messages.php" class="flex items-center px-6 py-3 hover:bg-teal-700">
          <i class="fas fa-comments mr-3"></i>
          <span>Messages</span>
        </a>
        <a href="admin-calendar.php" class="flex items-center px-6 py-3 hover:bg-teal-700">
          <i class="fas fa-calendar-alt mr-3"></i>
          <span>Calendar</span>
        </a>
        <a href="admin-profile.php" class="flex items-center px-6 py-3 hover:bg-teal-700">
          <i class="fas fa-user-circle mr-3"></i>
          <span>Profile</span>
        </a>
      </nav>
      <div class="px-6 py-4 mt-auto">
        <button class="mt-4 w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded flex items-center justify-center">
          <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </button>
      </div>
    </div>
    <!-- Main Content -->
    <div class="flex-1 overflow-x-hidden overflow-y-auto">
      <header class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Payment Management</h1>
            <div class="flex items-center space-x-2">
              <button class="bg-teal-100 p-2 rounded-full text-teal-600 hover:bg-teal-200">
                <i class="fas fa-bell"></i>
              </button>
            </div>
          </div>
    </header>
      <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Payment Verification Section -->
        <div id="payment-verification" class="mb-8">
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Payment Verification Table</h2>
            <div class="flex space-x-3">
              <div class="relative w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                  <i class="fas fa-search text-gray-400"></i>
                </span>
                <input
                  type="text"
                  id="search-payment"
                  placeholder="Search by name"
                  maxlength="100"
                  class="w-full pl-10 pr-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-1 focus:ring-teal-500 focus:border-teal-500"
                />
              </div>
            </div>
          </div>
          <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment For</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="payment-table-body">
                  <tr data-user-id="HOA-001">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">Maria Santos</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">HOA Fee Month of May 2025</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">₱50</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <button onclick="openPaymentVerificationModal('HOA-001', 'Maria Santos', 'Bank Transfer', 'HOA Fee Month of May 2025', '50', '2025-05-04', 'REF001')"
                        class="text-white bg-teal-600 hover:bg-teal-700 px-3 py-1 rounded">View</button>
                    </td>
                  </tr>
                  <tr data-user-id="HOA-003">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">Ana Reyes</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">HOA Fee Month of May 2025</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">₱50</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <button onclick="openPaymentVerificationModal('HOA-003', 'Ana Reyes', 'GCash', 'HOA Fee Month of May 2025', '50', '2025-05-04', 'REF003')"
                        class="text-white bg-teal-600 hover:bg-teal-700 px-3 py-1 rounded">View</button>
                    </td>
                  </tr>
                  <tr data-user-id="HOA-005">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">Sofia Garcia</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">HOA Fee Month of May 2025</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">₱50</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <button onclick="openPaymentVerificationModal('HOA-005', 'Sofia Garcia', 'Cash', 'HOA Fee Month of May 2025', '50', '2025-05-04', 'Marj San Jose')"
                        class="text-white bg-teal-600 hover:bg-teal-700 px-3 py-1 rounded">View</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
              <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                  Showing <span class="font-medium">1</span> to <span class="font-medium">3</span> of <span class="font-medium">3</span> results
                </div>
                <div class="flex space-x-2">
                  <button class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Previous</button>
                  <button class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Next</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
  <!-- Payment Verification Modal -->
  <div id="paymentVerificationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden" role="dialog" aria-modal="true" aria-labelledby="modal-title">
    <div class="modal-content">
      <div class="modal-header">
        <h3 id="modal-title">Payment Verification</h3>
        <button onclick="closePaymentVerificationModal()" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="modal-body">
        <h4>Payment Details</h4>
        <div class="payment-card" id="payment-card">
          <p><strong>Name:</strong> <span id="verify-name"></span></p>
          <p><strong>Payment For:</strong> <span id="verify-payment-for"></span></p>
          <p><strong>Amount:</strong> ₱<span id="verify-amount"></span></p>
          <p><strong>Date:</strong> <span id="verify-date"></span></p>
          <p><strong>Payment Method:</strong> <span id="verify-method"></span></p>
          <p id="verify-reference-label"><strong>Reference Number:</strong> <span id="verify-reference"></span></p>
          <div id="proof-of-payment" class="border border-gray-300 rounded-md p-4 text-center">
            <p class="text-sm text-gray-600">[Image Placeholder - Picture of Receipt]</p>
          </div>
        </div>
        <div class="form-row mt-4">
          <div>
            <label for="verify-notes">Notes</label>
            <textarea id="verify-notes" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" onclick="closePaymentVerificationModal()" class="cancel-btn">Close</button>
          <div id="action-buttons" class="flex space-x-2">
            <button type="button" onclick="verifyPayment()" class="save-btn">Verify</button>
            <button type="button" onclick="rejectPayment()" class="reject-btn">Reject</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    // Payment Verification Modal
    window.openPaymentVerificationModal = function(hoaId, name, method, paymentFor, amount, date, reference) {
      document.getElementById('verify-name').textContent = name;
      document.getElementById('verify-payment-for').textContent = paymentFor;
      document.getElementById('verify-amount').textContent = amount;
      document.getElementById('verify-date').textContent = date;
      document.getElementById('verify-method').textContent = method;
      document.getElementById('verify-reference').textContent = reference;
      
      const referenceLabel = document.getElementById('verify-reference-label');
      const proofOfPayment = document.getElementById('proof-of-payment');
      
      if (name === 'Sofia Garcia' && method === 'Cash') {
        referenceLabel.innerHTML = `<strong>Payment Receipt Name:</strong> <span id="verify-reference">${reference}</span>`;
        proofOfPayment.style.display = 'none';
        document.getElementById('verify-notes').value = '';
      } else {
        referenceLabel.innerHTML = `<strong>Reference Number:</strong> <span id="verify-reference">${reference}</span>`;
        proofOfPayment.style.display = 'block';
        document.getElementById('verify-notes').value = '';
      }
      
      document.getElementById('paymentVerificationModal').classList.remove('hidden');
      document.body.classList.add('overflow-hidden');
    };
    window.closePaymentVerificationModal = function() {
      document.getElementById('paymentVerificationModal').classList.add('hidden');
      document.body.classList.remove('overflow-hidden');
    };
    window.verifyPayment = function() {
      const hoaId = document.querySelector(`tr[data-user-id="${document.querySelector('[data-user-id]').dataset.userId}"]`).dataset.userId;
      const row = document.querySelector(`tr[data-user-id="${hoaId}"]`);
      if (row) {
        row.remove();
      }
      alert('Payment verified successfully! Moved to Payment History.');
      closePaymentVerificationModal();
      filterPayments();
    };
    window.rejectPayment = function() {
      const hoaId = document.querySelector(`tr[data-user-id="${document.querySelector('[data-user-id]').dataset.userId}"]`).dataset.userId;
      const row = document.querySelector(`tr[data-user-id="${hoaId}"]`);
      if (row) {
        row.remove();
      }
      alert('Payment rejected and removed from verification.');
      closePaymentVerificationModal();
      filterPayments();
    };
    // Search Functionality
    const searchInput = document.getElementById('search-payment');
    const tableBody = document.getElementById('payment-table-body');
    const rows = Array.from(tableBody.getElementsByTagName('tr'));
    function filterPayments() {
      const searchTerm = searchInput.value.toLowerCase();
      rows.forEach(row => {
        const name = row.cells[0].textContent.toLowerCase();
        const matchesSearch = name.includes(searchTerm);
        row.style.display = matchesSearch ? '' : 'none';
      });
    }
    searchInput.addEventListener('input', filterPayments);
  </script>
</body>
</html>