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

$(document).ready(function () {
  $('#login-form').on('submit', function (event) {
    event.preventDefault();
    handleLogin();
  });
});

function handleLogin() {
  const username = $('#username').val().trim();
  const password = $('#password').val().trim();

  if (!username || !password) {
    state.set({ error: 'Please fill all fields.' });
    showToast({ type: 'error', message: 'Please fill all fields.', position: 'bottom-right' });
    return;
  }

  state.set({ loading: true, error: '', success: '' });

  $.ajax({
    url: '/hoa_system/core/auth/login.php',
    type: 'POST',
    data: { username, password },
    dataType: 'json',
    success: function (res) {
      state.set({ loading: false });

      if (res.success) {
        showToast({ type: 'success', message: res.message, position: 'bottom-right' });
        if (res.firstTime) {
          setTimeout(() => {
            window.location.href = '/hoa_system/app/public/auth/setup.php';
          }, 1200);
        } else {
          setTimeout(() => {
            window.location.href = '/hoa_system/app/pages/dashboard.php';
          }, 1200);
        }
      } else {
        showToast({ type: 'error', message: res.message, position: 'bottom-right' });
        state.set({ error: res.message });
      }
    },
    error: function () {
      state.set({ loading: false, error: 'Server error.' });
      showToast({ type: 'error', message: 'Something went wrong!', position: 'bottom-right' });
    }
  });
}

function render() {
  const { loading } = state;
  const $btn = $('#loginBtn');

  $btn.prop('disabled', loading);
  $btn.html(loading
    ? `<div role="status">
          <svg aria-hidden="true" class="w-4 h-4 text-gray-200 animate-spin fill-teal-800 me-2"
            viewBox="0 0 100 101" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.59C100 78.2 77.61 100.59 50 100.59C22.38 100.59 0 78.2 0 50.59C0 22.97 22.38 0.59 50 0.59C77.61 0.59 100 22.97 100 50.59Z" fill="currentColor"/>
            <path d="M93.97 39.04C96.39 38.4 97.86 35.91 97.01 33.55C95.29 28.82 92.87 24.37 89.82 20.35C85.85 15.12 80.88 10.72 75.21 7.41C69.54 4.1 63.27 1.94 56.77 1.05C51.77 0.36 46.7 0.44 41.73 1.27C39.26 1.69 37.81 4.19 38.45 6.62C39.09 9.05 41.57 10.47 44.05 10.11C47.85 9.55 51.72 9.53 55.54 10.05C60.86 10.78 65.99 12.55 70.63 15.25C75.27 17.96 79.33 21.56 82.58 25.84C84.92 28.91 86.8 32.29 88.18 35.88C89.08 38.21 91.54 39.68 93.97 39.04Z" fill="currentFill"/>
          </svg>
          <span class="sr-only">Loading...</span>
        </div>`
    : 'Log in'
  );
}
