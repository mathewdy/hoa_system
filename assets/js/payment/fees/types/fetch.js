const state = {
  loading: false,
  error: '',
  success: '',
  feeTypes: [],
  search: '',
  pagination: { totalPages: 1, currentPage: 1, limit: 10 },

  set(newState) {
    Object.assign(this, newState);
    render();
  }
};

$(document).ready(function() {
  fetchFeeTypes(1);
  $(document).on('click', '.page-btn', function(e) {
    e.preventDefault();
    const page = $(this).data('page');
    fetchFeeTypes(page);
  });

  $('#simple-search').on('input', function() {
    const query = $(this).val();
    state.set({ search: query, pagination: { ...state.pagination, currentPage: 1 } });
    fetchFeeTypes(1);
  });
});

function fetchFeeTypes(page = 1) {
  state.set({ loading: true, error: '', success: '' });

  $.ajax({
    url: `/hoa_system/core/payments/getFeeTypes.php`,
    type: 'GET',
    dataType: 'json',
    data: { 
      page, 
      limit: state.pagination.limit,
      search: state.search
    },
    success: function(res) {
      if (res.success) {
        state.set({
          loading: false,
          feeTypes: res.data,
          pagination: res.pagination,
          success: 'Fee Types loaded successfully.'
        });
      } else {
        state.set({ loading: false, error: res.message || 'Failed to load fee types.', feeTypes: [] });
      }
    },
    error: function() {
      state.set({ loading: false, error: 'Server error.', feeTypes: [] });
    }
  });
}

function render() {
  const { loading, feeTypes, pagination, error } = state;
  const $tableBody = $('#feeTypesTable tbody');

  $tableBody.empty();

  if (loading) {
    for (let i = 0; i < 5; i++) {
      $tableBody.append(`
        <tr class="animate-pulse">
          <td class="px-6 py-4">
            <div class="h-4 bg-gray-200 rounded-full w-full"></div>
          </td>
          <td class="px-6 py-4">
            <div class="h-4 bg-gray-200 rounded-full w-full"></div>
          </td>
          <td class="px-6 py-4">
            <div class="h-4 bg-gray-200 rounded-full w-full"></div>
          </td>
          <td class="px-6 py-4">
            <div class="h-4 bg-gray-200 rounded-full w-full"></div>
          </td>
          <td class="px-6 py-4">
            <div class="h-4 bg-gray-200 rounded-full w-full"></div>
          </td>
        </tr>
      `);
    }

    $('#paginationList').empty();
    return; 
  }

  if (feeTypes.length === 0) {
    $tableBody.append(`
      <tr>
        <td colspan="5" class="text-center px-6 py-4 text-gray-900 whitespace-nowrap">
            No fee type found.
        </td>
      </tr>
    `);
  } else {
    feeTypes.forEach(feeType => {
      const isActive = feeType.is_active == 1 ? 'Active' : 'Inactive'
      const isApproved = feeType.approved == 1 ? 'Active' : 'Inactive'
      const color = isActive === 'Active' ? 'green' : 'red';
      const dateStr = feeType.start_date;
      const dateObj = new Date(dateStr);
      const formatted = dateObj.toLocaleDateString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric"
      });
      $tableBody.append(`
        <tr class="bg-white border-b border-gray-200 hover:bg-gray-100">
          <td class="flex flex-row items-center px-6 py-4 gap-2">
            <span class="font-medium text-gray-900 whitespace-nowrap">
              ${feeType.fee_name}
            </span>
            <span class="bg-${color}-100 hover:bg-${color}-200 border border-${color}-400 text-${color}-600 text-xs font-medium px-1.5 py-0.5 rounded">
              ${isActive}
            </span>
          </td>
          <td class="px-6 py-4 text-gray-900">
            ₱${feeType.amount}
          </td>
          <td class="px-6 py-4 text-gray-900">
            ${formatted}
          </td>
          <td class="px-6 py-4">
            <span class="bg-${color}-100 hover:bg-${color}-200 border border-${color}-400 text-${color}-600 text-xs font-medium px-1.5 py-0.5 rounded">
              ${isApproved}
            </span>
          </td>
          <td class="px-6 py-4">
            <a href="payments.php?user_id=${feeType.user_id}"
              class="text-indigo-600 hover:text-indigo-900">
              View
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
          ? 'text-white bg-teal-500 disabled'
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