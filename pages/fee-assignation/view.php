<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';
require_once $root . 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/hoa_system/app/core/init.php';

$user = $_GET['id']; // make sure this is sanitized

$sql = "
  SELECT 
    f.id,
    f.user_id,
    f.fee_name,
    f.status,
    f.amount,
    f.next_due_date,
    f.date_created,
    m.due_name,
    m.amount AS monthly_amount,
    CONCAT(
        TRIM(CONCAT(i.first_name, ' ', COALESCE(i.middle_name, ''), ' ', i.last_name))
    ) AS full_name,
    u.email_address
  FROM fees f 
  LEFT JOIN monthly_dues m ON f.due_id = m.id
  LEFT JOIN user_info i ON f.user_id = i.user_id
  LEFT JOIN users u ON i.user_id = u.user_id
  WHERE f.user_id = ?
";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$pageTitle = '';
ob_start();

$firstRow = mysqli_fetch_assoc($result);
?>

<div class="mt-1">
  <h3 class="text-2xl font-medium text-gray-900 mb-4 name"><?= $pageTitle ?></h3>

  <div class="flex items-center justify-between p-4 border-b">
        <h3 class="text-lg font-semibold text-gray-900">
            User Fee Breakdown
        </h3>
    </div>

    <div class="p-6">
        <div class="mb-4">
            <p class="text-sm text-gray-500">
              Viewing fees for: 
              <?= $firstRow ? $firstRow['full_name'] : 'Unknown User' ?>
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b">
                    <tr>
                      <th class="px-6 py-3">Fee Name</th>
                      <th class="px-6 py-3">Amount Due</th>
                      <th class="px-6 py-3">Due Date</th>
                    </tr>
                </thead>

                <tbody id="feeBreakdownTable">

                  <?php 
                  if ($firstRow): ?>
                    <tr>
                        <td class="p-4"><?= $firstRow['fee_name']; ?></td>
                        <td><?= number_format($firstRow['amount'], 2); ?></td>
                        <td><?= $firstRow['next_due_date']; ?></td>
                    </tr>
                  <?php endif; ?>

                  <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td class="p-4"><?= $row['fee_name']; ?></td>
                        <td><?= number_format($row['amount'], 2); ?></td>
                        <td><?= $row['next_due_date']; ?></td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();

$pageScripts = '
  <script type="module" src="/hoa_system/ui/modules/fees/getById.fees.js"></script>
';

require_once BASE_PATH . '/pages/layout.php';
?>
