-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 07, 2024 at 05:25 AM
-- Server version: 8.0.40
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `evaluation`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `username`, `email`, `password`, `image`, `date_created`) VALUES
(1, 'devon', 'devon', 'devon@gmail.com', '123', '', '2024-11-02 02:09:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblanswer`
--

CREATE TABLE `tblanswer` (
  `answer_id` int NOT NULL,
  `evaluate_id` int NOT NULL,
  `criteria_id` int NOT NULL,
  `comment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ratings` enum('1','2','3','4') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblcriteria`
--

CREATE TABLE `tblcriteria` (
  `criteria_id` int NOT NULL,
  `criteria` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcriteria`
--

INSERT INTO `tblcriteria` (`criteria_id`, `criteria`) VALUES
(1, 'Preparation of the lessons'),
(2, 'Routine activities (checking of  attendance, etc.)'),
(3, 'Lesson motivation'),
(4, 'Mastery of the subject matter'),
(5, 'Teaching  techniques and strategies'),
(6, 'Classroom management / Class disicpline'),
(7, 'Clarity of Explanation'),
(8, 'Command of language of instruction'),
(9, 'Voice of modulation and diction'),
(10, 'Class participation in the discussion'),
(11, 'Grooming / Personality'),
(12, ' Prompt in coming to the class and never been absent'),
(13, 'Time consciousness (arrival / departure)');

-- --------------------------------------------------------

--
-- Table structure for table `tbldepartment`
--

CREATE TABLE `tbldepartment` (
  `department_id` int NOT NULL,
  `department_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbldepartment`
--

INSERT INTO `tbldepartment` (`department_id`, `department_name`) VALUES
(1, 'Information Technology'),
(2, 'BS Education (English)'),
(3, 'BS Education (Math)'),
(4, 'Elementay Education'),
(5, 'Hospitality and Tourism Management'),
(6, 'Criminology'),
(7, 'Senior High'),
(8, 'Junior High');

-- --------------------------------------------------------

--
-- Table structure for table `tblevaluate`
--

CREATE TABLE `tblevaluate` (
  `evaluation_id` int NOT NULL,
  `schoolyear_id` int NOT NULL,
  `student_id` int NOT NULL,
  `teacher_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblschoolyear`
--

CREATE TABLE `tblschoolyear` (
  `schoolyear_id` int NOT NULL,
  `school_year` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `semester` enum('1','2','3','') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_default` enum('No','Yes') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'No',
  `is_status` enum('Not Yet Started','Started','Closed') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Not Yet Started'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblschoolyear`
--

INSERT INTO `tblschoolyear` (`schoolyear_id`, `school_year`, `semester`, `is_default`, `is_status`) VALUES
(20, '2020 - 2021', '1', 'Yes', 'Started');

-- --------------------------------------------------------

--
-- Table structure for table `tblsection`
--

CREATE TABLE `tblsection` (
  `section_id` int NOT NULL,
  `section_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `year_level` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblsection`
--

INSERT INTO `tblsection` (`section_id`, `section_name`, `year_level`) VALUES
(1, 'A1', 1),
(2, 'B1', 2),
(3, 'C1', 3),
(4, 'D1', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tblsection_teacher_subject`
--

CREATE TABLE `tblsection_teacher_subject` (
  `section_teacher_subject_id` int NOT NULL,
  `section_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `subject_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblstudent`
--

CREATE TABLE `tblstudent` (
  `student_id` int NOT NULL,
  `school_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `department_id` int NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `year_level` int NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblstudent_section`
--

CREATE TABLE `tblstudent_section` (
  `student_section_id` int NOT NULL,
  `student_id` int NOT NULL,
  `section_id` int NOT NULL,
  `is_regular` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblstudent_teacher_subject`
--

CREATE TABLE `tblstudent_teacher_subject` (
  `sts_id` int NOT NULL,
  `student_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `subject_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblsubject`
--

CREATE TABLE `tblsubject` (
  `subject_id` int NOT NULL,
  `subject_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblsubject`
--

INSERT INTO `tblsubject` (`subject_id`, `subject_name`) VALUES
(7, '123'),
(9, '213'),
(8, '321'),
(6, 'IT DB'),
(2, 'IT DB1'),
(4, 'IT IPT'),
(5, 'IT PT'),
(1, 'IT SAD'),
(3, 'IT SPI');

-- --------------------------------------------------------

--
-- Table structure for table `tblteacher`
--

CREATE TABLE `tblteacher` (
  `teacher_id` int NOT NULL,
  `school_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `department_id` int NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblteacher`
--

INSERT INTO `tblteacher` (`teacher_id`, `school_id`, `name`, `department_id`, `image`) VALUES
(1, 9876543, 'sad sad', 1, '672b5b641f8d9.jpg'),
(2, 8765432, 'das das', 2, '672b5b7cc3de7.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tblteacher_section`
--

CREATE TABLE `tblteacher_section` (
  `teacher_section_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `section_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblanswer`
--
ALTER TABLE `tblanswer`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `evaluate_id` (`evaluate_id`),
  ADD KEY `criteria_id` (`criteria_id`);

--
-- Indexes for table `tblcriteria`
--
ALTER TABLE `tblcriteria`
  ADD PRIMARY KEY (`criteria_id`);

--
-- Indexes for table `tbldepartment`
--
ALTER TABLE `tbldepartment`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `tblevaluate`
--
ALTER TABLE `tblevaluate`
  ADD PRIMARY KEY (`evaluation_id`),
  ADD KEY `schoolyear_id` (`schoolyear_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `tblschoolyear`
--
ALTER TABLE `tblschoolyear`
  ADD PRIMARY KEY (`schoolyear_id`);

--
-- Indexes for table `tblsection`
--
ALTER TABLE `tblsection`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `tblsection_teacher_subject`
--
ALTER TABLE `tblsection_teacher_subject`
  ADD PRIMARY KEY (`section_teacher_subject_id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `tblstudent`
--
ALTER TABLE `tblstudent`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `tblstudent_section`
--
ALTER TABLE `tblstudent_section`
  ADD PRIMARY KEY (`student_section_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `tblstudent_teacher_subject`
--
ALTER TABLE `tblstudent_teacher_subject`
  ADD PRIMARY KEY (`sts_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `tblsubject`
--
ALTER TABLE `tblsubject`
  ADD PRIMARY KEY (`subject_id`),
  ADD UNIQUE KEY `subject_name` (`subject_name`);

--
-- Indexes for table `tblteacher`
--
ALTER TABLE `tblteacher`
  ADD PRIMARY KEY (`teacher_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `tblteacher_section`
--
ALTER TABLE `tblteacher_section`
  ADD PRIMARY KEY (`teacher_section_id`),
  ADD KEY ` teacher_id` (`teacher_id`),
  ADD KEY `section_id` (`section_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblanswer`
--
ALTER TABLE `tblanswer`
  MODIFY `answer_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcriteria`
--
ALTER TABLE `tblcriteria`
  MODIFY `criteria_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbldepartment`
--
ALTER TABLE `tbldepartment`
  MODIFY `department_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblevaluate`
--
ALTER TABLE `tblevaluate`
  MODIFY `evaluation_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblschoolyear`
--
ALTER TABLE `tblschoolyear`
  MODIFY `schoolyear_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tblsection`
--
ALTER TABLE `tblsection`
  MODIFY `section_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblsection_teacher_subject`
--
ALTER TABLE `tblsection_teacher_subject`
  MODIFY `section_teacher_subject_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblstudent`
--
ALTER TABLE `tblstudent`
  MODIFY `student_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblstudent_section`
--
ALTER TABLE `tblstudent_section`
  MODIFY `student_section_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblstudent_teacher_subject`
--
ALTER TABLE `tblstudent_teacher_subject`
  MODIFY `sts_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblsubject`
--
ALTER TABLE `tblsubject`
  MODIFY `subject_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblteacher`
--
ALTER TABLE `tblteacher`
  MODIFY `teacher_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblteacher_section`
--
ALTER TABLE `tblteacher_section`
  MODIFY `teacher_section_id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblsection_teacher_subject`
--
ALTER TABLE `tblsection_teacher_subject`
  ADD CONSTRAINT `tblsection_teacher_subject_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `tblsection` (`section_id`),
  ADD CONSTRAINT `tblsection_teacher_subject_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `tblteacher` (`teacher_id`),
  ADD CONSTRAINT `tblsection_teacher_subject_ibfk_3` FOREIGN KEY (`subject_id`) REFERENCES `tblsubject` (`subject_id`);

--
-- Constraints for table `tblstudent_teacher_subject`
--
ALTER TABLE `tblstudent_teacher_subject`
  ADD CONSTRAINT `tblstudent_teacher_subject_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `tblstudent` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tblstudent_teacher_subject_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `tblteacher` (`teacher_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tblstudent_teacher_subject_ibfk_3` FOREIGN KEY (`subject_id`) REFERENCES `tblsubject` (`subject_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
