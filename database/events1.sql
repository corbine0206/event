-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2023 at 09:56 AM
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

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `event_id`, `session_id`, `email`, `dateIn`, `timeIn`) VALUES
(1, 8, 11, 'corbine.santos0206@gmail.com', '2023-10-05', '02:56:16'),
(2, 8, 12, 'corbine.santos0206@gmail.com', '2023-10-05', '02:56:24'),
(3, 8, 13, 'corbine.santos0206@gmail.com', '2023-10-05', '02:56:32');

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

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `comment`, `suggestion`, `similar_event`, `event_id`, `email`) VALUES
(1, 'comment', 'suggestion', 'yes? yes', 8, 'corbine.santos0206@gmail.com'),
(2, 'comment', 'suggestion', 'yes? yes', 8, 'corbine.santos0206@gmail.com'),
(3, 'a', 'a', 'a', 8, 'corbine.santos0206@gmail.com'),
(4, 'a', 'a', 'a', 8, 'corbine.santos0206@gmail.com'),
(5, 'a', 'a', 'a', 8, 'corbine.santos0206@gmail.com'),
(6, 'a', 'a', 'a', 8, 'corbine.santos0206@gmail.com'),
(7, 'a', 'a', 'a', 8, 'corbine.santos0206@gmail.com'),
(8, 'a', 'a', 'a', 8, 'corbine.santos0206@gmail.com'),
(9, 'a', 'a', 'a', 8, 'corbine.santos0206@gmail.com'),
(10, 'a', 'a', 'a', 8, 'corbine.santos0206@gmail.com'),
(11, 'a', 'a', 'a', 8, 'corbine.santos0206@gmail.com'),
(12, 'a', 'a', 'a', 8, 'corbine.santos0206@gmail.com'),
(13, 'a', 'a', 'a', 8, 'corbine.santos0206@gmail.com'),
(14, 'a', 'a', 'a', 8, 'corbine.santos0206@gmail.com'),
(15, 'a', 'a', 'a', 8, 'corbine.santos0206@gmail.com'),
(16, 'a', 'a', 'a', 8, 'corbine.santos0206@gmail.com'),
(17, 'a', 'a', 'a', 8, 'corbine.santos0206@gmail.com'),
(18, 'coment', 'sug', 'yes', 8, 'corbine.santos0206@gmail.com');

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
(7, '1', 1, 1),
(8, 'event title', 1, 2),
(9, 'SAMPLE EVENT', 1, 1),
(10, 'SAMPLE EVENT', 1, 1);

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
(10, 7, '', '2023-08-31', '06:00', '13:00'),
(11, 8, 'session 1', '2023-09-01', '06:00', '13:00'),
(12, 8, 'session 2', '2023-09-02', '06:00', '13:00'),
(13, 8, 'she', '2023-11-15', '06:00', '13:00');

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
(1, 6, 'corbine.santos0206@gmail.com', 0),
(2, 8, 'Aljonlayson21@gmail.com', 0),
(3, 8, 'santos.johncorbine.s.020698@gmail.com', 0),
(4, 8, 'corbine.santos0206@gmail.com', 1),
(5, 9, 'Aljonlayson21@gmail.com', 0),
(6, 9, 'santos.johncorbine.s.020698@gmail.com', 0),
(7, 9, 'corbine.santos0206@gmail.com', 0),
(8, 10, 'Aljonlayson21@gmail.com', 0),
(9, 10, 'santos.johncorbine.s.020698@gmail.com', 0),
(10, 10, 'corbine.santos0206@gmail.com', 0);

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
(28, 6, 9, 16, 'technology 2', 'technology 2'),
(29, 8, 11, 17, 'product 1', 'tech line 1'),
(30, 8, 11, 17, 'product 2', 'tech line 2'),
(31, 8, 11, 17, 'product 3', 'tech line 3'),
(32, 8, 11, 17, 'product 4', 'tech line 4'),
(33, 8, 11, 18, 'product 1 tech 2', 'tech 1 for tech 2'),
(34, 8, 11, 18, 'product 2 technology 2', 'techline 2 for technology 2'),
(35, 8, 12, 19, 'My product 1', 'My technology 1'),
(36, 8, 12, 19, 'My product 2', 'My technlogy line 2'),
(37, 8, 12, 20, 'You product 1', 'You technology line 1'),
(38, 8, 12, 20, 'You product 2', 'You Technology line 2'),
(39, 8, 13, 21, 'she product 1', 'she tech line 1'),
(40, 8, 13, 21, 'she product 2', 'she tech line 2');

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

--
-- Dumping data for table `recommendation`
--

