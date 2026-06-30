-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2025 at 12:54 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bus_pass_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'f865b53623b121fd34ee5426c792e5c33af8c227');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `applied_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `buses`
--

CREATE TABLE `buses` (
  `id` int(11) NOT NULL,
  `bus_number` varchar(20) NOT NULL,
  `driver_name` varchar(100) DEFAULT NULL,
  `total_seats` int(11) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bus_pass`
--

CREATE TABLE `bus_pass` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pass_type` enum('1','3','6','12') NOT NULL,
  `valid_until` date NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `renewed` tinyint(1) DEFAULT 0,
  `download_link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `source_stop` varchar(255) NOT NULL,
  `destination_stop` varchar(255) NOT NULL,
  `payment_status` enum('pending','paid') DEFAULT 'pending',
  `total_fare` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_percent` int(11) DEFAULT 0,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `final_paid_amount` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bus_pass`
--

INSERT INTO `bus_pass` (`id`, `user_id`, `pass_type`, `valid_until`, `status`, `renewed`, `download_link`, `created_at`, `updated_at`, `source_stop`, `destination_stop`, `payment_status`, `total_fare`, `discount_percent`, `discount_amount`, `final_paid_amount`) VALUES
(1, 1, '1', '2025-04-04', 'approved', 0, NULL, '2025-03-04 08:13:04', '2025-03-04 11:56:01', 'Karwanchiwadi', 'Ratnagiri Bus Stand', 'paid', 0.00, 0, 0.00, 0.00),
(3, 2, '3', '2025-06-05', 'approved', 0, NULL, '2025-03-05 06:24:33', '2025-03-05 06:26:42', 'Salvi Stop', 'Ratnagiri Bus Stand', 'paid', 930.00, 50, 465.00, 465.00),
(4, 3, '6', '2025-09-05', 'approved', 0, NULL, '2025-03-05 08:05:20', '2025-03-05 09:34:17', 'Kuwarbav', 'Ratnagiri Bus Stand', 'paid', 1240.00, 50, 620.00, 620.00),
(5, 4, '1', '2025-04-05', 'approved', 0, NULL, '2025-03-05 08:28:48', '2025-03-05 08:36:40', 'Maruti Mandir', 'Ratnagiri Bus Stand', 'paid', 620.00, 50, 310.00, 310.00),
(6, 5, '1', '2025-04-05', 'approved', 0, NULL, '2025-03-05 08:55:31', '2025-03-05 09:34:05', 'Karwanchiwadi', 'Ratnagiri Bus Stand', 'paid', 1240.00, 25, 310.00, 930.00),
(7, 6, '3', '2025-06-05', 'approved', 0, NULL, '2025-03-05 09:40:50', '2025-03-05 09:42:06', 'Khedshi', 'Ratnagiri Bus Stand', 'pending', 1550.00, 50, 775.00, 775.00),
(8, 7, '1', '2025-04-05', 'approved', 0, NULL, '2025-03-05 11:20:27', '2025-03-05 11:22:20', 'Salvi Stop', 'Ratnagiri Bus Stand', 'paid', 930.00, 50, 465.00, 465.00);

-- --------------------------------------------------------

--
-- Table structure for table `bus_stops`
--

CREATE TABLE `bus_stops` (
  `id` int(11) NOT NULL,
  `stop_name` varchar(100) NOT NULL,
  `one_way_fare` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bus_stops`
--

INSERT INTO `bus_stops` (`id`, `stop_name`, `one_way_fare`) VALUES
(1, 'Ratnagiri Bus Stand', 0.00),
(2, 'Karwanchiwadi', 20.00),
(3, 'Salvi Stop', 15.00);

-- --------------------------------------------------------

--
-- Table structure for table `fares`
--

CREATE TABLE `fares` (
  `id` int(11) NOT NULL,
  `source` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `fare` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fares`
--

INSERT INTO `fares` (`id`, `source`, `destination`, `fare`) VALUES
(1, 'Karwanchiwadi', 'Ratnagiri Bus Stand', 40),
(2, 'Salvi Stop', 'Ratnagiri Bus Stand', 30),
(3, 'Kuwarbav', 'Ratnagiri Bus Stand', 40),
(4, 'Maruti Mandir', 'Ratnagiri Bus Stand', 20),
(5, 'Khedshi', 'Ratnagiri Bus Stand', 50);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `submitted_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `message`, `submitted_on`) VALUES
(1, 6, 'service is good', '2025-03-05 09:47:49'),
(2, 6, 'service is good', '2025-03-05 09:54:05'),
(3, 6, 'not bad', '2025-03-05 09:59:59'),
(4, 6, 'it is good!', '2025-03-05 10:00:10');

-- --------------------------------------------------------

--
-- Table structure for table `pass_renewals`
--

CREATE TABLE `pass_renewals` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bus_pass_id` int(11) NOT NULL,
  `requested_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bus_pass_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` enum('cash','card','UPI') NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_status` enum('pending','completed','failed') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `bus_pass_id`, `amount`, `payment_method`, `transaction_id`, `payment_date`, `payment_status`) VALUES
(1, 1, 1, 1000.00, 'UPI', 'TXN67c6ea519c7f1', '2025-03-04 07:26:01', 'completed'),
(2, 2, 3, 1000.00, '', 'TXN67c7eea23d4cb', '2025-03-05 01:56:42', 'completed'),
(3, 3, 4, 620.00, 'UPI', 'TXN67c8076a1008d', '2025-03-05 08:12:26', 'completed'),
(4, 5, 6, 930.00, 'UPI', 'TXN67c811d2b6ab4', '2025-03-05 08:56:50', 'completed'),
(5, 7, 8, 465.00, '', 'TXN67c8339877ddb6417', '2025-03-05 11:20:56', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` int(11) NOT NULL,
  `source` varchar(100) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `distance` int(11) NOT NULL,
  `bus_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pass_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_status` enum('pending','completed','failed') DEFAULT 'pending',
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('student','kamgar') NOT NULL,
  `institution_name` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `institution_name`, `company_name`, `created_at`, `photo`) VALUES
