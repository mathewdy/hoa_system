-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2025 at 06:00 PM
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
(62, 20255661, 20207488, '2025-12-01', 1, 'GCash', 'Mathew Melendez ', '', 1, '2025-11-12', '2025-11-12'),
(63, 20255661, 202010458, '2025-12-01', 1, 'Bank Transfer', 'Mathew Melendez ', '', 1, '2025-11-12', '2025-11-12'),
(64, 20255661, 20204767, '2016-04-06', 1, 'GCash', 'Mathew Melendez ', '', 1, '2025-11-12', '2025-11-12'),
(65, 20252509, 20207488, '2025-12-01', 1, 'GCash', 'Mathew Melendez ', '', 1, '2025-11-12', '2025-11-12'),
(66, 20252509, 20202339, '2025-01-01', 0, '', '', '', 0, '2025-11-12', '2025-11-12'),
(67, 20252509, 20202339, '2025-02-01', 0, '', '', '', 0, '2025-11-12', '2025-11-12'),
(68, 20252509, 20202339, '2025-03-01', 0, '', '', '', 0, '2025-11-12', '2025-11-12'),
(69, 20252509, 20202339, '2025-04-01', 0, '', '', '', 0, '2025-11-12', '2025-11-12'),
(70, 20252509, 20202339, '2025-05-01', 0, '', '', '', 0, '2025-11-12', '2025-11-12'),
(71, 20252509, 20202339, '2025-06-01', 0, '', '', '', 0, '2025-11-12', '2025-11-12'),
(72, 20252509, 20202339, '2025-07-01', 0, '', '', '', 0, '2025-11-12', '2025-11-12'),
(73, 20252509, 20202339, '2025-08-01', 0, '', '', '', 0, '2025-11-12', '2025-11-12'),
(74, 20252509, 20202339, '2025-09-01', 0, '', '', '', 0, '2025-11-12', '2025-11-12'),
(75, 20252509, 20202339, '2025-11-01', 1, 'GCash', 'Mathew Melendez ', '', 1, '2025-11-12', '2025-11-12'),
(76, 20252509, 20202339, '2025-12-01', 1, 'Bank Transfer', 'Mathew Melendez ', '', 1, '2025-11-12', '2025-11-12'),
(77, 20252509, 20201395, '2025-12-01', 1, 'GCash', 'tapat', '', 1, '2025-11-13', '2025-11-13'),
(78, 20252509, 202010458, '2025-12-01', 1, 'GCash', 'over', '', 1, '2025-11-13', '2025-11-13');

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
-- Table structure for table `payment_history`
--

CREATE TABLE `payment_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fee_type_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `payment_receipt_name` varchar(100) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `reference_number` varchar(100) NOT NULL,
  `is_walk_in` int(11) NOT NULL,
  `proof_of_payment` varchar(255) DEFAULT NULL,
  `date_created` date NOT NULL,
  `date_updated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_history`
--

INSERT INTO `payment_history` (`id`, `user_id`, `fee_type_id`, `amount`, `payment_method`, `payment_receipt_name`, `remarks`, `reference_number`, `is_walk_in`, `proof_of_payment`, `date_created`, `date_updated`) VALUES
(23, 20255661, 0, 48, 'GCash', 'Mathew Melendez ', '', 'you', 0, '1762879792_Building_official_-_NBP.drawio.png', '2025-11-12', '2025-11-12'),
(24, 20255661, 0, 51, 'GCash', 'Mathew Melendez ', '', 'tite', 0, '1762879818_Applicant_-_FOPA.drawio.png', '2025-11-12', '2025-11-12'),
(25, 20255661, 0, 8, 'Bank Transfer', 'Mathew Melendez ', '', 'tite', 0, '1762880058_...png', '2025-11-12', '2025-11-12'),
(26, 20252509, 0, 51, 'GCash', 'Mathew Melendez ', '', 'hahaha', 0, '1762880398_Sectionheads_-_FOPA.drawio.png', '2025-11-12', '2025-11-12'),
(27, 20252509, 0, 79, 'Bank Transfer', 'Mathew Melendez ', '', 'you', 0, '1762880438_Technical_staff_-_NBP.drawio.png', '2025-11-12', '2025-11-12'),
(28, 20252509, 0, 79, 'GCash', 'Mathew Melendez ', '', 'tite', 0, '1762880470_Assessment_officer_-_NBP.drawio.png', '2025-11-12', '2025-11-12'),
(29, 20252509, 0, 99, 'GCash', 'tapat', '', 'hahaha', 0, '1762964894_Building_official_-_NBP.drawio.png', '2025-11-13', '2025-11-13'),
(30, 20252509, 78, 8, 'GCash', 'over', '', 'you', 0, '1762965048_UC-BPNM-RBP-002.drawio.png', '2025-11-13', '2025-11-13');

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
(48, 20252509, 66, 0, '', '', '', '', 0, '2025-11-12', '2025-11-12'),
(49, 20252509, 67, 0, '', '', '', '', 0, '2025-11-12', '2025-11-12'),
(50, 20252509, 68, 0, '', '', '', '', 0, '2025-11-12', '2025-11-12'),
(51, 20252509, 69, 0, '', '', '', '', 0, '2025-11-12', '2025-11-12'),
(52, 20252509, 70, 0, '', '', '', '', 0, '2025-11-12', '2025-11-12'),
(53, 20252509, 71, 0, '', '', '', '', 0, '2025-11-12', '2025-11-12'),
(54, 20252509, 72, 0, '', '', '', '', 0, '2025-11-12', '2025-11-12'),
(55, 20252509, 73, 0, '', '', '', '', 0, '2025-11-12', '2025-11-12'),
(56, 20252509, 74, 0, '', '', '', '', 0, '2025-11-12', '2025-11-12');

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
(68, 20255661, 107.00, '2025-11-12', '2025-11-12'),
(69, 20252509, 719.00, '2025-11-12', '2025-11-13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `suffix` varchar(50) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `hoa_number` int(11) DEFAULT NULL,
  `phone_number` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `date_of_birth` date NOT NULL,
  `citizenship` varchar(100) NOT NULL,
  `civil_status` varchar(100) NOT NULL,
  `account_status` int(11) NOT NULL,
  `home_address` varchar(255) DEFAULT NULL,
  `lot_number` int(11) NOT NULL,
  `block_number` int(11) NOT NULL,
  `phase_number` int(11) NOT NULL,
  `village_name` varchar(200) NOT NULL,
  `date_created` date NOT NULL,
  `date_updated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `user_id`, `first_name`, `middle_name`, `last_name`, `suffix`, `email_address`, `hoa_number`, `phone_number`, `age`, `date_of_birth`, `citizenship`, `civil_status`, `account_status`, `home_address`, `lot_number`, `block_number`, `phase_number`, `village_name`, `date_created`, `date_updated`) VALUES
