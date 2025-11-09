
function showToast(type, message) {
  const icons = {
    success: 'ri-checkbox-circle-line text-green-500',
    error: 'ri-error-warning-line text-red-500',
    info: 'ri-information-line text-blue-500'
  };
  const bg = type === 'error' ? 'bg-red-100' : type === 'success' ? 'bg-green-100' : 'bg-blue-100';

  const $toast = $(`
    <div class="flex items-center w-full max-w-xs p-4 text-gray-700 ${bg} rounded-lg shadow transition transform">
      <i class="${icons[type]} text-xl mr-2"></i>
      <div class="text-sm font-medium flex-1">${message}</div>
      <button type="button" class="ml-3 text-gray-500 hover:text-gray-700" 
        onclick="$(this).parent().fadeOut(200, function(){ $(this).remove(); })">
        <i class="ri-close-line"></i>
      </button>
    </div>
  `);

  $('#toast-container').append($toast);
  setTimeout(() => {
    $toast.fadeOut(300, function() { $(this).remove(); });
  }, 4000);
}

$(document).ready(function() {
  $('.open-modal-btn').on('click', function() {
    const roleName = $(this).data('role');
    const roleId = $(this).data('role-id'); 
    $('#sec-role').val(roleName);
    $('#createForm').find('input[name="role_id"]').val(roleId);
    $('#default-modal h3').text(`Create ${roleName} Account`);
  });

  $('#createForm').on('submit', function(e) {
    e.preventDefault();
    handleCreate();
    renderState()
  });
});

function handleCreate() {
  const $form = $('#createForm');
  const formData = new FormData($form[0]);

  if (!$form[0].checkValidity()) {
    showToast('error', 'Please fill all required fields.');
    return;
  }

  state.set({ loading: true, error: '', success: '' });

  $.ajax({
    url: '/hoa_system/core/users/create.php', 
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    dataType: 'json',
    success: function(response) {
      if (response.success) {
        state.set({ loading: false, success: response.message });
        showToast('success', response.message);

        $form[0].reset();
        $('#sec-role').val(''); 
      } else {
        state.set({ loading: false, error: response.message });
        showToast('error', response.message);
      }
    },
    error: function(xhr, status, error) {
      state.set({ loading: false, error: 'Server error.' });
      showToast('error', 'Server error.');
    }
  });
}

function renderState() {
  const { loading } = state;
  const $btn = $('#submitBtn');
  $btn.prop('disabled', loading);
  $btn.html(loading ? 'Saving...' : 'Save');
}
