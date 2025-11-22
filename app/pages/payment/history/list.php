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
          <div class="mt-1">
            <h3 class="text-2xl font-medium text-gray-900 mb-4">Payment History</h3>
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
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg border border-gray-200">
              <table id="usersTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                  <tr>
                    <th scope="col" class="px-6 py-3">
                      Name
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
          </div>
        </main>
      </div>
    </div>
    <?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/scripts.php'); ?>
    <?php echo '<script src="'. BASE_PATH .'assets/js/payment/history/fetch.js"></script>'; ?>
    </div>
  </body>
</html>
