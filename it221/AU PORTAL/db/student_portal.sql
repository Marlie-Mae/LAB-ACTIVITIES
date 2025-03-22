-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Mar 22, 2025 at 03:03 AM
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
-- Database: `student_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course`
--

CREATE TABLE `tbl_course` (
  `course_code` varchar(20) NOT NULL,
  `course_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_course`
--

INSERT INTO `tbl_course` (`course_code`, `course_description`) VALUES
('BEED', 'Bachelor of Science in Elementary Education'),
('BPA', 'Bachelor of Public Administration'),
('BSACC', 'Bachelor of Science in Accountancy'),
('BSBA', 'Bachelor of Science in Business Administration'),
('BSC', 'Bachelor of Science in Criminology'),
('BSCS', 'Bachelor of Science in Computer Science'),
('BSECE', 'Bachelor of Science in Electronics Engineering'),
('BSED', 'Bachelor of Secondary Education'),
('BSHM', 'Bachelor of Science in Hospitality Management'),
('BSIT', 'Bachelor of Science in Information Technology'),
('BSME', 'Bachelor of Science in Mechanical Engineering'),
('BSN', 'Bachelor of Science in Nursing'),
('BSP', 'Bachelor of Science in Psychology');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department`
--

CREATE TABLE `tbl_department` (
  `department_code` varchar(20) NOT NULL,
  `department_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_department`
--

INSERT INTO `tbl_department` (`department_code`, `department_name`) VALUES
('ACC', 'Accountancy'),
('BUS', 'Business Administration'),
('CRM', 'Criminology'),
('CS', 'Computer Science'),
('EDU', 'Education'),
('ENG', 'Engineering'),
('HRM', 'Hotel and Restaurant Management'),
('IT', 'Information Technology'),
('MKT', 'Marketing Management'),
('NURS', 'Nursing'),
('PSY', 'Psychology');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_faculty`
--

CREATE TABLE `tbl_faculty` (
  `faculty_code` varchar(10) NOT NULL,
  `faculty_name` varchar(100) NOT NULL,
  `department_code` varchar(20) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_faculty`
--

INSERT INTO `tbl_faculty` (`faculty_code`, `faculty_name`, `department_code`, `password`) VALUES
('CS-0001', 'Ryan Fadrigo', 'CS', '827ccb0eea8a706c4c34a16891f84e7b'),
('EDU-0001', 'John Doe', 'EDU', '827ccb0eea8a706c4c34a16891f84e7b'),
('HRM-001', 'Teodora Alonzo', 'CRM', '827ccb0eea8a706c4c34a16891f84e7b'),
('IT-0001', 'Maylane Ballita', 'IT', '827ccb0eea8a706c4c34a16891f84e7b'),
('IT-0002', 'Shiela Dala', 'CS', '827ccb0eea8a706c4c34a16891f84e7b');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_school_year`
--

CREATE TABLE `tbl_school_year` (
  `school_year_code` varchar(11) NOT NULL,
  `school_year` varchar(9) NOT NULL,
  `semester` varchar(6) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_school_year`
--

INSERT INTO `tbl_school_year` (`school_year_code`, `school_year`, `semester`, `status`) VALUES
('2024-2025-1', '2024-2025', '1', 'inactive'),
('2024-2025-2', '2024-2025', '2', 'active'),
('2025-2026-1', '2025-2026', '1', 'inactive'),
('2025-2026-2', '2025-2026', '2', 'inactive');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student_info`
--

CREATE TABLE `tbl_student_info` (
  `student_no` varchar(8) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `middle_name` varchar(30) NOT NULL,
  `course_code` varchar(20) NOT NULL,
  `year_level` int(1) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_student_info`
--

INSERT INTO `tbl_student_info` (`student_no`, `last_name`, `first_name`, `middle_name`, `course_code`, `year_level`, `password`) VALUES
('22-0001', 'Awayan', 'Marlie Mae', 'Borbon', 'BSIT', 3, '827ccb0eea8a706c4c34a16891f84e7b'),
('22-0002', 'Lim', 'James', 'Lim', 'BEED', 2, '827ccb0eea8a706c4c34a16891f84e7b'),
('22-0003', 'Biago', 'Elda', 'Borbon', 'BSCS', 1, '827ccb0eea8a706c4c34a16891f84e7b'),
('22-0004', 'Lennon', 'Kate', 'Lim', 'BSIT', 4, '827ccb0eea8a706c4c34a16891f84e7b'),
('22-0005', 'Fernandez', 'Jack', 'Reyes', 'BSME', 1, '827ccb0eea8a706c4c34a16891f84e7b'),
('22-0006', 'Tejero', 'Gary', 'Dantes', 'BSECE', 2, '827ccb0eea8a706c4c34a16891f84e7b'),
('22-0007', 'Windsor', 'Elizabeth', 'Chu', 'BSN', 4, '827ccb0eea8a706c4c34a16891f84e7b'),
('22-0008', 'Fadrigo', 'Ryan', 'Santos', 'BSN', 2, '827ccb0eea8a706c4c34a16891f84e7b');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subject`
--

CREATE TABLE `tbl_subject` (
  `subject_code` varchar(20) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `department_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_subject`
--

INSERT INTO `tbl_subject` (`subject_code`, `subject_name`, `department_code`) VALUES
('GCS-101', 'Mathematics in the Modern World', 'ACC'),
('IT220', 'Software Engineering', 'IT'),
('IT221', 'Elective 4', 'IT'),
('ITC128', 'Social and Professional Issure', 'IT'),
('ITC129', 'Computer Organization', 'IT');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` varchar(20) NOT NULL,
  `password` text NOT NULL,
  `account_type` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `password`, `account_type`, `status`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'active'),
('admin01', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'inactive'),
('Marlie-Admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'active'),
('Marlie-User', '827ccb0eea8a706c4c34a16891f84e7b', 'user', 'active'),
('Marlie01', '827ccb0eea8a706c4c34a16891f84e7b', 'user', 'active'),
('Ryan-Admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'active'),
('User01', '827ccb0eea8a706c4c34a16891f84e7b', 'user', 'active'),
('User02', '827ccb0eea8a706c4c34a16891f84e7b', 'user', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_course`
--
ALTER TABLE `tbl_course`
  ADD PRIMARY KEY (`course_code`);

--
-- Indexes for table `tbl_department`
--
ALTER TABLE `tbl_department`
  ADD PRIMARY KEY (`department_code`);

--
-- Indexes for table `tbl_faculty`
--
ALTER TABLE `tbl_faculty`
  ADD PRIMARY KEY (`faculty_code`);

--
-- Indexes for table `tbl_school_year`
--
ALTER TABLE `tbl_school_year`
  ADD PRIMARY KEY (`school_year_code`);

--
-- Indexes for table `tbl_student_info`
--
ALTER TABLE `tbl_student_info`
  ADD PRIMARY KEY (`student_no`);

--
-- Indexes for table `tbl_subject`
--
ALTER TABLE `tbl_subject`
  ADD PRIMARY KEY (`subject_code`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
