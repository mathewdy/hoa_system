<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';
require_once $root . 'config.php';
// require_once $root . 'app/includes/session.php';
include_once($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php');
$pageTitle = 'Homeowners';
ob_start();
?>

 <div id="payment-history-section" class="mb-8">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-xl font-semibold text-gray-900">Daily Payment History</h2>
          <div class="flex items-center space-x-6 bg-teal-50 border border-teal-200 rounded-xl px-6 py-3 shadow-sm">
            <div>
              <p class="text-sm font-medium text-teal-700">Total Collected (₱)</p>
              <p id="totalCollected" class="text-2xl font-bold text-black-900">0</p>
            </div>
           
          </div>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
          <div class="overflow-x-auto">
            <form id="remitSelectorForm" method="POST" onsubmit="return false;">
              <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                <thead class="bg-teal-100">
                  <tr>
                    <th class="px-4 py-2 text-left">Select</th>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Fee Name</th>
                    <th class="px-4 py-2 text-left">Amount (₱)</th>
                    <th class="px-4 py-2 text-left">Date</th>
                  </tr>
                </thead>

                <tbody id="paymentHistoryTableBody" class="divide-y divide-gray-200">
                  <?php 
                  $sql_view_remittance = "
                    SELECT 
                      p.id,
                      p.amount, 
                      p.date_created, 
                      u.user_id,
                      u.role_id,
                      i.first_name, 
                      i.last_name
                    FROM payment_history p
                    INNER JOIN users u ON u.user_id = p.created_by 
                    INNER JOIN user_info i ON u.user_id = i.user_id 
                    WHERE u.role_id = '6'
                    ORDER BY i.first_name, i.last_name

                  ";

                  $run_view_remittance = mysqli_query($conn, $sql_view_remittance);

                  if(mysqli_num_rows($run_view_remittance) > 0){
                      foreach($run_view_remittance as $row_remittance) {
                        $ph_id = (int)$row_remittance['id'];
                        $fullname = htmlspecialchars($row_remittance['first_name'] . " " . $row_remittance['last_name']);
                        $fee_name = htmlspecialchars($row_remittance['fee_name']);
                        $amount_val = number_format($row_remittance['amount'], 2);
                        $raw_amount = htmlspecialchars($row_remittance['amount']);
                        $date_val = !empty($row_remittance['date_created']) ? date('F d, Y', strtotime($row_remittance['date_created'])) : 'N/A';
                  ?>
                      <tr>
                        <td class="px-4 py-2 text-center">
                          <input 
                            type="checkbox" 
                            class="amountCheckbox" 
                            name="selected_payments[]" 
                            value="<?php echo $ph_id; ?>" 
                            data-amount="<?php echo $raw_amount; ?>"
                            data-fee="<?php echo $fee_name; ?>"
                            data-name="<?php echo $fullname; ?>">
                        </td>
                        <td class="px-4 py-2"><?php echo $fullname; ?></td>
                        <td class="px-4 py-2"><?php echo $fee_name; ?></td>
                        <td class="px-4 py-2">₱<?php echo $amount_val; ?></td>
                        <td class="px-4 py-2"><?php echo $date_val; ?></td>
                      </tr>
                  <?php 
                      }
                  } else {
                    echo '<tr><td colspan="5" class="text-center py-4 text-gray-500">No payment records found.</td></tr>';
                  }
                  ?>
                </tbody>
              </table>

              <!-- Hidden field (kept for compatibility if needed) -->
              <input type="hidden" id="totalAmountInput" name="amount" value="">

              <!-- Trigger modal instead of immediate submit -->
              <div style="margin-top: 15px;">
                <button type="button" id="openRemitModalBtn" 
                  style="background-color: #16a34a; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer;">
                  Submit
                </button>
              </div>
            </form>

        <!-- REMIT MODAL (final form posts to handler) -->
        <div id="remitModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999;">
          <div style="width:420px; margin:6% auto; background:#fff; padding:18px; border-radius:10px; box-shadow:0 8px 30px rgba(0,0,0,0.25); position:relative;">
            <button type="button" onclick="closeRemitModal()" style="position:absolute; right:12px; top:8px; background:transparent; border:none; font-size:22px; cursor:pointer;">&times;</button>
            <h3 style="margin-top:4px; margin-bottom:12px;">Submit Remittance</h3>

            <form id="remitForm" action="../../Query/submit-remittance.php" method="POST">
              <label style="display:block; margin-bottom:6px;">Particular</label>
              <textarea name="particular" id="modalParticular" rows="3" required style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;"></textarea>

              <label style="display:block; margin-top:8px; margin-bottom:6px;">Amount</label>
              <input type="number" step="0.01" name="amount" id="modalAmount" readonly required style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc; background:#f8fafc;">

              <label style="display:block; margin-top:8px; margin-bottom:6px;">Date</label>
              <input type="date" name="date" id="modalDate" value="<?php echo date('Y-m-d'); ?>" required style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;">

              <label style="display:block; margin-top:8px; margin-bottom:6px;">Transaction Type</label>
              <select name="transaction_type" id="modalTransactionType" style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;">
                <option value="">Select</option>
                <option value="Credit">Credit</option>
                <option value="Debit">Debit</option>
              </select>

              <label style="display:block; margin-top:8px; margin-bottom:6px;">Secretary Name</label>
              <input type="text" name="secretary_name" id="modalSecretaryName" value="" required style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;">

              <!-- Container for hidden selected payment ids -->
              <div id="selectedPaymentsContainer"></div>

              <div style="margin-top:12px; display:flex; gap:8px; justify-content:flex-end;">
                <button type="button" onclick="closeRemitModal()" style="padding:8px 12px; border-radius:6px; border:1px solid #ccc; background:#fff; cursor:pointer;">Cancel</button>
                <button type="submit" name="submit_remittance" style="padding:8px 14px; border-radius:6px; border:none; background:#16a34a; color:#fff; cursor:pointer;">Submit Remittance</button>
              </div>
            </form>
          </div>
        </div>



          

      <!-- Remittance Table Section -->
      <div id="remittance-table-section" class="mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">Remittance Table</h2>

        <div class="bg-white shadow rounded-lg overflow-hidden">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Particular</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount (₱)</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
              </thead>
              <tbody id="remittanceTableBody" class="bg-white divide-y divide-gray-200">
                <!-- Remittance entries will be rendered dynamically -->
                  
                <?php 

                  $sql_remittance_table = "SELECT * FROM remittance";
                  $run_remittance_table = mysqli_query($conn,$sql_remittance_table);

                  if(mysqli_num_rows($run_remittance_table) > 0){
                    foreach($run_remittance_table as $row_remittance_table){
                      ?>


                        <tr>
                          <td><?php echo $row_remittance_table['particular']?></td>
                          <td><?php echo $row_remittance_table['amount']?></td>
                          <td>
                            <?php 
                              if($row_remittance_table['is_approved'] == 0){
                                echo "Pending";
                              }else{
                                echo "Approved";
                              }
                            ?>
                          </td>
                          <td>

                            <a href="view-table-remittance.php?id=<?php echo $row_remittance_table['id']?>">View</a>
                          
                          </td>
                        </tr>

                      <?php 
                    }
                  }



                ?>

              </tbody>
            </table>
          </div>
        </div>
      </div>

<?php
$content = ob_get_clean();

$pageScripts = '
  <script type="module" src="/hoa_system/ui/modules/users/get.homeowners.js"></script>
';

require_once BASE_PATH . '/pages/layout.php';
?>