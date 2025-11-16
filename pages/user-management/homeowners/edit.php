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
        <div class="mt-1">
          <h3 class="text-2xl font-medium text-gray-900 mb-4">Edit Account</h3>
          <form id="createForm" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-sm">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <div>
                <label for="sec-first-name" class="block mb-2 text-sm font-medium text-gray-900">First Name</label>
                <input type="text" id="sec-first-name" name="first_name" placeholder="Enter first name"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" required />
              </div>

              <div>
                <label for="sec-middle-name" class="block mb-2 text-sm font-medium text-gray-900">Middle Name</label>
                <input type="text" id="sec-middle-name" name="middle_name" placeholder="Enter middle name"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" />
              </div>

              <div>
                <label for="sec-last-name" class="block mb-2 text-sm font-medium text-gray-900">Last Name</label>
                <input type="text" id="sec-last-name" name="last_name" placeholder="Enter last name"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" required />
              </div>

              <div>
                <label for="sec-name-suffix" class="block mb-2 text-sm font-medium text-gray-900">Name Suffix</label>
                <input type="text" id="sec-name-suffix" name="name_suffix" placeholder="e.g., Jr., Sr."
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" />
              </div>

              <input type="hidden" name="role" id="sec-role" value="<?= $role; ?>" readonly
                class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />

              <div>
                <label for="sec-email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                <input type="email" id="sec-email" name="email" placeholder="Enter email address"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" required />
              </div>

              <div>
                <label for="sec-age" class="block mb-2 text-sm font-medium text-gray-900">Age</label>
                <input type="number" id="sec-age" name="age" placeholder="Enter age" min="18"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" required />
              </div>

              <div>
                <label for="sec-phone" class="block mb-2 text-sm font-medium text-gray-900">Phone Number</label>
                <div class="flex">
                  <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md">
                    +63
                  </span>
                  <input type="tel" id="sec-phone" name="phone" placeholder="123456789" pattern="[0-9]{10}" maxlength="10"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    class="rounded-none rounded-r-lg bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" required />
                </div>
              </div>

              <div>
                <label for="sec-dob" class="block mb-2 text-sm font-medium text-gray-900">Date of Birth</label>
                <input type="date" id="sec-dob" name="date_of_birth"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" required />
              </div>

              <div>
                <label for="sec-citizenship" class="block mb-2 text-sm font-medium text-gray-900">Citizenship</label>
                <input type="text" id="sec-citizenship" name="citizenship" placeholder="Enter citizenship"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" required />
              </div>

              <div>
                <label for="sec-relationship-status" class="block mb-2 text-sm font-medium text-gray-900">Civil Status</label>
                <select id="sec-relationship-status" name="civil_status"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" required>
                  <option value="" disabled selected>Select status</option>
                  <option value="Single">Single</option>
                  <option value="Married">Married</option>
                  <option value="Divorced">Divorced</option>
                  <option value="Widowed">Widowed</option>
                  <option value="Annulled">Annulled</option>
                </select>
              </div>

              <div class="sm:col-span-2">
                <label for="sec-home-address" class="block mb-2 text-sm font-medium text-gray-900">Home Address</label>
                <input type="text" id="sec-home-address" name="home_address" placeholder="Enter home address"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" required />
              </div>

              <div>
                <label for="sec-lot-number" class="block mb-2 text-sm font-medium text-gray-900">Lot #</label>
                <input type="text" id="sec-lot-number" name="lot_number" placeholder="Enter lot number"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" required />
              </div>

              <div>
                <label for="sec-block-number" class="block mb-2 text-sm font-medium text-gray-900">Block #</label>
                <input type="text" id="sec-block-number" name="block_number" placeholder="Enter block number"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" required />
              </div>

              <div>
                <label for="sec-phase-number" class="block mb-2 text-sm font-medium text-gray-900">Phase #</label>
                <input type="text" id="sec-phase-number" name="phase_number" placeholder="Enter phase number"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" required />
              </div>

              <div>
                <label for="sec-village-name" class="block mb-2 text-sm font-medium text-gray-900">Village Name</label>
                <input type="text" id="sec-village-name" name="village_name" placeholder="Enter village name"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" required />
              </div>
            </div>

            <div class="flex justify-end items-center gap-2 pt-4">
              <button type="reset"
                class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 hover:text-teal-700 focus:ring-4 focus:ring-gray-100">
                Cancel
              </button>
              <button id="submitBtn" type="submit"
                class="text-white bg-teal-700 hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-teal-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                Save
              </button>
            </div>
          </form>
        </div>
      </main>
    </div>
  </div>

  <div id="confirmModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 
    justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
      <div class="relative bg-white rounded-lg shadow">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
          <h3 class="text-lg font-semibold text-gray-900">
            Confirm Action
          </h3>
          <button type="button"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
            data-modal-hide="confirmModal">
            <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close</span>
          </button>
        </div>

        <div class="p-4 md:p-5">
          <p class="text-sm text-gray-500">Are you sure you want to save these changes?</p>
        </div>

        <div class="flex justify-end items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
          <button data-modal-hide="confirmModal" type="button"
            class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 hover:text-teal-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
            Cancel
          </button>
          <button id="confirmSaveBtn" data-modal-hide="confirmModal" type="button"
            class="text-white bg-teal-700 hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-teal-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ms-3">
            Yes, Save
          </button>
        </div>
      </div>
    </div>
  </div>

  <?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/scripts.php'); ?>
  <?php echo '<script type="module" src="'. BASE_PATH .'/assets/js/users/fetchById.js"></script>'; ?>
  </body>
</html>

