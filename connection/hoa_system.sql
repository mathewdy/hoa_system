-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2025 at 04:47 PM
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
(1, 123, 0, 'Mari Mcfadden', '', 0, 1, '0000-00-00', 0, '', 3, '2025-11-05 21:33:38', '2025-11-05 21:33:38'),
(2, 456, 0, 'Brett Atkinson', 'Duis anim nostrum numquam obcaecati dolore vel ad assumenda natus', 95, 0, '1979-05-13', 0, '', 3, '2025-11-05 21:34:24', '2025-11-05 21:34:24'),
(3, 789, 0, 'Brett Atkinson', 'Duis anim nostrum numquam obcaecati dolore vel ad assumenda natus', 95, 0, '1979-05-13', 0, '', 3, '2025-11-05 21:34:48', '2025-11-05 21:34:48'),
(4, 202010506, 0, 'Hedwig Yates', 'Consequat Dolor dolor qui rerum laudantium ex amet sint', 45, 0, '2014-10-22', 0, '', 1, '2025-11-05 21:51:20', '2025-11-05 21:51:20'),
(5, 20203494, 0, 'Bernard Malone', 'Esse dolore mollit vero pariatur Possimus quis nisi qui qui eaque sunt et ut cupidatat fugit', 12, 0, '1991-09-06', 0, '', 2, '2025-11-05 22:10:09', '2025-11-05 22:10:09'),
(6, 20203210, 0, 'Marshall Sullivan', 'Veniam quo adipisci est reprehenderit minima earum explicabo Maxime et omnis quis rerum aut amet quo quo distinctio Voluptas fuga', 29, 0, '2023-05-15', 0, '', 2, '2025-11-05 23:00:26', '2025-11-05 23:00:26'),
(7, 20205024, 0, 'Callie Fisher', 'Est assumenda voluptatem atque est aliquip doloremque labore dolor ut assumenda rem praesentium', 47, 1, '1980-04-12', 0, '', 1, '2025-11-05 23:01:19', '2025-11-05 23:01:19'),
(8, 20204690, 0, 'Ciaran Anthony', 'Voluptatem Vel non consequat Itaque eaque voluptatem est ut', 41, 2, '1991-08-01', 0, '', 3, '2025-11-05 23:03:45', '2025-11-05 23:03:45'),
(9, 20209158, 0, 'Evelyn Harrison', 'Non nemo ratione ea quo esse voluptates esse aut voluptas aliquip dolorum aut adipisci veritatis pariatur Fugit ut id', 61, 0, '2013-06-26', 1, '', 3, '2025-11-05 23:41:59', '2025-11-05 23:44:47'),
(10, 20209490, 0, 'Olga Maxwell', 'Aliqua Quae eu sapiente velit sit elit id', 46, 0, '2011-07-01', 1, '', 3, '2025-11-05 23:42:28', '2025-11-05 23:44:42'),
(11, 20209480, 0, 'Ferdinand Washington', 'Harum hic sint sed consequatur architecto accusamus necessitatibus corporis quia necessitatibus dignissimos', 77, 1, '2016-09-08', 1, '', 3, '2025-11-05 23:44:08', '2025-11-05 23:44:08');

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
(39, 2, 20254061, 'Mechelle', 'Vielka Farrell', 'Palmer', 'Veronica Wheeler', 'verovalut@mailinator.com', 0, '+639917385959', 29, '1997-05-05', 'Deserunt tempora rep', 'Divorced', 1, 'Excepturi pariatur ', 310, 653, 145, 'Juliet Holland', '2025-11-05', '2025-11-05'),
(40, 3, 20251458, 'Halee', 'Omar White', 'Oneill', 'Judah Barlow', 'cibawu@mailinator.com', 0, '+639917137979', 59, '2009-09-20', 'In nulla labore expe', 'Annulled', 1, 'Exercitation do susc', 857, 699, 555, 'Levi Deleon', '2025-11-05', '2025-11-05'),
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
  ADD KEY `role_id` (`role_id`,`user_id`),
  ADD KEY `hoa_number` (`hoa_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fee_type`
--
ALTER TABLE `fee_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
