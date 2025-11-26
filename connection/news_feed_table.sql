-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2025 at 06:43 PM
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
-- Table structure for table `news_feed`
--

CREATE TABLE `news_feed` (
  `id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `post_images` blob NOT NULL,
  `project_file` blob NOT NULL,
  `date_created` date NOT NULL,
  `date_updated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news_feed`
--

INSERT INTO `news_feed` (`id`, `created_by`, `post_title`, `description`, `post_images`, `project_file`, `date_created`, `date_updated`) VALUES
(7, 0, 'In sunt dicta quasi  edited  123', 'Libero quaerat inven edited  1231231232131', 0x313736333931383031365f302e706e67, '', '2025-11-24', '2025-11-24'),
(8, 0, 'm,athew edited 1231234132412341234', 'Incididunt perferendmsduasdsadhasyd  edited 123123412341234123412341234', 0x313736333931383437325f302e6a7067, 0x313736333931383437325f48454d502d38302d32303235303431362d504d502d313333303036202d207369676e65642e706466, '2025-11-24', '2025-11-24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `news_feed`
--
ALTER TABLE `news_feed`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `news_feed`
--
ALTER TABLE `news_feed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
