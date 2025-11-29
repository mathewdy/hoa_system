import { $State } from '../../core/state.js';
import { DataFetcher } from '../../core/data-fetch.js';
import { TableView } from '../../core/table-view.js';

const BASE_URL = '/hoa_system/';
const API_URL = `${BASE_URL}app/api/remittance/get.remittance.php`;

const $state = $State({
  search: '',
  pagination: { currentPage: 1, limit: 10, totalPages: 0, totalRecords: 0 },
  data: [],
  loading: false
});

const fetcher = new DataFetcher($state, API_URL);

const columns = [
  row => `<div class="font-medium text-gray-900">${row.particular || '—'}</div>`,
  row => `<div class="text-green-700 font-medium">₱${parseFloat(row.amount).toFixed(2)}</div>`,
  row => row.is_approved
    ? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Approved</span>'
    : '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>',
  row => `<button class="viewBtn text-teal-600 hover:underline" data-id="${row.id}">View</button>`
];

new TableView($state, fetcher, {
  tableId: 'dataTable',
  searchId: 'simple-search',
  paginationId: 'paginationList',
  columns
});

const modal = document.getElementById('remittanceModal');
const modalContent = document.getElementById('modalContent');
const closeModal = document.getElementById('closeModal');
const approveBtn = document.getElementById('approveBtn');
const rejectBtn = document.getElementById('rejectBtn');
const cancelBtn = document.getElementById('cancelBtn');

let currentId = null;

document.addEventListener('click', e => {
  if (e.target.matches('.viewBtn')) {
    currentId = e.target.dataset.id;
    fetch(`${BASE_URL}app/api/remittance/get.remittance.php?id=${currentId}`)
      .then(res => res.json())
      .then(data => {
        if(data.success){
          const row = data.data;
          modalContent.innerHTML = `
            <p><strong>ID:</strong> ${row.id}</p>
            <p><strong>User ID:</strong> ${row.user_id}</p>
            <p><strong>Particular:</strong> ${row.particular}</p>
            <p><strong>Amount:</strong> ₱${parseFloat(row.amount).toFixed(2)}</p>
            <p><strong>Date:</strong> ${row.date}</p>
            <p><strong>Transaction Type:</strong> ${row.transaction_type}</p>
            <p><strong>Secretary Name:</strong> ${row.secretary_name}</p>
            <p><strong>Approved:</strong> ${row.is_approved ? "Yes" : "No"}</p>
            <p><strong>Date Created:</strong> ${row.date_created}</p>
          `;
          modal.classList.remove('hidden');
        } else {
          alert('Failed to fetch details.');
        }
      });
  }
});

closeModal.addEventListener('click', () => modal.classList.add('hidden'));
cancelBtn.addEventListener('click', () => modal.classList.add('hidden'));

approveBtn.addEventListener('click', () => updateStatus(currentId, 1));
rejectBtn.addEventListener('click', () => updateStatus(currentId, 0));

function updateStatus(id, status) {
  const action = status === 1 ? "approve" : "reject";

  const formData = new FormData();
  formData.append("remittance_id", id);
  formData.append("action", action);

  fetch(`${BASE_URL}app/api/remittance/verify.php`, {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert(data.message);
      modal.classList.add('hidden');
      $state.fetch();
    } else {
      alert(data.message || 'Failed to update status');
    }
  })
  .catch(err => {
    console.error(err);
    alert("Network error.");
  });
}
