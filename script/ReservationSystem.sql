-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2025 at 05:31 PM
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
-- Database: `reservation_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `messageID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `createdAt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`messageID`, `name`, `email`, `message`, `createdAt`) VALUES
(1, 'Mhyca Varona', 'mhycavarona@yahoo.com', 'Hi beb', '2025-05-28 06:10:17'),
(2, 'Julie AnAn', 'juliemabangisxz@yahoo.com', 'Pwede ka ba sapakin?', '2025-05-28 06:11:38'),
(3, 'Arvin Bananini', 'arvintusta@gmail.com', 'I love Valerina Cappuccino', '2025-05-28 06:13:28'),
(4, 'Eriz Pisot', 'erizpisot@gmail.com', 'I love dinosaurs', '2025-05-28 06:21:14');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `paymentID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `reservationID` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `paymentDate` datetime NOT NULL,
  `paymentMethod` varchar(50) NOT NULL,
  `paymentStatus` varchar(50) NOT NULL,
  `transactionReference` varchar(100) DEFAULT NULL,
  `createdAt` datetime DEFAULT current_timestamp(),
  `lastUpdate` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservationID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `serviceID` int(11) NOT NULL,
  `date` date NOT NULL,
  `startTime` time NOT NULL,
  `endTime` time NOT NULL,
  `totalCost` decimal(10,2) NOT NULL,
  `statusID` int(11) NOT NULL,
  `createdAt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `roleID` int(11) NOT NULL,
  `roleName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`roleID`, `roleName`) VALUES
(1, 'Admin'),
(2, 'Customer');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `statusID` int(11) NOT NULL,
  `statusName` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`statusID`, `statusName`) VALUES
(1, 'Active'),
(2, 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `lastName` varchar(45) NOT NULL,
  `firstName` varchar(45) NOT NULL,
  `middleName` varchar(45) NOT NULL,
  `username` varchar(45) NOT NULL,
  `phoneNumber` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `roleID` int(11) DEFAULT NULL,
  `statusID` int(11) DEFAULT NULL,
  `createdAt` datetime DEFAULT current_timestamp(),
  `lastUpdate` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isActive` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `lastName`, `firstName`, `middleName`, `username`, `phoneNumber`, `email`, `password`, `roleID`, `statusID`, `createdAt`, `lastUpdate`, `isActive`) VALUES
(8, 'Nakase', 'Mico', 'Libunao', 'miconakase17', '09665270518', 'miconakaseyt@gmail.com', '$2y$10$3iZBCAVb.utS5WSjL2OrUu6QEQhtCXG45Csuo9rrtYsfqkTVqJwZK', NULL, NULL, '2025-05-20 09:12:28', NULL, NULL),
(9, 'Gavino', 'John Rey', 'N/A', 'jepoy69', '09998876654', 'jepoy69@gmail.com', '$2y$10$dJWhai6vP.kSTh2RyNC8M.8HCxqYTePxB2LMN5UfSzGKi1CiS0jqK', NULL, NULL, '2025-05-20 09:13:52', NULL, NULL),
(11, 'Varona', 'Mhyca', 'Gacilo', 'Mhics25', '09519614271', 'varonamhics@gmail.com', '$2y$10$SYKNe6Y81ZhN5Q6VBhHqneKcAAdPn94njXCJyLProet1WMdXRIf2a', NULL, NULL, '2025-05-26 05:25:48', '2025-05-26 05:25:48', NULL),
(12, 'Arandia', 'Jim', '', 'jim123', '09767889876', 'jim123@yahoo.com', '$2y$10$wtCbrHV9LpyJStlPfCVQtu6358OaiDJY3CuDJxt/p/X1MQQgFcBbe', NULL, NULL, '2025-05-29 05:49:40', '2025-05-29 05:49:40', NULL),
(13, 'Carpio', 'Julie Ann', 'Bonguit', 'julieanncarpio', '09675568887', 'julieanncarpio55@gmail.com', '$2y$10$3XT7KUh8z3TwNc245EtZMOAAYEJARVV79X9U5nawS/J.Ify1aNozm', NULL, NULL, '2025-08-26 08:15:28', '2025-08-26 08:15:28', NULL),
(14, 'Pandaan', 'Sally', '', 'sallymae', '09876779988', 'truchorus.official@gmail.com', '$2y$10$O3jcU9/JhpBJi00vqhBwueiZXxPICL1UGa/Elrc6kxV.Kdo0DiqKi', NULL, NULL, '2025-09-03 11:40:36', '2025-09-03 11:40:36', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`messageID`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `reservationID` (`reservationID`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservationID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `serviceID` (`serviceID`),
  ADD KEY `statusID` (`statusID`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`roleID`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`statusID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD KEY `roleID` (`roleID`),
  ADD KEY `statusID` (`statusID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `messageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `paymentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservationID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `roleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `statusID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_payments_reservations` FOREIGN KEY (`reservationID`) REFERENCES `reservations` (`reservationID`),
  ADD CONSTRAINT `fk_payments_users` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `fk_reservations_status` FOREIGN KEY (`statusID`) REFERENCES `status` (`statusID`),
  ADD CONSTRAINT `fk_reservations_users` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_roles` FOREIGN KEY (`roleID`) REFERENCES `roles` (`roleID`),
  ADD CONSTRAINT `fk_users_status` FOREIGN KEY (`statusID`) REFERENCES `status` (`statusID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
