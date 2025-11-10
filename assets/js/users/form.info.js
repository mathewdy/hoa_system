$('.item').on('click', function() {
  const roleId = $(this).data('role-id');
  const roleName = $(this).data('role-name');
  
  $('.form-title').text(`New ${roleName} Account`);
  $('#sec-role').val(`${roleId}`);
});