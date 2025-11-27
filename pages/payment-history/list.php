
<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';
require_once $root . 'config.php';
// require_once $root . 'app/includes/session.php';
include_once($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php');

$pageTitle = 'Payment History';
ob_start();
?>
<div class="mt-1">
  <h3 class="text-2xl font-medium text-gray-900 mb-4"><?= $pageTitle ?></h3>
  <div class="mb-4 border-b border-default">
    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
      <li class="me-2" role="presentation">
        <button id="homeowners-tab" data-tabs-target="#homeowners" type="button" role="tab" aria-controls="homeowners" aria-selected="false"
          class="inline-block p-4 border-b-2 rounded-t-lg border-transparent hover:text-teal-600 hover:border-teal-600 aria-selected:border-teal-600 aria-selected:text-teal-600">
          Homeowners
        </button>
      </li>
      <li class="me-2" role="presentation">
        <button id="tricycle-tab" data-tabs-target="#tricycle" type="button" role="tab" aria-controls="tricycle" aria-selected="false"
          class="inline-block p-4 border-b-2 rounded-t-lg border-transparent hover:text-teal-600 hover:border-teal-600 aria-selected:border-teal-600 aria-selected:text-teal-600">
          Tricycle
        </button>
      </li>
      <li class="me-2" role="presentation">
        <button id="stalls-tab" data-tabs-target="#stalls" type="button" role="tab" aria-controls="stalls" aria-selected="false"
          class="inline-block p-4 border-b-2 rounded-t-lg border-transparent hover:text-teal-600 hover:border-teal-600 aria-selected:border-teal-600 aria-selected:text-teal-600">
          Stalls
        </button>
      </li>
      <li role="presentation">
        <button id="court-tab" data-tabs-target="#court" type="button" role="tab" aria-controls="court" aria-selected="false"
          class="inline-block p-4 border-b-2 rounded-t-lg border-transparent hover:text-teal-600 hover:border-teal-600 aria-selected:border-teal-600 aria-selected:text-teal-600">
          Court
        </button>
      </li>
    </ul>
  </div>
  <div id="default-tab-content">
    <div class="hidden rounded-lg" id="homeowners" role="tabpanel" aria-labelledby="homeowners-tab">
       <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                <thead class="bg-teal-100">
                  <tr>
                    <th class="px-4 py-2 text-left">Fee Name</th>
                    <th class="px-4 py-2 text-left">Amount (₱)</th>
                    <th class="px-4 py-2 text-left">Date</th>
                  </tr>
                </thead>

                <tbody id="paymentHistoryTableBody" class="divide-y divide-gray-200">
                  <?php 
                  $sql_view_remittance = "
                    SELECT * FROM payment_verification WHERE is_submitted = 0 AND is_approve IN (1, 2)
                  ";

                  $run_view_remittance = mysqli_query($conn, $sql_view_remittance);

                  if(mysqli_num_rows($run_view_remittance) > 0){
                      foreach($run_view_remittance as $row_remittance) {
                        $ph_id = (int)$row_remittance['id'];
                        $fee_name = 'Monthly Fee';
                        $amount_val = number_format($row_remittance['amount_paid'], 2);
                        $raw_amount = htmlspecialchars($row_remittance['amount_paid']);
                        $date_val = !empty($row_remittance['date_created']) ? date('F d, Y', strtotime($row_remittance['date_created'])) : 'N/A';
                  ?>
                      <tr>
                        
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

    </div>
  </div>
  <div id="default-tab-content">
    <div class="hidden rounded-lg" id="tricycle" role="tabpanel" aria-labelledby="tricycle-tab">
      <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                <thead class="bg-teal-100">
                  <tr>
                    <th class="px-4 py-2 text-left">Fee Name</th>
                    <!-- <th class="px-4 py-2 text-left">Amount (₱)</th> -->
                    <th class="px-4 py-2 text-left">Date</th>
                  </tr>
                </thead>

                <tbody id="paymentHistoryTableBody" class="divide-y divide-gray-200">
                  <?php 
                  $sql_view_remittance = "
                    SELECT * FROM tricycle WHERE status = 1
                  ";

                  $run_view_remittance = mysqli_query($conn, $sql_view_remittance);

                  if(mysqli_num_rows($run_view_remittance) > 0){
                      foreach($run_view_remittance as $row_remittance) {
                        $ph_id = (int)$row_remittance['id'];
                        $fee_name = htmlspecialchars($row_remittance['toda_name']);
                        // $amount_val = number_format($row_remittance['amount'], 2);
                        // $raw_amount = htmlspecialchars($row_remittance['amount']);
                        $date_val = !empty($row_remittance['date_created']) ? date('F d, Y', strtotime($row_remittance['date_created'])) : 'N/A';
                  ?>
                      <tr>
                        
                        <td class="px-4 py-2"><?php echo $fee_name; ?></td>
                        <!-- <td class="px-4 py-2">₱<?php echo $amount_val; ?></td> -->
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
    </div>
  </div>
  <div id="default-tab-content">
    <div class="hidden rounded-lg" id="stalls" role="tabpanel" aria-labelledby="stalls-tab">
      <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                <thead class="bg-teal-100">
                  <tr>
                    <th class="px-4 py-2 text-left">Fee Name</th>
                    <th class="px-4 py-2 text-left">Amount (₱)</th>
                    <th class="px-4 py-2 text-left">Date</th>
                  </tr>
                </thead>

                <tbody id="paymentHistoryTableBody" class="divide-y divide-gray-200">
                  <?php 
                  $sql_view_remittance = "
                    SELECT * FROM stall_rent WHERE status = 1
                  ";

                  $run_view_remittance = mysqli_query($conn, $sql_view_remittance);

                  if(mysqli_num_rows($run_view_remittance) > 0){
                      foreach($run_view_remittance as $row_remittance) {
                        $ph_id = (int)$row_remittance['id'];
                        $fee_name = htmlspecialchars($row_remittance['particulars']);
                        $amount_val = number_format($row_remittance['amount'], 2);
                        $raw_amount = htmlspecialchars($row_remittance['amount']);
                        $date_val = !empty($row_remittance['date_created']) ? date('F d, Y', strtotime($row_remittance['date_created'])) : 'N/A';
                  ?>
                      <tr>
                        
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
    </div>
  </div>
  <div id="default-tab-content">
    <div class="hidden rounded-lg" id="court" role="tabpanel" aria-labelledby="court-tab">
      <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                <thead class="bg-teal-100">
                  <tr>
                    <th class="px-4 py-2 text-left">Fee Name</th>
                    <th class="px-4 py-2 text-left">Amount (₱)</th>
                    <th class="px-4 py-2 text-left">Date</th>
                  </tr>
                </thead>

                <tbody id="paymentHistoryTableBody" class="divide-y divide-gray-200">
                  <?php 
                  $sql_view_remittance = "
                    SELECT * FROM court WHERE status = 1
                  ";

                  $run_view_remittance = mysqli_query($conn, $sql_view_remittance);

                  if(mysqli_num_rows($run_view_remittance) > 0){
                      foreach($run_view_remittance as $row_remittance) {
                        $ph_id = (int)$row_remittance['id'];
                        $fee_name = htmlspecialchars($row_remittance['particulars']);
                        $amount_val = number_format($row_remittance['amount'], 2);
                        $raw_amount = htmlspecialchars($row_remittance['amount']);
                        $date_val = !empty($row_remittance['date_created']) ? date('F d, Y', strtotime($row_remittance['date_created'])) : 'N/A';
                  ?>
                      <tr>
                        
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
