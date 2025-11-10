import { showToast } from '/hoa_system/assets/js/utils/toast.js';

const state = {
  loading: false,
  error: '',
  success: '',
  user: null,

  set(newState) {
    Object.assign(this, newState);
    render();
  }
};

$(document).ready(function() {
  $('#login-form').on('submit', function(event) {
    event.preventDefault()
    handleLogin(event)
    render()
  });
});


function handleLogin(event) {
  event.preventDefault();
  const username = $('#username').val().trim();
  const password = $('#password').val().trim();

  if (!username || !password) {
    state.set({ error: 'Please fill all fields.' });
    showToast('error', 'Please fill all fields.');
    return;
  }

  state.set({ loading: true, error: '', success: '' });

  $.ajax({
    url: '/hoa_system/core/auth/login.php',
    type: 'POST',
    data: { username, password },
    dataType: 'json',
    success: function(res) {
      if (res.success) {
        state.set({ loading: true, success: res.message, user: res.user });
        showToast({ type: 'success', message: res.message, position: 'bottom-right'});
        setTimeout(() => {
          window.location.href = "../../pages/dashboard.php";
        }, 1500);
      } else {
        state.set({ loading: false, error: res.message });
        showToast({ type: 'error', message: res.message, position: 'bottom-right'});
      }
    },
    error: function() {
      state.set({ loading: false, error: 'Server error.' });
      showToast({ type: 'error', message: 'Something went wrong!', position: 'bottom-right'});
    }
  });
}

function render() {
  const { loading } = state;
  const $btn = $('#loginBtn');
  const $spinner = $('#btn-spinner');

  $btn.prop('disabled', loading);
  $btn.html(loading 
    ? `<div role="status hidden">
          <svg aria-hidden="true" class="w-4 h-4 text-black-200 animate-spin dark:text-white-600 fill-teal-800 me-2" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
              <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
          </svg>
          <span class="sr-only">Loading...</span>
        </div>` 
    : 'Log in'
  )
}
