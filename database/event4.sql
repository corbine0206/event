-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2023 at 02:46 PM
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
  `event_status` int(11) NOT NULL COMMENT '0 = deleted\r\n1 = active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_title`, `user_id`, `event_status`) VALUES
(1, 'sample title', 1, 0),
(2, 'sample title', 1, 0),
(3, 'sample', 0, 0),
(4, 'my event title', 0, 0),
(5, 'sample title', 0, 0),
(6, 'sample title11', 0, 0),
(7, 'sample title11', 0, 0),
(8, 'sample title11', 0, 0),
(9, 'sample title', 0, 0),
(10, 'sample title', 0, 0),
(11, 'sample title', 0, 0),
(12, 'sample title', 0, 0),
(13, 'sample title', 0, 0),
(14, 'sample title', 1, 0),
(15, 'new event', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `event_sessions`
--

CREATE TABLE `event_sessions` (
  `session_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `session_title` varchar(255) NOT NULL,
  `date1` varchar(10) NOT NULL,
  `time1` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_sessions`
--

INSERT INTO `event_sessions` (`session_id`, `event_id`, `session_title`, `date1`, `time1`) VALUES
(1, 1, 'session 1', '2023-08-31', '06:00:00'),
(2, 3, 'session 1', '2023-09-01', '06:00:00'),
(3, 3, 'session 2', '2023-01-01', '06:00:00'),
(4, 4, 'session 1', '2023-09-01', '06:00:00'),
(5, 5, 'session 1', '2023-09-01', '06:00:00'),
(6, 6, 'session 1', '2023-08-31', '06:00:00'),
(7, 7, 'session 1', '2023-08-31', '06:00:00'),
(8, 9, 'session 1', '2023-09-01', '06:00:00'),
(9, 10, 'session 1', '2023-09-07', '06:00:00'),
(10, 11, 'session 1', '2023-09-07', '06:00:00'),
(11, 15, 'new session', '2023-08-31', '06:00:00'),
(12, 15, 'session 2', '2023-10-06', '06:00:00'),
(13, 15, 'session 3', '2023-09-30', '06:00:00'),
(14, 15, 'session 4', '2023-10-07', '06:00:00'),
(15, 15, 'session 5', '2023-09-02', '06:00:00');

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
(1, 15, 'corbine.santos0206@gmail.com', 0);

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
(2, 3, 2, 2, 'product', 'tech'),
(3, 3, 3, 3, 'product', 'tech lne'),
(4, 4, 4, 4, 'product 1', 'tech line 1'),
(5, 4, 4, 4, 'product 2', 'tech line 3'),
(6, 4, 4, 4, 'product 3', 'tech line 2'),
(7, 4, 4, 5, 'product 1 for tech 2', 'tech 1 for tech 2'),
(8, 4, 4, 5, 'product 2 for tech 2', 'tech 2 for tech 2'),
(9, 15, 11, 6, 'product 1', 'technology 1'),
(10, 15, 11, 6, '3', '4'),
(11, 15, 11, 6, '2', '2'),
(12, 15, 12, 7, 'prod 1', 'tech 1'),
(13, 15, 12, 7, 'prod 2', 'tech 2'),
(14, 15, 12, 7, 'prod 3', 'tech 3'),
(15, 15, 13, 8, 'my product 1', 'my technology 1'),
(16, 15, 13, 8, 'my product 2', 'my technology 2'),
(17, 15, 13, 8, 'my product 3', 'my technology 3'),
(18, 15, 13, 8, 'my product 4', 'my technology 4'),
(19, 15, 14, 9, 'your product1', 'your techline 1'),
(20, 15, 14, 9, 'your product2', 'your techline 2'),
(21, 15, 15, 10, 'our product 1', 'our techline 1'),
(22, 15, 15, 10, 'our product 2', 'our techline 2');

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
(2, 3, 2, 'samle'),
(3, 3, 3, 'tech'),
(4, 4, 4, 'technology'),
(5, 4, 4, 'technology 2'),
(6, 15, 11, 'technology'),
(7, 15, 12, 'technology 2'),
(8, 15, 13, 'techy 1'),
(9, 15, 14, 'your technology'),
(10, 15, 15, 'our technology');

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
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`participants_id`);

--
-- Indexes for table `product_technology_lines`
--
ALTER TABLE `product_technology_lines`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `technology_id` (`technology_id`);

--
-- Indexes for table `technologies`
--
ALTER TABLE `technologies`
  ADD PRIMARY KEY (`technology_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `session_id` (`session_id`);

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
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `event_sessions`
--
ALTER TABLE `event_sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `participants_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_technology_lines`
--
ALTER TABLE `product_technology_lines`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `technologies`
--
ALTER TABLE `technologies`
  MODIFY `technology_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_sessions`
--
ALTER TABLE `event_sessions`
  ADD CONSTRAINT `event_sessions_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`);

--
-- Constraints for table `product_technology_lines`
--
ALTER TABLE `product_technology_lines`
  ADD CONSTRAINT `product_technology_lines_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  ADD CONSTRAINT `product_technology_lines_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `event_sessions` (`session_id`),
  ADD CONSTRAINT `product_technology_lines_ibfk_3` FOREIGN KEY (`technology_id`) REFERENCES `technologies` (`technology_id`);

--
-- Constraints for table `technologies`
--
ALTER TABLE `technologies`
  ADD CONSTRAINT `technologies_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  ADD CONSTRAINT `technologies_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `event_sessions` (`session_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
