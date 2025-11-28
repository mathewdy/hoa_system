$(document).ready(function() {
  let selectedFees = [];

  $(".selectFee").change(function() {
    const selected = $(".selectFee:checked").length > 0;
    $("#walk-in-payment-btn").toggleClass("hidden", !selected);
  });

  $("#walk-in-payment-btn").click(function() {
    selectedFees = [];

    $(".selectFee:checked").each(function() {
      const feeId = $(this).val();
      const feeName = $(this).data("fee-name");
      const feeAmount = parseFloat($(this).data("fee-amount"));
      
      selectedFees.push({ feeId, feeName, feeAmount });
    });

    if (selectedFees.length === 0) return;

    let totalAmount = 0;
    let feeDetailsHtml = '';

    selectedFees.forEach(fee => {
      totalAmount += fee.feeAmount;
      feeDetailsHtml += `
        <div>
          <p><strong>Fee Name:</strong> ${fee.feeName}</p>
          <p><strong>Amount:</strong> ₱${fee.feeAmount.toFixed(2)}</p>
        </div>
        <hr>
      `;
    });

    $("#selected-fees-details").html(`
      <div><strong>Total Amount: ₱${totalAmount.toFixed(2)}</strong></div>
      ${feeDetailsHtml}
    `);

    $("#amount").val(totalAmount.toFixed(2));
    $("#user-id").val($(".selectFee:checked").first().data("user"));
    $("#payment-method").val('Cash');
    $("#payment-date").val(new Date().toISOString().split('T')[0]);
    $('#walkInPaymentModal').removeClass('hidden');
    $('body').addClass('overflow-hidden');
  });

  $("#closeModal").click(function() {
    $('#walkInPaymentModal').addClass('hidden');
    $('body').removeClass('overflow-hidden');
  });

  $("#walk-in-payment-form").submit(function(e) {
    e.preventDefault();

    if (selectedFees.length === 0) {
      alert("Please select at least one fee.");
      return;
    }

    const userId = $("#user-id").val();
    const amount = parseFloat($("#amount").val());
    const paymentMethod = $("#payment-method").val();
    const paymentDate = $("#payment-date").val();
    const receiptName = $("#receipt-name").val();
    const remarks = $("#remarks").val();

    if (!userId || !amount || !paymentMethod || !paymentDate || !receiptName) {
      alert("Please fill out all required fields.");
      return;
    }

    const feeIds = selectedFees.map(f => f.feeId);

    $.ajax({
      url: '/hoa_system/pages/fee-assignation/payment-process.php',
      type: 'POST',
      data: {
        user_id: userId,
        fee_ids: feeIds,
        amount: amount,
        payment_method: paymentMethod,
        payment_date: paymentDate,
        receipt_name: receiptName,
        remarks: remarks
      },
      success: function(response) {
        if (response.success) {
          alert(response.message);
          location.reload();
        } else {
          alert("Error: " + response.message);
        }
      },
      error: function(err) {
        console.error(err);
        alert("Something went wrong. Please try again.");
      }
    });
  });
});
