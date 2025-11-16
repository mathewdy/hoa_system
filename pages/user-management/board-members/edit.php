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
          <h3 class="text-2xl font-medium text-gray-900 mb-4">Edit Account</h3>
            <form id="createForm" method="POST" class="bg-white p-6 rounded-lg shadow">
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 border-b pb-2 mb-4">
                        Personal Information
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- First Name -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">First Name</label>
                            <input type="text" name="first_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5"
                                required>
                        </div>

                        <!-- Middle Name -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Middle Name</label>
                            <input type="text" name="middle_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5">
                        </div>

                        <!-- Last Name -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Last Name</label>
                            <input type="text" name="last_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5"
                                required>
                        </div>

                        <!-- Suffix -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Name Suffix</label>
                            <input type="text" name="name_suffix"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5">
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Email Address</label>
                            <input type="email" name="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5"
                                required>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Phone Number</label>
                            <input type="text" name="phone"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5"
                                required>
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Date of Birth</label>
                            <input type="date" name="date_of_birth"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5"
                                required>
                        </div>

                        <!-- Citizenship -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Citizenship</label>
                            <input type="text" name="citizenship"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5"
                                required>
                        </div>

                        <!-- Civil Status -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Civil Status</label>
                            <select name="civil_status"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5"
                                required>
                                <option disabled selected>Select status</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Widowed">Widowed</option>
                                <option value="Annulled">Annulled</option>
                            </select>
                        </div>

                    </div>
                </div>

                <!-- ---------------------- -->
                <!-- ADDRESS INFORMATION    -->
                <!-- ---------------------- -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 border-b pb-2 mb-4">
                        Address Information
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Home Address -->
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900">Home Address</label>
                            <input type="text" name="home_address"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5"
                                required>
                        </div>

                        <!-- Lot -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Lot #</label>
                            <input type="text" name="lot_number"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5"
                                required>
                        </div>

                        <!-- Block -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Block #</label>
                            <input type="text" name="block_number"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5"
                                required>
                        </div>

                        <!-- Phase -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Phase #</label>
                            <input type="text" name="phase_number"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5"
                                required>
                        </div>

                        <!-- Village -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Village Name</label>
                            <input type="text" name="village_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5"
                                required>
                        </div>

                    </div>
                </div>

                <!-- BUTTONS -->
                <div class="flex justify-end gap-3 pt-4">
                    <button type="reset"
                        class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100">
                        Cancel
                    </button>

                    <button type="submit"
                        class="py-2.5 px-5 text-sm font-medium text-white bg-teal-700 rounded-lg hover:bg-teal-800 focus:ring-4 focus:ring-teal-300">
                        Save
                    </button>
                </div>

            </form>

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
<?php
$content = ob_get_clean();

$pageScripts = '
  <script src="' . BASE_URL . 'ui/modules/users/fetchById.boardmember.js"></script>
';

require_once BASE_PATH . '/pages/layout.php';
?>