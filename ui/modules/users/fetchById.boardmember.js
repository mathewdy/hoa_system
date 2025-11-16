import { showToast } from '/hoa_system/ui/utils/toast.js';

$(document).ready(function () {
    const urlParams = new URLSearchParams(window.location.search);
    const userId = urlParams.get('id');

    function loadUserData() {
        $.get('/hoa_system/app/api/users/getById.users.php?id=' + userId)
            .done(function (res) {
                const u = res.data;

                // Header
                $('#heading').text(u.fullName || 'No Name');
                $('#subheading').text(u.role || 'Resident');
                document.title = (u.fullName || 'User') + " - HOA Profile";

                // Personal Info
                $('#personalInfo input[name="user_id"]').val(u.user_id);
                $('#personalInfo input[name="first_name"]').val(u.first_name || '');
                $('#personalInfo input[name="middle_name"]').val(u.middle_name || '');
                $('#personalInfo input[name="last_name"]').val(u.last_name || '');
                $('#personalInfo input[name="suffix"]').val(u.suffix || '');
                $('#personalInfo input[name="phone"]').val(u.phone || '');
                $('#personalInfo input[name="birthdate"]').val(u.birthdate || '');
                $('#personalInfo input[name="citizenship"]').val(u.citizenship || '');
                $('#personalInfo select[name="civil_status"]').val(u.civil_status || '');

                // Home Details
                $('#homeDetailsForm input[name="user_id"]').val(u.user_id);
                $('#homeDetailsForm input[name="hoa_number"]').val(u.hoa_number || '');
                $('#homeDetailsForm input[name="home_address"]').val(u.home_address || '');
                $('#homeDetailsForm input[name="lot"]').val(u.lot_number || '');
                $('#homeDetailsForm input[name="block"]').val(u.block_number || '');
                $('#homeDetailsForm input[name="phase"]').val(u.phase_number || '');
                $('#homeDetailsForm input[name="village"]').val(u.village_name || '');

                // Account Settings
                $('#accountSettingsForm input[name="user_id"]').val(u.user_id);
                $('#accountSettingsForm input[name="email_address"]').val(u.email || '');
                $('#accountSettingsForm input[name="role"]').val(u.role || '');
            });
    }

    // Edit buttons
    function setupEditButton(buttonId, formSelector) {
      $(document).on('click', '#editButtonPersonal, #editButtonHome, #editButtonAccount', function () {
          const button = $(this);
          const form = button.closest('form');
          const inputs = form.find('input, select');
          const saveBtn = form.find('.save-btn');
          const isEditing = button.text().trim().includes('Edit');

          if (isEditing) {
              // → SWITCH TO EDIT MODE
              inputs.prop({ readonly: false, disabled: false });
              saveBtn.removeClass('hidden');
              button.html('<i class="ri-close-line mr-1"></i> Cancel');
          } else {
              // → SWITCH BACK TO VIEW MODE
              inputs.prop({ readonly: true, disabled: true });
              saveBtn.addClass('hidden');
              button.html('<i class="ri-edit-line mr-1"></i> Edit');
              loadUserData(); // revert changes
          }
      });
    }

    setupEditButton('#editButtonPersonal', '#personalInfo');
    setupEditButton('#editButtonHome', '#homeDetailsForm');
    setupEditButton('#editButtonAccount', '#accountSettingsForm');

$('form').on('submit', function (e) {
    e.preventDefault();

    const form = $(this);
    const section = form.find('input[name="section"]').val();
    let endpoint = '';

    switch (section) {
        case 'personal':
            endpoint = '/hoa_system/app/api/users/put.personalInfo.php';
            break;
        case 'home':
            endpoint = '/hoa_system/app/api/users/put.homeDetails.php';
            break;
        case 'account':
            endpoint = '/hoa_system/app/api/users/put.accountSettings.php';
            break;
        default:
            showToast({ type: 'error', message: 'Unknown section', position: 'bottom-right' });
            return;
    }

    const formData = form.serialize()

    $.post(endpoint, formData)
        .done(function (res) {
            if (res.success) {
                showToast({ type: 'success', message: res.message || 'Saved!', position: 'bottom-right' });
                loadUserData(); 

                form.find('.save-btn').addClass('hidden');
                form.find('input, select').prop({ readonly: true, disabled: true });
                form.prev().find('.edit-button, a').html('<i class="ri-edit-line mr-1"></i> Edit');
            } else {
                showToast({ type: 'error', message: res.message || 'Save failed', position: 'bottom-right' });
            }
        })
        .fail(function () {
            showToast({ type: 'error', message: 'Server error', position: 'bottom-right' });
        });
});

    loadUserData();
});