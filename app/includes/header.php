<header class="flex flex-row justify-between items-center p-4 sm:px-6 lg:px-8 gap-2 bg-white shadow-md">
  <span>
    <a href="javascript:void(0)" id="sidebarToggle" class="flex items-center text-lg font-black text-teal-600 hover:text-teal-800">
      <i class="ri-menu-2-fill"></i>
    </a>
  </span>

  <div class="flex flex-row items-center gap-2">
    <a href="#" class="flex items-center text-md font-medium text-teal-600 hover:text-teal-800 p-2">
      <i class="ri-notification-3-fill"></i>
    </a>

    <button id="dropdownAvatarNameButton"
      data-dropdown-toggle="dropdownAvatarName"
      data-dropdown-placement="bottom"
      type="button"
      class="text-md font-medium text-gray-600 hover:text-black-800 flex items-center"
    >
      <img id="userAvatar" class="w-8 h-8 rounded-sm ring-2 ring-gray-300 p-2 me-2" src="<?= BASE_PATH ?>/assets/img/user-alt-64.png" alt="Avatar">
      <span class="flex flex-col justify-start gap-0 leading-none">
        <p id="userName" class="text-sm m-0 p-0 leading-none">Loading...</p>
        <span id="userRole" class="text-start text-blue-800 text-xs font-medium me-2 rounded-lg">Loading</span>
      </span>
    </button>

    <div id="dropdownAvatarName" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-md border border-gray-200 w-[20rem]">
      <div class="flex flex-row items-center px-4 py-3">
        <img id="dropdownUserAvatar" class="w-10 h-10 rounded-sm ring-2 ring-gray-300 p-2 me-2" src="<?= BASE_PATH ?>/assets/img/user-alt-64.png" alt="Avatar">
        <div class="text-sm text-gray-900">
          <div id="dropdownUserName" class="font-medium">Loading...</div>
          <div id="dropdownUserEmail" class="truncate">Loading...</div>
        </div>
      </div>
      <ul class="py-2 text-sm text-gray-700">
        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100"><i class="ri-history-line me-2"></i>Activity Logs</a></li>
        <li><a href="<?= BASE_PATH ?>/app/profile.php" class="block px-4 py-2 hover:bg-gray-100"><i class="ri-account-circle-fill me-2"></i>Profile</a></li>
      </ul>
      <div class="py-2">
        <a href="<?= BASE_PATH ?>/core/auth/logout.php" class="block px-4 py-2 text-sm hover:bg-gray-100"><i class="ri-logout-box-line me-2"></i>Sign out</a>
      </div>
    </div>
  </div>
</header>
