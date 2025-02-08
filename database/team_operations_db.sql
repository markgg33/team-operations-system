-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2025 at 08:18 AM
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
-- Database: `team_operations_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announce_id` int(11) NOT NULL,
  `announce_title` varchar(255) NOT NULL,
  `announce_desc` varchar(255) NOT NULL,
  `date_posted` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`announce_id`, `announce_title`, `announce_desc`, `date_posted`) VALUES
(1, 'break time tagging', 'please check announcement here', '2025-02-06 23:47:48');

-- --------------------------------------------------------

--
-- Table structure for table `team_users`
--

CREATE TABLE `team_users` (
  `team_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `dob` varchar(100) NOT NULL,
  `usertype` varchar(100) NOT NULL,
  `photo` mediumblob NOT NULL,
  `is_online` tinyint(1) DEFAULT 0,
  `is_logged_in` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_users`
--

INSERT INTO `team_users` (`team_id`, `first_name`, `middle_name`, `surname`, `username`, `password`, `email`, `gender`, `dob`, `usertype`, `photo`, `is_online`, `is_logged_in`) VALUES
(1, 'Mark Francis', 'Perez', 'De Guzman', 'WEB-2024-01', '123', 'deguzmanmarkfrancisp@gmail.com', 'male', '12/10/1997', 'admin', '', 0, 1),
(2, 'Michael Gilbert', 'Buenaobra', 'Del Rosario', 'WEB-2024-02', '123', 'michaelgilbert@gmail.com', 'Male', '2000-08-29', 'user', 0x75706c6f6164732f706e6777696e672e636f6d202832292e706e67, 0, 0),
(6, 'Joeanalyn', 'Diaz', 'Grande', 'WEB-2024-03', '123', 'joeanalyn07@gmail.com', 'Male', '1999-06-12', 'user', 0x75706c6f6164732f706e6777696e672e636f6d202832292e706e67, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `ticket_title` varchar(255) NOT NULL,
  `ticket_desc` varchar(255) NOT NULL,
  `ticket_status` enum('In Progress','On Hold','Done') NOT NULL DEFAULT 'In Progress',
  `assigned_to` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `ticket_title`, `ticket_desc`, `ticket_status`, `assigned_to`, `created_at`, `updated_at`) VALUES
(1, 'Add password_verify and hash for this system', 'Good day, Mike.\r\n\r\nPlease see attached file (sample) for the changes in the System. We need to implement the password hash and verification for DB security. \r\n\r\nCheers,\r\n\r\nFrancis.', 'In Progress', 2, '2025-02-07 05:15:34', '2025-02-07 05:15:34'),
(2, 'sample title', 'sample description', 'In Progress', 2, '2025-02-07 10:41:53', '2025-02-07 10:41:53'),
(3, 'ADD PRIORITY LEVELS FOR TICKETS', 'Good day.\r\n\r\nPlease add a priority level for the ticket to determine the risk of service flow.\r\n\r\nCheers,\r\n\r\nFrancis.', 'In Progress', 2, '2025-02-08 06:35:30', '2025-02-08 06:35:30');

-- --------------------------------------------------------

--
-- Table structure for table `upload_session`
--

CREATE TABLE `upload_session` (
  `session_id` int(11) NOT NULL,
  `session_title` varchar(255) NOT NULL,
  `session_desc` varchar(255) NOT NULL,
  `session_vid` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `upload_session`
--

INSERT INTO `upload_session` (`session_id`, `session_title`, `session_desc`, `session_vid`) VALUES
(1, 'How to rename // SESSION 2.5.2025', 'Sample Description', 0x766964656f5f36376132643064653438663466372e37373030383633312e6d7034);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announce_id`);

--
-- Indexes for table `team_users`
--
ALTER TABLE `team_users`
  ADD PRIMARY KEY (`team_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `assigned_to` (`assigned_to`);

--
-- Indexes for table `upload_session`
--
ALTER TABLE `upload_session`
  ADD PRIMARY KEY (`session_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announce_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `team_users`
--
ALTER TABLE `team_users`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `upload_session`
--
ALTER TABLE `upload_session`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `team_users` (`team_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
