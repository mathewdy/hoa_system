import { showToast } from '/hoa_system/assets/js/utils/toast.js';

const state = {
  loading: false,
  error: '',
  success: '',
  users: [],

  set(newState) {
    Object.assign(this, newState);
    render();
  }
};

$(document).ready(function() {
  const params = new URLSearchParams(window.location.search);
  const userId = params.get('user_id');
  fetchUser(userId)
  $('#submitBtn').prop('disabled', true)
  $('#confirmSaveBtn').on('submit', function (e) {
    e.preventDefault(); // stop immediate form submit
    const confirmModal = document.getElementById('confirmModal');
    const modal = new Modal(confirmModal);
    modal.show();

    $('#confirmSaveBtn').off('click').on('click', function () {
      modal.hide();
      saveForm();
    });
  });
});

function fetchUser(id) {
  state.set({ loading: true, error: '', success: '' });

  $.ajax({
    url: `/hoa_system/core/users/board-members/users-by-id.php?user_id=${id}`,
    type: 'GET',
    dataType: 'json',
    success: function (response) {
      if (response.success) {
        state.set({
          loading: false,
          user: response.data,
          success: 'User loaded successfully.'
        });
      } else {
        state.set({
          loading: false,
          error: response.message || 'Failed to load user.',
          user: {}
        });
      }
    },
    error: function () {
      state.set({ loading: false, error: 'Server error.', user: {} });

    }
  });
}
function saveForm() {
  const formData = $('#createForm').serialize();

  $.ajax({
    url: '/hoa_system/core/users/board-members/edit.php',
    type: 'POST',
    data: formData,
    dataType: 'json',
    beforeSend: function () {
      $('#submitBtn').prop('disabled', true).text('Saving...');
    },
    success: function (response) {
      $('#submitBtn').prop('disabled', false).text('Save');
      if (response.success) {
        showToast({ type: 'success', message: res.message })
      } else {
        showToast({ type: 'error', message: res.message || 'Error saving data.'})
      }
    },
    error: function () {
      $('#submitBtn').prop('disabled', false).text('Save');
      showToast({ type: 'error', message: 'Error saving data.'})
    }
  });
}

function render() {
  const { loading, user, error } = state;

  if (loading) {
    $('#submitBtn').prop('disabled', true).text('Loading...');
    return;
  } else {
    $('#submitBtn').prop('disabled', false).text('Save');
  }

  if (error) {
    console.error(error);
    return;
  }

  if (user && Object.keys(user).length > 0) {
    const phone = user.phone_number ? user.phone_number.replace('+639', '') : '';
    $('#sec-phone').val(phone);
    $('#sec-first-name').val(user.first_name);
    $('#sec-middle-name').val(user.middle_name);
    $('#sec-last-name').val(user.last_name);
    $('#sec-name-suffix').val(user.suffix);
    $('#sec-role').val(user.role_id);
    $('#sec-email').val(user.email_address);
    $('#sec-age').val(user.age);
    $('#sec-dob').val(user.date_of_birth);
    $('#sec-citizenship').val(user.citizenship);
    $('#sec-relationship-status').val(user.civil_status);
    $('#sec-home-address').val(user.home_address);
    $('#sec-lot-number').val(user.lot_number);
    $('#sec-block-number').val(user.block_number);
    $('#sec-phase-number').val(user.phase_number);
    $('#sec-village-name').val(user.village_name);
  }
}
