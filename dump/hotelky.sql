-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2025 at 05:50 PM
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
-- Database: `hotelky`
--

-- --------------------------------------------------------

--
-- Table structure for table `booked_room`
--

CREATE TABLE `booked_room` (
  `bid` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `rid` int(11) DEFAULT NULL,
  `check_in` date DEFAULT NULL,
  `check_out` date DEFAULT NULL,
  `total_day` int(11) DEFAULT NULL,
  `total_price` int(11) DEFAULT NULL,
  `pay_method` varchar(255) DEFAULT NULL,
  `adult` int(11) DEFAULT NULL,
  `child` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `isactive` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booked_room`
--

INSERT INTO `booked_room` (`bid`, `uid`, `rid`, `check_in`, `check_out`, `total_day`, `total_price`, `pay_method`, `adult`, `child`, `created_at`, `isactive`) VALUES
(1, 1, 1, NULL, NULL, 10, 1200, 'Account Balance', 1, 1, '2025-02-16 09:59:42', 1),
(2, 1, 3, NULL, NULL, 9, 630, 'Account Balance', 1, 1, '2025-02-16 15:51:44', 1),
(3, 1, 1, '1970-01-01', '1970-01-01', 10, 1200, 'Account Balance', 1, 1, '2025-02-16 15:54:04', 1),
(4, 1, 2, NULL, NULL, 7, 700, 'Account Balance', 1, 1, '2025-02-16 15:57:02', 1),
(5, 1, 2, '1970-01-01', '1970-01-01', 3, 300, 'Account Balance', 1, 1, '2025-02-16 15:58:37', 1),
(6, 1, 3, '2025-02-16', '2025-02-16', 1, 70, 'Account Balance', 1, 1, '2025-02-16 16:01:16', 1),
(7, 1, 2, '2025-02-16', '2025-02-18', 2, 200, 'Account Balance', 1, 1, '2025-02-16 16:07:04', 1),
(8, 1, 3, '2025-02-16', '2025-02-17', 1, 70, 'Account Balance', 1, 1, '2025-02-16 16:18:28', 1),
(9, 1, 1, '2025-02-16', '2025-02-17', 1, 120, 'Account Balance', 1, 1, '2025-02-16 16:29:26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `rid` int(11) NOT NULL,
  `room_name` varchar(255) DEFAULT NULL,
  `adult_mcap` int(11) DEFAULT NULL,
  `child_mcap` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`rid`, `room_name`, `adult_mcap`, `child_mcap`, `price`, `details`) VALUES
(1, 'Deluxe Room', 3, 3, 120, 'Spacious Room with Sky View\nEnjoy a large and airy room with floor-to-ceiling windows offering breathtaking sky views. This room features a cozy queen-size bed, a functional work desk, and abundant natural lighting. Perfect for guests who appreciate a peaceful and relaxing atmosphere.'),
(2, 'Suite Room', 3, 2, 100, 'Luxury Suite with King-Size Bed\nExperience luxury in this elegant suite, designed for ultimate comfort. It features a plush king-size bed, a private living area, and a lavish bathroom with a bathtub. Ideal for honeymooners or those seeking a premium stay.'),
(3, 'Standard Room', 2, 2, 70, 'Cozy and Comfortable Room\nA warm and inviting space designed for ultimate relaxation. This room offers a comfortable bed, stylish interiors, and essential amenities to make your stay pleasant. A great choice for solo travelers or couples.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `account_balance` int(11) DEFAULT 0,
  `isadmin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `name`, `email`, `password`, `account_balance`, `isadmin`) VALUES
(1, 'a', 'a@gmail.com', '$2y$12$3lqaXYpK8hBFoc2mlHR6z.QAQ.8SipE8/P/hPLs26Ij637Z1ZcLe2', 910, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booked_room`
--
ALTER TABLE `booked_room`
  ADD PRIMARY KEY (`bid`),
  ADD KEY `fk_booked_user` (`uid`),
  ADD KEY `fk_booked_room` (`rid`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`rid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booked_room`
--
ALTER TABLE `booked_room`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booked_room`
--
ALTER TABLE `booked_room`
  ADD CONSTRAINT `fk_booked_room` FOREIGN KEY (`rid`) REFERENCES `rooms` (`rid`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_booked_user` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
