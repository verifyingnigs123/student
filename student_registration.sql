-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2025 at 06:57 PM
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
(6, 123412131313, '1100.00'),
(7, 231160010211, '500.00');

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
(26, 231160010212, 'Math', '89'),
(27, 123412131313, 'Math', '90'),
(28, 231160010213, 'Arts', '89'),
(29, 231160010213, 'Religon', '75'),
(30, 231160010214, 'Science', '92');

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
(2, '2311600104', 'Lathougs'),
(3, '2311600101', 'Lathougs'),
(4, '2311600103', 'Lathougs'),
(5, '231160010322', 'Lathougs'),
(6, '231160010325', 'Lathougs'),
(7, '123412131313', 'Lathougs'),
(8, '231160010212', 'Lathougs'),
(9, '231160010213', 'Lathougs'),
(10, '231160010211', 'Lathougs'),
(11, '231160010215', 'Lathougs'),
(12, '231160010214', 'Lathougs'),
(13, '231160010104', 'Lathougs'),
(14, '231160010210', 'Lathougs');

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
  `student_type` varchar(50) DEFAULT NULL,
  `fName` varchar(50) DEFAULT NULL,
  `mName` varchar(50) DEFAULT NULL,
  `lName` varchar(50) DEFAULT NULL,
  `extName` varchar(10) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `place` varchar(100) DEFAULT NULL,
  `student_id` varchar(20) DEFAULT NULL,
  `religion` varchar(50) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contactNumber` varchar(20) DEFAULT NULL,
  `strand` varchar(50) DEFAULT NULL,
  `level` varchar(20) DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `school_year` varchar(20) DEFAULT NULL,
  `is_approved` enum('approved','reject') NOT NULL,
  `registered_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_type`, `fName`, `mName`, `lName`, `extName`, `birthdate`, `age`, `place`, `student_id`, `religion`, `gender`, `street`, `city`, `state`, `country`, `zip`, `email`, `contactNumber`, `strand`, `level`, `semester`, `school_year`, `is_approved`, `registered_at`) VALUES
(3, 'Old Student', 'Justine', '', 'moril', '', '0000-00-00', 0, '', '231160010212', '', '', '', '', '', '', '', 'ffauzi@gmail.com', '09071787237', 'STEM', 'Grade 11', '1st Semester', '', 'approved', '2025-04-23 11:22:12'),
(4, 'Old Student', 'Johar', '', 'Gogo', '', '2003-08-12', 20, 'Polomolok', '231160010211', 'ambot', 'Male', 'Brgy. Poblacion', 'Polomolok', 'South Cotabato', 'Philippines', '9504', 'ffauzi@gmail.com', '09071787237', 'GAS', 'Grade 12', '1st Semester', '2025-2026', 'approved', '2025-04-23 11:27:33'),
(6, 'Old Student', 'hehe', '', 'Gogor', '', '2003-08-12', 0, '', '231160010210', '', '', '', '', '', '', '', 'ffauzi@gmail.com', '09071787237', 'HUMSS', 'Grade 11', '1st Semester', '', 'approved', '2025-04-23 11:34:16'),
(7, 'Transferee Student', 'Raph', '', 'Visayas', '', '2003-08-12', 21, 'Polomolok', '231160010213', 'ambot', 'Male', 'Polomolok, South Cotabato', 'Polomolok', 'South Cotabato', 'Philippines', '9504', 'fauzi@gmail.com', '09071787237', 'HUMSS', 'Grade 11', '2nd Semester', '2025-2026', 'approved', '2025-04-23 11:35:58'),
(8, 'Old Student', 'Raph', '', 'Visayas', '', '0000-00-00', 21, '', '231160010201', '', '', '', '', '', '', '', 'fauzi@gmail.com', '09071787237', 'STEM', 'Grade 12', '1st Semester', '', 'approved', '2025-04-23 11:40:48'),
(10, 'Old Student', 'Justine', '', 'Moril', '', '2004-08-12', 20, '', '231160010215', '', '', '', '', '', '', '', 'ffauzi@gmail.com', '09071787235', 'GAS', 'Grade 11', '1st Semester', '', 'approved', '2025-04-23 14:41:22'),
(11, 'New Student', 'Johar', '', 'Gogo', '', '2005-08-12', 19, 'Polomolok', '231160010218', 'ambot', 'Male', 'Polomolok, South Cotabato', 'Polomolok', 'South Cotabato', 'Philippines', '9504', 'ffauzi@gmail.com', '09071787231', 'GAS', 'Grade 11', '2nd Semester', '2026-2027', 'approved', '2025-04-23 14:43:39'),
(18, 'Old Student', 'Benjie', '', 'Glenogo', '', '2003-08-12', 20, '', '231160010104', '', '', '', '', '', '', '', 'benjie@gmail.com', '09359544536', 'HUMSS', 'Grade 12', '1st Semester', '', 'approved', '2025-04-29 16:54:22');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
