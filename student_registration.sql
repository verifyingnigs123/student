-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2025 at 05:54 AM
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
  `balance` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `semester` varchar(50) DEFAULT NULL,
  `school_year` varchar(20) DEFAULT NULL,
  `grade_level` varchar(10) DEFAULT NULL,
  `strand` varchar(50) DEFAULT NULL,
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account_balance`
--

INSERT INTO `account_balance` (`id`, `student_id`, `balance`, `description`, `semester`, `school_year`, `grade_level`, `strand`, `date_updated`) VALUES
(18, 231160010104, '3000.00', 'Tuition fee', '1st Semester', '2025-2026', 'Grade 11', 'STEM', '2025-06-04 00:35:54');

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
(57, 231160010104, 'Math', '91');

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
(6, '231160010325', 'Lathougs'),
(7, '123412131313', 'Lathougs'),
(8, '231160010212', 'gwapo'),
(9, '231160010213', 'Lathougs'),
(10, '231160010211', 'Lathougs'),
(11, '231160010215', 'Lathougs'),
(12, '231160010214', 'Lathougs'),
(14, '231160010210', 'Lathougs'),
(15, '231160010109', 'Lathougs'),
(16, '231160010218', 'laso'),
(17, '231160010108', 'laso123'),
(20, '231160010201', 'Lathougs'),
(21, '231160010104', 'Lathougs');

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
(5, '231160010104', 'Prelim', 'Approved', '2024-08-12', '2025-02-12');

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
(21, '231160010104', 'Arts', 'Monday', '1pm to 2pm', 'fgm103');

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
  `registered_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_pic` varchar(255) DEFAULT 'profile.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_type`, `fName`, `mName`, `lName`, `extName`, `birthdate`, `age`, `place`, `student_id`, `religion`, `gender`, `street`, `city`, `state`, `country`, `zip`, `email`, `contactNumber`, `strand`, `level`, `semester`, `school_year`, `is_approved`, `registered_at`, `profile_pic`) VALUES
(10, 'Old Student', 'Justine', '', 'Moril', '', '2004-08-12', 20, '', '231160010215', '', '', '', '', '', '', '', 'ffauzi@gmail.com', '09071787235', 'GAS', 'Grade 11', '1st Semester', '', 'approved', '2025-04-23 14:41:22', 'profile.png'),
(11, 'New Student', 'Johar', '', 'Gogo', '', '2005-08-12', 19, 'Polomolok', '231160010218', 'ambot', 'Male', 'Polomolok, South Cotabato', 'Polomolok', 'South Cotabato', 'Philippines', '9504', 'ffauzi@gmail.com', '09071787231', 'GAS', 'Grade 11', '2nd Semester', '2026-2027', 'approved', '2025-04-23 14:43:39', 'profile.png'),
(43, 'Old Student', 'Benjie', '', 'Glenogo', '', '2004-08-12', 0, '', '231160010104', '', '', '', '', '', '', '', 'benjie@gmail.com', '09359544536', 'HUMSS', 'Grade 11', '1st Semester', '', 'approved', '2025-05-30 14:46:03', 'profile_683ed94f655010.10706364.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `fName` varchar(100) NOT NULL,
  `mName` varchar(100) DEFAULT NULL,
  `lName` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `fName`, `mName`, `lName`, `email`, `contact`, `subject`) VALUES
(1, 'Jim', '', 'Jamero', 'jamero@gmail.com', '09071787237', 'science');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_login`
--

CREATE TABLE `teacher_login` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_login`
--

INSERT INTO `teacher_login` (`id`, `email`, `password`) VALUES
(1, 'jamero@gmail.com', 'Lathougs');

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
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_login`
--
ALTER TABLE `teacher_login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_balance`
--
ALTER TABLE `account_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `permits`
--
ALTER TABLE `permits`
  MODIFY `permit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `teacher_login`
--
ALTER TABLE `teacher_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
