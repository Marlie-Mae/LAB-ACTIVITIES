-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Feb 11, 2025 at 03:47 AM
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
('BEED', 'Bachelor of Elementary Education'),
('BSACC', 'Bachelor of Science in Accountancy'),
('BSBA', 'Bachelor of Science in Business Administration'),
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
('F-001', 'Maylane Ballita', 'IT', '827ccb0eea8a706c4c34a16891f84e7b');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_school_year`
--

CREATE TABLE `tbl_school_year` (
  `school_year_code` varchar(11) NOT NULL,
  `school_year` varchar(9) NOT NULL,
  `semester` varchar(6) NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_school_year`
--

INSERT INTO `tbl_school_year` (`school_year_code`, `school_year`, `semester`, `status`) VALUES
('2024-2025-1', '2024-2025', '1', 1);

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
('22-0002', 'Lim', 'Fatima', 'Reyes', 'BSCS', 1, '827ccb0eea8a706c4c34a16891f84e7b');

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
('IT220', 'Software Engineering', 'IT'),
('IT221', 'Elective 4', 'IT'),
('ITC128', 'Social and Professional Issure', 'IT'),
('ITC129', 'Computer Organization', 'IT');

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
