-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2025 at 12:13 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hoa_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `fee_assignation`
--

CREATE TABLE `fee_assignation` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fee_type_id` int(11) NOT NULL,
  `next_due` date DEFAULT NULL,
  `is_paid` int(11) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `payment_receipt_name` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `is_approved` int(11) NOT NULL,
  `date_created` date NOT NULL,
  `date_updated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fee_assignation`
--

INSERT INTO `fee_assignation` (`id`, `user_id`, `fee_type_id`, `next_due`, `is_paid`, `payment_method`, `payment_receipt_name`, `remarks`, `is_approved`, `date_created`, `date_updated`) VALUES
(79, 20255661, 20207488, '2025-11-01', 0, '', '', '', 0, '2025-11-13', '2025-11-13'),
(80, 20255661, 20201395, '2025-11-01', 0, '', '', '', 0, '2025-11-13', '2025-11-13'),
(81, 20252509, 20207488, '2025-12-01', 1, 'GCash', 'over', '', 1, '2025-11-13', '2025-11-14'),
(82, 20252509, 20201395, '2025-12-01', 1, 'GCash', 'Mathew Melendez tiute', '', 1, '2025-11-13', '2025-11-13'),
(83, 20252509, 202010458, '2025-12-01', 1, 'Bank Transfer', 'tapat', '', 1, '2025-11-14', '2025-11-14');

-- --------------------------------------------------------

--
-- Table structure for table `fee_type`
--

CREATE TABLE `fee_type` (
  `id` int(11) NOT NULL,
  `fee_type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fee_name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `cadence` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `is_active` int(11) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `approved` int(11) DEFAULT NULL,
  `datetime_created` datetime NOT NULL,
  `datetime_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fee_type`
--

INSERT INTO `fee_type` (`id`, `fee_type_id`, `user_id`, `fee_name`, `description`, `amount`, `cadence`, `start_date`, `is_active`, `remarks`, `approved`, `datetime_created`, `datetime_updated`) VALUES
(25, 20207488, 202540617, 'Cat food', 'Provident iste at est ut vero ratione eos', 51, 1, '2025-11-01', 1, '', 1, '2025-11-08 13:49:15', '2025-11-08 13:50:47'),
(26, 202010458, 202540617, 'Dog food', 'Dicta et commodo amet architecto at sint facilis quas maxime', 8, 1, '2025-11-01', 1, '', 1, '2025-11-08 13:50:12', '2025-11-08 13:50:50'),
(27, 20204767, 202540617, 'Hose and Lot', 'Sapiente occaecat numquam ut dolor ullamco magnam sint reprehenderit consequat Aut esse eligendi aliquam autem sed eaque dolorem earum', 48, 2, '2024-07-20', 1, '', 1, '2025-11-08 14:28:13', '2025-11-08 14:28:28'),
(28, 20201222, 202540617, 'Pool', 'Atque ea ratione quasi perspiciatis veritatis optio commodo aut aspernatur', 57, 2, '2016-03-06', 1, '', 1, '2025-11-08 14:28:24', '2025-11-08 14:28:31'),
(29, 20202339, 202540617, 'DinaSure', 'Odio quia incididunt qui temporibus dolores deserunt facilis sint dolor vel enim', 79, 1, '2025-01-01', 1, '', 1, '2025-11-08 14:57:40', '2025-11-08 14:57:46'),
(30, 20201395, 202540617, 'Internet', 'Repellendus Nostrud fugiat excepteur culpa et ipsam sed sint ad sed ipsam', 99, 1, '2025-11-01', 1, '', 1, '2025-11-08 22:12:28', '2025-11-08 22:13:26');

-- --------------------------------------------------------

--
-- Table structure for table `hoa_info`
--

