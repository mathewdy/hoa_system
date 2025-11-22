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
</head>

<body>
  <div class="h-screen flex bg-gray-50">
    <?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/sidebar.php'); ?>
    <div class="flex flex-col flex-1">
      <?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/header.php'); ?>
      <main class="flex-1 p-6 overflow-y-auto">
      <!-- Ledger Section -->
      <div id="ledger-section" class="mb-8">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-xl font-semibold text-gray-900">HOA Collected Fee Ledger</h2>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Particulars</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Debit (₱)</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Credit (₱)</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Balance After (₱)</th>
                </tr>
              </thead>
              <tbody id="ledgerTableBody" class="bg-white divide-y divide-gray-200">
                <!-- Ledger entries will be rendered dynamically -->
              </tbody>
            </table>
          </div>
          <!-- Pagination -->
          <div class="border-t border-gray-200 bg-gray-50 px-6 py-3 flex justify-center items-center space-x-4">
            <button id="prevPageButton" class="py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 opacity-50 cursor-not-allowed" onclick="prevPage()" disabled>
              Previous
            </button>
            <span id="pageInfo" class="text-sm text-gray-700 font-medium"></span>
            <button id="nextPageButton" class="py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500" onclick="nextPage()">
              Next
            </button>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<script>
  // Simulated data for ledger entries
  let ledgerEntries = [
    {
      date: "2025-01-20",
      description: "Dues collected from residents - January",
      debit: 0,
      credit: 50000
    },
    {
      date: "2025-01-20",
      description: "Budget release for Community Garden Setup",
      debit: 15000,
      credit: 0
    },
    {
      date: "2025-02-15",
      description: "Dues collected from residents - February",
      debit: 0,
      credit: 50000
    },
    {
      date: "2025-03-15",
      description: "Budget release for Basketball Court Renovation",
      debit: 20000,
      credit: 0
    },
    {
      date: "2025-03-20",
      description: "Budget release for Street Lighting Upgrade",
      debit: 85000,
      credit: 0
    },
    {
      date: "2025-04-10",
      description: "Dues collected from residents - April",
      debit: 0,
      credit: 50000
    },
  ];

  let currentPage = 1;
  const entriesPerPage = 5;

  document.addEventListener('DOMContentLoaded', function() {
    renderLedger();
  });

  function renderLedger() {
    const tbody = document.getElementById('ledgerTableBody');
    const prevPageButton = document.getElementById('prevPageButton');
    const nextPageButton = document.getElementById('nextPageButton');
    const pageInfo = document.getElementById('pageInfo');
    tbody.innerHTML = '';

    const sortedEntries = ledgerEntries.sort((a, b) => new Date(a.date) - new Date(b.date));
    const totalPages = Math.ceil(ledgerEntries.length / entriesPerPage);
    const startIndex = (currentPage - 1) * entriesPerPage;
    const endIndex = startIndex + entriesPerPage;
    const paginatedEntries = sortedEntries.slice(startIndex, endIndex);

    let totalCollectedFees = 179400; // Initial total collected fees
    sortedEntries.forEach((entry, index) => {
      totalCollectedFees += entry.credit - entry.debit;
      entry.balanceAfter = totalCollectedFees;
    });

    paginatedEntries.forEach(entry => {
      tbody.innerHTML += `
        <tr>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">${entry.description}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${entry.date}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold ${entry.debit > 0 ? 'bg-red-200' : ''}">${entry.debit > 0 ? `₱${entry.debit.toLocaleString()}` : ''}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold ${entry.credit > 0 ? 'bg-blue-200' : ''}">${entry.credit > 0 ? `₱${entry.credit.toLocaleString()}` : ''}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">${entry.balanceAfter !== undefined ? `₱${entry.balanceAfter.toLocaleString()}` : ''}</td>
        </tr>
      `;
    });

    // Update pagination buttons
    prevPageButton.disabled = currentPage === 1;
    prevPageButton.classList.toggle('opacity-50', currentPage === 1);
    prevPageButton.classList.toggle('cursor-not-allowed', currentPage === 1);
    nextPageButton.disabled = currentPage === totalPages || totalPages === 0;
    nextPageButton.classList.toggle('opacity-50', currentPage === totalPages || totalPages === 0);
    nextPageButton.classList.toggle('cursor-not-allowed', currentPage === totalPages || totalPages === 0);
    pageInfo.textContent = `Page ${currentPage} of ${totalPages || 1}`;
  }

  function prevPage() {
    if (currentPage > 1) {
      currentPage--;
      renderLedger();
    }
  }

  function nextPage() {
    if (currentPage < Math.ceil(ledgerEntries.length / entriesPerPage)) {
      currentPage++;
      renderLedger();
    }
  }
</script>
  <?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/scripts.php'); ?>
  <?php echo '<script src="'. BASE_PATH .'/assets/js/users/board-members/fetch.js"></script>'; ?>
  </body>
</html>