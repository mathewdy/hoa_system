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
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6 w-full">
          <div class="flex items-center space-x-6">
            <div class="relative">
              <img src="https://randomuser.me/api/portraits/women/8.jpg" 
                alt="Profile" 
                class="profile-avatar w-24 h-24 rounded-full object-cover" 
                id="profile-picture-preview" />
              <label for="profile-picture" 
                  class="absolute -bottom-1 -right-1 bg-teal-600 text-white rounded-full p-2 cursor-pointer hover:bg-teal-700 transition-colors shadow-lg">
                <i class="fas fa-camera text-xs"></i>
                <input type="file" id="profile-picture" class="hidden" accept="image/png,image/jpeg" />
              </label>
            </div>
            <div>
              <h2 class="text-2xl font-bold text-gray-900">Marj Celine Aberia San Jose</h2>
              <p class="text-gray-600">Admin • Mabuhay Homes 2000</p>
            </div>
          </div>
        </div>

        <div class="mb-4 border-b border-default">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                  <button 
                    class="inline-block p-4 border-b-2 rounded-t-lg border-transparent 
                      hover:text-teal-600 hover:border-teal-600 aria-selected:border-teal-600 
                      aria-selected:text-teal-600" 
                    id="profile-tab" 
                    data-tabs-target="#profile" 
                    type="button" 
                    role="tab" 
                    aria-controls="profile" 
                    aria-selected="false"
                  >
                      Personal Information
                  </button>
                </li>
                <li class="me-2" role="presentation">
                  <button 
                    class="inline-block p-4 border-b-2 rounded-t-lg border-transparent 
                      hover:text-teal-600 hover:border-teal-600 aria-selected:border-teal-600 
                      aria-selected:text-teal-600" 
                    id="dashboard-tab" 
                    data-tabs-target="#dashboard" 
                    type="button" 
                    role="tab" 
                    aria-controls="dashboard" 
                    aria-selected="false"
                  >
                    Dashboard
                  </button>
                </li>
                <li role="presentation">
                  <button 
                    class="inline-block p-4 border-b-2 rounded-t-lg border-transparent 
                      hover:text-teal-600 hover:border-teal-600 aria-selected:border-teal-600 
                      aria-selected:text-teal-600"
                    id="contacts-tab" 
                    data-tabs-target="#contacts" 
                    type="button" 
                    role="tab" 
                    aria-controls="contacts" 
                    aria-selected="false"
                  >
                    Account Settings
                  </button>
                </li>
            </ul>
        </div>

        <div id="default-tab-content">
          <div class="hidden rounded-base bg-neutral-secondary-soft" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="profile-section bg-white rounded-lg shadow-sm mb-6 w-full" id="basic-info-section">
              <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <div>
                  <h3 class="text-lg font-semibold text-gray-900">Basic Information</h3>
                  <p class="text-sm text-gray-500">Your name and role information</p>
                </div>
                <button class="edit-button text-teal-600 hover:text-teal-700 px-3 py-1 rounded-md hover:bg-teal-50 transition-colors" 
                        onclick="editSection('basic-info')">
                  <i class="fas fa-edit mr-1"></i> Edit
                </button>
              </div>
              
              <div id="basic-info-display" class="p-6">
                <div class="space-y-4">
                  <div class="info-row py-3 px-4 rounded-md">
                    <div class="flex justify-between items-center">
                      <div>
                        <p class="text-sm font-medium text-gray-500">Full Name</p>
                        <p class="text-gray-900" id="display-name">Marj Celine Aberia San Jose</p>
                      </div>
                      <i class="fas fa-user text-gray-400"></i>
                    </div>
                  </div>
                  <div class="info-row py-3 px-4 rounded-md">
                    <div class="flex justify-between items-center">
                      <div>
                        <p class="text-sm font-medium text-gray-500">Role</p>
                        <p class="text-gray-900">Admin</p>
                      </div>
                      <i class="fas fa-user-tie text-gray-400"></i>
                    </div>
                  </div>
                </div>
              </div>

              <div id="basic-info-edit" class="p-6 hidden">
                <div class="space-y-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <input type="text" id="edit-name" value="Marj Celine Aberia San Jose" 
                      class="form-input w-full p-3 rounded-md" readonly 
                      style="background-color: #f9fafb; color: #6b7280;">
                    <p class="text-xs text-gray-500 mt-1">Name cannot be changed. Contact administrator if needed.</p>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                    <input type="text" value="Secretary" 
                      class="form-input w-full p-3 rounded-md" readonly 
                      style="background-color: #f9fafb; color: #6b7280;">
                    <p class="text-xs text-gray-500 mt-1">Role is assigned by administrator.</p>
                  </div>
                </div>
                <div class="save-cancel-buttons flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-100">
                  <button onclick="cancelEdit('basic-info')" 
                          class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition-colors">
                    Cancel
                  </button>
                  <button onclick="saveSection('basic-info')" 
                          class="px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition-colors">
                    Save
                  </button>
                </div>
              </div>
            </div>

            <!-- Contact Information Section -->
            <div class="profile-section bg-white rounded-lg shadow-sm mb-6 w-full" id="contact-info-section">
              <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <div>
                  <h3 class="text-lg font-semibold text-gray-900">Contact Information</h3>
                  <p class="text-sm text-gray-500">How people can reach you</p>
                </div>
                <button class="edit-button text-teal-600 hover:text-teal-700 px-3 py-1 rounded-md hover:bg-teal-50 transition-colors" 
                        onclick="editSection('contact-info')">
                  <i class="fas fa-edit mr-1"></i> Edit
                </button>
              </div>
              
              <div id="contact-info-display" class="p-6">
                <div class="space-y-4">
                  <div class="info-row py-3 px-4 rounded-md">
                    <div class="flex justify-between items-center">
                      <div>
                        <p class="text-sm font-medium text-gray-500">Email</p>
                        <p class="text-gray-900" id="display-email">maria.santos@email.com</p>
                      </div>
                      <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                  </div>
                  <div class="info-row py-3 px-4 rounded-md">
                    <div class="flex justify-between items-center">
                      <div>
                        <p class="text-sm font-medium text-gray-500">Phone Number</p>
                        <p class="text-gray-900" id="display-phone">+63 917 123 4567</p>
                      </div>
                      <i class="fas fa-phone text-gray-400"></i>
                    </div>
                  </div>
                  <div class="info-row py-3 px-4 rounded-md">
                    <div class="flex justify-between items-center">
                      <div>
                        <p class="text-sm font-medium text-gray-500">Address</p>
                        <p class="text-gray-900" id="display-address">123 Mabuhay St. Lot 12, Block 3, Phase 2, Mabuhay Homes 2000</p>
                      </div>
                      <i class="fas fa-map-marker-alt text-gray-400"></i>
                    </div>
                  </div>
                </div>
              </div>

              <div id="contact-info-edit" class="p-6 hidden">
                <div class="space-y-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" id="edit-email" value="maria.santos@email.com" 
                          class="form-input w-full p-3 rounded-md" readonly 
                          style="background-color: #f9fafb; color: #6b7280;">
                    <p class="text-xs text-gray-500 mt-1">Email cannot be changed. Contact administrator if needed.</p>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <input type="tel" id="edit-phone" value="+63 917 123 4567" 
                          class="form-input w-full p-3 rounded-md" 
                          pattern="\+63[0-9]{10}">
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                    <input type="text" id="edit-address" value="123 Mabuhay St. Lot 12, Block 3, Phase 2, Mabuhay Homes 2000" 
                          class="form-input w-full p-3 rounded-md" readonly 
                          style="background-color: #f9fafb; color: #6b7280;">
                    <p class="text-xs text-gray-500 mt-1">Address is based on your property registration.</p>
                  </div>
                </div>
                <div class="save-cancel-buttons flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-100">
                  <button onclick="cancelEdit('contact-info')" 
                          class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition-colors">
                    Cancel
                  </button>
                  <button onclick="saveSection('contact-info')" 
                          class="px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition-colors">
                    Save
                  </button>
                </div>
              </div>
            </div>

            <!-- Personal Details Section -->
            <div class="profile-section bg-white rounded-lg shadow-sm mb-6 w-full" id="personal-details-section">
              <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <div>
                  <h3 class="text-lg font-semibold text-gray-900">Personal Details</h3>
                  <p class="text-sm text-gray-500">Information about yourself</p>
                </div>
                <button class="edit-button text-teal-600 hover:text-teal-700 px-3 py-1 rounded-md hover:bg-teal-50 transition-colors" 
                        onclick="editSection('personal-details')">
                  <i class="fas fa-edit mr-1"></i> Edit
                </button>
              </div>
              
              <div id="personal-details-display" class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div class="info-row py-3 px-4 rounded-md">
                    <div class="flex justify-between items-center">
                      <div>
                        <p class="text-sm font-medium text-gray-500">Date of Birth</p>
                        <p class="text-gray-900" id="display-dob">June 15, 1985</p>
                      </div>
                      <i class="fas fa-birthday-cake text-gray-400"></i>
                    </div>
                  </div>
                  <div class="info-row py-3 px-4 rounded-md">
                    <div class="flex justify-between items-center">
                      <div>
                        <p class="text-sm font-medium text-gray-500">Age</p>
                        <p class="text-gray-900">35 years old</p>
                      </div>
                      <i class="fas fa-calendar-alt text-gray-400"></i>
                    </div>
                  </div>
                  <div class="info-row py-3 px-4 rounded-md">
                    <div class="flex justify-between items-center">
                      <div>
                        <p class="text-sm font-medium text-gray-500">Relationship Status</p>
                        <p class="text-gray-900" id="display-relationship">Single</p>
                      </div>
                      <i class="fas fa-heart text-gray-400"></i>
                    </div>
                  </div>
                  <div class="info-row py-3 px-4 rounded-md">
                    <div class="flex justify-between items-center">
                      <div>
                        <p class="text-sm font-medium text-gray-500">Citizenship</p>
                        <p class="text-gray-900">Filipino</p>
                      </div>
                      <i class="fas fa-globe text-gray-400"></i>
                    </div>
                  </div>
                </div>
              </div>

              <div id="personal-details-edit" class="p-6 hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                    <input type="text" value="June 15, 1985" 
                          class="form-input w-full p-3 rounded-md" readonly 
                          style="background-color: #f9fafb; color: #6b7280;">
                    <p class="text-xs text-gray-500 mt-1">Cannot be changed.</p>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Relationship Status</label>
                    <select id="edit-relationship" class="form-input w-full p-3 rounded-md">
                      <option value="Single" selected>Single</option>
                      <option value="Married">Married</option>
                      <option value="Divorced">Divorced</option>
                      <option value="Widowed">Widowed</option>
                    </select>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Citizenship</label>
                    <input type="text" value="Filipino" 
                          class="form-input w-full p-3 rounded-md" readonly 
                          style="background-color: #f9fafb; color: #6b7280;">
                    <p class="text-xs text-gray-500 mt-1">Cannot be changed.</p>
                  </div>
                </div>
                <div class="save-cancel-buttons flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-100">
                  <button onclick="cancelEdit('personal-details')" 
                          class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition-colors">
                    Cancel
                  </button>
                  <button onclick="saveSection('personal-details')" 
                          class="px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition-colors">
                    Save
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="hidden p-4 rounded-base bg-neutral-secondary-soft" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
              <p class="text-sm text-body">This is some placeholder content the <strong class="font-medium text-heading">Dashboard tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
          </div>
          <div class="hidden p-4 rounded-base bg-neutral-secondary-soft" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
            <!-- Account Settings Section -->
            <div class="profile-section bg-white rounded-lg shadow-sm mb-6 w-full" id="account-settings-section">
              <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <div>
                  <h3 class="text-lg font-semibold text-gray-900">Account Settings</h3>
                  <p class="text-sm text-gray-500">Manage your account security</p>
                </div>
              </div>
              
              <div class="p-6">
                <div class="space-y-4">
                  <div class="info-row py-4 px-4 rounded-md flex justify-between items-center">
                    <div>
                      <p class="font-medium text-gray-900">Password</p>
                    </div>
                    <button onclick="openPasswordModal()" 
                            class="text-teal-600 hover:text-teal-700 px-3 py-1 rounded-md hover:bg-teal-50 transition-colors">
                      <i class="fas fa-key mr-1"></i> Change Password
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


      </main>
    </div>
  </div>

  <!-- Change Password Modal -->
  <div id="password-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
      <div class="p-6 border-b border-gray-100">
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-bold text-gray-900">Change Password</h3>
          <button onclick="closePasswordModal()" class="text-gray-400 hover:text-gray-600 p-2">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      
      <form id="password-form" class="p-6">
        <div class="space-y-4">
          <div>
            <label for="current-password" class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
            <input type="password" id="current-password" class="form-input w-full p-3 rounded-md" required>
          </div>
          <div>
            <label for="new-password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
            <input type="password" id="new-password" class="form-input w-full p-3 rounded-md" required minlength="8">
          </div>
          <div>
            <label for="confirm-password" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
            <input type="password" id="confirm-password" class="form-input w-full p-3 rounded-md" required>
          </div>
        </div>
        
        <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-100">
          <button type="button" onclick="closePasswordModal()" 
                  class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition-colors">
            Cancel
          </button>
          <button type="submit" 
                  class="px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition-colors">
            Update Password
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Profile Picture Upload
    document.getElementById('profile-picture').addEventListener('change', function (e) {
      const file = e.target.files[0];
      if (file) {
        if ((file.type === 'image/png' || file.type === 'image/jpeg') && file.size <= 5 * 1024 * 1024) {
          const reader = new FileReader();
          reader.onload = function (event) {
            document.getElementById('profile-picture-preview').src = event.target.result;
          };
          reader.readAsDataURL(file);
        } else {
          alert('Please upload a PNG or JPG image under 5MB.');
          e.target.value = '';
        }
      }
    });

    // Section Editing Functions
    function editSection(sectionName) {
      const section = document.getElementById(sectionName + '-section');
      const display = document.getElementById(sectionName + '-display');
      const edit = document.getElementById(sectionName + '-edit');
      
      section.classList.add('section-editing');
      display.classList.add('hidden');
      edit.classList.remove('hidden');
    }

    function cancelEdit(sectionName) {
      const section = document.getElementById(sectionName + '-section');
      const display = document.getElementById(sectionName + '-display');
      const edit = document.getElementById(sectionName + '-edit');
      
      section.classList.remove('section-editing');
      display.classList.remove('hidden');
      edit.classList.add('hidden');
      
      // Reset form values
      if (sectionName === 'contact-info') {
        document.getElementById('edit-phone').value = '+63 917 123 4567';
      } else if (sectionName === 'personal-details') {
        document.getElementById('edit-relationship').value = 'Single';
      }
    }

    function saveSection(sectionName) {
      if (sectionName === 'contact-info') {
        const phone = document.getElementById('edit-phone').value;
        document.getElementById('display-phone').textContent = phone;
      } else if (sectionName === 'personal-details') {
        const relationship = document.getElementById('edit-relationship').value;
        document.getElementById('display-relationship').textContent = relationship;
      }
      
      cancelEdit(sectionName);
      
      // Show success message
      const section = document.getElementById(sectionName + '-section');
      const originalBg = section.style.backgroundColor;
      section.style.backgroundColor = '#f0fdf4';
      section.style.borderColor = '#22c55e';
      
      setTimeout(() => {
        section.style.backgroundColor = originalBg;
        section.style.borderColor = '';
      }, 2000);
    }

    // Password Modal Functions
    function openPasswordModal() {
      document.getElementById('password-modal').classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    }

    function closePasswordModal() {
      document.getElementById('password-modal').classList.add('hidden');
      document.body.style.overflow = 'auto';
      document.getElementById('password-form').reset();
    }

    // Password Form Submission
    document.getElementById('password-form').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const newPassword = document.getElementById('new-password').value;
      const confirmPassword = document.getElementById('confirm-password').value;
      
      if (newPassword !== confirmPassword) {
        alert('New password and confirmation do not match!');
        return;
      }
      
      alert('Password updated successfully!');
      closePasswordModal();
    });

    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
      const modal = document.getElementById('password-modal');
      if (e.target === modal) {
        closePasswordModal();
      }
    });
  </script>
  <?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/scripts.php'); ?>
</body>
</html>