INSERT INTO `recommendation` (`recommend_id`, `event_id`, `session_id`, `email`) VALUES
(1, 8, 11, 'corbine.santos0206@gmail.com'),
(2, 8, 12, 'corbine.santos0206@gmail.com'),
(3, 8, 11, 'corbine.santos0206@gmail.com'),
(4, 8, 12, 'corbine.santos0206@gmail.com'),
(5, 8, 11, 'corbine.santos0206@gmail.com'),
(6, 8, 12, 'corbine.santos0206@gmail.com'),
(7, 8, 11, 'corbine.santos0206@gmail.com'),
(8, 8, 12, 'corbine.santos0206@gmail.com');

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
(1, 8, 'corbine.santos0206@gmail.com', 29, 17, 11, 'tech line 1'),
(2, 8, 'corbine.santos0206@gmail.com', 34, 18, 11, 'techline 2 for technology 2'),
(3, 8, 'corbine.santos0206@gmail.com', 36, 19, 12, 'My technlogy line 2'),
(4, 8, 'corbine.santos0206@gmail.com', 30, 17, 11, 'tech line 2'),
(5, 8, 'corbine.santos0206@gmail.com', 34, 18, 11, 'techline 2 for technology 2'),
(6, 8, 'corbine.santos0206@gmail.com', 35, 19, 12, 'My technology 1'),
(7, 8, 'corbine.santos0206@gmail.com', 31, 17, 11, 'tech line 3'),
(8, 8, 'corbine.santos0206@gmail.com', 34, 18, 11, 'techline 2 for technology 2'),
(9, 8, 'corbine.santos0206@gmail.com', 35, 19, 12, 'My technology 1'),
(10, 8, 'corbine.santos0206@gmail.com', 30, 17, 11, 'tech line 2'),
(11, 8, 'corbine.santos0206@gmail.com', 33, 18, 11, 'tech 1 for tech 2'),
(12, 8, 'corbine.santos0206@gmail.com', 35, 19, 12, 'My technology 1'),
(13, 8, 'santos.johncorbine.s.020698@gmail.com', 34, 18, 11, 'techline 2 for technology 2'),
(14, 8, 'santos.johncorbine.s.020698@gmail.com', 36, 19, 12, 'My technlogy line 2'),
(15, 8, 'santos.johncorbine.s.020698@gmail.com', 38, 20, 12, 'You Technology line 2'),
(16, 6, 'corbine.santos0206@gmail.com', 26, 14, 8, 'technology 2'),
(17, 6, 'corbine.santos0206@gmail.com', 27, 15, 8, 'tech 1 tech 2'),
(18, 6, 'corbine.santos0206@gmail.com', 28, 16, 9, 'technology 2'),
(19, 8, 'corbine.santos0206@gmail.com', 29, 17, 11, 'tech line 1'),
(20, 8, 'corbine.santos0206@gmail.com', 33, 18, 11, 'tech 1 for tech 2'),
(21, 8, 'corbine.santos0206@gmail.com', 35, 19, 12, 'My technology 1'),
(22, 8, 'corbine.santos0206@gmail.com', 30, 17, 11, 'tech line 2'),
(23, 8, 'corbine.santos0206@gmail.com', 33, 18, 11, 'tech 1 for tech 2'),
(24, 8, 'corbine.santos0206@gmail.com', 35, 19, 12, 'My technology 1'),
(25, 8, 'corbine.santos0206@gmail.com', 30, 17, 11, 'tech line 2'),
(26, 8, 'corbine.santos0206@gmail.com', 33, 18, 11, 'tech 1 for tech 2'),
(27, 8, 'corbine.santos0206@gmail.com', 35, 19, 12, 'My technology 1'),
(28, 8, 'corbine.santos0206@gmail.com', 31, 17, 11, 'tech line 3'),
(29, 8, 'corbine.santos0206@gmail.com', 33, 18, 11, 'tech 1 for tech 2'),
(30, 8, 'corbine.santos0206@gmail.com', 35, 19, 12, 'My technology 1'),
(31, 8, 'corbine.santos0206@gmail.com', 29, 17, 11, 'tech line 1'),
(32, 8, 'corbine.santos0206@gmail.com', 33, 18, 11, 'tech 1 for tech 2'),
(33, 8, 'corbine.santos0206@gmail.com', 36, 19, 12, 'My technlogy line 2'),
(34, 8, 'corbine.santos0206@gmail.com', 29, 17, 11, 'tech line 1'),
(35, 8, 'corbine.santos0206@gmail.com', 33, 18, 11, 'tech 1 for tech 2'),
(36, 8, 'corbine.santos0206@gmail.com', 35, 19, 12, 'My technology 1'),
(37, 8, 'corbine.santos0206@gmail.com', 29, 17, 11, 'tech line 1'),
(38, 8, 'corbine.santos0206@gmail.com', 33, 18, 11, 'tech 1 for tech 2'),
(39, 8, 'corbine.santos0206@gmail.com', 35, 19, 12, 'My technology 1'),
(40, 8, 'corbine.santos0206@gmail.com', 29, 17, 11, 'tech line 1'),
(41, 8, 'corbine.santos0206@gmail.com', 33, 18, 11, 'tech 1 for tech 2'),
(42, 8, 'corbine.santos0206@gmail.com', 35, 19, 12, 'My technology 1'),
(43, 8, 'corbine.santos0206@gmail.com', 29, 17, 11, 'tech line 1'),
(44, 8, 'corbine.santos0206@gmail.com', 33, 18, 11, 'tech 1 for tech 2'),
(45, 8, 'corbine.santos0206@gmail.com', 35, 19, 12, 'My technology 1'),
(46, 8, 'corbine.santos0206@gmail.com', 29, 17, 11, 'tech line 1'),
(47, 8, 'corbine.santos0206@gmail.com', 33, 18, 11, 'tech 1 for tech 2'),
(48, 8, 'corbine.santos0206@gmail.com', 35, 19, 12, 'My technology 1'),
(49, 8, 'corbine.santos0206@gmail.com', 29, 17, 11, 'tech line 1'),
(50, 8, 'corbine.santos0206@gmail.com', 33, 18, 11, 'tech 1 for tech 2'),
(51, 8, 'corbine.santos0206@gmail.com', 37, 20, 12, 'You technology line 1'),
(52, 8, 'corbine.santos0206@gmail.com', 29, 17, 11, 'tech line 1'),
(53, 8, 'corbine.santos0206@gmail.com', 33, 18, 11, 'tech 1 for tech 2'),
(54, 8, 'corbine.santos0206@gmail.com', 35, 19, 12, 'My technology 1'),
(55, 8, 'corbine.santos0206@gmail.com', 29, 17, 11, 'tech line 1'),
(56, 8, 'corbine.santos0206@gmail.com', 33, 18, 11, 'tech 1 for tech 2'),
(57, 8, 'corbine.santos0206@gmail.com', 35, 19, 12, 'My technology 1'),
(58, 8, 'corbine.santos0206@gmail.com', 31, 17, 11, 'tech line 3'),
(59, 8, 'corbine.santos0206@gmail.com', 37, 20, 12, 'You technology line 1'),
(60, 8, 'corbine.santos0206@gmail.com', 39, 21, 13, 'she tech line 1'),
(61, 8, 'corbine.santos0206@gmail.com', 30, 17, 11, 'tech line 2'),
(62, 8, 'corbine.santos0206@gmail.com', 33, 18, 11, 'tech 1 for tech 2'),
(63, 8, 'corbine.santos0206@gmail.com', 36, 19, 12, 'My technlogy line 2');

