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
  <style>

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
        <a href="president-dashboard.php" class="flex items-center px-6 py-3 hover:bg-teal-600">
          <i class="fas fa-tachometer-alt mr-3"></i>
          <span>Dashboard</span>
        </a>
        <a href="president-accounts.php" class="flex items-center px-6 py-3 hover:bg-teal-600">
          <i class="fas fa-user-gear mr-3"></i>
          <span>Admin Management</span>
        </a>

        <a href="registered-homeowners.php" class="flex items-center px-6 py-3 hover:bg-teal-600">
          <i class="fas fa-home mr-3"></i>
          <span>Homeowners</span>
        </a>

        <a href="president-feetype.php" class="flex items-center px-6 py-3 hover:bg-teal-600">
          <i class="fas fa-money-check mr-3"></i>
          <span>Fee Type</span>
        </a>
        <a href="president-projectproposal.php" class="flex items-center px-6 py-3 hover:bg-teal-600">
          <i class="fas fa-gavel mr-3"></i>
          <span>Resolution</span>
        </a>
        <a href="president-liquidation.php" class="flex items-center px-6 py-3 hover:bg-teal-600">
          <i class="fas fa-file-invoice-dollar mr-3"></i>
          <span>Liquidation of Expenses</span>
        </a>
        <a href="president-ledger.php" class="flex items-center px-6 py-3 hover:bg-teal-600">
          <i class="fas fa-book mr-3"></i>
          <span>Ledger</span>
        </a>
        <a href="president-remittance.php" class="flex items-center px-6 py-3 hover:bg-teal-600">
          <i class="fas fa-money-check mr-3"></i>
          <span>Remittance</span>
        </a>
        <a href="president-payment-history.php" class="flex items-center px-6 py-3 hover:bg-teal-600">
          <i class="fas fa-receipt mr-3"></i>
          <span>Payment History</span>
        </a>      

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
              <button @click="window.location.href='president-tricycle.php'" class="flex items-center w-full px-10 py-2 hover:bg-teal-600 focus:outline-none">
                <i class="fas fa-bicycle mr-2" title="Tricycle"></i>
                <span class="flex-1 text-left">Tricycle</span>
              </button>
            </div>
            <div class="relative">
              <button @click="window.location.href='president-court.php'" class="flex items-center w-full px-10 py-2 hover:bg-teal-600 focus:outline-none">
                <i class="fas fa-basketball-ball mr-2" title="Court"></i>
                <span class="flex-1 text-left">Court</span>
              </button>
            </div>
            <div class="relative">
              <button @click="window.location.href='president-stall.php'" class="flex items-center w-full px-10 py-2 hover:bg-teal-600 focus:outline-none">
                <i class="fas fa-store mr-2" title="Stall"></i>
                <span class="flex-1 text-left">Stall</span>
              </button>
            </div>
          </div>
        </div>
        <a href="president-newsfeed.php" class="flex items-center px-6 py-3 hover:bg-teal-600">
          <i class="fas fa-newspaper mr-3"></i>
          <span>News Feed</span>
        </a>
        <a href="president-calendar.php" class="flex items-center px-6 py-3 hover:bg-teal-600">
          <i class="fas fa-calendar-alt mr-3"></i>
          <span>Calendar</span>
        </a>
      </nav>
    </div>

    <div class="flex-1 flex flex-col">
      <header class="flex flex-row justify-between items-center p-4 sm:px-6 lg:px-8 gap-2 bg-white shadow-md">
        <span>
          <a href="#" id="menuToggler" class="flex items-center text-lg font-black text-teal-600 hover:text-teal-800">
            <i class="ri-menu-2-fill"></i>
          </a>
        </span>
        <div class="flex flex-row items-center gap-2">
          <a href="#" id="dropdownAvatarNameButton" class="flex items-center text-md font-medium text-teal-600 hover:text-teal-800 p-2">
            <i class="ri-notification-3-fill"></i>
          </a>
          <a 
            href="#" 
            id="dropdownAvatarNameButton" 
            data-dropdown-toggle="dropdownAvatarName" 
            data-dropdown-placement="bottom"
            data-dropdown-offset-distance="10"
            class="text-md font-medium text-gray-600 hover:text-black-800"
          >
            <span class="flex items-center">
              <!-- <i class="ri-account-circle-fill text-2xl me-2"></i> -->
              <img class="w-8 h-8 rounded-sm ring-2 ring-gray-300 p-2 me-2" src="<?= BASE_PATH. '/assets/img/user-alt-64.png'?>" alt="Default avatar">
              <span class="flex flex-col gap-0 leading-none">
                <span>
                  <p class="text-sm m-0 p-0 leading-none">
                    Bonnie Green
                  </p>
                </span>
                <span>
                  <span class="text-blue-800 text-xs font-medium me-2 rounded-lg">Admin</span>
                </span>
              </span>
            </span>  
          </a>
          <div id="dropdownAvatarName" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-md border border-gray-200 w-[20rem]">
              <div class="flex flex-row items-center px-4 py-3 ">
                <img class="w-10 h-10 rounded-sm ring-2 ring-gray-300 p-2 me-2" src="<?= BASE_PATH. '/assets/img/user-alt-64.png'?>" alt="Default avatar">
                <div class="text-sm text-gray-900">
                  <div class="font-medium ">Sample User</div>
                  <div class="truncate">Sample@mailinator.com</div>
                </div>
              </div>
              <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownInformdropdownAvatarNameButtonationButton">
                <li>
                  <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                    <i class="ri-history-line me-2"></i>
                    Activity Logs
                  </a>
                </li>
                <li>
                  <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                    <i class="ri-account-circle-fill me-2"></i>
                    Profile
                  </a>
                </li>
              </ul>
              <div class="py-2">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  <i class="ri-logout-box-line me-2"></i>
                  Sign out
                </a>
              </div>
          </div>
        </div>
      </header>
      <main class="flex-1 p-6">
        <div class="mt-1">
          <h3 class="text-2xl font-medium text-gray-900 mb-4">Admin Accounts</h3>
          <div class="flex flex-row align-middle mb-4 gap-2">
            <form class="flex flex-1 items-center">   
              <label for="simple-search" class="sr-only">Search</label>
              <div class="relative w-full">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                  <i class="ri-search-line text-gray-400"></i>
                </div>
                <input type="text" id="simple-search" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-1 focus:ring-teal-600 focus:border-teal-600 block w-full ps-10 p-2" placeholder="Search User..." required />
              </div>
            </form>
            <div class="flex">
              <button id="dropdownBottomButton" data-dropdown-toggle="dropdownBottom" data-dropdown-placement="bottom" class="md:mb-0 text-white bg-teal-600 hover:bg-teal-800 focus:ring-1 focus:outline-none focus:ring-teal-600 font-medium rounded-lg text-sm px-5 py-1.5 text-center items-center" type="button">
                <i class="ri-add-circle-line me-2 text-lg"></i>
                New Account
                <i class="ri-arrow-down-s-line ms-2 text-lg"></i>
              </button>
            </div>

            <div id="dropdownBottom" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-[15rem] border border-gray-200">
                <ul class="py-2 text-sm text-gray-600 font-medium" aria-labelledby="dropdownBottomButton">
                  <li>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100" onclick="openCreateModal('Admin')" >
                      <i class="ri-admin-fill text-blue-400 me-2"></i>
                      Admin
                    </a>
                  </li>
                  <li>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100" onclick="openCreateModal('Secretary')" >
                      <i class="ri-briefcase-4-fill text-amber-900 me-2"></i>
                      Secretary
                    </a>
                  </li>
                  <li>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100" onclick="openCreateModal('Treasurer')" >
                      <i class="ri-cash-line text-green-800 me-2"></i>
                      Treasurer
                    </a>
                  </li>
                  <li>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100" onclick="openCreateModal('Audit')" >
                      <i class="ri-survey-fill me-2"></i>
                      Audit
                    </a>
                  </li>
                </ul>
            </div>
          </div>
          
          <div class="relative overflow-x-auto shadow-md sm:rounded-lg border border-gray-200">
            <table id="usersTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
              <thead class="text-xs text-gray-800 uppercase bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3">
                    Name
                  </th>
                  <th scope="col" class="px-6 py-3">
                    Role
                  </th>
                  <th scope="col" class="px-6 py-3">
                    Email
                  </th>
                  <th scope="col" class="px-6 py-3">
                    Status
                  </th>
                  <th scope="col" class="px-6 py-3">
                    Action
                  </th>
                </tr>
              </thead>
              <tbody>
                <!-- Intentionally left blank -->
              </tbody>
          </table>
          <nav id="paginationNav"
            class="flex items-center flex-column flex-wrap md:flex-row justify-between p-4"
            aria-label="Table navigation">
            
            <span id="pageInfo"
              class="text-sm font-normal text-gray-500 mb-4 md:mb-0 block w-full md:inline md:w-auto">
              Showing <span id="rangeStart" class="font-semibold text-gray-900">1</span> -
              <span id="rangeEnd" class="font-semibold text-gray-900">10</span>
              of <span id="totalRecords" class="font-semibold text-gray-900">0</span>
            </span>
            
            <ul id="paginationList"
              class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
            </ul>
          </nav>
        </div>
      </main>
    </div>
  </div>

  <div id="create-secretary-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl max-h-screen overflow-y-auto">
      <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center sticky top-0 bg-white z-10">
        <h3 id="modal-title" class="text-lg font-medium text-gray-900">Create Admin Account</h3>
        <button id="close-create-modal" class="text-gray-400 hover:text-gray-500">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="p-6">
        <form id="create-secretary-form" method="POST" enctype="multipart/form-data" action="../../Query/create-account.php">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
              <label for="sec-first-name" class="block text-sm font-medium text-gray-700">First Name</label>
              <input type="text" name="first_name" id="sec-first-name" placeholder="Enter first name"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm" required />
            </div>
            <div>
              <label for="sec-middle-name" class="block text-sm font-medium text-gray-700">Middle Name</label>
              <input type="text" name="middle_name" id="sec-middle-name" placeholder="Enter middle name"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm" />
            </div>
            <div>
              <label for="sec-last-name" class="block text-sm font-medium text-gray-700">Last Name</label>
              <input type="text" name="last_name" id="sec-last-name" placeholder="Enter last name"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm" required />
            </div>
            <div>
              <label for="sec-name-suffix" class="block text-sm font-medium text-gray-700">Name Suffix</label>
              <input type="text" name="name_suffix" id="sec-name-suffix" placeholder="e.g., Jr., Sr."
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm" />
            </div>
            <div>
              <label for="sec-role" class="block text-sm font-medium text-gray-700">Role</label>
              <input type="text" name="role" id="sec-role" readonly
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-gray-100 sm:text-sm" />
            </div>
            <div>
              <label for="sec-email" class="block text-sm font-medium text-gray-700">Email</label>
              <input type="email" name="email" id="sec-email" placeholder="Enter email address"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm" required />
            </div>
            
            <div>
              <label for="sec-age" class="block text-sm font-medium text-gray-700">Age</label>
              <input type="number" name="age" id="sec-age" placeholder="Enter age" min="18"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm" required />
            </div>
            <div>
              <label for="sec-phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
              <div class="mt-1 flex rounded-md shadow-sm">
                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                  +63
                </span>
                <input type="tel" name="phone" id="sec-phone" placeholder="123456789" pattern="[0-9]{10}" maxlength="10"
                  class="flex-1 block w-full rounded-none rounded-r-md border border-gray-300 py-2 px-3 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm" 
                  oninput="this.value = this.value.replace(/[^0-9]/g, '')" required />
              </div>
            </div>
            <div>
              <label for="sec-dob" class="block text-sm font-medium text-gray-700">Date of Birth</label>
              <input type="date" name="date_of_birth" id="sec-dob"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm" required />
            </div>
            <div>
              <label for="sec-citizenship" class="block text-sm font-medium text-gray-700">Citizenship</label>
              <input type="text" name="citizenship" id="sec-citizenship" placeholder="Enter citizenship"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm" required />
            </div>
            <div>
              <label for="sec-relationship-status" class="block text-sm font-medium text-gray-700">Civil Status</label>
              <select name="civil_status" id="sec-relationship-status"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm" required>
                <option value="" disabled selected>Select status</option>
                <option value="Single">Single</option>
                <option value="Married">Married</option>
                <option value="Divorced">Divorced</option>
                <option value="Widowed">Widowed</option>
                <option value="Annulled">Annulled</option>
              </select>
            </div>
            <div>
              <label for="sec-relationship-status" class="block text-sm font-medium text-gray-700">Status</label>
              <select name="account_status" id="sec-relationship-status"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm" required>
                <option value="" disabled selected>Select status</option>
                <option value="1">Active</option>
                <option value="2">Inactive</option>
              </select>
            </div>
            <div class="sm:col-span-2">
              <label for="sec-home-address" class="block text-sm font-medium text-gray-700">Home Address</label>
              <input type="text" name="home_address" id="sec-home-address" placeholder="Enter home address"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm" required />
            </div>
            <div>
              <label for="sec-lot-number" class="block text-sm font-medium text-gray-700">Lot #</label>
              <input type="text" name="lot_number" id="sec-lot-number" placeholder="Enter lot number"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm" required />
            </div>
            <div>
              <label for="sec-block-number" class="block text-sm font-medium text-gray-700">Block #</label>
              <input type="text" name="block_number" id="sec-block-number" placeholder="Enter block number"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm" required />
            </div>
            <div>
              <label for="sec-phase-number" class="block text-sm font-medium text-gray-700">Phase #</label>
              <input type="text" name="phase_number" id="sec-phase-number" placeholder="Enter phase number"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm" required />
            </div>
            <div>
              <label for="sec-village-name" class="block text-sm font-medium text-gray-700">Village Name</label>
              <input type="text" name="village_name" id="sec-village-name" placeholder="Enter village name"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm" required />
            </div>
          </div>
          <div class="mt-6 flex justify-end">
            <button type="button" id="cancel-create-modal"
              class="py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 mr-2">
              Cancel
            </button>
            <button type="submit" id="create-submit-btn" name="create_account"
              class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
              Create Account
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script>
    // Sidebar functionality
    document.addEventListener('DOMContentLoaded', function() {
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
          // Stop event propagation to prevent triggering the dropdown toggle
          e.stopPropagation();
          if (link.getAttribute('href') === currentPath) {
            e.preventDefault();
            sidebarLinks.forEach(l => l.classList.remove('bg-teal-700', 'bg-teal-900'));
            link.classList.add('bg-teal-700');
          }
        });
      });
    });

    function openCreateModal(role) {
      const modal = document.getElementById('create-secretary-modal');
      const modalTitle = document.getElementById('modal-title');
      const roleInput = document.getElementById('sec-role');
      const submitBtn = document.getElementById('create-submit-btn');
      
      // Update modal content based on role
      modalTitle.textContent = `Create ${role} Account`;
      roleInput.value = role;
      submitBtn.textContent = `Create ${role} Account`;
      
      modal.classList.remove('hidden');
    }

    // Update existing event listeners
    document.getElementById('close-create-modal').addEventListener('click', function() {
      document.getElementById('create-secretary-modal').classList.add('hidden');
    });

    document.getElementById('cancel-create-modal').addEventListener('click', function() {
      document.getElementById('create-secretary-modal').classList.add('hidden');
    });

    window.addEventListener('click', (e) => {
      if (e.target === document.getElementById('create-secretary-modal')) {
        document.getElementById('create-secretary-modal').classList.add('hidden');
      }
    });

  

    // Open Edit Secretary Modal
    function openEditModal(id, firstName, middleName, lastName, suffix, role, email, age, phone, dob, citizenship, relationshipStatus, homeAddress, lotNumber, blockNumber, phaseNumber, villageName, status) {
      const modal = document.getElementById('edit-secretary-modal');
      const modalTitle = document.getElementById('edit-modal-title');
      modalTitle.textContent = `Edit ${role} Account`;
      
      document.getElementById('edit-first-name').value = firstName;
      document.getElementById('edit-middle-name').value = middleName;
      document.getElementById('edit-last-name').value = lastName;
      document.getElementById('edit-name-suffix').value = suffix;
      document.getElementById('edit-role').value = role;
      document.getElementById('edit-email').value = email;
      document.getElementById('edit-status').value = status;
      document.getElementById('edit-age').value = age;
      document.getElementById('edit-phone').value = phone;
      document.getElementById('edit-dob').value = dob;
      document.getElementById('edit-citizenship').value = citizenship;
      document.getElementById('edit-relationship-status').value = relationshipStatus;
      document.getElementById('edit-home-address').value = homeAddress;
      document.getElementById('edit-lot-number').value = lotNumber;
      document.getElementById('edit-block-number').value = blockNumber;
      document.getElementById('edit-phase-number').value = phaseNumber;
      document.getElementById('edit-village-name').value = villageName;
      modal.classList.remove('hidden');
    }

    // Close Edit Secretary Modal
    document.getElementById('close-edit-modal').addEventListener('click', () => {
      document.getElementById('edit-secretary-modal').classList.add('hidden');
    });

    document.getElementById('cancel-edit-modal').addEventListener('click', () => {
      document.getElementById('edit-secretary-modal').classList.add('hidden');
    });

    window.addEventListener('click', (e) => {
      if (e.target === document.getElementById('edit-secretary-modal')) {
        document.getElementById('edit-secretary-modal').classList.add('hidden');
      }
    });

    // Edit Secretary Form Submission
    document.getElementById('edit-secretary-form').addEventListener('submit', (e) => {
      e.preventDefault();
      const status = document.getElementById('edit-status').value;
      alert(`Changes saved successfully! Status updated to ${status.charAt(0).toUpperCase() + status.slice(1)}.`);
      document.getElementById('edit-secretary-modal').classList.add('hidden');
    });

    function searchTable() {
      const input = document.getElementById('search-input');
      const filter = input.value.toUpperCase();
      const table = document.getElementById('secretary-table');
      const tr = table.getElementsByTagName('tr');

      for (let i = 1; i < tr.length; i++) {
        const td = tr[i].getElementsByTagName('td');
        let txtValue = '';
        
        for (let j = 0; j < td.length - 1; j++) {
          txtValue += td[j].textContent || td[j].innerText;
        }
        
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = '';
        } else {
          tr[i].style.display = 'none';
        }
      }
    }
  </script>
  <?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/scripts.php'); ?>
  <?php echo '<script src="'. BASE_PATH .'/assets/js/users/fetch.js"></script>'; ?>
</body>
</html>

