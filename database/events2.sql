-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 14, 2023 at 08:56 AM
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
-- Database: `events`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `event_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_title`) VALUES
(1, 'title1'),
(2, 'title'),
(3, 'sample title'),
(4, 'a'),
(5, 'a'),
(6, 'a'),
(7, 'a'),
(8, 'a'),
(9, 'a'),
(10, 'a'),
(11, 'a'),
(12, 'a'),
(13, 'a'),
(14, 'a'),
(15, 'a'),
(16, 'a'),
(17, 'a'),
(18, 'a'),
(19, 'a'),
(20, 'a'),
(21, 'a'),
(22, 'a');

-- --------------------------------------------------------

--
-- Table structure for table `participats`
--

CREATE TABLE `participats` (
  `participants_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0 = false\r\n1 = true'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `participats`
--

INSERT INTO `participats` (`participants_id`, `event_id`, `email`, `status`) VALUES
(1, 22, 'corbine.santos0206@gmail.com', 0),
(2, 22, 'santos.johncorbine.s.020698@gmail.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `subtopics`
--

CREATE TABLE `subtopics` (
  `subtopic_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `subtopic_title` varchar(255) NOT NULL,
  `product` varchar(255) NOT NULL,
  `date1` varchar(255) NOT NULL,
  `time1` varchar(255) NOT NULL,
  `technology_line` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subtopics`
--

INSERT INTO `subtopics` (`subtopic_id`, `event_id`, `topic_id`, `subtopic_title`, `product`, `date1`, `time1`, `technology_line`) VALUES
(1, 0, 1, 'sub topic', 'product 1', '', '', 'tech line'),
(2, 0, 1, 'sub topic 2', 'product 2', '', '', 'tech line 2'),
(3, 0, 1, 'sub 1 topic 2', 'product 1 topic 2', '', '', 'tech 1 topic 2'),
(4, 0, 1, 'sub 2 topic 2', 'product 2 topic 2', '', '', 'tech 2 topic 2'),
(5, 0, 2, 'sub topic', 'product 1', '', '', 'tech line'),
(6, 0, 2, 'sub topic 2', 'product 2', '', '', 'tech line 2'),
(7, 0, 2, 'sub 1 topic 2', 'product 1 topic 2', '', '', 'tech 1 topic 2'),
(8, 0, 2, 'sub 2 topic 2', 'product 2 topic 2', '', '', 'tech 2 topic 2'),
(9, 2, 3, 'sub', '1', '11111-01-20', '06:00', 'tech line'),
(10, 3, 4, 'sub', 'product 1', '2023-09-07', '06:00', 'tech line'),
(11, 4, 5, 'sub', 'product 1', '2023-09-06', '06:00', 'tech line');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `topic_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `topic_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`topic_id`, `event_id`, `topic_title`) VALUES
(1, 1, 'main topic'),
(2, 1, 'topic 2'),
(3, 2, 'tpic'),
(4, 3, 'topic'),
(5, 4, 'topic');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `participats`
--
ALTER TABLE `participats`
  ADD PRIMARY KEY (`participants_id`);

--
-- Indexes for table `subtopics`
--
ALTER TABLE `subtopics`
  ADD PRIMARY KEY (`subtopic_id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`topic_id`),
  ADD KEY `event_id` (`event_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `participats`
--
ALTER TABLE `participats`
  MODIFY `participants_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subtopics`
--
ALTER TABLE `subtopics`
  MODIFY `subtopic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subtopics`
--
ALTER TABLE `subtopics`
  ADD CONSTRAINT `subtopics_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`topic_id`);

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
