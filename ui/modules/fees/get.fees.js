import { $State } from '../../core/state.js';
import { DataFetcher } from '../../core/data-fetch.js';
import { TableView } from '../../core/table-view.js';

if (!$('[data-module="boardmembers"]').length) {
  console.log('[BoardMembers] Not active on this page');
} else {
  console.log('[BoardMembers] LOADED');
}

const BASE_URL = '/hoa_system/';
const API_URL = `${BASE_URL}app/api/fees/get.fees.php`;

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
        <div class="font-medium text-gray-900">${row.fullName || '—'}</div>
      </div>
    </div>`,
  row => `
    <div class="flex items-center">
      <div class>
        <div class="font-medium text-gray-900">${row.fee_name || '—'}</div>
      </div>
    </div>`,
  row => `
    <div class="flex items-center">
      <div class>
        <div class="font-medium text-gray-900">${row.fee_type || '—'}</div>
      </div>
    </div>`,
  row => {
    const amount = new Intl.NumberFormat('en-PH', {
      style: 'currency',
      currency: 'PHP',
      minimumFractionDigits: 2
    }).format(row.amount);

    return `<span class="font-medium text-green-600">${amount}</span>`;
  },
  row => { 
    const statusColors = {
      Pending:  "bg-yellow-100 text-yellow-800",
      Approved: "bg-green-100 text-green-800",
      Paid: "bg-green-100 text-green-800",
      Rejected: "bg-red-100 text-red-800",
      Cancelled:"bg-gray-100 text-gray-800"
    };

    const colorClass = statusColors[row.status] || "bg-gray-100 text-gray-800";

    return `
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${colorClass}">
            ${row.status}
        </span>
    `;
  },
  row => {
    const formatted = new Date(row.date_created).toLocaleDateString('en-PH', {
      month: 'short',
      day: 'numeric',
      year: 'numeric'
    });

    return `<span class="font-medium">${formatted}</span>`;
  },
  row => { 
    return `
    <div class="flex items-center gap-2">
      <a 
        href="view.php?id=${row.user_id}" 
        class="text-teal-600 hover:text-teal-800" 
        title="View">
        <i class="ri-eye-fill text-xl"></i>
      </a>
    </div>`
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
