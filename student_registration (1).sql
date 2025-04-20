-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2025 at 08:23 PM
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
(7, 231160011456, '1234.00');

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
(26, 131320100421, 'math', '90'),
(27, 131320100421, 'science', '90'),
(32, 231160011456, 'math', '90'),
(33, 231160011456, 'science', '91'),
(34, 231160011456, 'ITE', '90');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `student_id`, `password`) VALUES
(8, '131320100421', 'Lathougs'),
(10, '131320100422', 'Lathougs'),
(11, '131320100423', 'Lathougs'),
(12, '123456789123', 'Lathougs'),
(13, '131320100424', 'Lathougs'),
(14, '231160011456', 'Lathougs'),
(15, '231160011789', 'Lathougs');

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
  `semester` varchar(20) NOT NULL,
  `school_year` varchar(9) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `fName`, `mName`, `lName`, `extName`, `birthdate`, `age`, `place`, `student_id`, `religion`, `gender`, `street`, `city`, `state`, `country`, `zip`, `email`, `contactNumber`, `strand`, `level`, `semester`, `school_year`, `created_at`, `role`) VALUES
(9, 'raph', 'Fabian', 'Visayas', '', '2005-04-07', 20, 'general santos', '131320100421', 'roman chatolic', 'Male', 'FVR Village purok 17-A Block 47 lot 26', 'General Santos', 'South Cotabato', 'Philippine', '9500', 'raphjohnvisayas@gmail.com', '09950035409', 'TVL', 'Grade 11', '1st Semester', '', '2025-04-09 15:07:33', 'user'),
(11, 'maricris', '', 'danuya', '', '2004-05-06', 20, 'general santos', '231160011456', 'roman chatolic', 'Female', 'FVR Village purok 17-A Block 47 lot 26', 'General Santos', 'South Cotabato', 'Philippine', '9500', 'maricris@gmail.com', '09161234524', 'TVL', 'Grade 11', '', '', '2025-04-09 19:02:04', 'user'),
(12, 'john', '', 'lalic', '', '2000-04-05', 23, 'general santos', '231160011567', 'roman chatolic', 'Male', 'FVR Village purok 17-A Block 47 lot 26', 'General Santos', 'South Cotabato', 'Philippine', '9500', 'lalic@gmail.com', '09999432532', 'TVL', 'Grade 11', '1st Semester', '', '2025-04-09 19:42:43', 'user'),
(14, 'justine', '', 'moril', '', '2005-01-26', 20, 'general santos', '231160011568', 'roman chatolic', 'Male', 'FVR Village purok 17-A Block 47 lot 26', 'General Santos', 'South Cotabato', 'Philippine', '9500', 'justine@gmail.com', '09123456754', 'TVL', 'Grade 11', '1st Semester', '2025-2026', '2025-04-09 19:47:58', 'user'),
(17, 'rence', '', 'lagsil', '', '2005-01-20', 24, 'gensan', '231160011789', 'roman catholic', 'Male', 'BLK47 BARANGAY FATIMA', 'General Santos City', 'sout cot', 'Philippines', '9500', 'rence@gmail.com', '09123456971', 'TVL', 'Grade 11', '1st Semester', '2025-2026', '2025-04-20 18:20:05', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `transferee_students`
--

CREATE TABLE `transferee_students` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `middleName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) NOT NULL,
  `ext_Name` varchar(10) DEFAULT NULL,
  `birthdate` date NOT NULL,
  `Age` int(11) NOT NULL,
  `Place` varchar(100) NOT NULL,
  `Student_id` varchar(15) NOT NULL,
  `Religion` varchar(50) NOT NULL,
  `Gender` enum('Male','Female') NOT NULL,
  `Street` varchar(100) NOT NULL,
  `City` varchar(50) NOT NULL,
  `State` varchar(50) NOT NULL,
  `Country` varchar(50) NOT NULL,
  `Zipcode` varchar(10) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `ContactNumber` varchar(15) NOT NULL,
  `Strand` varchar(10) NOT NULL,
  `Level` varchar(10) NOT NULL,
  `Semester` varchar(20) NOT NULL,
  `School_year` varchar(20) NOT NULL,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Role` enum('user','admin') NOT NULL DEFAULT 'user'
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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `studentID` (`student_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD UNIQUE KEY `contactNumber` (`contactNumber`);

--
-- Indexes for table `transferee_students`
--
ALTER TABLE `transferee_students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Student_id` (`Student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_balance`
--
ALTER TABLE `account_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `transferee_students`
--
ALTER TABLE `transferee_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
