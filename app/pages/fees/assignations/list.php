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
        <!-- Assignation of Monthly HOA Fee Section -->
          
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Assignation of Monthly HOA Fee</h2>
            <div class="flex items-center space-x-4">
              <!-- Search Bar -->
              <div class="bg-white rounded-lg shadow flex">
                <input id="searchInput" type="text" placeholder="Search homeowners by name or email..." 
                  class="border rounded-l px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-teal-500">
                <button class="bg-teal-600 text-white px-4 py-2 rounded-r hover:bg-teal-700">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Name
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Email
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Unpaid Fees
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Action
                    </th>
                  </tr>
                </thead>
                <tbody id="homeownersTableBody" class="bg-white divide-y divide-gray-200">
                  <?php
                  $query_homeowners = "SELECT * FROM users WHERE role_id ='6'";
                  $run_homeowners = mysqli_query($conn,$query_homeowners);

                  if(mysqli_num_rows($run_homeowners) > 0){
                        foreach($run_homeowners as $row_homeowners){
                          ?>
                        <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <?php echo $row_homeowners['first_name'] . " " . $row_homeowners['last_name']; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <?php echo $row_homeowners['email_address']; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <a href="admin-view-fee-assignation.php?user_id=<?php echo $row_homeowners['user_id']; ?>">View</a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <?php

                          if($row_homeowners['account_status'] == 1){
                            echo "<span class='px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800'>Active</span>";
                          } else {
                            echo "<span class='px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800'>Inactive</span>";
                          }

                          ?>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                          <a href="add-fee-assignation.php?user_id=<?php echo $row_homeowners['user_id']; ?>" class="bg-teal-600 text-white px-4 py-2 rounded-md hover:bg-teal-700">
                            Edit
                        </td>
                      </tr>
                      <?php
                    }
                  }

                  ?>
                </tbody>
              </table>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
              <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                  Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of <span class="font-medium">5</span> results
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
        </div>
      </main>
    </div>
  </div>
  <!-- Assign Fee Modal -->
  <div id="assignFeeModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Assign Fee</h3>
        <button onclick="closeAssignFeeModal()">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="modal-body">
        <h4>Select Fees to Assign</h4>
        <form id="assign-fee-form" class="space-y-6">
          <div class="space-y-2">
            <div class="flex items-center">
              <input type="checkbox" id="fee-FEE002" name="fees" value="FEE002"
                class="focus:ring-teal-500 h-4 w-4 text-teal-600 border-gray-300 rounded" />
              <label for="fee-FEE002">
                Monthly Dues (₱50)
              </label>
            </div>
          </div>
          <div>
            <h4 class="mt-6">Selected Homeowners</h4>
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      HOA ID
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Name
                    </th>
                  </tr>
                </thead>
                <tbody id="selected-homeowners-table" class="bg-white divide-y divide-gray-200">
                  <!-- Dynamically populated via JavaScript -->
                </tbody>
              </table>
            </div>
            <div class="mt-4 flex justify-center items-center space-x-2">
              <button type="button" id="prev-page-btn" onclick="changePage(-1)"
                class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                Prev
              </button>
              <span id="page-number" class="text-sm text-gray-700">1</span>
              <button type="button" id="next-page-btn" onclick="changePage(1)"
                class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                Next
              </button>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" onclick="closeAssignFeeModal()" class="cancel-btn">Cancel</button>
            <button type="submit" class="save-btn">Assign</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Edit Fee Assignment Modal -->
  <div id="editFeeAssignmentModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Edit Fee Assignment</h3>
        <button onclick="closeEditFeeAssignmentModal()">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="modal-body">
        <h4>Assign Fees to <span id="edit-user-name"></span></h4>
        <form id="edit-fee-assignment-form" class="space-y-4">
          <input type="hidden" id="edit-hoa-id" name="hoa-id" />
          <div class="space-y-4">
            <div class="bg-white p-4 border rounded-md shadow-sm">
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <input type="checkbox" id="edit-fee-monthly" name="fees" value="FEE-MONTHLY"
                    class="focus:ring-teal-500 h-4 w-4 text-teal-600 border-gray-300 rounded mr-3" />
                  <label for="edit-fee-monthly" class="text-sm font-medium text-gray-900">
                    Monthly Dues (₱50)
                  </label>
                </div>
                <div class="flex space-x-2">
                  <select id="edit-fee-month" class="border border-gray-300 rounded-md px-2 py-1 text-sm">
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                  </select>
                  <select id="edit-fee-year" class="border border-gray-300 rounded-md px-2 py-1 text-sm">
                    <option value="2025">2025</option>
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" onclick="closeEditFeeAssignmentModal()" class="cancel-btn">Cancel</button>
            <button type="submit" class="save-btn">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Unpaid Fees Modal -->
  <div id="unpaidFeesModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="modal-content max-w-md">
      <div class="modal-header">
        <h3>Unpaid Fees</h3>
        <button onclick="closeUnpaidFeesModal()">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="modal-body">
        <div class="card-container" id="unpaid-fees-cards">
          <!-- Fee card example -->
          <div class="fee-card w-full max-w-full">
            <div class="flex items-center">
              <input type="checkbox" class="fee-checkbox focus:ring-teal-500 h-4 w-4 text-teal-600 border-gray-300 rounded mr-3" data-fee-id="FEE003" />
              <div class="w-full">
                <div class="text-sm font-medium text-gray-900">Fee Name: Monthly Dues Fee - Month of April</div>
                <div class="text-sm text-gray-600">Description: Settle your payment!</div>
                <div class="text-sm text-gray-600">Amount: ₱50</div>
                <div class="text-sm text-gray-600">Due Date: April 30, 2025</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="closeUnpaidFeesModal()" class="cancel-btn">Close</button>
        <button type="button" onclick="openWalkInPaymentModal()" class="bg-teal-600 hover:bg-teal-700 text-white py-2 px-4 rounded">Walk-In Payment</button>
      </div>
    </div>
  </div>
  <!-- Walk In Payment Modal -->
  <div id="walkInPaymentModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="modal-content max-w-md modal-scrollable">
      <div class="modal-header">
        <h3>Upload Proof of Payment</h3>
        <button onclick="closeWalkInPaymentModal()">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="modal-body">
        <div class="mb-4 p-3 bg-gray-100 rounded-md">
          <h4 class="font-medium mb-2">Selected Fee</h4>
          <div id="selected-fee-details">
            <!-- Fee details will be populated dynamically -->
          </div>
        </div>
        <h4 class="font-medium mb-2">Proof of Payment</h4>
        <form id="walk-in-payment-form" class="space-y-3">
          <div>
            <label for="walk-in-full-name" class="text-sm font-medium">Full Name</label>
            <input type="text" id="walk-in-full-name" class="bg-gray-100" readonly />
          </div>
          <div>
            <label for="walk-in-amount" class="text-sm font-medium">Amount</label>
            <input type="text" id="walk-in-amount" class="bg-gray-100" readonly />
          </div>
          <div>
            <label for="walk-in-payment-method" class="text-sm font-medium">Payment Method</label>
            <select id="walk-in-payment-method" class="bg-gray-100" readonly>
              <option value="Cash">Cash</option>
              <option value="Bank Transfer">Bank Transfer</option>
              <option value="Check">Check</option>
            </select>
          </div>
          <div>
            <label for="walk-in-date" class="text-sm font-medium">Date</label>
            <input type="date" id="walk-in-date" class="bg-gray-100" readonly />
          </div>
          <div>
            <label for="walk-in-payment-receipt-name" class="text-sm font-medium">Payment Receipt Name</label>
            <input type="text" id="walk-in-payment-receipt-name" />
          </div>
          <div>
            <label for="walk-in-remarks" class="text-sm font-medium">Remarks (Optional)</label>
            <textarea id="walk-in-remarks" rows="2"></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" onclick="closeWalkInPaymentModal()" class="cancel-btn">Cancel</button>
            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white py-2 px-4 rounded">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/scripts.php'); ?>
  <?php echo '<script src="'. BASE_PATH .'/assets/js/users/board-members/fetch.js"></script>'; ?>
  </body>
</html>