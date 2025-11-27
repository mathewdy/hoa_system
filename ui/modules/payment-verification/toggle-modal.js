import { showToast } from '../../utils/toast.js';

$(document).on('click', '.view', async function () {
  const paymentId = $(this).data('id');
  console.log(paymentId)
  try {
    const res = await $.getJSON(`/hoa_system/app/api/fees/getById.payment-verification.php?id=${paymentId}`);
    
    if (!res.success) throw new Error('Failed to load payment');

    const payment = res.data[0];
    const fees = payment.fees || [];

    $('#pv-ref').text(payment.reference_number);
    $('#pv-method').text(payment.payment_method);
    $('#pv-user').text(payment.full_name);
    $('#pv-walkin').text(payment.is_walk_in ? 'Yes' : 'No');
    $('#pv-date').text(new Date(payment.date_created).toLocaleDateString('en-PH'));

    const $tbody = $('#pv-fees-body');
    $tbody.empty();
    let total = 0;
    fees.forEach(f => {
      total += parseFloat(f.amount || 0);
      $tbody.append(`
        <tr>
          <td class="px-4 py-2">${f.fee_name}</td>
          <td class="px-4 py-2">₱${parseFloat(f.amount).toLocaleString('en-PH', {minimumFractionDigits: 2})}</td>
          <td class="px-4 py-2">${f.status_text}</td>
          <td class="px-4 py-2">${f.next_due_date_formatted}</td>
        </tr>
      `);
    });

    $('#pv-total').text(`₱${total.toLocaleString('en-PH', {minimumFractionDigits: 2})}`);

  } catch (err) {
    console.error(err);
    alert('Failed to load payment verification.');
  }
});


$(document).on('click', '#verifyPayment', async function () {
    const paymentId = $('.view').data('id')

    if (!paymentId) return;

    try {
        const response = await $.post('/hoa_system/app/api/fees/post.verify.php', {
            payment_id: paymentId
        });

        if (response.success) {
            showToast({ message: response.message, type: 'success' });
        } else {
            showToast({ message: response.message, type: 'error' });
        }
    } catch (err) {
        showToast({ message: 'Network error', type: 'error' });
    }
});
