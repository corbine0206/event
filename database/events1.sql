-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2023 at 01:20 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `event_title` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_status` int(11) NOT NULL COMMENT '0 = deleted\r\n1 = active\r\n2 = already answer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_title`, `user_id`, `event_status`) VALUES
(1, 'sample title', 1, 2),
(2, 'sample title', 1, 1),
(3, 'title', 1, 1),
(4, 'Sales Mastery', 1, 1),
(5, 'sample title', 1, 1),
(6, 'event title', 1, 2),
(7, '1', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `event_sessions`
--

CREATE TABLE `event_sessions` (
  `session_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `session_title` varchar(255) NOT NULL,
  `date1` varchar(10) NOT NULL,
  `time1` varchar(10) NOT NULL,
  `time2` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_sessions`
--

INSERT INTO `event_sessions` (`session_id`, `event_id`, `session_title`, `date1`, `time1`, `time2`) VALUES
(1, 1, 'session 1', '2023-09-01', '06:00', '13:00'),
(2, 2, 'session 1', '2023-09-01', '06:00', '13:00'),
(3, 3, 'session 1', '2023-09-02', '06:00', '13:00'),
(4, 4, 'From Pipeline in Peril to Sales Success: Besting PAN at De La Rue', '2023-09-01', '06:00', '13:00'),
(5, 4, 'Power of the Platform: The Key to Retiring More RSW', '2023-09-30', '06:00', '13:00'),
(6, 4, 'Compete to Win in the Margin: Edging Out Juniper/Mist at LaRoche', '2023-10-07', '06:00', '13:00'),
(7, 5, 'session 1', '2023-09-01', '06:00', '13:00'),
(8, 6, 'session 1', '2023-09-01', '06:00', '13:00'),
(9, 6, 'session 2', '2023-09-01', '06:00', '13:00'),
(10, 7, '', '2023-08-31', '06:00', '13:00');

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `participants_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0 = pending\r\n1 = answered\r\n2 = deleted event'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`participants_id`, `event_id`, `email`, `status`) VALUES
(1, 6, 'corbine.santos0206@gmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_technology_lines`
--

CREATE TABLE `product_technology_lines` (
  `product_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `technology_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `technology_line` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_technology_lines`
--

INSERT INTO `product_technology_lines` (`product_id`, `event_id`, `session_id`, `technology_id`, `product_name`, `technology_line`) VALUES
(1, 1, 1, 1, 'product 1', 'tech line 1'),
(2, 1, 1, 1, 'product 2', 'tech line 12'),
(3, 1, 1, 2, '21', '21'),
(4, 1, 1, 2, '22', '22'),
(5, 1, 1, 2, '23', '23'),
(6, 1, 1, 3, '31', '31'),
(7, 1, 1, 3, '32', '32'),
(8, 1, 1, 4, '41', '41'),
(9, 1, 1, 4, '42', '42'),
(10, 1, 1, 4, '43', '43'),
(11, 2, 2, 5, 'product 1', 'tech'),
(12, 3, 3, 6, 'product 1', 'tech'),
(13, 4, 4, 7, 'XDR', 'Cloud Security'),
(14, 4, 4, 8, 'Palo Alto', 'Customer Install Base'),
(15, 4, 4, 9, 'Source Fire', 'Network Security'),
(16, 4, 4, 10, 'Viptella', 'SD-WAN'),
(17, 4, 4, 11, 'ACI', 'Data Center Network'),
(18, 4, 4, 11, 'Nexus Dashboard', 'Data Center Network SW'),
(19, 4, 5, 12, 'Nexus', 'Data Center Network'),
(20, 4, 5, 12, 'Nexus Dashboard', 'Data Center Network SW'),
(21, 4, 5, 12, 'Nexus Insights', 'Data Center Network SW'),
(22, 4, 6, 13, 'Third party', 'IOT - Sensors'),
(23, 4, 6, 13, 'UCS', 'Data Center Server'),
(24, 4, 6, 13, 'Intersight ', 'Data Center Server SW'),
(25, 6, 8, 14, 'product 1', 'tech line 1'),
(26, 6, 8, 14, 'product 2', 'technology 2'),
(27, 6, 8, 15, 'product 1 tech 2', 'tech 1 tech 2'),
(28, 6, 9, 16, 'technology 2', 'technology 2');

-- --------------------------------------------------------

--
-- Table structure for table `response`
--

CREATE TABLE `response` (
  `reponse_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `technology_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `response` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `technologies`
--

CREATE TABLE `technologies` (
  `technology_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `technology_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `technologies`
--

INSERT INTO `technologies` (`technology_id`, `event_id`, `session_id`, `technology_name`) VALUES
(1, 1, 1, 'technology'),
(2, 1, 1, 'technology 2'),
(3, 1, 1, 'technolog 3'),
(4, 1, 1, 'technology 4'),
(5, 2, 2, 'technology 1'),
(6, 3, 3, 'tech'),
(7, 4, 4, 'Cloud Security'),
(8, 4, 4, 'Customer Install Base'),
(9, 4, 4, 'Security'),
(10, 4, 4, 'Enterprise Networking and Software'),
(11, 4, 4, 'Cloud Infrastructure and Software'),
(12, 4, 5, 'Cloud Infrastructure and Software'),
(13, 4, 6, 'IOT'),
(14, 6, 8, 'technology'),
(15, 6, 8, 'technology 2'),
(16, 6, 9, 'tech1 for session 2');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0 = inactive\r\n1 = active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `status`) VALUES
(1, 'email@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 1),
(2, 'testeraccount1@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 1),
(3, 'testeraccount2@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `event_sessions`
--
ALTER TABLE `event_sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`participants_id`);

--
-- Indexes for table `product_technology_lines`
--
ALTER TABLE `product_technology_lines`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `response`
--
ALTER TABLE `response`
  ADD PRIMARY KEY (`reponse_id`);

--
-- Indexes for table `technologies`
--
ALTER TABLE `technologies`
  ADD PRIMARY KEY (`technology_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `event_sessions`
--
ALTER TABLE `event_sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `participants_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_technology_lines`
--
ALTER TABLE `product_technology_lines`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `response`
--
ALTER TABLE `response`
  MODIFY `reponse_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `technologies`
--
ALTER TABLE `technologies`
  MODIFY `technology_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
