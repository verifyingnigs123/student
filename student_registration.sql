-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2025 at 06:56 PM
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
-- Database: `student_registration`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_balance`
--

CREATE TABLE `account_balance` (
  `id` int(11) NOT NULL,
  `student_id` bigint(50) NOT NULL,
  `balance` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account_balance`
--

INSERT INTO `account_balance` (`id`, `student_id`, `balance`) VALUES
(1, 2311600102, '200.00'),
(2, 2311600103, '1000.00'),
(3, 2311600104, '1200.00'),
(4, 2311600101, '19000.00'),
(5, 2311600100, '2000.00'),
(6, 123412131313, '100.00');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `grade` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `student_id`, `subject`, `grade`) VALUES
(8, 2311600102123, 'Math', '97'),
(19, 2311600103, 'Arts', '90'),
(20, 2311600103, 'Religon', '81'),
(21, 2311600101, 'Math', '96'),
(22, 2311600101, 'Arts', '81'),
(23, 2311600101, 'PE', '86'),
(24, 123456, 'Math', '75'),
(25, 123412131313, 'Math', '89');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `student_id`, `password`) VALUES
(1, '2311600102', 'Lathougs'),
(2, '2311600104', 'Lathougs'),
(3, '2311600101', 'Lathougs'),
(4, '2311600103', 'Lathougs'),
(5, '231160010322', 'Lathougs'),
(6, '231160010325', 'Lathougs'),
(7, '123412131313', 'Lathougs');

-- --------------------------------------------------------

--
-- Table structure for table `permits`
--

CREATE TABLE `permits` (
  `permit_id` int(11) NOT NULL,
  `student_id` varchar(50) DEFAULT NULL,
  `permit_type` varchar(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `expiration_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permits`
--

INSERT INTO `permits` (`permit_id`, `student_id`, `permit_type`, `status`, `issue_date`, `expiration_date`) VALUES
(1, '2311600101', 'Prelim', 'Pending', '2024-03-12', '2025-03-01'),
(2, '2311600102', 'Midterm', 'Approved', '2025-01-04', '2025-03-05'),
(3, '123412131313', 'Prelim', 'Approved', '2024-03-12', '2025-03-01');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `day` varchar(20) NOT NULL,
  `time` varchar(20) NOT NULL,
  `room` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `student_id`, `subject`, `day`, `time`, `room`) VALUES
(16, '123412131313', 'Arts', 'Friday', '8am to 9am', 'fgm101'),
(17, '123412131313', 'Math', 'Tuesday', '11am to 12am', 'fgm103'),
(18, '123412131313', 'PE', 'Monday', '11am to 12am', 'fgm105'),
(19, '123412131313', 'Science', 'Friday', '8am to 9am', 'fgm101');

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
-- Indexes for dumped tables
--

--
-- Indexes for table `account_balance`
--
ALTER TABLE `account_balance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permits`
--
ALTER TABLE `permits`
  ADD PRIMARY KEY (`permit_id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_balance`
--
ALTER TABLE `account_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `permits`
--
ALTER TABLE `permits`
  MODIFY `permit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
