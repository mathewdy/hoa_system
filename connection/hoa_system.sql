-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2025 at 05:15 PM
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
(11, 20208293, 202540617, 'Nehru Ewing', 'Quo anim doloremque ut itaque maiores et pariatur Sint temporibus in repellendus Et reprehenderit', 55, 0, '2021-05-01', 0, '', 1, '2025-11-06 23:00:44', '2025-11-06 23:01:52'),
(12, 20209303, 202540617, 'Samuel Hunt', 'Ea iure rerum deserunt odio consequat Ea unde cumque', 73, 0, '1984-11-30', 0, '', 1, '2025-11-06 23:00:48', '2025-11-06 23:06:06'),
(13, 20206643, 202540617, 'Elaine Hampton', 'Incididunt et quo laborum distinctio Dicta quibusdam sint quaerat est qui', 29, 0, '2006-07-15', 0, '', 1, '2025-11-06 23:00:52', '2025-11-06 23:06:46'),
(14, 20205279, 202540617, 'Charity Ferguson', 'Ut facere velit nesciunt id sunt', 55, 2, '1988-08-30', 0, '', 1, '2025-11-06 23:09:46', '2025-11-07 00:13:16'),
(15, 20207655, 202540617, 'Jin Reed asdasdasdasdsa', 'Vel numquam eligendi nulla dolor e123123123123u error ratione voluptate minus in exercitation qui dolore', 2147483647, 2, '1985-11-11', 1, '', 1, '2025-11-06 23:09:51', '2025-11-07 00:13:39'),
(16, 20201577, 202540617, 'Bernard Ramos', 'Odit molestiae in autem doloribus sunt ut voluptas nihil totam veniam repudiandae nisi molestias sit', 42, 0, '1977-01-02', 0, '', 1, '2025-11-06 23:09:56', '2025-11-07 00:13:50'),
(17, 20201429, 202540617, 'Dara Cotton', 'Cumque illo ab illo illo saepe et et est ipsam veniam in consequatur Velit dolore quibusdam dolores et', 44, 1, '1983-03-10', 0, '', 1, '2025-11-06 23:12:26', '2025-11-07 00:05:45'),
(18, 20204131, 202540617, 'Eve Dickerson', 'Ad vel esse non qui', 44, 1, '2025-11-01', 0, '', 1, '2025-11-06 23:12:44', '2025-11-07 00:12:59'),
(19, 20206162, 202540617, 'Samson Richardson e', 'Qui edited ', 30, 0, '1987-02-18', 1, '', 1, '2025-11-06 23:19:33', '2025-11-07 00:11:18');

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
(39, 2, 202540617, 'Mechelle', 'Vielka Farrell', 'Palmer', 'Veronica Wheeler', 'verovalut@mailinator.com', 0, '+639917385959', 29, '1997-05-05', 'Deserunt tempora rep', 'Divorced', 1, 'Excepturi pariatur ', 310, 653, 145, 'Juliet Holland', '2025-11-05', '2025-11-05'),
(40, 3, 2025406137, 'Halee', 'Omar White', 'Oneill', 'Judah Barlow', 'cibawu@mailinator.com', 0, '+639917137979', 59, '2009-09-20', 'In nulla labore expe', 'Annulled', 1, 'Exercitation do susc', 857, 699, 555, 'Levi Deleon', '2025-11-05', '2025-11-05'),
(41, 4, 20256086, 'Kelly', 'Ulric Mckee', 'Horn', 'Keegan Flores', 'wagecab@mailinator.com', 0, '+639173797931', 60, '1973-10-24', 'Ut in est molestiae', 'Widowed', 1, 'Numquam sit ea ut qu', 150, 392, 403, 'Liberty Bolton', '2025-11-05', '2025-11-05'),
(42, 4, 20258505, 'Steven', 'Abra', 'Desiree', 'Lynn', 'byferulap@mailinator.com', 0, '+639Indigo', 179, '2024-09-20', 'Dawn', 'Married', 1, 'Mary', 0, 0, 0, 'Preston', '2025-11-05', '2025-11-05'),
(43, 2, 20251709, 'Shannon', 'Holmes Walter', 'Tran', 'Julie Daugherty', 'verovalut@mailinator.com', 0, '+639312331233', 47, '2023-04-18', 'Amet accusantium op', 'Annulled', 1, 'Odit ullamco volupta', 871, 481, 590, 'Noelani Mcguire', '2025-11-05', '2025-11-05'),
(44, 6, 20255661, 'Sonia', 'Jakeem Hopkins', 'Wheeler', 'Victor Kinney', 'betogix@mailinator.com', 778, '+6391 (499) 918-5992', 90, '2019-09-19', 'Perspiciatis nostru', 'Widowed', 1, '', 204, 350, 2, 'Lucian Miranda', '2025-11-05', '2025-11-05'),
(45, 6, 20257123, 'Fritz', 'Addison Curtis', 'Bean', 'Josephine Brennan', 'nygiv@mailinator.com', 190, '+639+639823172321', 34, '1998-04-06', 'Sed tempor dolore te', 'married', 1, NULL, 897, 485, 4, 'Gemma Kane', '2025-11-05', '2025-11-05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fee_type`
--
ALTER TABLE `fee_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `fee_type`
--
ALTER TABLE `fee_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fee_type`
--
ALTER TABLE `fee_type`
  ADD CONSTRAINT `fee_type_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
