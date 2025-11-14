<?php
  include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/config.php');
  include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/connection/connection.php');
  include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/session.php');
  $id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/page-icon.php'); ?>
  <?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/styles.php'); ?>
</head>

<body>
  <div class="h-screen flex bg-gray-50">
    <?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/sidebar.php'); ?>
    <div class="flex flex-col flex-1">
      <?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/header.php'); ?>
      <main class="flex-1 p-6 overflow-y-auto">
        <!-- Payment Verification Section -->
        <div id="payment-verification" class="mb-8">
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Payment Verification Table</h2>
            <div class="flex space-x-3">
              <div class="relative w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                  <i class="fas fa-search text-gray-400"></i>
                </span>
                <input
                  type="text"
                  id="search-payment"
                  placeholder="Search by name"
                  maxlength="100"
                  class="w-full pl-10 pr-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-1 focus:ring-teal-500 focus:border-teal-500"
                />
              </div>
            </div>
          </div>
          <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200 shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Payment For</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Amount</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    $query_homeowners = "
                        SELECT 
                            u.user_id,
                            u.first_name,
                            u.last_name,
                            fa.id AS fee_assignation_id,
                            ft.fee_name,
                            ft.amount,
                            fa.is_paid,
                            fa.is_approved
                        FROM users u
                        LEFT JOIN fee_assignation fa ON u.user_id = fa.user_id
                        LEFT JOIN fee_type ft ON fa.fee_type_id = ft.fee_type_id
                        WHERE u.role_id = '6'
                          AND fa.id IS NOT NULL
                        ORDER BY u.first_name, u.last_name
                    ";

                    $run_homeowners = mysqli_query($conn, $query_homeowners);

                    if (mysqli_num_rows($run_homeowners) > 0) {
                        foreach ($run_homeowners as $row_homeowners) {
                            $approved = $row_homeowners['is_approved'];
                            $paid = $row_homeowners['is_paid'];

                            // 🧠 Logical Status Mapping
                            if ($paid == 0 && $approved == 0) {
                                $status_label = "<span class='px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold'>Unpaid</span>";
                                $is_unpaid = true;
                            } elseif ($approved == 2) {
                                $status_label = "<span class='px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-xs font-semibold'>Pending</span>";
                                $is_unpaid = false;
                            } elseif ($approved == 1) {
                                $status_label = "<span class='px-3 py-1 rounded-full bg-green-100 text-green-800 text-xs font-semibold'>Approved</span>";
                                $is_unpaid = false;
                            } elseif ($approved == 0 && $paid == 1) {
                                $status_label = "<span class='px-3 py-1 rounded-full bg-red-100 text-red-800 text-xs font-semibold'>Rejected</span>";
                                $is_unpaid = false;
                            } else {
                                $status_label = "<span class='px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold'>No Payment Yet</span>";
                                $is_unpaid = true;
                            }
                    ?>
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-800">
                                <?php echo htmlspecialchars($row_homeowners['first_name'] . " " . $row_homeowners['last_name']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                <?php echo htmlspecialchars($row_homeowners['fee_name'] ?? 'N/A'); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                ₱<?php echo number_format($row_homeowners['amount'] ?? 0, 2); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php echo $status_label; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <?php if (!empty($row_homeowners['fee_assignation_id'])): ?>
                                    <?php if ($is_unpaid): ?>
                                        <button class="inline-flex items-center px-3 py-1.5 bg-gray-300 text-gray-500 rounded-md text-sm font-medium cursor-not-allowed" disabled>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View
                                        </button>
                                    <?php else: ?>
                                        <!-- <a href="view-online-payment.php?id=<?php echo $row_homeowners['fee_assignation_id']; ?>&user_id=<?php echo $row_homeowners['user_id']; ?>" 
                                            class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium transition">
                                            View
                                        </a> -->
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-gray-400 text-sm">N/A</span>
                                <?php endif; ?>
                            </td>
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
        </div>
      </main>
    </div>
  </div>
  <?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/scripts.php'); ?>
  <?php echo '<script src="'. BASE_PATH .'/assets/js/users/board-members/fetch.js"></script>'; ?>
  </body>
</html>