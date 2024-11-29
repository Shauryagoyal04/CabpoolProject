-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2024 at 07:35 PM
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
-- Database: `cabpoolproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `ride_id` int(11) NOT NULL,
  `status` enum('upcoming','completed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_name`, `ride_id`, `status`) VALUES
(1, 'Harsh Vardhan', 28, 'upcoming'),
(2, 'Harsh Vardhan', 31, 'upcoming'),
(3, 'Harsh Vardhan', 29, 'upcoming'),
(4, 'Harsh Vardhan', 33, 'upcoming'),
(5, 'Harsh Vardhan', 30, 'upcoming'),
(6, 'Harsh Vardhan', 30, 'upcoming'),
(7, 'Harsh Vardhan', 22, 'upcoming');

-- --------------------------------------------------------

--
-- Table structure for table `rides`
--

CREATE TABLE `rides` (
  `id` int(11) NOT NULL,
  `owner_name` varchar(50) NOT NULL,
  `leaving_from` varchar(50) NOT NULL,
  `going_to` varchar(50) NOT NULL,
  `ride_time` datetime NOT NULL,
  `seats_available` int(11) NOT NULL,
  `rider1_name` varchar(50) NOT NULL,
  `rider2_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rides`
--

INSERT INTO `rides` (`id`, `owner_name`, `leaving_from`, `going_to`, `ride_time`, `seats_available`, `rider1_name`, `rider2_name`) VALUES
(21, 'Shreshtha Singhal', '62', '128', '2024-12-12 10:00:00', 1, 'Shreshtha Singhal', ''),
(22, 'Shreshtha Singhal', '128', '62', '2024-12-12 10:00:00', 0, 'Shreshtha Singhal', 'Harsh Vardhan'),
(23, 'Shreshtha Singhal', '128', '62', '2024-12-15 10:00:00', 2, '', ''),
(24, 'Piyush', '128', '62', '2024-12-12 10:00:00', 2, '', ''),
(25, 'Piyush', '128', '62', '2024-12-30 10:00:00', 1, '', ''),
(26, 'Piyush', '128', '62', '2024-12-23 10:00:00', 1, '', ''),
(27, 'Piyush', '128', '62', '2024-11-30 02:58:00', 0, 'Harsh Vardhan', ''),
(28, 'Piyush', '128', '62', '2024-11-30 20:00:00', 0, 'Harsh Vardhan', ''),
(29, 'Piyush', '128', '62', '2024-12-10 15:04:00', 0, 'Harsh Vardhan', ''),
(30, 'Harsh Vardhan', '62', '128', '2024-12-18 10:05:00', 0, 'Harsh Vardhan', 'Harsh Vardhan'),
(31, 'Harsh Vardhan', '62', '128', '2024-11-29 11:51:00', 0, 'Harsh Vardhan', ''),
(32, 'Harsh Vardhan', '62', '128', '2024-11-29 15:40:00', 1, '', ''),
(33, 'Harsh Vardhan', '62', '128', '2024-11-29 15:42:00', 0, 'Harsh Vardhan', ''),
(34, 'Harsh Vardhan', '62', '128', '2024-11-30 15:25:00', 2, '', ''),
(35, 'Harsh Vardhan', '128', '62', '2024-12-09 12:55:00', 1, '', ''),
(36, 'Harsh Vardhan', '62', '128', '2024-11-29 23:55:00', 2, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `username` varchar(50) NOT NULL,
  `enrollment_num` varchar(20) NOT NULL,
  `email_id` varchar(100) NOT NULL,
  `phone_num` bigint(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `rating` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `number_of_ratings` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`username`, `enrollment_num`, `email_id`, `phone_num`, `password`, `rating`, `created_at`, `updated_at`, `number_of_ratings`) VALUES
('Shaurya Goyal', '', 'shaurya@gmail.com', 8869081708, '$2y$10$HdLAyopehHZcqzIRqlbYyeaLt6G6ms6QjUUZ1.tQ4Tx', 0, '2024-11-28', '0000-00-00', 0),
('Shreshtha Singhal', '', 'shreshtha@gmail.com', 9090909090, '1234', 0, '2024-11-28', '0000-00-00', 0),
('Sarthak Agarwal', '', 'sarthak@gmial.com', 9191919191, '12345', 0, '2024-11-28', '0000-00-00', 0),
('Sahil Singh', '', 'sahil@gmail.com', 1234578901, '1234', 0, '2024-11-28', '0000-00-00', 0),
('Piyush', '', 'piyush@gmail.com', 9876543210, '1234', 0, '2024-11-29', '0000-00-00', 0),
('Harsh Vardhan', '', 'harsh@gmail.com', 9091929394, '1234', 34, '2024-11-29', '0000-00-00', 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ride_id` (`ride_id`);

--
-- Indexes for table `rides`
--
ALTER TABLE `rides`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rides`
--
ALTER TABLE `rides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`ride_id`) REFERENCES `rides` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
