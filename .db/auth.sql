-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2024 at 03:00 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auth`
--

-- --------------------------------------------------------

--
-- Table structure for table `local_storage`
--

CREATE TABLE `local_storage` (
  `id` int(11) NOT NULL,
  `storage_key` varchar(255) NOT NULL,
  `storage_value` text NOT NULL,
  `floor` varchar(50) NOT NULL,
  `uid` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `details` varchar(500) NOT NULL,
  `type` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'default-pp.png',
  `date` date NOT NULL,
  `uid` int(8) DEFAULT NULL,
  `pinId` varchar(50) DEFAULT NULL,
  `coordinates` varchar(100) DEFAULT NULL,
  `floor` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `specific_place` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','admin') NOT NULL DEFAULT 'student',
  `uid` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `email`, `password`, `role`, `uid`) VALUES
(9, 'jhewen', 'shene', 'js@gmail.com', '$2y$10$MZBLag/bCQDw5CzNe4X6auVEAFcu3O2d3LhxK3T7UjpVvgdS9cs72', 'student', 87850305),
(15, 'olivia', 'benson', 'gijevi@mailinator.com', '$2y$10$RfRhPglso2IDVjZ8fpNKrOgay4vCZGpGZEteX7zWrGbh3uIaV7eN6', 'admin', NULL),
(16, 'pauline', 'kaye', 'pk@gmail.com', '$2y$10$YKFSRbefW79G1eGkMiyxdO5tU7ZOQPJMiJ73O6VqxWkoSdq.HdLN2', 'student', 22782317);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `local_storage`
--
ALTER TABLE `local_storage`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `storage_key_index` (`storage_key`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_email` (`email`),
  ADD UNIQUE KEY `uid` (`uid`),
  ADD UNIQUE KEY `uid_2` (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `local_storage`
--
ALTER TABLE `local_storage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
