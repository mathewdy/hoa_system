import { $State } from '../../core/state.js';
import { DataFetcher } from '../../core/data-fetch.js';
import { TableView } from '../../core/table-view.js';

if (!$('[data-module="my-fees"]').length) {
  console.log('[My Fees] Not on this page');
} else {
  console.log('[My Fees] LOADED – Homeowner Portal');
}

const API_URL = '/hoa_system/app/api/payment-history/getById.homeowner.fee.php';

const $state = $State({
  search: '',
  status: 'all',
  pagination: { currentPage: 1, limit: 15, totalPages: 0, totalRecords: 0 },
  data: [],
  summary: { total_unpaid: 0, total_paid: 0, total_due: 0 },
  loading: false
});

const fetcher = new DataFetcher($state, API_URL);

const columns = [
  row => `
    <div>
      <div class="font-bold text-gray-900">${row.fee_name || 'Unknown Fee'}</div>
      ${row.description ? `<div class="text-xs text-gray-500 mt-1">${row.description}</div>` : ''}
    </div>
  `,

  row => {
    const fmt = new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(row.amount);
    return `<span class="text-lg font-bold ${row.status == 0 ? 'text-red-600' : 'text-green-600'}">${fmt}</span>`;
  },

  row => {
    const due = new Date(row.due_date).toLocaleDateString('en-PH', { month: 'long', day: 'numeric', year: 'numeric' });
    let badge = '';

    if (row.status == 1) {
      badge = '<span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">PAID</span>';
    } else if (row.is_overdue) {
      badge = '<span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 animate-pulse">OVERDUE</span>';
    } else {
      badge = '<span class="px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">UNPAID</span>';
    }

    return `
      <div>
        <div class="font-medium">${due}</div>
        <div class="mt-1">${badge}</div>
      </div>
    `;
  },

  row => {
    const d = new Date(row.date_created);
    return `<div class="text-sm text-gray-600">
      ${d.toLocaleDateString('en-PH')}
      <div class="text-xs text-gray-400">${d.toLocaleTimeString('en-PH', { hour: 'numeric', minute: '2-digit' })}</div>
    </div>`;
  }
];

new TableView($state, fetcher, {
  tableId: 'myFeesTable',
  searchId: 'fee-search',
  paginationId: 'feesPagination',
  columns
});

// Filter buttons
$(document).on('click', '[data-status]', function () {
  const status = $(this).data('status');
  $state.set({ status, 'pagination.currentPage': 1 });
  $('[data-status]').removeClass('bg-teal-600 text-white').addClass('bg-gray-200 text-gray-700');
  $(this).removeClass('bg-gray-200 text-gray-700').addClass('bg-teal-600 text-white');
  fetcher.fetch();
});

// Toast
function toast(msg, type = 'info') {
  const colors = { success: 'bg-green-600', error: 'bg-red-600', info: 'bg-blue-600' };
  const icons  = { success: 'ri-check-line', error: 'ri-close-line', info: 'ri-information-line' };

  const $t = $(`
    <div class="fixed bottom-6 right-6 ${colors[type]} text-white px-6 py-4 rounded-lg shadow-2xl z-50 flex items-center gap-3 animate-fade-in">
      <i class="${icons[type]} text-xl"></i>
      <span class="font-medium">${msg}</span>
    </div>
  `);
  $('body').append($t);
  setTimeout(() => $t.addClass('animate-fade-out').on('animationend', () => $t.remove()), 4000);
}

$(document).on('fetch:error', (_, msg) => toast(msg || 'Failed to load fees', 'error'));