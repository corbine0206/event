-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2023 at 12:53 PM
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
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `dateIn` varchar(255) NOT NULL,
  `timeIn` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `suggestion` text NOT NULL,
  `similar_event` text NOT NULL,
  `event_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'new event', 1, 2);

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
(1, 1, 'From Pipeline in Peril to Sales Success: Besting PAN at De La Rue', '2023-10-11', '08:00', '19:00'),
(2, 1, 'Power of the Platform: The Key to Retiring More RSW', '2023-10-12', '09:00', '14:00'),
(3, 1, 'Compete to Win in the Margin: Edging Out Juniper/Mist at LaRoche', '2023-10-13', '08:00', '15:00'),
(4, 1, 'Compete to Win in the Margin: Edging Out Juniper/Mist at LaRoche', '2023-10-15', '10:00', '13:00');

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
(1, 1, 'corbine.santos0206@gmail.com', 1),
(2, 1, 'Aljonlayson21@gmail.com', 1),
(3, 1, 'santos.johncorbine.s.020698@gmail.com', 0);

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
(1, 1, 1, 1, 'Network Security ', 'Infrastrucutre Security'),
(2, 1, 1, 2, 'Firewalls and Security Appliances', 'Customer Install Base'),
(3, 1, 1, 3, 'SD-WAN', 'Networking Hardware'),
(4, 1, 2, 4, 'Data Center Networking', 'Data Center and Cloud'),
(5, 1, 2, 4, 'Software-Defined Networking(SDN)', 'Software Management'),
(6, 1, 2, 5, 'Network Management', 'Software Management'),
(7, 1, 4, 6, 'Firewalls and Security Appliances', 'Customer Install Base'),
(8, 1, 4, 7, 'Data Center Networking', 'Data Center and Cloud'),
(9, 1, 4, 8, 'Switches', 'Network Security');

-- --------------------------------------------------------

--
-- Table structure for table `recommendation`
--

CREATE TABLE `recommendation` (
  `recommend_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

--
-- Dumping data for table `response`
--

INSERT INTO `response` (`reponse_id`, `event_id`, `email`, `product_id`, `technology_id`, `session_id`, `response`) VALUES
(1, 1, 'corbine.santos0206@gmail.com', 1, 1, 1, 'Infrastrucutre Security'),
(2, 1, 'corbine.santos0206@gmail.com', 4, 4, 2, 'Data Center and Cloud'),
(3, 1, 'corbine.santos0206@gmail.com', 7, 6, 4, 'Customer Install Base'),
(4, 1, 'Aljonlayson21@gmail.com', 1, 1, 1, 'Infrastrucutre Security'),
(5, 1, 'Aljonlayson21@gmail.com', 5, 4, 2, 'Software Management'),
(6, 1, 'Aljonlayson21@gmail.com', 9, 8, 4, 'Network Security'),
(7, 1, 'Aljonlayson21@gmail.com', 1, 1, 1, 'Infrastrucutre Security'),
(8, 1, 'Aljonlayson21@gmail.com', 5, 4, 2, 'Software Management'),
(9, 1, 'Aljonlayson21@gmail.com', 9, 8, 4, 'Network Security');

-- --------------------------------------------------------

--
-- Table structure for table `survey`
--

CREATE TABLE `survey` (
  `survey_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `survey_technologies`
--

CREATE TABLE `survey_technologies` (
  `survey_tech_id` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL,
  `technology_id` int(11) NOT NULL
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
(1, 1, 1, 'Security'),
(2, 1, 1, ' Competitive Intelligence'),
(3, 1, 1, 'Enterprise Networking'),
(4, 1, 2, 'Cloud Infrastructure'),
(5, 1, 2, 'Recurring Softwares'),
(6, 1, 4, 'Competitive Intelligence'),
(7, 1, 4, 'Cloud Infrastructure'),
(8, 1, 4, 'Enterprise Networking');

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
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`);

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
-- Indexes for table `recommendation`
--
ALTER TABLE `recommendation`
  ADD PRIMARY KEY (`recommend_id`);

--
-- Indexes for table `response`
--
ALTER TABLE `response`
  ADD PRIMARY KEY (`reponse_id`);

--
-- Indexes for table `survey`
--
ALTER TABLE `survey`
  ADD PRIMARY KEY (`survey_id`);

--
-- Indexes for table `survey_technologies`
--
ALTER TABLE `survey_technologies`
  ADD PRIMARY KEY (`survey_tech_id`);

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
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `event_sessions`
--
ALTER TABLE `event_sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `participants_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_technology_lines`
--
ALTER TABLE `product_technology_lines`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `recommendation`
--
ALTER TABLE `recommendation`
  MODIFY `recommend_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `response`
--
ALTER TABLE `response`
  MODIFY `reponse_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `survey`
--
ALTER TABLE `survey`
  MODIFY `survey_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `survey_technologies`
--
ALTER TABLE `survey_technologies`
  MODIFY `survey_tech_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `technologies`
--
ALTER TABLE `technologies`
  MODIFY `technology_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
