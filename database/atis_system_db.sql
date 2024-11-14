-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2024 at 01:13 PM
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
-- Database: `atis_system_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `access`
--

CREATE TABLE `access` (
  `Id` int(11) NOT NULL,
  `Access` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `access`
--

INSERT INTO `access` (`Id`, `Access`) VALUES
(1, 'Student'),
(2, 'Teacher'),
(3, 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Id` int(11) NOT NULL,
  `Firstname` varchar(50) NOT NULL,
  `Middlename` varchar(50) NOT NULL,
  `Lastname` varchar(50) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `Admin_img` varchar(50) NOT NULL,
  `phonenumber` varchar(200) NOT NULL,
  `Added_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `Id` int(11) NOT NULL,
  `class_id` int(10) NOT NULL,
  `admin_faculty_id` int(10) NOT NULL,
  `type` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `announce_date` date NOT NULL,
  `status` int(10) NOT NULL DEFAULT 1,
  `addet_At` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`Id`, `class_id`, `admin_faculty_id`, `type`, `title`, `description`, `start_time`, `end_time`, `announce_date`, `status`, `addet_At`) VALUES
(10, 0, 1, 'School', 'Admin Announcemt', 'This is an admin announcement.', '00:00:00', '00:00:00', '2024-11-14', 1, '2024-11-14 12:42:28');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `Id` int(200) NOT NULL,
  `Gradelevel_Id` int(100) NOT NULL,
  `Section` varchar(100) NOT NULL,
  `added_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`Id`, `Gradelevel_Id`, `Section`, `added_at`) VALUES
(25, 15, 'Red', '2024-11-14 11:55:38'),
(26, 17, 'Apple', '2024-11-14 11:55:43'),
(27, 18, 'Oak', '2024-11-14 11:55:48');

-- --------------------------------------------------------

--
-- Table structure for table `class_subjects`
--

