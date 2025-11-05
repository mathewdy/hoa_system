-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2025 at 01:59 PM
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
  `user_id` int(11) NOT NULL,
  `fee_name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `approved` int(11) NOT NULL,
  `datetime_created` datetime NOT NULL,
  `datetime_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(16, 2, 20257108, 'Isabelle', 'Rebecca Briggs', 'Jones', '0', 'tywuly@mailinator.com', 750, '+639917137979', 63, '2003-05-17', 'Perferendis sunt sit', 'Annulled', 0, 'Eum ea id saepe adi', 435, 557, 191, 'Hiram Hickman', '2025-11-05', '2025-11-05'),
(18, 2, 20255472, 'Isabelle', 'Rebecca Briggs', 'Jones', '0', 'tywuly@mailinator.com', 750, '+639917137979', 63, '2003-05-17', 'Perferendis sunt sit', 'Annulled', 0, 'Eum ea id saepe adi', 435, 557, 191, 'Hiram Hickman', '2025-11-05', '2025-11-05'),
(19, 2, 20258055, 'Nadine', 'Erin Morgan', 'Richards', '0', 'jyrydo@mailinator.com', 362, '+639917137979', 34, '1997-10-10', 'Velit dolorem quos r', 'Widowed', 0, 'Anim architecto veni', 239, 264, 513, 'Salvador Sellers', '2025-11-05', '2025-11-05'),
(21, 2, 20254331, 'Maxine', 'McKenzie Villarreal', 'Levy', '0', 'sysedib@mailinator.com', 388, '+639917137979', 52, '1979-04-08', 'Et voluptatem Conse', 'Annulled', 0, 'Enim molestiae ullam', 601, 713, 394, 'Scott Holman', '2025-11-05', '2025-11-05'),
(25, 2, 20255137, 'Kylynn', 'Marshall Blackwell', 'Mcgowan', 'Cedric Briggs', 'lumyve@mailinator.com', 0, '+639917137979', 43, '1983-06-11', 'Non voluptatem archi', 'Single', 0, 'Est laudantium veri', 666, 890, 560, 'Remedios Parks', '2025-11-05', '2025-11-05'),
(26, 2, 20257915, 'Thaddeus', 'Malcolm King', 'Austin', 'Ivor Harvey', 'xetasuwobe@mailinator.com', 0, '+639917137979', 54, '1982-09-30', 'Dolor ut blanditiis ', 'Single', 0, 'Voluptatibus fugiat ', 353, 496, 430, 'Nathan Curtis', '2025-11-05', '2025-11-05'),
(29, 6, 20258319, 'Simon', 'Raya Avery', 'Johnston', 'Mira Vaughn', 'botur@mailinator.com', 330, '+639+1 (896) 606-4244', 26, '1980-03-07', 'Nisi nulla maiores e', 'married', 0, NULL, 487, 275, 4, 'Bruce Huber', '2025-11-05', '2025-11-05'),
(31, 4, 20257130, 'Zeus', 'Sierra', 'Fatima', 'Hammett', 'rixefudobi@mailinator.com', 0, '+639Alfreda', 199, '2025-01-19', 'Maris', 'Annulled', 2, 'Axel', 0, 0, 4, 'Jacob', '2025-11-05', '2025-11-05'),
(32, 3, 20251311, 'Tanner', 'Vladimir Love', 'Flowers', 'Ivor Guerrero', 'jalilikiwo@mailinator.com', 0, '+639171379796', 64, '2009-12-29', 'Culpa ut placeat q', 'Divorced', 1, 'Ipsam aliquip expedi', 3, 177, 275, 'Wilma Edwards', '2025-11-05', '2025-11-05'),
(33, 6, 202510852, 'Elizabeth', 'Timothy Moody', 'Hernandez', 'Victoria Cook', 'bexy@mailinator.com', 188, '+639+1 (375) 133-8027', 18, '2009-09-28', 'Omnis voluptatum cup', '1', 0, NULL, 83, 781, 4, 'Kasper Mcgowan', '2025-11-05', '2025-11-05'),
(34, 6, 20257767, 'Charles', 'Colt Phillips', 'Wagner', 'Mikayla Baker', 'gizaqa@mailinator.com', 99, '+639+1 (543) 218-8555', 18, '1982-06-23', 'Quaerat in enim omni', '2', 0, NULL, 645, 540, 2, 'Hasad Griffin', '2025-11-05', '2025-11-05'),
(35, 6, 202510583, 'Tamara', 'Signe Contreras', 'Bray', 'Quinlan Jones', 'dubisu@mailinator.com', 481, '+639+1 (122) 766-8358', 100, '1972-08-23', 'Nemo sed in recusand', '2', 0, NULL, 692, 943, 1, 'Cheryl Fisher', '2025-11-05', '2025-11-05'),
(36, 6, 20253956, 'Amir', 'Natalie Byrd', 'Rosa', 'Kareem Thompson', 'powapoji@mailinator.com', 98, '+639+1 (148) 238-6787', 91, '1994-06-16', 'Quis odit culpa sed ', 'widowed', 1, NULL, 684, 63, 2, 'Pascale Mosley', '2025-11-05', '2025-11-05'),
(37, 6, 20253308, 'mathew', 'Althea Carter', 'Vega', 'Darryl Moss', 'xobyhuwiju@mailinator.com', 678, '+6391 (955) 232-6483', 21, '2014-05-05', 'Iste quia rerum anim', 'Single', 1, '', 874, 564, 2, 'Hilda Strong', '2025-11-05', '2025-11-05'),
(38, 6, 20257587, 'mathew', 'Althea Carter', 'Vega', 'Darryl Moss', 'xobyhuwiju@mailinator.com', 678, '+6391 (955) 232-6483', 21, '2014-05-05', 'Iste quia rerum anim', 'Married', 1, '', 874, 564, 2, 'Hilda Strong', '2025-11-05', '2025-11-05');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

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
