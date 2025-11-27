<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';
require_once $root . 'config.php';
// require_once $root . 'app/includes/session.php';
include_once($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php');

$sql_total_collected = "
    SELECT SUM(amount_paid) AS total_collected
    FROM payment_verification
    WHERE is_submitted = 0 AND is_approve = 1
";

$result_total = mysqli_query($conn, $sql_total_collected);
$total_collected = 0;

if ($row_total = mysqli_fetch_assoc($result_total)) {
    $total_collected = $row_total['total_collected'] ?? 0;
}
$pageTitle = 'Homeowners';
ob_start();
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<div id="payment-history-section" class="mb-8">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-xl font-semibold text-gray-900">Daily Payment History</h2>
          <div class="flex items-center space-x-6 bg-teal-50 border border-teal-200 rounded-xl px-6 py-3 shadow-sm">
            <div>
              <p class="text-sm font-medium text-teal-700">Total Collected (₱)</p>
              <p id="totalCollected" class="text-2xl font-bold text-black-900">₱<?= $total_collected ?></p>
            </div>
            <a href="remit.php?action=remit" class="bg-teal-700 text-white px-4 py-2 rounded-lg">
              Remit
            </a>
          </div>
        </div>

        <div class="shadow rounded-lg overflow-hidden">
          <div class="overflow-x-auto">
            <!-- <form id="remitSelectorForm" method="POST" onsubmit="return false;">
                  <?php 
                  $sql_view_remittance = "
                    SELECT * FROM payment_verification WHERE is_submitted = 0
                  ";

                  $run_view_remittance = mysqli_query($conn, $sql_view_remittance);

                  if(mysqli_num_rows($run_view_remittance) > 0){
                      foreach($run_view_remittance as $row_remittance) {
                        $ph_id = (int)$row_remittance['id'];
                        $fee_name = 'Monthly Fees';
                        $amount_val = number_format($row_remittance['amount_paid'], 2);
                        $raw_amount = htmlspecialchars($row_remittance['amount_paid']);
                        $date_val = !empty($row_remittance['date_created']) ? date('F d, Y', strtotime($row_remittance['date_created'])) : 'N/A';
                  ?>
                      <tr>
                        
                        <td class="px-4 py-2"><?php echo $fee_name; ?></td>
                        <td class="px-4 py-2">₱<?php echo $raw_amount; ?></td>
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

              <input type="hidden" id="totalAmountInput" name="amount" value="">

              
            </form> -->

        

          

      <div id="remittance-table-section">

        <div class="bg-white shadow rounded-lg overflow-hidden">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 p-4">Remittance Table</h2>

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
                <?php 

                  $sql_remittance_table = "SELECT * FROM remittance";
                  $run_remittance_table = mysqli_query($conn,$sql_remittance_table);

                  if(mysqli_num_rows($run_remittance_table) > 0){
                    foreach($run_remittance_table as $row_remittance_table){
                      ?>


                        <tr >
                          <td class="p-4"><?php echo $row_remittance_table['particular']?></td>
                          <td class="p-4"><?php echo $row_remittance_table['amount']?></td>
                          <td class="p-4">
                            <?php 
                              if($row_remittance_table['is_approved'] == 0){
                                echo "Pending";
                              }else{
                                echo "Approved";
                              }
                            ?>
                          </td>
                          <td>

                            <a href="view.php?id=<?php echo $row_remittance_table['id']?>">View</a>
                          
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