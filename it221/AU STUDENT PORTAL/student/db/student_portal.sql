-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql213.infinityfree.com
-- Generation Time: Mar 23, 2025 at 02:05 AM
-- Server version: 10.6.19-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_38326677_student_portal`
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
('BSAIS', 'Bachelor of Science in Accounting Information System'),
('BSED', 'Bachelor of Secondary Education'),
('BSHM', 'Bachelor of Science in Hospitality Management'),
('BSIT', 'Bachelor of Science in Information Technology'),
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
('CAS', 'College of Arts and Science'),
('CCJE', 'College of Criminal Justice Education'),
('CE', 'College of Education'),
('CIT', 'College of Information Technology');

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
('CIT01', 'Maylane Ballita', 'CIT', '@rell@no53');

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
('2024-2025-1', '2024-2025', '1', 'active'),
('2024-2025-2', '2024-2025', '2', 'active');

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
('21-00080', 'Palad', 'Juaren', 'Pablo', 'BSIT', 3, 'da69d4d08f053d165041d1fa1813cab7'),
('22-00017', 'Serrano', 'John Lloyd', 'Francisco', 'BSIT', 3, 'da69d4d08f053d165041d1fa1813cab7'),
('22-00025', 'Francisco', 'Jofer Jhon', 'Reyes', 'BSIT', 3, 'da69d4d08f053d165041d1fa1813cab7'),
('22-00029', 'De Guzman', 'Hannah', 'Mahinay', 'BSIT', 3, 'da69d4d08f053d165041d1fa1813cab7'),
('22-00037', 'Awayan', 'Marlie Mae', 'Borbon', 'BSIT', 3, '827ccb0eea8a706c4c34a16891f84e7b'),
('22-00049', 'Silva', 'Jerho', 'Lolong', 'BSIT', 3, 'da69d4d08f053d165041d1fa1813cab7'),
('22-00050', 'Juanites', 'John Raymund', 'Marquez', 'BSIT', 3, 'da69d4d08f053d165041d1fa1813cab7'),
('22-00055', 'Aquino', 'Marc Abi', 'Lesaca', 'BSIT', 3, 'da69d4d08f053d165041d1fa1813cab7'),
('22-00058', 'Concha', 'Christian Jake', 'Abrenica', 'BSIT', 3, 'da69d4d08f053d165041d1fa1813cab7'),
('22-00062', 'Edangalino', 'Judith', 'Fontamillas', 'BSIT', 3, 'da69d4d08f053d165041d1fa1813cab7'),
('22-00071', 'Gallano', 'Miguel Carlo', 'Nantes', 'BSIT', 3, 'da69d4d08f053d165041d1fa1813cab7'),
('22-00072', 'Dipasupil', 'Edrian', 'Caalim', 'BSIT', 3, 'da69d4d08f053d165041d1fa1813cab7'),
('22-00091', 'Vergara', 'Krizia Angela', 'Pastoral', 'BSIT', 3, 'da69d4d08f053d165041d1fa1813cab7'),
('22-00104', 'Guia', 'John Vincent', 'Mose', 'BSIT', 3, 'da69d4d08f053d165041d1fa1813cab7'),
('22-00120', 'Barbosa', 'Larry', 'Sombreo', 'BSIT', 3, 'da69d4d08f053d165041d1fa1813cab7'),
('22-00122', 'Guchone', 'Jacquelyn Lilly', 'Suya', 'BSIT', 3, 'da69d4d08f053d165041d1fa1813cab7'),
('22-00132', 'Lomugdang', 'Junalyn', 'Esclamado', 'BSIT', 3, 'da69d4d08f053d165041d1fa1813cab7'),
('22-00144', 'Pedro', 'Mark Joshua', 'Orejas', 'BSIT', 3, 'da69d4d08f053d165041d1fa1813cab7'),
('22-00150', 'Mayoya', 'Joshua', 'San Antonio', 'BSIT', 3, 'da69d4d08f053d165041d1fa1813cab7'),
('23-00056', 'Buenacosa', 'Genesis', 'Abkilan', 'BSIT', 3, 'da69d4d08f053d165041d1fa1813cab7'),
('23-00123', 'Layugan', 'Abigail', 'Capili', 'BSIT', 3, 'da69d4d08f053d165041d1fa1813cab7'),
('24-00057', 'Mingoa', 'Charlene', 'Pelopero', 'BSIT', 3, 'da69d4d08f053d165041d1fa1813cab7');

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
('GCAS 05', 'Mathematics in the Modern World', 'CAS'),
('GCAS 06', 'Purposive Communication', 'CAS'),
('GCAS 07', 'Science, Technology, and Society', 'CAS'),
('GCAS 15', 'P.E. 1 Enhancement Movement', 'CAS'),
('GCAS 19', 'NSTP 1', 'CIT'),
('IT 221', 'Elective 4', 'CIT'),
('ITC 110', 'Introduction to Computing', 'CIT'),
('ITC 111', 'Computer Programming 1', 'CIT'),
('ITC 112', 'Introduction to Graphics and Design', 'CIT'),
('ITC 120', 'Computer Programming 2', 'CIT'),
('ITC 121', 'Operating System', 'CIT'),
('ITC 122', 'Intro to Web Design', 'CIT'),
('ITC 210', 'Discrete Mathematics', 'CIT');

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
('admin', 'da69d4d08f053d165041d1fa1813cab7', 'admin', 'active'),
('Marlie-Admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'active'),
('Marlie-User', '827ccb0eea8a706c4c34a16891f84e7b', 'user', 'active');

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
