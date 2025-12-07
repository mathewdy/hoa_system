import { $State } from '../../core/state.js';
import { DataFetcher } from '../../core/data-fetch.js';
import { TableView } from '../../core/table-view.js';

const BASE_URL = '/hoa_system/';
const API_URL = `${BASE_URL}app/api/fee-type/get.fee-type.php`;

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
      <div class="font-medium text-gray-900">${row.fee_name || '—'}</div>
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
      Active: "bg-green-100 text-green-800",
      Inactive: "bg-red-100 text-red-800",
      Rejected: "bg-red-100 text-red-800",
    };

    const colorClass = statusColors[row.status] || "bg-gray-100 text-gray-800";

    return `
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${colorClass}">
            ${row.status}
        </span>
    `;
  },
  row => { 
    return `
      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
        ${row.effectivity_date}
      </span>
    `
  },
  
  row => { 
    const color = row.status === 'Active' ? 'red' : 'green';
    const title = row.status === 'Active' ? 'Deactivate' : 'Activate';


    if (row.status === 'Active' || row.status === 'Inactive') {
      
      return `
      <div class="flex gap-2">
        <a 
          href="view.php?id=${row.id}"  
          class="flex items-center gap-2 px-3 py-1 bg-teal-600 text-white rounded-lg hover:bg-teal-800 transition">
          <i class="ri-eye-fill text-xl text-white"></i> 
          View
        </a>
      </div>
      `;
    } 
    return `
      <div class="flex gap-2">
        <a 
          href="view.php?id=${row.id}" 
          class="flex items-center gap-2 px-3 py-1 text-white rounded-lg bg-teal-600 hover:bg-teal-700 transition">
          <i class="ri-eye-fill text-xl text-white"></i> 
          View
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
