import { $State } from '../../core/state.js';
import { DataFetcher } from '../../core/data-fetch.js';
import { TableView } from '../../core/table-view.js';

if (!$('[data-module="boardmembers"]').length) {
  console.log('[BoardMembers] Not active on this page');
} else {
  console.log('[BoardMembers] LOADED');
}

const BASE_URL = '/hoa_system/';
const API_URL = `${BASE_URL}app/api/fees/get.payment-verification.php`;

const $state = $State({
  search: '',
  pagination: {
    currentPage: 1,
    limit: 10,
    totalPages: 0,
    totalRecords: 0
  },
  data: [],
  loading: false
});

const fetcher = new DataFetcher($state, API_URL);

const columns = [
  row => `
    <div class="flex items-center">
      <div>
        <div class="font-medium text-gray-900">${row.full_name || '—'}</div>
        <div class="text-gray-500 text-xs">${row.created_by || '—'}</div>
      </div>
    </div>`,

  row => `<span class="text-gray-700">${row.payment_method || '—'}</span>`,
  
  row => {
    const amount = new Intl.NumberFormat('en-PH', {
      style: 'currency',
      currency: 'PHP',
      minimumFractionDigits: 2
    }).format(row.total_amount);

    return `<div class="text-gray-900 font-medium">${amount}</div>` 
  },

  row => `<span class="text-gray-700">${row.reference_number || '—'}</span>`,

  row => `
    <a href="/hoa_system/pages/payment-verification/verify.php?id=${row.id}&action=approve">
    Approve
    </a>
    <a href="/hoa_system/pages/payment-verification/verify.php?id=${row.id}&action=reject">
    Reject
    </a>
    `
];

new TableView($state, fetcher, {
  tableId: 'dataTable',
  searchId: 'simple-search',
  paginationId: 'paginationList',
  columns
});

function toast(msg, type = 'info') {
  const colors = { success: 'bg-green-600', error: 'bg-red-600', info: 'bg-blue-600' };
  const icons = { success: 'ri-check-line', error: 'ri-close-line', info: 'ri-information-line' };

  const $toast = $(`
    <div role="alert" aria-live="assertive"
        class="fixed bottom-4 right-4 ${colors[type]} text-white px-6 py-3 rounded-lg shadow-xl z-50 flex items-center gap-2 animate-fade-in">
      <i class="${icons[type]} text-lg"></i>
      <span>${msg}</span>
    </div>
  `);

  $('body').append($toast);
  setTimeout(() => $toast.addClass('animate-fade-out').on('animationend', () => $toast.remove()), 3000);
}

$(document).on('fetch:error', (e, msg) => toast(msg || 'Failed to load.', 'error'));
