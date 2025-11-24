$('#actionBtn').on('click', function (e) {

  const endpoint = '/hoa_system/app/api/users/put.activate.php'
  $.post(endpoint, $form.serialize())
    .done(res => {
      if (res.success) {
        showToast({ message: 'Account activated!', type: 'success' })
      } else {
        showToast({ message: 'Account activation failed.', type: 'error' })
      }
    })
    .fail(() => {
      showToast({ message: 'Network error', type: 'error' });
    })
    .always(() => {
      $btn.prop('disabled', false).html(original);
    });
});