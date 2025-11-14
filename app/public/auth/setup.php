<?php 
  include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/config.php');
  include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/session.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/page-icon.php'); ?>
  <?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/styles.php'); ?>

</head>
<body class="min-h-screen md:bg-gray-50 flex flex-col">
  <div class="flex justify-center">
    <div 
      id="toast-container" 
      class="flex flex-col justify-center fixed mt-5 space-y-2 z-50">
    </div>
  </div>
  <div class="flex-1 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <div class="flex justify-center">
        <span class="text-7xl text-teal-600">
          <i class="ri-community-line"></i>
        </span>
      </div>
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">HOAConnect</h2>
      <p class="mt-2 text-center text-sm text-gray-600">Set up your Mabuhay Homes 2000 account</p>
    </div>
    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
        <div id="error-message" class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative hidden" role="alert">
          <span class="block sm:inline" id="error-text"></span>
        </div>
        <form id="setup-password-form" method="POST" class="space-y-6">
          <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">

          <div>
              <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
              <div class="mt-1 relative">
                  <input
                      id="password"
                      name="password"
                      type="password"
                      autocomplete="current-password"
                      required
                      class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm pr-10 pw"
                  />
                  <button
                      type="button"
                      id="toggle-password"
                      data-target="#password"
                      class="absolute inset-y-0 right-0 pr-3 flex items-center pw-toggle"
                  >
                      <i class="ri-eye-line"></i>
                  </button>
              </div>
          </div>

          <div>
              <label for="confirmPassword" class="block text-sm font-medium text-gray-700">Confirm Password</label>
              <div class="mt-1 relative">
                  <input
                      id="confirmPassword"
                      name="confirm_password"
                      type="password"
                      autocomplete="current-password"
                      required
                      class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm pr-10 pw"
                  />
                  <button
                      type="button"
                      id="toggle-confirm-password"
                      data-target="#confirmPassword"
                      class="absolute inset-y-0 right-0 pr-3 flex items-center pw-toggle"
                  >
                      <i class="ri-eye-line"></i>
                  </button>
              </div>
          </div>

          <div>
              <button
                  type="submit"
                  id="submitBtn"
                  class="w-full flex justify-center items-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500"
              >
                  Submit
              </button>
              <input type="hidden" name="setup" value="1">
          </div>
      </form>


      <div class="mt-6">
          <div class="relative">
              <div class="absolute inset-0 flex items-center">
                  <div class="w-full border-t border-gray-300"></div>
              </div>
              <div class="relative flex justify-center text-sm">
                  <span class="px-2 bg-white text-gray-500">Need help?</span>
              </div>
          </div>

          <div class="mt-6 text-center text-sm font-bold text-gray-500">
              <p>Visit the HOA office for assistance.</p>
          </div>
      </div>
    </div>
  </div>
</div>
  <footer class="bg-white py-4 border-t border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <p class="text-center text-sm text-gray-500">
              &copy; <script>document.write(new Date().getFullYear())</script> HOAConnect. All rights reserved. 
          </p>
      </div>
  </footer>
  <?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/scripts.php'); ?>
  <?php echo '<script type="module" src="'. BASE_PATH .'/assets/js/auth/login/setup.js"></script>'; ?>
  </body>
</html>