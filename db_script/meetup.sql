-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2021 at 08:11 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `meetup`
--
CREATE DATABASE IF NOT EXISTS `meetup` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `meetup`;

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `age` int(11) NOT NULL,
  `dob` date DEFAULT NULL,
  `profession` varchar(255) DEFAULT NULL,
  `locality` varchar(255) DEFAULT NULL,
  `number_of_guests` tinyint(4) NOT NULL DEFAULT '0',
  `address` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`id`, `name`, `age`, `dob`, `profession`, `locality`, `number_of_guests`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Amit', 35, '1985-12-07', 'Employed', 'Kandivali', 1, 'A306 Venus Heights Kandivali Mumbai 67', '2021-07-16 02:14:55', '2021-07-15 22:44:55'),
(2, 'Paras', 35, '1983-11-18', 'Employed', 'Adarsh', 0, '404 Silver Croft Marve Road Malad Mumbai 400064', '2021-07-16 02:17:16', '2021-07-16 02:22:40'),
(3, 'Parth', 33, '1984-02-18', 'Student', 'SV Road', 1, '405 God Grace SV Road Kandivali Mumbai 400067', '2021-07-16 02:21:42', '2021-07-16 02:21:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `locality_idx` (`locality`(191)),
  ADD KEY `name_idx` (`name`(191));

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
