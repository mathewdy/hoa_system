const state = {
  loading: false,
  error: '',
  success: '',
  users: [],
  pagination: { totalPages: 1, currentPage: 1, limit: 10 },

  set(newState) {
    Object.assign(this, newState);
    render();
  }
};

$(document).ready(function() {
  fetchUsers(1);

  $(document).on('click', '.page-btn', function() {
    const page = $(this).data('page');
    fetchUsers(page);
  });
});

function fetchUsers(page = 1) {
  state.set({ loading: true, error: '', success: '' });

  $.ajax({
    url: `/hoa_system/core/users/users.php?page=${page}&limit=${state.pagination.limit}`,
    type: 'GET',
    dataType: 'json',
    success: function(response) {
      if (response.success) {
        state.set({
          loading: false,
          users: response.data,
          pagination: response.pagination,
          success: 'Users loaded successfully.'
        });
      } else {
        state.set({ loading: false, error: response.message || 'Failed to load users.', users: [] });
      }
    },
    error: function() {
      state.set({ loading: false, error: 'Server error.', users: [] });
    }
  });
}

function render() {
  const { loading, users, pagination, error } = state;
  const $tableBody = $('#usersTable tbody');
  const $pagination = $('#pagination');
  const $status = $('#status');

  if (loading) {
    $status.html('<div class="alert alert-info">Loading users...</div>');
  } else if (error) {
    $status.html(`<div class="alert alert-danger">${error}</div>`);
  } else {
    $status.html('');
  }

  $tableBody.empty();

  if (users.length === 0 && !loading) {
    $tableBody.append(`
      <tr>
        <td colspan="3" class="text-center">
          No users found.
        </td>
      </tr>`
    );
  } else {
    users.forEach(user => {
      let color;
      if(user.status == 'Active') {
        color = 'green'
      } else {
        color = 'red'
      }

      $tableBody.append(`
        <tr class="bg-white border-b border-gray-200 hover:bg-gray-100">
          <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
            ${user.fullName}
          </td>
          <td class="px-6 py-4 text-gray-900">
            ${user.role_name}
          </td>
          <td class="px-6 py-4 text-gray-900">
            ${user.email_address}
          </td>
          <td class="px-6 py-4 text-gray-900">
            <span class="bg-${color}-100 text-${color}-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">
              ${user.status}
            </span>
          </td>
          <td class="px-6 py-4">
            <a href="edit.php?user_id=${user.user_id}"
              class="text-indigo-600 hover:text-indigo-900">
              Edit
            </a>
          </td>
        </tr>
      `);
    });
  }

  if (pagination && pagination.totalRecords) {
    const start = (pagination.currentPage - 1) * pagination.limit + 1;
    const end = Math.min(start + pagination.limit - 1, pagination.totalRecords);
    const $paginationList = $('#paginationList');
    $('#rangeStart').text(start);
    $('#rangeEnd').text(end);
    $('#totalRecords').text(pagination.totalRecords);

    $paginationList.empty();

    const prevDisabled = pagination.currentPage === 1 ? 'opacity-50 pointer-events-none' : '';
    const nextDisabled = pagination.currentPage === pagination.totalPages ? 'opacity-50 pointer-events-none' : '';

    $paginationList.append(`
      <li>
        <a href="#" data-page="${pagination.currentPage - 1}" 
          class="page-btn flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 ${prevDisabled}">
          Previous
        </a>
      </li>
    `);

    const startPage = Math.max(1, pagination.currentPage - 2);
    const endPage = Math.min(pagination.totalPages, startPage + 4);

    for (let i = startPage; i <= endPage; i++) {
      const active =
        i === pagination.currentPage
          ? 'text-white bg-teal-500'
          : 'text-gray-500 bg-white border-gray-300 hover:bg-gray-100 hover:text-gray-700';
      $paginationList.append(`
        <li>
          <a href="#" data-page="${i}" 
            class="page-btn flex items-center justify-center px-3 h-8 leading-tight border ${active}">
            ${i}
          </a>
        </li>
      `);
    }

    $paginationList.append(`
      <li>
        <a href="#" data-page="${pagination.currentPage + 1}" 
          class="page-btn flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 ${nextDisabled}">
          Next
        </a>
      </li>
    `);
  }
}