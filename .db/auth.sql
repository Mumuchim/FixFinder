-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2024 at 03:11 AM
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
  `storage_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `local_storage`
--

INSERT INTO `local_storage` (`id`, `storage_key`, `storage_value`) VALUES
(1, 'pinPositions', '[{\"pinId\":\"pin-1731904986149\",\"top\":\"264px\",\"left\":\"785px\",\"imgSrc\":null}]'),
(2, 'pinPositions', '[{\"pinId\":\"pin-1731904986149\",\"top\":\"264px\",\"left\":\"785px\",\"imgSrc\":\"http://localhost:3000/null\"},{\"pinId\":\"pin-1731931944278\",\"top\":\"168px\",\"left\":\"451px\",\"imgSrc\":\"http://localhost:3000/null\"},{\"pinId\":\"pin-1731932061102\",\"top\":\"224px\",\"left\":\"1087px\",\"imgSrc\":null}]'),
(3, 'pinPositions', '[{\"pinId\":\"pin-1732201404587\",\"top\":\"290px\",\"left\":\"790px\",\"imgSrc\":\"http://localhost:3000/null\"},{\"pinId\":\"pin-1732201628235\",\"top\":\"8px\",\"left\":\"940px\",\"imgSrc\":\"http://localhost:3000/null\"},{\"pinId\":\"pin-1732203613475\",\"top\":\"216px\",\"left\":\"1087px\",\"imgSrc\":null}]'),
(4, 'pinPositions', '[{\"pinId\":\"pin-1732201404587\",\"top\":\"290px\",\"left\":\"790px\",\"imgSrc\":\"http://localhost:3000/null\"},{\"pinId\":\"pin-1732201628235\",\"top\":\"8px\",\"left\":\"940px\",\"imgSrc\":\"http://localhost:3000/null\"},{\"pinId\":\"pin-1732203613475\",\"top\":\"216px\",\"left\":\"1087px\",\"imgSrc\":null}]'),
(5, 'pinPositions', '[{\"pinId\":\"pin-1732290244244\",\"top\":\"217px\",\"left\":\"775px\",\"imgSrc\":\"img/Caution_shadow.png\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `pins`
--

CREATE TABLE `pins` (
  `id` int(11) NOT NULL,
  `pin_id` varchar(255) NOT NULL,
  `top` varchar(50) NOT NULL,
  `left` varchar(50) NOT NULL,
  `img_src` varchar(255) NOT NULL,
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
  `details` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'default-pp.png',
  `date` date NOT NULL,
  `uid` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`id`, `user`, `title`, `details`, `type`, `image`, `date`, `uid`) VALUES
(1, 'daenerys targaryen', 'testing ', '            1', 'Hazard', 'default-pp.png', '2024-12-08', 66862195),
(2, 'daenerys targaryen', '5', '            5', 'Hazard', 'default-pp.png', '2024-12-08', 66862195),
(3, 'daenerys targaryen', '6', '            6', 'Request', 'default-pp.png', '2024-12-09', 66862195),
(4, 'daenerys targaryen', '8', '                            8', 'Request', 'default-pp.png', '2024-12-09', 66862195),
(5, 'daenerys targaryen', 'walang sabon', '                            wwww', 'Electrical Hazard', 'default-pp.png', '2024-12-09', 66862195),
(6, 'daenerys targaryen', 'u', '                            u', 'Cleaning', 'default-pp.png', '2024-12-09', 66862195),
(7, 'daenerys targaryen', 'u', '                            u', 'Cleaning', 'default-pp.png', '2024-12-09', 66862195),
(8, 'daenerys targaryen', 'u', '                            u', 'Cleaning', 'default-pp.png', '2024-12-09', 66862195),
(9, 'jhewen shene', 'nakita ko si dean', 'scary', 'Hazard', 'default-pp.png', '2024-12-09', 87850305);

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
  `role` enum('student','admin') NOT NULL,
  `uid` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `email`, `password`, `role`, `uid`) VALUES
(1, 'test', 'test', 'test@gmail.com', '$2y$10$OPE6pGMDmlmkQnTTWen8jevvyFXJ9e72x1F74vCgQtJ.Xextm5V06', 'student', 0),
(2, 'Lavinia Robles', 'Megan Hart', 'dotop@mailinator.com', '$2y$10$HOL/1U2rp/8oy/uAgrc4euNsNqotb1vMxMu0Sx6sugEII1avQ8ZxW', 'student', 16426406),
(3, 'Yardley Franklin', 'Wylie Strickland', 'zoxomezupa@mailinator.com', '$2y$10$kxdxoILE23ahQXa/8n.MXuY5ZT7xs/LlSHE8RU94Ei4gsZNRtvhNi', 'admin', 13276805),
(4, 'Michael Hurst', 'Florence Ballard', 'hozusymow@mailinator.com', '$2y$10$fjG0pRwl.ueCcXaQ2r3rdOOFMCLMUj8w73QDvD.cABfREEjaPOsj.', 'student', 41214463),
(5, 'Kevin Bryant', 'Miranda Weaver', 'nuxequ@mailinator.com', '$2y$10$5x6nDqVZaYDFuiP.ASE6Weg5/Hjz8NE2h1BDkTaWMBeGyP50BJYnq', 'admin', NULL),
(6, 'daenerys', 'targaryen', 'rypipunesy@mailinator.com', '$2y$10$xIw1iXK61Njq47eirw5TQuQtoc2a.zG54.U0gqQARTLCR01TavEza', 'student', 66862195),
(7, 'Mollie Mcpherson', 'Cassandra Noble', 'keqyrolec@mailinator.com', '$2y$10$Z9QREkbpkvDtZab.qoIVXenUk24rqq25HLLbWG.uvandfXSgSWCm6', 'admin', NULL),
(8, 'Grace Cline', 'Ori Sims', 'lesones@mailinator.com', '$2y$10$3AMgMCCVR2XMax3iClh97eKnsm1593k7ByGIXMEgxm1d0HOVjd1U.', 'admin', NULL),
(9, 'jhewen', 'shene', 'js@gmail.com', '$2y$10$MZBLag/bCQDw5CzNe4X6auVEAFcu3O2d3LhxK3T7UjpVvgdS9cs72', 'student', 87850305);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `local_storage`
--
ALTER TABLE `local_storage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pins`
--
ALTER TABLE `pins`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pins`
--
ALTER TABLE `pins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