CREATE TABLE `class_subjects` (
  `Id` int(50) NOT NULL,
  `class_id` int(50) NOT NULL,
  `subject_id` int(50) NOT NULL,
  `faculty_id` int(20) NOT NULL,
  `day` varchar(10) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `added_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_subjects`
--

INSERT INTO `class_subjects` (`Id`, `class_id`, `subject_id`, `faculty_id`, `day`, `start_time`, `end_time`, `added_at`) VALUES
(39, 25, 16, 70, '7', '08:00:00', '09:00:00', '2024-11-14 12:06:13'),
(41, 26, 14, 71, '11', '06:00:00', '07:00:00', '2024-11-14 12:36:38'),
(42, 27, 14, 71, '11', '06:00:00', '07:00:00', '2024-11-14 12:37:02');

-- --------------------------------------------------------

--
-- Table structure for table `days`
--

CREATE TABLE `days` (
  `Id` int(10) NOT NULL,
  `day` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `days`
--

INSERT INTO `days` (`Id`, `day`) VALUES
(7, 'M'),
(8, 'T'),
(9, 'W'),
(10, 'TH'),
(11, 'F'),
(12, 'S');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `Id` int(200) NOT NULL,
  `Firstname` varchar(50) NOT NULL,
  `Middlename` varchar(50) NOT NULL,
  `Lastname` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Faculty_img` varchar(50) NOT NULL,
  `phonenumber` varchar(100) NOT NULL,
  `Added_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`Id`, `Firstname`, `Middlename`, `Lastname`, `Email`, `Faculty_img`, `phonenumber`, `Added_at`) VALUES
(70, 'Anthony Gabriel', '', 'Amurao', 'faculty1@school.edu', '', '123456', '2024-11-14 11:57:06'),
(71, 'John', '', 'Pliskin', 'faculty2@school.edu', '', '123456', '2024-11-14 12:00:23');

-- --------------------------------------------------------

--
-- Table structure for table `gradelevel`
--

CREATE TABLE `gradelevel` (
  `Id` int(200) NOT NULL,
  `Gradelevel` varchar(100) NOT NULL,
  `Description` varchar(200) NOT NULL,
  `added_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gradelevel`
--

INSERT INTO `gradelevel` (`Id`, `Gradelevel`, `Description`, `added_at`) VALUES
(15, 'Grade 1', 'Elementary', '2022-12-18 13:45:55'),
(17, 'Grade 2', 'Elementary', '2024-09-26 20:54:10'),
(18, 'Grade 3', 'Elementary', '2024-10-19 23:58:38'),
(19, 'Grade 4', 'Elementary', '2024-11-14 14:44:32'),
(20, 'Grade 5', 'Elementary', '2024-11-14 14:44:43'),
(21, 'Grade 6', 'Elementary', '2024-11-14 14:44:49'),
(22, 'Grade 7', 'Junior High', '2024-11-14 14:45:07');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `Id` int(50) NOT NULL,
  `student_id` int(50) NOT NULL,
  `faculty_id` int(50) NOT NULL,
  `class_subject_id` int(50) NOT NULL,
  `quarter_id` varchar(50) NOT NULL,
  `written_work` varchar(50) NOT NULL,
  `performance_task` varchar(50) NOT NULL,
  `quarterly_assesment` varchar(50) NOT NULL,
  `quarterly_grade` varchar(50) NOT NULL,
  `comment` varchar(50) NOT NULL,
  `ww1` int(11) NOT NULL,
  `ww2` int(11) NOT NULL,
  `ww3` int(10) NOT NULL,
  `ww4` int(10) NOT NULL,
  `ww5` int(10) NOT NULL,
  `pt1` int(10) NOT NULL,
  `pt2` int(10) NOT NULL,
  `pt3` int(10) NOT NULL,
  `pt4` int(10) NOT NULL,
  `pt5` int(10) NOT NULL,
  `qa` int(10) NOT NULL,
  `addet_At` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`Id`, `student_id`, `faculty_id`, `class_subject_id`, `quarter_id`, `written_work`, `performance_task`, `quarterly_assesment`, `quarterly_grade`, `comment`, `ww1`, `ww2`, `ww3`, `ww4`, `ww5`, `pt1`, `pt2`, `pt3`, `pt4`, `pt5`, `qa`, `addet_At`) VALUES
(78, 200, 70, 39, '1', '20', '25', '20', '65.00', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-11-14 12:47:50'),
(79, 200, 70, 39, '2', '25', '40', '15', '80.00', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-11-14 12:48:26'),
(80, 200, 70, 39, '3', '20', '50', '15', '85.00', '3rd quarterr', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-11-14 12:52:46'),
(81, 200, 70, 39, '4', '25', '40', '15', '80.00', '4th quarter', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-11-14 12:53:21');

-- --------------------------------------------------------

--
-- Table structure for table `quarters`
--

CREATE TABLE `quarters` (
  `Id` int(11) NOT NULL,
  `quarter` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quarters`
--

INSERT INTO `quarters` (`Id`, `quarter`) VALUES
(1, 'First Quarter'),
(2, 'Second Quarter'),
(3, 'Third Quarter'),
(4, 'Fourth Quarter');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `Id` int(200) NOT NULL,
  `Firstname` varchar(50) NOT NULL,
  `Middlename` varchar(50) NOT NULL,
  `Lastname` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Student_img` varchar(50) NOT NULL,
  `class_id` int(50) NOT NULL,
  `phonenumber` varchar(200) NOT NULL,
  `Added_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`Id`, `Firstname`, `Middlename`, `Lastname`, `Email`, `Student_img`, `class_id`, `phonenumber`, `Added_at`) VALUES
(200, 'Clarence', '', 'Cabiles', 'student1@school.edu', '', 25, '123456', '2024-11-14 11:51:56'),
(201, 'John Mark', '', 'Canlas', 'student2@school.edu', '', 25, '123456', '2024-11-14 11:56:28'),
(202, 'John Carl', '', 'Mendoza', 'student3@school.edu', '', 25, '123456', '2024-11-14 11:56:48'),
(203, 'Mark Anthony', '', 'Gonzales', 'student4@school.edu', '', 26, '123456', '2024-11-14 15:08:01');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `Id` int(200) NOT NULL,
  `Subject` varchar(100) NOT NULL,
  `Description` varchar(200) NOT NULL,
  `added_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`Id`, `Subject`, `Description`, `added_at`) VALUES
(14, 'MAPEH', '1-6', '2024-11-14 11:53:14'),
(15, 'Science', '1-6', '2024-11-14 11:53:18'),
(16, 'Math', '1-6', '2024-11-14 11:53:27'),
(17, 'AP', '1-6', '2024-11-14 11:53:42'),
(18, 'English', '1-6', '2024-11-14 11:53:51');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `cover_img1` varchar(100) NOT NULL,
  `cover_img2` varchar(100) NOT NULL,
  `cover_img3` varchar(100) NOT NULL,
  `about_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `cover_img1`, `cover_img2`, `cover_img3`, `about_content`) VALUES
(1, 'ATISystem', 'email@sample.com', '123456', 'test.jpg', '', '', '&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-weight: 400; text-align: justify;&quot;&gt;&amp;nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&rsquo;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_announcement`
--

CREATE TABLE `teacher_announcement` (
  `Id` int(50) NOT NULL,
  `class_id` varchar(50) NOT NULL,
  `faculty_id` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `announce_date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `added_At` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_announcement`
--

INSERT INTO `teacher_announcement` (`Id`, `class_id`, `faculty_id`, `type`, `title`, `description`, `start_time`, `end_time`, `announce_date`, `status`, `added_At`) VALUES
(6, '38', '65', 'School', 'adwdaw', 'awdwad', '00:00:00', '01:00:00', '2024-11-20', 1, '2024-11-10 16:04:48'),
(8, '36', '66', 'School', 'wadad', 'awdadwad', '02:00:00', '04:00:00', '2024-11-15', 1, '2024-11-10 16:04:48'),
(10, '39', '70', 'School', 'Teacher Announcement', 'Homework for class \"Red\"', '00:00:00', '00:00:00', '2024-11-14', 1, '2024-11-14 14:15:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int(200) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `access` varchar(100) NOT NULL,
  `Faculty_Id` int(50) NOT NULL,
  `Student_Id` int(50) NOT NULL,
  `Admin_Id` int(50) NOT NULL,
  `stud_class_id` int(100) NOT NULL,
  `resettoken` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `username`, `password`, `access`, `Faculty_Id`, `Student_Id`, `Admin_Id`, `stud_class_id`, `resettoken`) VALUES
(144, 'student1@school.edu', 'e10adc3949ba59abbe56e057f20f883e', '1', 0, 200, 0, 25, ''),
(145, 'student2@school.edu', 'e10adc3949ba59abbe56e057f20f883e', '1', 0, 201, 0, 25, ''),
(146, 'student3@school.edu', 'e10adc3949ba59abbe56e057f20f883e', '1', 0, 202, 0, 25, ''),
(147, 'faculty1@school.edu', 'e10adc3949ba59abbe56e057f20f883e', '2', 70, 0, 0, 0, ''),
(148, 'faculty2@school.edu', 'e10adc3949ba59abbe56e057f20f883e', '2', 71, 0, 0, 0, ''),
(150, 'student4@school.edu', 'e10adc3949ba59abbe56e057f20f883e', '3', 0, 0, 11, 0, ''),
(151, 'admin1@school.edu', '21232f297a57a5a743894a0e4a801fc3', '3', 0, 0, 1, 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Gradelevel_Id` (`Gradelevel_Id`);

--
-- Indexes for table `class_subjects`
--
ALTER TABLE `class_subjects`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `days`
--
ALTER TABLE `days`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `gradelevel`
--
ALTER TABLE `gradelevel`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `quarters`
--
ALTER TABLE `quarters`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_announcement`
--
ALTER TABLE `teacher_announcement`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access`
--
ALTER TABLE `access`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `Id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `class_subjects`
--
ALTER TABLE `class_subjects`
  MODIFY `Id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `days`
--
ALTER TABLE `days`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `Id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `gradelevel`
--
ALTER TABLE `gradelevel`
  MODIFY `Id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `Id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `quarters`
--
ALTER TABLE `quarters`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `Id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `Id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `teacher_announcement`
--
ALTER TABLE `teacher_announcement`
  MODIFY `Id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
