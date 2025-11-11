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

<body class="">
  <div class="h-full flex bg-gray-50">
    <aside id="sidebar" class="w-64 h-100 bg-teal-700 text-white border-r border-gray-200 p-4">
      <div class="px-3 mb-8">
        <h1 class="text-2xl font-bold">HOAConnect</h1>
        <p class="text-sm text-teal-200">Mabuhay Homes 2000</p>
      </div>
      <div id="sidebarList">
      </div>
    </aside>
    <div class="flex-1 flex flex-col">
      <header class="flex flex-row justify-between items-center p-4 sm:px-6 lg:px-8 gap-2 bg-white shadow-md">
        <span>
          <a href="javascript:void(0 )" id="sidebarToggle" class="flex items-center text-lg font-black text-teal-600 hover:text-teal-800">
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
                <a href="<?= BASE_PATH . '/core/auth/logout.php'?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  <i class="ri-logout-box-line me-2"></i>
                  Sign out
                </a>
              </div>
          </div>
        </div>
      </header>
      <main class="flex-1 p-6">
        <div class="mt-1">
          <h3 class="text-2xl font-medium text-gray-900 mb-4">Board Members</h3>
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
                    <a 
                      href="create.php?role=3" 
                      class="item block px-4 py-2 hover:bg-gray-100"
                    >
                      <i class="ri-admin-fill text-blue-400 me-2"></i>
                      Admin
                    </a>
                  </li>
                  <li>
                    <a 
                      href="create.php?role=2" 
                      class="item block px-4 py-2 hover:bg-gray-100" 
                    >
                      <i class="ri-briefcase-4-fill text-amber-900 me-2"></i>
                      Secretary
                    </a>
                  </li>
                  <li>
                    <a 
                      href="create.php?role=4" 
                      class="item block px-4 py-2 hover:bg-gray-100" 
                    >
                      <i class="ri-cash-line text-green-800 me-2"></i>
                      Treasurer
                    </a>
                  </li>
                  <li>
                    <a 
                      href="create.php?role=5" 
                      class="item block px-4 py-2 hover:bg-gray-100"
                    >
                      <i class="ri-survey-fill me-2"></i>
                      Audit
                    </a>
                  </li>
                </ul>
            </div>
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
  <?php 
    echo '
      <script src="'. BASE_PATH .'/assets/js/sidebar.js"></script>
      <script src="'. BASE_PATH .'/assets/js/users/board-members/fetch.js"></script>
    '; 
  ?>
  </body>
</html>

