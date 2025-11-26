import { $State } from '../../core/state.js';
import { DataFetcher } from '../../core/data-fetch.js';
import { TableView } from '../../core/table-view.js';

const BASE_URL = '/hoa_system/';
const API_URL = `${BASE_URL}app/api/monthly-dues/get.monthly-dues.php`;

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
      <div class="font-medium text-gray-900">${row.id || '—'}</div>
    </div>`,
  row => `
    <div class="flex items-center">
      <div class="font-medium text-gray-900">${row.due_name || '—'}</div>
    </div>`,

  row => {
    const amount = new Intl.NumberFormat('en-PH', {
      style: 'currency',
      currency: 'PHP',
      minimumFractionDigits: 2
    }).format(row.amount);

    return `<span class="font-medium text-green-600">${amount}</span>`;
  },

  row => row.status === 'Active'
    ? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>'
    : '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Inactive</span>',

  row => { 
    const color = row.status == 'Active' ? 'red' : 'green'
    const title = row.status == 'Active' ? 'Deactivate' : 'Activate'
    return `
      <a 
        id="actionBtn"
        href="javascript:void(0)" 
        class="text-teal-600 hover:text-teal-800 actionBtn" 
        title="${title}" data-action="${row.status}" data-id="${row.id}">
        <i class="ri-shut-down-line text-xl text-${color}-500 hover:text-${color}-300"></i>
      </a>`
  }
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
