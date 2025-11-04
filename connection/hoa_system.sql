-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2025 at 08:00 PM
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

INSERT INTO `users` (`id`, `role_id`, `user_id`, `first_name`, `middle_name`, `last_name`, `suffix`, `email_address`, `hoa_number`, `phone_number`, `age`, `date_of_birth`, `citizenship`, `civil_status`, `home_address`, `lot_number`, `block_number`, `phase_number`, `village_name`, `date_created`, `date_updated`) VALUES
(16, 2, 20257108, 'Isabelle', 'Rebecca Briggs', 'Jones', '0', 'tywuly@mailinator.com', 750, '+639917137979', 63, '2003-05-17', 'Perferendis sunt sit', 'Annulled', 'Eum ea id saepe adi', 435, 557, 191, 'Hiram Hickman', '2025-11-05', '2025-11-05'),
(18, 2, 20255472, 'Isabelle', 'Rebecca Briggs', 'Jones', '0', 'tywuly@mailinator.com', 750, '+639917137979', 63, '2003-05-17', 'Perferendis sunt sit', 'Annulled', 'Eum ea id saepe adi', 435, 557, 191, 'Hiram Hickman', '2025-11-05', '2025-11-05'),
(19, 2, 20258055, 'Nadine', 'Erin Morgan', 'Richards', '0', 'jyrydo@mailinator.com', 362, '+639917137979', 34, '1997-10-10', 'Velit dolorem quos r', 'Widowed', 'Anim architecto veni', 239, 264, 513, 'Salvador Sellers', '2025-11-05', '2025-11-05'),
(21, 2, 20254331, 'Maxine', 'McKenzie Villarreal', 'Levy', '0', 'sysedib@mailinator.com', 388, '+639917137979', 52, '1979-04-08', 'Et voluptatem Conse', 'Annulled', 'Enim molestiae ullam', 601, 713, 394, 'Scott Holman', '2025-11-05', '2025-11-05'),
(25, 2, 20255137, 'Kylynn', 'Marshall Blackwell', 'Mcgowan', 'Cedric Briggs', 'lumyve@mailinator.com', 0, '+639917137979', 43, '1983-06-11', 'Non voluptatem archi', 'Single', 'Est laudantium veri', 666, 890, 560, 'Remedios Parks', '2025-11-05', '2025-11-05'),
(26, 2, 20257915, 'Thaddeus', 'Malcolm King', 'Austin', 'Ivor Harvey', 'xetasuwobe@mailinator.com', 0, '+639917137979', 54, '1982-09-30', 'Dolor ut blanditiis ', 'Single', 'Voluptatibus fugiat ', 353, 496, 430, 'Nathan Curtis', '2025-11-05', '2025-11-05'),
(29, 6, 20258319, 'Simon', 'Raya Avery', 'Johnston', 'Mira Vaughn', 'botur@mailinator.com', 330, '+639+1 (896) 606-4244', 26, '1980-03-07', 'Nisi nulla maiores e', 'married', NULL, 487, 275, 4, 'Bruce Huber', '2025-11-05', '2025-11-05'),
(31, 6, 20257130, 'Wallace', 'Tanek Holcomb', 'Rodgers', 'Rose Cohen', 'tyqox@mailinator.com', 950, '+639+1 (311) 914-2143', 35, '2003-04-06', 'Aperiam ut aut hic d', 'divorced', NULL, 665, 159, 2, 'Bo Cabrera', '2025-11-05', '2025-11-05');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

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
