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
        <!-- Stats Cards -->
        <div class="flex justify-between gap-4 mb-4">
          <div class="flex flex-row p-6 bg-white border border-gray-200 rounded-lg shadow-sm gap-4 w-full">
            <button type="button" class="text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm px-4 py-3 text-center inline-flex items-center">
            <i class="ri-team-fill text-2xl"></i>
            <span class="sr-only">Icon description</span>
            </button>
            <div class="flex flex-col items-start">
              <div class="text-2xl font-bold">
                3
              </div>
              <div class="text-sm text-gray-400">
                Total TODA
              </div>
            </div>
          </div>
          <div class="flex flex-row p-6 bg-white border border-gray-200 rounded-lg shadow-sm gap-4 w-full">
            <button type="button" class="text-green-700 border border-green-700 hover:bg-green-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-full text-sm px-4 py-3 text-center inline-flex items-center">
            <i class="ri-motorbike-fill text-2xl"></i>
            <span class="sr-only">Icon description</span>
            </button>
            <div class="flex flex-col items-start">
              <div class="text-2xl font-bold">
                35
              </div>
              <div class="text-sm text-gray-400">
                Total Tricycles
              </div>
            </div>
          </div>
          <div class="flex flex-row p-6 bg-white border border-gray-200 rounded-lg shadow-sm gap-4 w-full">
            <button type="button" class="text-orange-400 border border-orange-400 hover:bg-orange-400 hover:text-white focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-full text-sm px-4 py-3 text-center inline-flex items-center">
              <i class="ri-wallet-fill text-2xl"></i>
              <span class="sr-only">Icon description</span>
            </button>
            <div class="flex flex-col items-start">
              <div class="text-2xl font-bold">
                ₱3,000
              </div>
              <div class="text-sm text-gray-400">
                Total Revenue
              </div>
            </div>
          </div>
        </div>

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
          <form class="w-[10rem]">
            <select id="status" class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body">
              <option selected>All</option>
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
          </form>
          <button id="dropdownBottomButton" data-dropdown-toggle="dropdownBottom" data-dropdown-placement="bottom" class="md:mb-0 text-white bg-teal-600 hover:bg-teal-800 focus:ring-1 focus:outline-none focus:ring-teal-600 font-medium rounded-lg text-sm px-5 py-1.5 text-center flex items-center" type="button">
            <i class="ri-add-circle-line me-2 text-lg"></i>
            New TODA
          </button>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg border border-gray-200">
          <table id="usersTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
              <tr>
                <th scope="col" class="px-6 py-3">
                  Name
                </th>
                <th scope="col" class="px-6 py-3">
                  Role
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

  <?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/scripts.php'); ?>
  <?php echo '<script src="'. BASE_PATH .'/assets/js/users/board-members/fetch.js"></script>'; ?>
  </body>
</html>
