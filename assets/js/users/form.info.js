$('.item').on('click', function() {
  const roleId = $(this).data('role-id');
  const roleName = $(this).data('role-name');
  console.log(roleId)
  // $('#create-form').find('input[name="role"]').val(roleId);
  $('.form-title').text(`New ${roleName} Account`);
  $('#sec-role').val(`${roleId}`);
});