-- --------------------------------------------------------

--
-- Table structure for table `survey`
--

CREATE TABLE `survey` (
  `survey_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `survey`
--

INSERT INTO `survey` (`survey_id`, `comment_id`, `session_id`) VALUES
(1, 1, 11),
(2, 2, 11),
(3, 2, 12),
(4, 3, 11),
(5, 3, 12),
(6, 4, 11),
(7, 4, 12),
(8, 5, 11),
(9, 5, 12),
(10, 6, 11),
(11, 6, 12),
(12, 7, 11),
(13, 7, 12),
(14, 8, 11),
(15, 8, 12),
(16, 9, 11),
(17, 9, 12),
(18, 10, 11),
(19, 10, 12),
(20, 11, 11),
(21, 11, 12),
(22, 12, 11),
(23, 12, 12),
(24, 13, 11),
(25, 13, 12),
(26, 14, 11),
(27, 14, 12),
(28, 15, 11),
(29, 15, 12),
(30, 16, 11),
(31, 16, 12),
(32, 17, 11),
(33, 18, 11),
(34, 18, 12),
(35, 18, 13);

-- --------------------------------------------------------

--
-- Table structure for table `survey_technologies`
--

CREATE TABLE `survey_technologies` (
  `survey_tech_id` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL,
  `technology_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `survey_technologies`
--

INSERT INTO `survey_technologies` (`survey_tech_id`, `survey_id`, `technology_id`) VALUES
(1, 33, 17),
(2, 34, 19),
(3, 35, 21);

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
(16, 6, 9, 'tech1 for session 2'),
(17, 8, 11, 'technology'),
(18, 8, 11, 'technology 2'),
(19, 8, 12, 'My technology 1 for session 2'),
(20, 8, 12, 'You Technology'),
(21, 8, 13, 'she technology');

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
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `event_sessions`
--
ALTER TABLE `event_sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `participants_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_technology_lines`
--
ALTER TABLE `product_technology_lines`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `recommendation`
--
ALTER TABLE `recommendation`
  MODIFY `recommend_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `response`
--
ALTER TABLE `response`
  MODIFY `reponse_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `survey`
--
ALTER TABLE `survey`
  MODIFY `survey_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `survey_technologies`
--
ALTER TABLE `survey_technologies`
  MODIFY `survey_tech_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `technologies`
--
ALTER TABLE `technologies`
  MODIFY `technology_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
