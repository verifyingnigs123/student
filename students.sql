-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2025 at 07:03 PM
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
-- Database: `student_registration`
--

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `fName` varchar(50) NOT NULL,
  `mName` varchar(50) DEFAULT NULL,
  `lName` varchar(50) NOT NULL,
  `extName` varchar(10) DEFAULT NULL,
  `birthdate` date NOT NULL,
  `age` int(11) NOT NULL,
  `place` varchar(100) NOT NULL,
  `student_id` varchar(15) NOT NULL,
  `religion` varchar(50) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `street` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contactNumber` varchar(15) NOT NULL,
  `strand` varchar(10) NOT NULL,
  `level` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `fName`, `mName`, `lName`, `extName`, `birthdate`, `age`, `place`, `student_id`, `religion`, `gender`, `street`, `city`, `state`, `country`, `zip`, `email`, `contactNumber`, `strand`, `level`, `created_at`, `role`) VALUES
(1, 'raphjohn', '', 'visayas', '', '2005-04-07', 19, 'general santos', '131320100421', 'roman chatolic', 'Male', 'FVR Village purok 17-A Block 47 lot 26', 'General Santos', 'South Cotabato', 'Philippine', '9500', 'raphjohnvisayas@gmail.com', '09950035409', 'GAS', 'Grade 11', '2025-04-02 17:55:22', 'user'),
(2, 'leonard', 'Fabian', 'Visayas', '', '2005-02-15', 19, 'general santos', '131320100422', 'roman chatolic', 'Male', 'FVR Village purok 17-A Block 47 lot 26', 'General Santos', 'South Cotabato', 'Philippine', '9767', 'leonard@gmail.com', '09123456754', 'GAS', 'Grade 11', '2025-04-04 17:29:30', 'user'),
(4, 'Raph John', '', 'Visayas', '', '2005-04-07', 19, 'general santos', '131320100423', 'roman chatolic', 'Male', 'FVR Village purok 17-A Block 47 lot 26', 'General Santos', 'South Cotabato', 'Philippine', '9500', 'raphjvisayas@gmail.com', '09950035408', 'TVL', 'Grade 11', '2025-04-04 18:29:05', 'user'),
(5, '12313', '', 'Visayas', '', '2005-04-07', 19, 'general santos', '131320100424', 'roman chatolic', 'Male', 'FVR Village purok 17-A Block 47 lot 26', 'General Santos', 'South Cotabato', 'Philippine', '9500', 'raphvisayas@gmail.com', '09950035401', 'GAS', 'Grade 12', '2025-04-04 18:42:29', 'user'),
(6, 'john paul ', '', 'Lalic', '', '2006-04-07', 19, 'general santos', '123456789123', 'roman chatolic', 'Male', 'FVR Village purok 17-A Block 47 lot 26', 'General Santos', 'South Cotabato', 'Philippine', '9500', 'raphjohn@gmail.com', '09123456755', 'TVL', 'Grade 11', '2025-04-04 18:46:53', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `studentID` (`student_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD UNIQUE KEY `contactNumber` (`contactNumber`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