CREATE TABLE `hoa_info` (
  `id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `hoa_number` varchar(100) NOT NULL,
  `home_address` varchar(100) NOT NULL,
  `lot` varchar(100) NOT NULL,
  `block` varchar(100) NOT NULL,
  `phase` varchar(100) NOT NULL,
  `village` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hoa_info`
--

INSERT INTO `hoa_info` (`id`, `user_id`, `hoa_number`, `home_address`, `lot`, `block`, `phase`, `village`) VALUES
(1, '202540617', '0', 'Excepturi pariatur', '310', '653', '145', 'Juliet Holland');

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE `payment_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fee_type_id` int(11) NOT NULL,
  `fee_name` varchar(100) NOT NULL,
  `amount` int(11) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `payment_receipt_name` varchar(100) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `reference_number` varchar(100) NOT NULL,
  `is_walk_in` int(11) NOT NULL,
  `proof_of_payment` varchar(255) DEFAULT NULL,
  `is_submitted` int(11) NOT NULL DEFAULT 0,
  `date_created` date NOT NULL,
  `date_updated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_history`
--

INSERT INTO `payment_history` (`id`, `user_id`, `fee_type_id`, `fee_name`, `amount`, `payment_method`, `payment_receipt_name`, `remarks`, `reference_number`, `is_walk_in`, `proof_of_payment`, `is_submitted`, `date_created`, `date_updated`) VALUES
(32, 20252509, 82, 'Internet', 99, 'GCash', 'Mathew Melendez tiute', '', 'tite', 0, '1763049317_Section_head_2_-_fopa.drawio.png', 1, '2025-11-13', '2025-11-14'),
(33, 20252509, 81, 'Cat food', 51, 'GCash', 'over', '', 'you', 0, '1763049705_Gemini_Generated_Image_ld2mhcld2mhcld2m.png', 1, '2025-11-14', '2025-11-14'),
(34, 20252509, 83, 'Dog food', 8, 'Bank Transfer', 'tapat', '', 'you', 0, '1763052817_BPNM-OBO-FOPA-001_v2.drawio.png', 1, '2025-11-13', '2025-11-14');

-- --------------------------------------------------------

--
-- Table structure for table `payment_verification`
--

CREATE TABLE `payment_verification` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fee_assignation_id` int(11) DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `reference_number` varchar(100) NOT NULL,
  `proof_of_payment` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `date_created` date NOT NULL,
  `date_updated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_verification`
--

INSERT INTO `payment_verification` (`id`, `user_id`, `fee_assignation_id`, `amount`, `payment_method`, `remarks`, `reference_number`, `proof_of_payment`, `status`, `date_created`, `date_updated`) VALUES
(61, 20255661, 79, 0, '', '', '', '', 0, '2025-11-13', '2025-11-13'),
(62, 20255661, 80, 0, '', '', '', '', 0, '2025-11-13', '2025-11-13');

-- --------------------------------------------------------

--
-- Table structure for table `remittance`
--

CREATE TABLE `remittance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `particular` varchar(100) NOT NULL,
  `amount` int(11) NOT NULL,
  `date` date NOT NULL,
  `transaction_type` varchar(100) NOT NULL,
  `secretary_name` varchar(110) NOT NULL,
  `is_approved` int(11) NOT NULL,
  `date_created` date NOT NULL,
  `date_updated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `remittance`
--

INSERT INTO `remittance` (`id`, `user_id`, `particular`, `amount`, `date`, `transaction_type`, `secretary_name`, `is_approved`, `date_created`, `date_updated`) VALUES
(7, NULL, 'Remittance Collection', 158, '2025-11-14', 'Credit', 'haha', 1, '2025-11-14', '2025-11-14');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'President'),
(2, 'Secretary'),
(3, 'Admin'),
(4, 'Treasury '),
(5, 'Audit'),
(6, 'Home Owner');

-- --------------------------------------------------------

--
-- Table structure for table `unpaid_fees`
--

CREATE TABLE `unpaid_fees` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_balance` decimal(10,2) NOT NULL,
  `date_created` date NOT NULL,
  `date_updated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unpaid_fees`
--

INSERT INTO `unpaid_fees` (`id`, `user_id`, `total_balance`, `date_created`, `date_updated`) VALUES
(70, 20255661, 150.00, '2025-11-13', '2025-11-13'),
(71, 20252509, 8.00, '2025-11-13', '2025-11-14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `is_first_time` tinyint(4) NOT NULL,
  `reset_token` varchar(100) NOT NULL,
  `reset_token_expire` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) NOT NULL,
  `date_created` date NOT NULL,
  `date_updated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `user_id`, `email_address`, `password`, `is_first_time`, `reset_token`, `reset_token_expire`, `status`, `date_created`, `date_updated`) VALUES
(39, 1, '202540617', 'verovalut@mailinator.com', '$2y$10$jWG2dKx7gCj7AfGuhASHMuEWd.9U0EzRkc/4aaE2zy/4MWumFyNH2', 0, '', '2025-11-15 22:39:48', 1, '2025-11-05', '2025-11-05');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `suffix` varchar(100) NOT NULL,
  `phone_number` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `citizenship` varchar(100) NOT NULL,
  `civil_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`id`, `user_id`, `first_name`, `middle_name`, `last_name`, `suffix`, `phone_number`, `date_of_birth`, `citizenship`, `civil_status`) VALUES
(1, '202540617', 'Mechelle', 'Vielka Farrell', 'Palmer', 'Veronica Wheeler', '+639917385959', '1997-05-05', 'Deserunt tempora rep', 'Divorced');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fee_assignation`
--
ALTER TABLE `fee_assignation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`fee_type_id`),
  ADD KEY `fee_type_id` (`fee_type_id`);

--
-- Indexes for table `fee_type`
--
ALTER TABLE `fee_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fee_type_id` (`fee_type_id`);

--
-- Indexes for table `hoa_info`
--
ALTER TABLE `hoa_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fee_type_id` (`fee_type_id`);

--
-- Indexes for table `payment_verification`
--
ALTER TABLE `payment_verification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fee_assignation_id` (`fee_assignation_id`);

--
-- Indexes for table `remittance`
--
ALTER TABLE `remittance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unpaid_fees`
--
ALTER TABLE `unpaid_fees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fee_assignation`
--
ALTER TABLE `fee_assignation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `fee_type`
--
ALTER TABLE `fee_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `hoa_info`
--
ALTER TABLE `hoa_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `payment_verification`
--
ALTER TABLE `payment_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `remittance`
--
ALTER TABLE `remittance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `unpaid_fees`
--
ALTER TABLE `unpaid_fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fee_assignation`
--
ALTER TABLE `fee_assignation`
  ADD CONSTRAINT `fee_assignation_ibfk_2` FOREIGN KEY (`fee_type_id`) REFERENCES `fee_type` (`fee_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hoa_info`
--
ALTER TABLE `hoa_info`
  ADD CONSTRAINT `hoa_info_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment_verification`
--
ALTER TABLE `payment_verification`
  ADD CONSTRAINT `payment_verification_ibfk_2` FOREIGN KEY (`fee_assignation_id`) REFERENCES `fee_assignation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_info`
--
ALTER TABLE `user_info`
  ADD CONSTRAINT `user_info_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
