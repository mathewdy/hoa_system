import { showToast } from '/hoa_system/assets/js/utils/toast.js';

$(document).ready(function () {
  $('#createForm').on('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    formData.append('create_account', '1');

    handleCreate(formData);
  });
});

function handleCreate(formData) {
  state.set({ loading: true, error: '', success: '' });
  renderState();

  $.ajax({
    url: '/hoa_system/core/users/create.php', 
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    dataType: 'json',
    success: function (response) {
      if (response.success) {
        state.set({ loading: false, success: response.message });
        showToast({ type: 'success', message: response.message, position: 'bottom-right' });
        $('#createForm')[0].reset();
        setTimeout(() => {
          window.location.reload()
        }, 1500);
      } else {
        state.set({ loading: false, error: response.message });
        showToast({ type: 'error', message: response.message, position: 'bottom-right' });
        
      }
    },
    error: function () {
      state.set({ loading: false, error: 'Server error.', position: 'bottom-right' });
      showToast({ type: 'error', message: 'Server error.', position: 'bottom-right' });
    }
  });
}

function renderState() {
  const { loading } = state;
  const $btn = $('#submitBtn');
  $btn.prop('disabled', loading);
  $btn.html(loading ? 'Saving...' : 'Save');
}
