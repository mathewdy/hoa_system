import { $State } from '../../core/state.js';
import { DataFetcher } from '../../core/data-fetch.js';
import { TableView } from '../../core/table-view.js';

const BASE_URL = '/hoa_system/';
const API_URL = `${BASE_URL}app/api/fee-assignation/get.homeowners.php`;

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
      <div class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 font-bold text-sm">
        ${row.fullName?.charAt(0) || '?'}
      </div>
      <div class="ml-3">
        <div class="font-medium text-gray-900">${row.fullName || '—'}</div>
        <div class="text-sm text-gray-500">${row.email_address || '—'}</div>
      </div>
    </div>`,
  row => {
    const formatted = new Intl.NumberFormat('en-PH', {
      style: 'currency',
      currency: 'PHP',
      minimumFractionDigits: 2
    }).format(row.total_unpaid_amount);

    return `<span class="font-medium text-green-600">${formatted}</span>`;
  },

  row => row.status == '1'
    ? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Paid</span>'
    : '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Unpaid</span>',
  row => {
    return new Date(row.due_date).toLocaleDateString('en-PH', {
      month: 'short',
      day: 'numeric',
      year: 'numeric'
    });
  },
  row => { 
    return `
      <div class="flex gap-2">
        <a 
          href="view.php?id=${row.user_id}"  
          class="flex items-center gap-2 px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-800 transition">
          <i class="ri-eye-fill text-xl text-white"></i> 
          View
        </a>
        <a 
          href="assign.php?id=${row.user_id}"  
          class="flex items-center gap-2 px-3 py-1 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">
          <i class="ri-cash-line text-xl text-white"></i> 
          Assign
        </a>
      </div>
      `;
  }
];

new TableView($state, fetcher, {
  tableId: 'dataTable',
  searchId: 'simple-search',
  paginationId: 'paginationList',
  columns
});

// Toast (optional, for errors)
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
window.addEventListener('error', (e) => {
  console.error('JS ERROR:', e.error);
  toast('JavaScript Error: ' + e.message, 'error');
});

window.addEventListener('unhandledrejection', (e) => {
  console.error('Promise Error:', e.reason);
  toast('System Error: Check console!', 'error');
});