(1, 'Rasika Krishna Surve', 'rasikasurve13@gmail.com', '$2y$10$f7glWT/63ydK1fPvQps0s.R7FFr1BNG8ueFDdyam/RjIDQ5XxLNiq', 'kamgar', '', 'Bartakke Institute of IT Ratnagiri', '2025-03-04 08:11:54', NULL),
(2, 'Shivani Surve', 'shivanisurve@gmail.com', '$2y$10$oTfVWumqvrTWvdIW/M2f8.ssnkjJaFbYzT7iwzFeLnK2UpMA6FE.K', 'student', 'Gogate college ratnagiri', '', '2025-03-05 06:21:52', NULL),
(3, 'Sanika Bhore', 'sanika@gmail.com', '$2y$10$O.Y2v6ynkIzHykunN2M88eaUkom/sdjRzNyRDXENAxYX4ERwnIkkS', 'student', 'BIIT', '', '2025-03-05 08:01:52', NULL),
(4, 'Priya Naik', 'priya@gmail.com', '$2y$10$dxrxi6BCPhg0R9mv/k6Kc.r7mBfv7n8CGFsGA2WCmmaYZE5toJpKS', 'student', 'BIIT', '', '2025-03-05 08:25:15', NULL),
(5, 'Tanvi surve', 'tanvi@gmail.com', '$2y$10$k8umAf9.czA2P6bUvaNCpezdNl87G3ans1SX03L8BJ75uYNnfcQHS', 'kamgar', '', 'ASBF', '2025-03-05 08:54:57', NULL),
(6, 'Tanvi Rajendra Shevade', 'tanvishevade25@gmail.com', '$2y$10$AkJW0XskzaZEVkGSfUh.M.wysRLx7zMamisDDngcekS5NaFrun4cK', 'student', 'Mksss', '', '2025-03-05 09:40:06', NULL),
(7, 'Arati Sathe', 'arati@gmail.com', '$2y$10$6SbPaK6fRU0wxt5ShUAHnOcZLGFWrszWAxtR9CgUsMZeHrRQlQR4O', 'student', 'GGPS', '', '2025-03-05 11:19:51', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `buses`
--
ALTER TABLE `buses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bus_number` (`bus_number`);

--
-- Indexes for table `bus_pass`
--
ALTER TABLE `bus_pass`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `bus_stops`
--
ALTER TABLE `bus_stops`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stop_name` (`stop_name`);

--
-- Indexes for table `fares`
--
ALTER TABLE `fares`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pass_renewals`
--
ALTER TABLE `pass_renewals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `bus_pass_id` (`bus_pass_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_id` (`transaction_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `bus_pass_id` (`bus_pass_id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_id` (`bus_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pass_id` (`pass_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buses`
--
ALTER TABLE `buses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bus_pass`
--
ALTER TABLE `bus_pass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `bus_stops`
--
ALTER TABLE `bus_stops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fares`
--
ALTER TABLE `fares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pass_renewals`
--
ALTER TABLE `pass_renewals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bus_pass`
--
ALTER TABLE `bus_pass`
  ADD CONSTRAINT `bus_pass_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `pass_renewals`
--
ALTER TABLE `pass_renewals`
  ADD CONSTRAINT `pass_renewals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pass_renewals_ibfk_2` FOREIGN KEY (`bus_pass_id`) REFERENCES `bus_pass` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`bus_pass_id`) REFERENCES `bus_pass` (`id`);

--
-- Constraints for table `routes`
--
ALTER TABLE `routes`
  ADD CONSTRAINT `routes_ibfk_1` FOREIGN KEY (`bus_id`) REFERENCES `buses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`pass_id`) REFERENCES `bus_pass` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
