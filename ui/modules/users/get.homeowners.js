$(document).ready(() => {
  const apiUrl = `/hoa_system/app/api/users/get.homeowners.php`;
  
  const columns = [
    u => {
      const name = u.fullName || '';
      const email = u.email_address || '';
      return `<div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 font-bold text-sm">
                  ${escape(name.charAt(0))}
                </div>
                <div class="ml-3">
                  <div class="font-medium text-gray-900">${escape(name)}</div>
                  <div class="text-sm text-gray-500">${escape(email)}</div>
                </div>
              </div>`;
    },

    u => {
      const status = u.status || 'Inactive';
      return `<span class="px-2.5 py-0.5 rounded-full text-xs font-medium ${
        status === 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
      }">${escape(status)}</span>`;
    },

    u => {
      const id = u.user_id || '';
      return `<a href="${a === '6' ? 'edit-homeowner.php' : 'edit.php'}?id=${escape(id)}" 
      class="text-indigo-600 hover:underline font-medium">Edit</a>`
    }
  ];

  const headers = ['Name', 'Status', 'Action'];
  $('#dataTable thead tr').empty().append(
    headers.map(h => `<th class="px-6 py-3 text-xs font-medium text-gray-700 uppercase tracking-wider">${h}</th>`).join('')
  );

  new AppState({
    apiUrl: apiUrl,
    tableId: 'dataTable',
    searchId: 'simple-search',
    paginationId: 'paginationList',
    columns: columns
  });
});

function escape(str) {
  return $('<div>').text(str).html();
}
