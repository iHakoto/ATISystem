-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2024 at 05:27 PM
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

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Id`, `Firstname`, `Middlename`, `Lastname`, `Email`, `Admin_img`, `phonenumber`, `Added_at`) VALUES
(76, 'William Rowell', 'Aplacador', 'Gimena', 'williamrowellgimena1@yahoo.com', 'william.jpg', '922321111', '2022-10-04 23:17:33'),
(80, 'Rowell', 'awdadawdwa', 'Gimena', 'willgimena1@gmail.com', '', '09758869674', '2024-09-26 19:45:38');

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
(8, 0, 76, 'School', 'waedwadwa', 'wdad', '02:59:00', '03:59:00', '2024-12-31', 1, '2024-11-10 16:04:06');

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
(22, 15, 'Red', '2022-12-18 13:46:28'),
(23, 17, 'Blue', '2024-09-29 16:23:43'),
(24, 15, 'Pink', '2024-10-19 23:59:31');

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
(32, 22, 11, 65, '7', '18:00:00', '20:00:00', '2024-09-29 17:02:24'),
(33, 23, 12, 65, '7', '14:00:00', '16:00:00', '2024-09-29 17:02:41'),
(36, 22, 11, 66, '7', '20:00:00', '21:00:00', '2024-09-29 22:41:40'),
(37, 24, 13, 65, '7', '20:00:00', '21:00:00', '2024-10-20 00:00:13'),
(38, 24, 11, 65, '10', '21:00:00', '23:00:00', '2024-10-26 01:53:22');

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
(65, 'Dave', '', 'Perf', 'Dave1@gmail.com', '2.png', '09232323232', '2024-09-29 17:00:02'),
(66, 'Jerome', 'Magsino', 'Pogi', 'jerome1@gmail.com', '', '09111111111', '2024-09-29 17:00:26');

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
(15, 'Grade 1', 'test1', '2022-12-18 13:45:55'),
(17, 'Grade 2', '', '2024-09-26 20:54:10'),
(18, 'Grade 3', '', '2024-10-19 23:58:38');

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
(73, 188, 65, 38, '3', '23', '10', '23', '56.00', '', 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, '2024-11-12 23:00:43'),
(74, 188, 65, 37, '1', '20.20', '10', '23', '53.20', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-11-12 23:51:44'),
(75, 179, 65, 37, '1', '31', '10', '23', '64.00', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-11-12 23:52:02'),
(76, 179, 65, 38, '1', '44', '23', '12', '79.00', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-11-12 23:52:44'),
(77, 188, 65, 37, '2', '30', '12', '23', '65.00', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-11-12 23:55:01');

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
(178, 'Brix', 'test', 'Paredes', 'brix@gmail.com', '', 22, '09222222222', '2024-09-29 17:01:07'),
(179, 'Romel', 'test', 'Panganiban', 'romel1@gmail.com', '3.png', 24, '09344333333', '2024-09-29 17:01:34'),
(188, 'Rowell', '', 'Gimena', 'willgimena1@gmail.com', 'GRITTY.jpg', 24, '09758869674', '2024-10-19 23:58:20');

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
(11, 'Math', '(Grade 1)', '2024-09-26 00:20:26'),
(12, 'English', '', '2024-09-26 20:54:23'),
(13, 'Science', '(Grade 1)', '2024-10-19 23:59:00');

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
(1, 'ATISystem', 'will@sample.com', '0948 8542 622', 'test.jpg', '', '', '&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-weight: 400; text-align: justify;&quot;&gt;&amp;nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&rsquo;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;');

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
(8, '36', '66', 'School', 'wadad', 'awdadwad', '02:00:00', '04:00:00', '2024-11-15', 1, '2024-11-10 16:04:48');

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
(44, 'williamrowellgimena1@yahoo.com', 'fcea920f7412b5da7be0cf42b8c93759', '3', 0, 0, 76, 0, 'NULL'),
(113, 'Dave1@gmail.com', 'fcea920f7412b5da7be0cf42b8c93759', '2', 65, 0, 0, 0, ''),
(114, 'jerome1@gmail.com', 'fcea920f7412b5da7be0cf42b8c93759', '2', 66, 0, 0, 0, ''),
(115, 'brix@gmail.com', 'fcea920f7412b5da7be0cf42b8c93759', '1', 0, 178, 0, 22, ''),
(116, 'romel1@gmail.com', 'fcea920f7412b5da7be0cf42b8c93759', '1', 0, 179, 0, 24, ''),
(129, 'willgimena1@gmail.com', 'fcea920f7412b5da7be0cf42b8c93759', '1', 0, 188, 0, 24, '');

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
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `Id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `class_subjects`
--
ALTER TABLE `class_subjects`
  MODIFY `Id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `days`
--
ALTER TABLE `days`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `Id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `gradelevel`
--
ALTER TABLE `gradelevel`
  MODIFY `Id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `Id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `quarters`
--
ALTER TABLE `quarters`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `Id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `Id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `teacher_announcement`
--
ALTER TABLE `teacher_announcement`
  MODIFY `Id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
