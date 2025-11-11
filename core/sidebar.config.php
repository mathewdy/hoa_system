<?php
include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/config.php');

$sidebarItems = [

  'President' => [
    ['label' => 'Dashboard', 'icon' => 'ri-dashboard-line', 'url' => BASE_PATH . 'app/pages/dashboard.php'],
    ['label' => 'User Management', 'icon' => 'ri-admin-line', 'submenu' => [
      ['label' => 'Board Members', 'icon' => 'ri-admin-line', 'url' => BASE_PATH . 'app/pages/user-management/board-members/list.php'],
      ['label' => 'Homeowners', 'icon' => 'ri-user-line', 'url' => BASE_PATH . 'app/pages/user-management/home-owners/list.php'],
    ]],
    ['label' => 'Fee Type', 'icon' => 'ri-file-list-line', 'url' => BASE_PATH . 'app/pages/fee_type.php'],
    ['label' => 'Resolution', 'icon' => 'ri-file-paper-line', 'url' => BASE_PATH . 'app/pages/resolution.php'],
    ['label' => 'Liquidation of Expenses', 'icon' => 'ri-money-dollar-box-line', 'url' => BASE_PATH . 'app/pages/liquidation.php'],
    ['label' => 'Ledger', 'icon' => 'ri-book-line', 'url' => BASE_PATH . 'app/pages/ledger.php'],
    ['label' => 'Remittance', 'icon' => 'ri-wallet-line', 'url' => BASE_PATH . 'app/pages/remittance.php'],
    ['label' => 'Payment History', 'icon' => 'ri-history-line', 'url' => BASE_PATH . 'app/pages/payment_history.php'],
    ['label' => 'Amenities', 'icon' => 'ri-building-line', 'submenu' => [
        ['label' => 'Tricycle', 'icon' => 'ri-bus-line', 'url' => BASE_PATH . 'app/pages/tricycle.php'],
        ['label' => 'Court', 'icon' => 'ri-football-line', 'url' => BASE_PATH . 'app/pages/court.php'],
        ['label' => 'Stall', 'icon' => 'ri-store-3-line', 'url' => BASE_PATH . 'app/pages/stall.php'],
    ]],
    ['label' => 'News Feed', 'icon' => 'ri-news-line', 'url' => BASE_PATH . 'app/pages/news.php'],
    ['label' => 'Calendar', 'icon' => 'ri-calendar-line', 'url' => BASE_PATH . 'app/pages/calendar.php']
  ],

  'Admin' => [
    ['label' => 'Dashboard', 'icon' => 'ri-dashboard-line', 'url' => BASE_PATH . 'app/pages/dashboard.php'],
    ['label' => 'User Management', 'icon' => 'ri-user-settings-line', 'url' => BASE_PATH . 'app/pages/user_management.php'],
    ['label' => 'Payment Management', 'icon' => 'ri-wallet-line', 'submenu' => [
        ['label' => 'Fee Type', 'icon' => 'ri-file-list-line', 'url' => BASE_PATH . 'app/pages/fee_type.php'],
        ['label' => 'Fee Assignation', 'icon' => 'ri-file-add-line', 'url' => BASE_PATH . 'app/pages/fee_assignation.php'],
        ['label' => 'Payment Verification', 'icon' => 'ri-checkbox-line', 'url' => BASE_PATH . 'app/pages/payment_verification.php'],
        ['label' => 'Remittance', 'icon' => 'ri-wallet-line', 'url' => BASE_PATH . 'app/pages/remittance.php'],
        ['label' => 'Payment History', 'icon' => 'ri-history-line', 'url' => BASE_PATH . 'app/pages/payment_history.php'],
    ]],
    ['label' => 'Amenities', 'icon' => 'ri-building-line', 'submenu' => [
        ['label' => 'Tricycle', 'icon' => 'ri-bus-line', 'url' => BASE_PATH . 'app/pages/tricycle.php'],
        ['label' => 'Court', 'icon' => 'ri-football-line', 'url' => BASE_PATH . 'app/pages/court.php'],
        ['label' => 'Stall', 'icon' => 'ri-store-3-line', 'url' => BASE_PATH . 'app/pages/stall.php'],
    ]],
    ['label' => 'Resolution', 'icon' => 'ri-file-paper-line', 'url' => BASE_PATH . 'app/pages/resolution.php'],
    ['label' => 'Ledger', 'icon' => 'ri-book-line', 'url' => BASE_PATH . 'app/pages/ledger.php'],
    ['label' => 'News Feed', 'icon' => 'ri-news-line', 'url' => BASE_PATH . 'app/pages/news.php'],
    ['label' => 'Receipt', 'icon' => 'ri-file-copy-line', 'url' => BASE_PATH . 'app/pages/receipt.php'],
    ['label' => 'Calendar', 'icon' => 'ri-calendar-line', 'url' => BASE_PATH . 'app/pages/calendar.php'],
  ],

  'Secretary' => [
    ['label' => 'Dashboard', 'icon' => 'ri-dashboard-line', 'url' => BASE_PATH . 'app/pages/dashboard.php'],
    ['label' => 'Resolution', 'icon' => 'ri-file-paper-line', 'url' => BASE_PATH . 'app/pages/resolution.php'],
    ['label' => 'News Feed', 'icon' => 'ri-news-line', 'url' => BASE_PATH . 'app/pages/news.php'],
    ['label' => 'Ledger', 'icon' => 'ri-book-line', 'url' => BASE_PATH . 'app/pages/ledger.php'],
    ['label' => 'Calendar', 'icon' => 'ri-calendar-line', 'url' => BASE_PATH . 'app/pages/calendar.php'],
  ],

  'Treasury' => [
    ['label' => 'Dashboard', 'icon' => 'ri-dashboard-line', 'url' => BASE_PATH . 'app/pages/dashboard.php'],
    ['label' => 'Payment History', 'icon' => 'ri-history-line', 'url' => BASE_PATH . 'app/pages/payment_history.php'],
    ['label' => 'Remittance', 'icon' => 'ri-wallet-line', 'url' => BASE_PATH . 'app/pages/remittance.php'],
    ['label' => 'Amenities', 'icon' => 'ri-building-line', 'submenu' => [
        ['label' => 'Tricycle', 'icon' => 'ri-bus-line', 'url' => BASE_PATH . 'app/pages/tricycle.php'],
        ['label' => 'Court', 'icon' => 'ri-football-line', 'url' => BASE_PATH . 'app/pages/court.php'],
        ['label' => 'Stall', 'icon' => 'ri-store-3-line', 'url' => BASE_PATH . 'app/pages/stall.php'],
    ]],
    ['label' => 'Resolution', 'icon' => 'ri-file-paper-line', 'url' => BASE_PATH . 'app/pages/resolution.php'],
    ['label' => 'Ledger', 'icon' => 'ri-book-line', 'url' => BASE_PATH . 'app/pages/ledger.php'],
    ['label' => 'Receipt', 'icon' => 'ri-file-copy-line', 'url' => BASE_PATH . 'app/pages/receipt.php'],
    ['label' => 'News Feed', 'icon' => 'ri-news-line', 'url' => BASE_PATH . 'app/pages/news.php'],
    ['label' => 'Calendar', 'icon' => 'ri-calendar-line', 'url' => BASE_PATH . 'app/pages/calendar.php'],
  ],

  'Audit' => [
    ['label' => 'Dashboard', 'icon' => 'ri-dashboard-line', 'url' => BASE_PATH . 'app/pages/dashboard.php'],
    ['label' => 'Liquidation of Expenses', 'icon' => 'ri-money-dollar-box-line', 'url' => BASE_PATH . 'app/pages/liquidation.php'],
    ['label' => 'Resolution', 'icon' => 'ri-file-paper-line', 'url' => BASE_PATH . 'app/pages/resolution.php'],
    ['label' => 'News Feed', 'icon' => 'ri-news-line', 'url' => BASE_PATH . 'app/pages/news.php'],
    ['label' => 'Ledger', 'icon' => 'ri-book-line', 'url' => BASE_PATH . 'app/pages/ledger.php'],
    ['label' => 'Calendar', 'icon' => 'ri-calendar-line', 'url' => BASE_PATH . 'app/pages/calendar.php'],
  ],

  'Home Owner' => [
    ['label' => 'Dashboard', 'icon' => 'ri-dashboard-line', 'url' => BASE_PATH . 'app/pages/dashboard.php'],
    ['label' => 'Payments', 'icon' => 'ri-wallet-line', 'submenu' => [
        ['label' => 'View Payments', 'icon' => 'ri-eye-line', 'url' => BASE_PATH . 'app/pages/view_payments.php'],
        ['label' => 'Payment History', 'icon' => 'ri-history-line', 'url' => BASE_PATH . 'app/pages/payment_history.php'],
    ]],
    ['label' => 'Resolution', 'icon' => 'ri-file-paper-line', 'url' => BASE_PATH . 'app/pages/resolution.php'],
    ['label' => 'News Feed', 'icon' => 'ri-news-line', 'url' => BASE_PATH . 'app/pages/news.php'],
    ['label' => 'Ledger', 'icon' => 'ri-book-line', 'url' => BASE_PATH . 'app/pages/ledger.php'],
    ['label' => 'Calendar', 'icon' => 'ri-calendar-line', 'url' => BASE_PATH . 'app/pages/calendar.php'],
  ],

];
