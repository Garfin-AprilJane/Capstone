-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2023 at 07:42 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ans_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

CREATE TABLE `details` (
  `detail_id` int(11) NOT NULL,
  `school_year_id` int(11) NOT NULL,
  `year_level` enum('Grade7','Grade8','Grade9','Grade10') NOT NULL,
  `section` varchar(100) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `details`
--

INSERT INTO `details` (`detail_id`, `school_year_id`, `year_level`, `section`, `student_id`) VALUES
(1, 1, 'Grade8', 'q', 1),
(2, 1, 'Grade9', 'z', 2);

-- --------------------------------------------------------

--
-- Table structure for table `first_grading`
--

CREATE TABLE `first_grading` (
  `first_grading_id` int(11) NOT NULL,
  `english` varchar(100) NOT NULL,
  `filipino` varchar(100) NOT NULL,
  `math` varchar(100) NOT NULL,
  `science` varchar(100) NOT NULL,
  `ap` varchar(100) NOT NULL,
  `esp` varchar(100) NOT NULL,
  `tle` varchar(100) NOT NULL,
  `music` varchar(100) NOT NULL,
  `art` varchar(100) NOT NULL,
  `pe` varchar(100) NOT NULL,
  `health` varchar(100) NOT NULL,
  `avg` varchar(100) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `first_grading`
--

INSERT INTO `first_grading` (`first_grading_id`, `english`, `filipino`, `math`, `science`, `ap`, `esp`, `tle`, `music`, `art`, `pe`, `health`, `avg`, `student_id`) VALUES
(1, '87', '88', ' 88', '88', '88', '88', '88', '88', '88', '88', '88', '88.00', 1),
(2, '88', '88', '88', '88', '88', '88', '88', '88', '88', '88', '88', '88.00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `fourth_grading`
--

CREATE TABLE `fourth_grading` (
  `fourth_grading_id` int(11) NOT NULL,
  `english` varchar(100) NOT NULL,
  `filipino` varchar(100) NOT NULL,
  `math` varchar(100) NOT NULL,
  `science` varchar(100) NOT NULL,
  `ap` varchar(100) NOT NULL,
  `esp` varchar(100) NOT NULL,
  `tle` varchar(100) NOT NULL,
  `music` varchar(100) NOT NULL,
  `art` varchar(100) NOT NULL,
  `pe` varchar(100) NOT NULL,
  `health` varchar(100) NOT NULL,
  `avg` varchar(100) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fourth_grading`
--

INSERT INTO `fourth_grading` (`fourth_grading_id`, `english`, `filipino`, `math`, `science`, `ap`, `esp`, `tle`, `music`, `art`, `pe`, `health`, `avg`, `student_id`) VALUES
(1, '99', '99', '99', '99', '99', '99', '99', '99', '99', '99', '99', '99.00', 1),
(2, '99', '99', '99', '99', '99', '99', '99', '99', '99', '99', '99', '99.00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `grade_id` int(11) NOT NULL,
  `grade_value` varchar(100) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `detail_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `history_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `school_year_value` varchar(100) NOT NULL,
  `section` varchar(100) NOT NULL,
  `grading_period` varchar(100) NOT NULL,
  `english` varchar(100) NOT NULL,
  `filipino` varchar(100) NOT NULL,
  `math` varchar(100) NOT NULL,
  `science` varchar(100) NOT NULL,
  `ap` varchar(100) NOT NULL,
  `esp` varchar(100) NOT NULL,
  `tle` varchar(100) NOT NULL,
  `music` varchar(100) NOT NULL,
  `art` varchar(100) NOT NULL,
  `pe` varchar(100) NOT NULL,
  `health` varchar(100) NOT NULL,
  `avg` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `parent_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `occupation` varchar(100) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `relation` enum('father','mother','guardian') NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `parents`
--

INSERT INTO `parents` (`parent_id`, `full_name`, `address`, `occupation`, `contact_number`, `relation`, `student_id`) VALUES
(1, 'q', 'q', 'q', '1', 'father', 1),
(2, 'a', 'a', 'a', '1', 'father', 2);

-- --------------------------------------------------------

--
-- Table structure for table `school_year`
--

CREATE TABLE `school_year` (
  `school_year_id` int(11) NOT NULL,
  `school_year_value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `school_year`
--

INSERT INTO `school_year` (`school_year_id`, `school_year_value`) VALUES
(1, '2023-2024'),
(2, '2024-2025');

-- --------------------------------------------------------

--
-- Table structure for table `second_grading`
--

CREATE TABLE `second_grading` (
  `second_grading_id` int(11) NOT NULL,
  `english` varchar(100) NOT NULL,
  `filipino` varchar(100) NOT NULL,
  `math` varchar(100) NOT NULL,
  `science` varchar(100) NOT NULL,
  `ap` varchar(100) NOT NULL,
  `esp` varchar(100) NOT NULL,
  `tle` varchar(100) NOT NULL,
  `music` varchar(100) NOT NULL,
  `art` varchar(100) NOT NULL,
  `pe` varchar(100) NOT NULL,
  `health` varchar(100) NOT NULL,
  `avg` varchar(100) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `second_grading`
--

INSERT INTO `second_grading` (`second_grading_id`, `english`, `filipino`, `math`, `science`, `ap`, `esp`, `tle`, `music`, `art`, `pe`, `health`, `avg`, `student_id`) VALUES
(1, '77', '77', '77', '77', '77', '77', '77', '77', '77', '77', '77', '77.00', 1),
(2, '99', '99', '99', '99', '99', '99', '99', '99', '99', '99', '99', '99.00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `staff_id` int(11) NOT NULL,
  `staff_name` varchar(100) NOT NULL,
  `sex` enum('male','female') NOT NULL,
  `address` varchar(100) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`staff_id`, `staff_name`, `sex`, `address`, `contact_number`, `email_address`, `user_id`) VALUES
(1, 'john doe', 'female', 's', '99', '99ii', 3);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `lrn` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `suffix` enum('jr.','sr.','i','ii','iii','iv') NOT NULL,
  `sex` enum('male','female') NOT NULL,
  `birth_date` date NOT NULL,
  `address` varchar(100) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `age` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `lrn`, `first_name`, `middle_name`, `last_name`, `suffix`, `sex`, `birth_date`, `address`, `contact_number`, `email_address`, `age`, `user_id`) VALUES
(1, 1, 'q', ' q', 'q', '', 'male', '2023-05-30', 'q', '1', 'q', '0', 5),
(2, 2, 'a', ' a', 'a', '', 'female', '2023-06-20', 'a', '1', 'a', '-1', 6);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `third_grading`
--

CREATE TABLE `third_grading` (
  `third_grading_id` int(11) NOT NULL,
  `english` varchar(100) NOT NULL,
  `filipino` varchar(100) NOT NULL,
  `math` varchar(100) NOT NULL,
  `science` varchar(100) NOT NULL,
  `ap` varchar(100) NOT NULL,
  `esp` varchar(100) NOT NULL,
  `tle` varchar(100) NOT NULL,
  `music` varchar(100) NOT NULL,
  `art` varchar(100) NOT NULL,
  `pe` varchar(100) NOT NULL,
  `health` varchar(100) NOT NULL,
  `avg` varchar(100) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `third_grading`
--

INSERT INTO `third_grading` (`third_grading_id`, `english`, `filipino`, `math`, `science`, `ap`, `esp`, `tle`, `music`, `art`, `pe`, `health`, `avg`, `student_id`) VALUES
(1, '88', '88', '88', '88', '88', '88', '88', '88', '88', '88', '88', '88.00', 1),
(2, '88', '88', '88', '88', '88', '88', '88', '88', '88', '88', '88', '88.00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `status` enum('activated','deactivated') NOT NULL,
  `role` enum('admin','registrar','student') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `status`, `role`) VALUES
(1, '', '', 'activated', 'student'),
(2, 'admin', '6ad4664ba23eac71b5ef5e826ea0c6cd', 'activated', 'admin'),
(3, 'registrar', '3b18b721b145bde5f9cc8707e588e4a5', 'activated', 'registrar'),
(5, 'student', '03a6a0da987379dddf22b98aad899762', 'activated', 'student'),
(6, 'students', '1cc39ffd758234422e1f75beadfc5fb2', 'activated', 'student');

-- --------------------------------------------------------

--
-- Table structure for table `yearlevel`
--

CREATE TABLE `yearlevel` (
  `year_level_id` int(11) NOT NULL,
  `year_level_value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `details`
--
ALTER TABLE `details`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `school_year_id` (`school_year_id`);

--
-- Indexes for table `first_grading`
--
ALTER TABLE `first_grading`
  ADD PRIMARY KEY (`first_grading_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `fourth_grading`
--
ALTER TABLE `fourth_grading`
  ADD PRIMARY KEY (`fourth_grading_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`grade_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `detail_id` (`detail_id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`parent_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `school_year`
--
ALTER TABLE `school_year`
  ADD PRIMARY KEY (`school_year_id`);

--
-- Indexes for table `second_grading`
--
ALTER TABLE `second_grading`
  ADD PRIMARY KEY (`second_grading_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`staff_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `students_ibfk_1` (`user_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `third_grading`
--
ALTER TABLE `third_grading`
  ADD PRIMARY KEY (`third_grading_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `yearlevel`
--
ALTER TABLE `yearlevel`
  ADD PRIMARY KEY (`year_level_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `details`
--
ALTER TABLE `details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `first_grading`
--
ALTER TABLE `first_grading`
  MODIFY `first_grading_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fourth_grading`
--
ALTER TABLE `fourth_grading`
  MODIFY `fourth_grading_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
  MODIFY `parent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `school_year`
--
ALTER TABLE `school_year`
  MODIFY `school_year_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `second_grading`
--
ALTER TABLE `second_grading`
  MODIFY `second_grading_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `third_grading`
--
ALTER TABLE `third_grading`
  MODIFY `third_grading_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `yearlevel`
--
ALTER TABLE `yearlevel`
  MODIFY `year_level_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `details`
--
ALTER TABLE `details`
  ADD CONSTRAINT `details_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `details_ibfk_2` FOREIGN KEY (`school_year_id`) REFERENCES `school_year` (`school_year_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `first_grading`
--
ALTER TABLE `first_grading`
  ADD CONSTRAINT `first_grading_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fourth_grading`
--
ALTER TABLE `fourth_grading`
  ADD CONSTRAINT `fourth_grading_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`detail_id`) REFERENCES `details` (`detail_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `parents`
--
ALTER TABLE `parents`
  ADD CONSTRAINT `parents_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `second_grading`
--
ALTER TABLE `second_grading`
  ADD CONSTRAINT `second_grading_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `staffs`
--
ALTER TABLE `staffs`
  ADD CONSTRAINT `staffs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `third_grading`
--
ALTER TABLE `third_grading`
  ADD CONSTRAINT `third_grading_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
