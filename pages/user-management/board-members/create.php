<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';

require_once $root . 'config.php';
require_once $root . 'app/includes/session.php';

$userRole = $_SESSION['role'] ?? 0;
$isAdminOrPresident = in_array($userRole, [1, 3]);
$pageTitle = 'Create';
ob_start();

?>
        <div class="mt-1">
          <h3 class="text-2xl font-medium text-gray-900 mb-4">Create Account</h3>
          <form id="createForm" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-sm">
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

            <div class="flex justify-end items-center mt-8 gap-2 border-t border-gray-200 pt-4">
              <a 
                href="<?= BASE_PATH .'app/pages/user-management/board-members/list.php'?>"
                class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 hover:text-teal-700 focus:ring-4 focus:ring-gray-100"
              >
                Cancel
              </a>
              <button id="submitBtn" type="submit"
                class="text-white bg-teal-700 hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-teal-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                Save
              </button>
            </div>
          </form>
        </div>
<?php
$content = ob_get_clean();

$pageScripts = '
  <script src="' . BASE_URL . 'ui/modules/users/get.boardmembers.js"></script>
';

require_once BASE_PATH . '/pages/layout.php';
?>