(39, 1, 202540617, 'Mechelle', 'Vielka Farrell', 'Palmer', 'Veronica Wheeler', 'verovalut@mailinator.com', 0, '+639917385959', 29, '1997-05-05', 'Deserunt tempora rep', 'Divorced', 1, 'Excepturi pariatur ', 310, 653, 145, 'Juliet Holland', '2025-11-05', '2025-11-05'),
(40, 3, 2025406137, 'Halee', 'Omar White', 'Oneill', 'Judah Barlow', 'cibawu@mailinator.com', 0, '+639917137979', 59, '2009-09-20', 'In nulla labore expe', 'Annulled', 1, 'Exercitation do susc', 857, 699, 555, 'Levi Deleon', '2025-11-05', '2025-11-05'),
(41, 4, 20256086, 'Kelly', 'Ulric Mckee', 'Horn', 'Keegan Flores', 'wagecab@mailinator.com', 0, '+639173797931', 60, '1973-10-24', 'Ut in est molestiae', 'Widowed', 1, 'Numquam sit ea ut qu', 150, 392, 403, 'Liberty Bolton', '2025-11-05', '2025-11-05'),
(42, 4, 20258505, 'Steven', 'Abra', 'Desiree', 'Lynn', 'byferulap@mailinator.com', 0, '+639Indigo', 179, '2024-09-20', 'Dawn', 'Married', 1, 'Mary', 0, 0, 0, 'Preston', '2025-11-05', '2025-11-05'),
(44, 6, 20255661, 'Sonia', 'Jakeem Hopkins', 'Wheeler', 'Victor Kinney', 'betogix@mailinator.com', 778, '+6391 (499) 918-5992', 90, '2019-09-19', 'Perspiciatis nostru', 'Widowed', 1, '', 204, 350, 2, 'Lucian Miranda', '2025-11-05', '2025-11-05'),
(45, 6, 20257123, 'Fritz', 'Addison Curtis', 'Bean', 'Josephine Brennan', 'nygiv@mailinator.com', 190, '+639823172321', 34, '1998-04-06', 'Sed tempor dolore te', 'Single', 1, '', 897, 485, 4, 'Gemma Kane', '2025-11-05', '2025-11-08'),
(46, 6, 20254233, 'Tanisha', 'Francis Ortiz', 'Walters', 'Nathan Cooley', 'niruluwek@mailinator.com', 376, '+6391 (284) 999-9366', 84, '1985-12-30', 'Irure perferendis qu', 'Single', 1, '', 424, 773, 1, 'Galena Crosby', '2025-11-08', '2025-11-08'),
(47, 6, 20252509, 'Hector', 'Kim Pierce', 'Crawford', 'Edward Taylor', 'tidoz@mailinator.com', 385, '+639+1 (696) 533-7476', 72, '1990-12-13', 'Natus et obcaecati s', 'divorced', 1, NULL, 209, 750, 2, 'Kristen Chapman', '2025-11-08', '2025-11-08');

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
-- Indexes for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `payment_verification`
--
ALTER TABLE `payment_verification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fee_assignation_id` (`fee_assignation_id`);

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
  ADD KEY `hoa_number` (`hoa_number`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fee_assignation`
--
ALTER TABLE `fee_assignation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `fee_type`
--
ALTER TABLE `fee_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `payment_verification`
--
ALTER TABLE `payment_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `unpaid_fees`
--
ALTER TABLE `unpaid_fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fee_assignation`
--
ALTER TABLE `fee_assignation`
  ADD CONSTRAINT `fee_assignation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fee_assignation_ibfk_2` FOREIGN KEY (`fee_type_id`) REFERENCES `fee_type` (`fee_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fee_type`
--
ALTER TABLE `fee_type`
  ADD CONSTRAINT `fee_type_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD CONSTRAINT `payment_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment_verification`
--
ALTER TABLE `payment_verification`
  ADD CONSTRAINT `payment_verification_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payment_verification_ibfk_2` FOREIGN KEY (`fee_assignation_id`) REFERENCES `fee_assignation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `unpaid_fees`
--
ALTER TABLE `unpaid_fees`
  ADD CONSTRAINT `unpaid_fees_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
