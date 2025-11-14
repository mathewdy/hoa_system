import { showToast } from '/hoa_system/assets/js/utils/toast.js';

$(document).ready(function() {
  $('#setup-password-form').on('submit', function(e) {
      e.preventDefault()

      const password = $('#password').val()
      const confirmPassword = $('#confirmPassword').val()

      if (password !== confirmPassword) {
          $('#error-text').text("Passwords do not match!")
          $('#error-message').removeClass('hidden')
          return
      }

      const formData = $(this).serialize()

      $('#submitBtn').prop('disabled', true).text('Processing...')

      $.ajax({
          url: '/hoa_system/core/auth/setup.php',
          type: 'POST',
          data: formData,
          dataType: 'json',
          success: function(res) {
              $('#submitBtn').prop('disabled', false).text('Submit')

              if (res.success) {
                  showToast({ type: 'success', message: res.message, position: 'bottom-right' })
                  setTimeout(() => {
                      window.location.href = '/hoa_system/app/pages/dashboard.php'
                  }, 1200);
              } else {
                  $('#error-text').text(res.message || 'Failed to update password.')
                  $('#error-message').removeClass('hidden')
              }
          },
          error: function(xhr, status, error) {
              $('#submitBtn').prop('disabled', false).text('Submit')
              $('#error-text').text('An error occurred. Please try again.')
              $('#error-message').removeClass('hidden')
              console.error(error, xhr.responseText)
          }
      });
  });
});
