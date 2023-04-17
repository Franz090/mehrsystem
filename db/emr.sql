-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2023 at 10:16 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emr`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(50) NOT NULL,
  `patient_id` int(50) NOT NULL,
  `midwife_id` int(50) DEFAULT NULL,
  `date` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `trimester` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `patient_id`, `midwife_id`, `date`, `status`, `trimester`) VALUES
(1, 7, NULL, '2022-11-30 00:00:00', 1, 0),
(2, 8, NULL, '2022-09-29 00:00:00', 1, 0),
(3, 9, NULL, '2022-09-29 00:00:00', 1, 0),
(4, 9, NULL, '2022-11-28 00:00:00', 1, 0),
(5, 9, NULL, '2022-09-29 00:00:00', 0, 0),
(16, 7, NULL, '2022-11-29 00:38:00', 0, 0),
(17, 8, NULL, '2022-12-04 19:02:00', -1, 0),
(18, 8, NULL, '2022-12-05 16:27:00', 1, 0),
(19, 8, NULL, '2022-12-05 05:00:00', 1, 0),
(20, 7, NULL, '2022-12-06 17:16:00', 1, 0),
(21, 7, NULL, '2022-12-18 14:36:00', 1, 0),
(22, 8, NULL, '2022-12-19 03:21:00', -1, 0),
(23, 8, NULL, '2022-12-22 03:27:00', 1, 0),
(24, 8, NULL, '2022-12-25 03:28:00', 1, 0),
(25, 7, NULL, '2023-01-16 18:28:00', 0, 1),
(26, 8, 3, '2023-01-16 15:59:00', 1, 1),
(27, 8, 3, '2023-01-18 15:00:00', 1, 0),
(28, 7, 2, '2023-01-17 11:44:00', 1, 1),
(29, 12, 2, '2023-01-23 08:25:00', 1, 0),
(30, 7, 2, '2023-01-31 09:46:00', -1, 1),
(31, 16, 2, '2023-01-24 11:33:00', 1, 0),
(32, 7, 2, '2023-01-24 09:23:00', -1, 0),
(33, 9, 2, '2023-01-24 08:10:00', -1, 2),
(34, 7, 2, '2023-01-24 12:07:00', -1, 0),
(35, 7, 2, '2023-02-03 10:54:00', -1, 0),
(36, 7, 2, '2023-01-24 12:54:00', 0, 0),
(37, 7, 2, '2023-01-25 09:13:00', 0, 0),
(38, 7, 2, '2023-03-01 13:12:00', -1, 0),
(39, 15, 2, '2023-03-02 14:23:00', -1, 1),
(40, 15, 2, '2023-03-01 16:24:00', -1, 1),
(41, 16, 2, '2023-03-01 14:25:00', -1, 1),
(42, 9, 2, '2023-03-01 15:50:00', -1, 2),
(43, 9, 2, '2023-03-01 13:51:00', 0, 0),
(44, 18, 2, '2023-03-06 13:53:00', -1, 0),
(45, 18, 2, '2023-03-06 11:54:00', -1, 0),
(46, 11, 2, '2023-03-07 08:24:00', 1, 0),
(47, 18, 2, '2023-03-14 14:27:00', -1, 0),
(49, 18, 2, '2023-03-01 14:40:00', -1, 0),
(50, 18, 2, '2023-03-01 14:43:00', -1, 0),
(53, 7, 2, '2023-03-01 14:46:00', -1, 0),
(54, 15, 2, '2023-03-01 15:51:00', -1, 1),
(55, 15, 2, '2023-03-01 14:53:00', -1, 1),
(57, 18, 2, '2023-03-29 15:06:00', -1, 0),
(58, 18, 2, '2023-03-30 15:21:00', -1, 0),
(59, 18, 2, '2023-03-30 15:24:00', -1, 0),
(60, 9, 2, '2023-03-30 15:39:00', -1, 2),
(61, 18, 2, '2023-03-30 15:40:00', -1, 0),
(62, 15, 2, '2023-03-02 15:00:00', -1, 1),
(63, 15, 2, '2023-03-08 15:58:00', -1, 1),
(64, 18, 2, '2023-03-28 10:00:00', -1, 0),
(65, 7, 2, '2023-03-31 12:01:00', -1, 1),
(67, 18, 2, '2023-03-01 17:06:00', -1, 0),
(70, 16, 2, '2023-03-02 09:39:00', 1, 1),
(75, 18, 2, '2023-03-13 08:52:00', -1, 0),
(76, 18, 2, '2023-03-13 08:53:00', -1, 0),
(77, 18, 2, '2023-03-02 14:03:00', -1, 0),
(79, 18, 2, '2023-03-02 12:34:00', -1, 0),
(80, 18, 2, '2023-03-02 10:34:00', -1, 0),
(81, 18, 2, '2023-03-16 11:26:00', -1, 0),
(83, 18, 2, '2023-03-30 11:19:00', -1, 0),
(84, 18, 2, '2023-04-04 12:54:00', -1, 3),
(86, 18, 2, '2023-04-03 09:09:00', -1, 0),
(87, 18, 2, '2023-03-14 12:27:00', -1, 2),
(88, 18, 2, '2023-03-23 08:24:00', -1, 2),
(89, 18, 2, '2023-03-06 11:22:00', -1, 2),
(90, 15, 2, '2023-03-06 09:29:00', 1, 1),
(91, 13, 2, '2023-03-13 08:31:00', -1, 0),
(92, 18, 2, '2023-03-06 09:32:00', 0, 2),
(93, 9, 2, '2023-03-06 09:34:00', 1, 2),
(94, 9, 2, '2023-03-07 09:38:00', -1, 2),
(95, 18, 2, '2023-03-06 10:42:00', -1, 2),
(96, 11, 2, '2023-03-06 15:34:00', 1, 0),
(97, 11, 2, '2023-03-06 15:34:00', -1, 0),
(98, 18, 2, '2023-04-07 16:39:00', -1, 2),
(99, 18, 2, '2023-04-07 16:39:00', -1, 2),
(100, 18, 2, '2023-03-22 10:40:00', -1, 0),
(101, 18, 2, '2023-03-22 11:24:00', -1, 0),
(103, 19, 2, '2023-03-23 12:05:00', -1, 0),
(104, 18, 2, '2023-03-15 10:35:00', 1, 2),
(105, 21, 2, '2023-03-15 11:36:00', -1, 0),
(106, 22, 2, '2023-03-28 11:58:00', -1, 0),
(107, 23, 2, '2023-03-10 13:26:00', -1, 0),
(108, 23, 2, '2023-03-10 15:29:00', -1, 0),
(109, 23, 2, '2023-03-10 15:31:00', -1, 0),
(110, 23, 2, '2023-03-14 12:33:00', -1, 1),
(112, 21, 2, '2023-04-18 12:41:00', -1, 0),
(113, 21, 2, '2023-03-21 13:17:00', 1, 3),
(114, 21, 2, '2023-03-13 13:18:00', -1, 0),
(115, 24, 2, '2023-03-15 13:29:00', 1, 0),
(116, 18, 2, '2023-03-13 13:31:00', -1, 0),
(117, 18, 2, '2023-03-13 13:32:00', -1, 2),
(118, 18, 2, '2023-03-13 16:47:00', -1, 0),
(119, 23, 2, '2023-03-14 15:26:00', -1, 0),
(120, 23, 2, '2023-03-13 15:33:00', -1, 1),
(121, 23, 2, '2023-03-13 12:35:00', -1, 1),
(122, 23, 2, '2023-03-13 08:29:00', -1, 0),
(124, 23, 2, '2023-03-29 16:46:00', -1, 0),
(125, 23, 2, '2023-03-13 11:02:00', -1, 0),
(126, 23, 2, '2023-03-20 15:41:00', 1, 0),
(127, 25, 2, '2023-03-30 11:31:00', 1, 0),
(128, 23, 2, '2023-03-17 12:06:00', 1, 0),
(129, 23, 2, '2023-03-14 12:12:00', -1, 3),
(131, 28, 6, '2023-03-28 09:02:00', -1, 0),
(132, 28, 6, '2023-03-22 09:15:00', 0, 0),
(133, 28, 6, '2023-03-28 13:16:00', 1, 0),
(134, 28, 6, '2023-03-30 13:24:00', 1, 0),
(135, 24, 2, '2023-03-28 09:27:00', 1, 0),
(136, 9, 2, '2023-03-28 11:28:00', -1, 2),
(137, 9, 2, '2023-03-28 11:28:00', 1, 2),
(138, 18, 2, '2023-03-29 09:29:00', 1, 2),
(139, 29, 5, '2023-03-27 09:33:00', 1, 0),
(140, 29, 5, '2023-03-27 13:35:00', 1, 0),
(141, 31, 30, '2023-04-05 10:45:00', 1, 0),
(142, 31, 30, '2023-03-29 10:46:00', 1, 0),
(143, 32, 30, '2023-03-29 12:49:00', 1, 0),
(144, 15, 2, '2023-03-30 10:16:00', 1, 1),
(145, 15, 2, '2023-03-30 10:28:00', -1, 1),
(146, 15, 2, '2023-04-03 10:57:00', -1, 1),
(147, 15, 2, '2023-04-03 10:57:00', 1, 1),
(148, 15, 2, '2023-04-04 09:06:00', -1, 1),
(149, 15, 2, '2023-04-04 09:06:00', 1, 1),
(150, 28, 6, '2023-04-04 09:06:00', -1, 0),
(151, 16, 2, '2023-04-05 11:58:00', 1, 3),
(152, 27, 2, '2023-04-28 11:58:00', 1, 0),
(153, 16, 2, '2023-04-05 14:47:00', 1, 0),
(155, 18, 2, '2023-04-05 08:19:00', 0, 2),
(156, 12, 2, '2023-04-10 15:09:00', 1, 0),
(157, 7, 2, '2023-04-10 14:18:00', 1, 1),
(158, 7, 2, '2023-04-10 16:18:00', 1, 1),
(159, 17, 2, '2023-04-12 16:07:00', 1, 0),
(160, 17, 2, '2023-04-25 16:10:00', 1, 0),
(161, 35, 34, '2023-04-10 16:40:00', 1, 0),
(162, 18, 2, '2023-04-13 11:17:00', 1, 0),
(163, 18, 2, '2023-04-11 10:13:00', 1, 1),
(164, 7, 2, '2023-04-11 16:32:00', 1, 1),
(165, 7, 2, '2023-04-11 16:34:00', 1, 1),
(166, 36, 2, '2023-04-12 11:28:00', -1, 0),
(167, 36, 2, '2023-04-24 10:32:00', 1, 1),
(170, 36, 2, '2023-04-12 11:04:00', -1, 1),
(171, 38, 3, '2023-04-25 08:27:00', 1, 0),
(172, 33, 2, '2023-04-12 13:32:00', 1, 0),
(173, 36, 2, '2023-06-12 08:34:00', -1, 1),
(174, 40, 39, '2023-04-12 11:07:00', 1, 0),
(175, 41, 2, '2023-04-13 14:06:00', 1, 0),
(176, 41, 2, '2023-04-17 11:07:00', 1, 0),
(177, 36, 2, '2023-04-12 14:27:00', -1, 0),
(178, 36, 2, '2023-04-12 14:39:00', -1, 2),
(179, 36, 2, '2023-04-12 14:52:00', 1, 0),
(181, 44, 3, '2023-04-13 14:47:00', 1, 0),
(182, 16, 2, '2023-04-13 12:52:00', 1, 3),
(183, 11, 2, '2023-04-13 13:50:00', -1, 0),
(184, 11, 2, '2023-04-21 16:52:00', 1, 0),
(185, 45, 34, '2023-04-14 11:55:00', 1, 3),
(186, 48, 47, '2023-04-17 09:18:00', 1, 0),
(187, 48, 47, '2023-04-17 09:24:00', 1, 0),
(188, 36, 2, '2023-04-19 14:39:00', 0, 0),
(189, 36, 2, '2023-04-17 13:40:00', 0, 2),
(190, 53, 52, '2023-04-17 10:50:00', 1, 0),
(191, 36, 2, '2023-04-19 11:02:00', 1, 1),
(192, 36, 2, '2023-04-27 11:07:00', -1, 1),
(193, 55, 2, '2023-04-27 11:04:00', 1, 1),
(194, 60, 52, '2023-04-19 08:41:00', 1, 0),
(195, 7, 2, '2023-04-20 16:46:00', 0, 0),
(196, 36, 2, '2023-04-18 15:05:00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `barangays`
--

CREATE TABLE `barangays` (
  `barangay_id` int(11) NOT NULL,
  `health_center` varchar(255) NOT NULL,
  `assigned_midwife` int(11) DEFAULT NULL,
  `archived` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangays`
--

INSERT INTO `barangays` (`barangay_id`, `health_center`, `assigned_midwife`, `archived`) VALUES
(1, 'Alipit', 2, 0),
(2, 'Bagumbayan', 3, 0),
(3, 'Bubukal', 3, 0),
(4, 'Calios', 4, 0),
(5, 'Duhat', 4, 0),
(6, 'Gatid', 5, 0),
(7, 'Jasaan', 6, 0),
(8, 'Labuin', 10, 0),
(9, 'Malinao', 2, 0),
(10, 'Oogong', 51, 0),
(11, 'Pagsawitan', 30, 0),
(12, 'Palasan', 49, 0),
(13, 'Patimbao', 49, 0),
(14, 'Poblacion I', 50, 0),
(15, 'Poblacion II', NULL, 0),
(16, 'Poblacion III', 51, 0),
(17, 'Poblacion IV', 52, 0),
(18, 'Poblacion V', NULL, 0),
(19, 'Poblacion VI New', NULL, 1),
(20, 'Poblacion VII New', NULL, 1),
(21, 'Poblacion VIII New', NULL, 1),
(22, 'San Jose', 39, 0),
(23, 'San Juan', 39, 0),
(24, 'San Pablo Norte', 52, 0),
(25, 'San Pablo Sur', 47, 0),
(26, 'Santisima Cruz', 34, 0),
(27, 'Santo Angel Central', 34, 0),
(28, 'Santo Angel Norte', 34, 0),
(29, 'Santo Angel Sur', 47, 0),
(30, 'Test', NULL, 1),
(31, 'teste2', NULL, 1),
(32, 'test', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `consultations`
--

CREATE TABLE `consultations` (
  `consultation_id` int(50) NOT NULL,
  `prescription` varchar(255) DEFAULT NULL,
  `patient_id` int(50) NOT NULL,
  `midwife_appointed` int(50) NOT NULL,
  `date` datetime NOT NULL,
  `trimester` int(11) NOT NULL,
  `gestation` varchar(255) NOT NULL,
  `blood_pressure` varchar(255) NOT NULL,
  `weight` int(11) NOT NULL,
  `height_ft` int(11) NOT NULL,
  `height_in` int(11) NOT NULL,
  `nutritional_status` varchar(255) NOT NULL,
  `status_analysis` varchar(255) NOT NULL,
  `advice` varchar(255) NOT NULL,
  `change_plan` varchar(255) NOT NULL,
  `date_return` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consultations`
--

INSERT INTO `consultations` (`consultation_id`, `prescription`, `patient_id`, `midwife_appointed`, `date`, `trimester`, `gestation`, `blood_pressure`, `weight`, `height_ft`, `height_in`, `nutritional_status`, `status_analysis`, `advice`, `change_plan`, `date_return`) VALUES
(1, 'A prescription', 9, 3, '2022-09-29 00:00:00', 0, 'gestation', '120/80 mmHg', 50, 5, 0, 'Normal', 'status', 'some adivce', 'plan', '2023-01-30 00:00:00'),
(2, 'Another Prescription', 9, 3, '2022-09-28 00:00:00', 2, 'gestation', '120/80 mmHg', 50, 6, 7, 'Normal', 'status', 'some adivce', 'plan', '2023-01-30 00:00:00'),
(3, ' asdf\r\n                ', 7, 2, '2023-01-08 20:19:00', 1, 'asdf', 'asdf', 55, 5, 1, 'Overweight', 'adsf', 'asdf', 'adsf', '2023-01-09 20:20:00'),
(4, ' \r\n           sdfsd     ', 15, 2, '2023-01-24 23:20:00', 1, '2 weeks pregnant', '12/100mhgg', 45, 5, 5, 'Normal', 'fddfs', 'fdsf', 'fdsfsf', '2023-01-31 11:21:00'),
(5, ' \r\n         das           ', 9, 2, '2023-03-02 13:15:00', 2, '2 weeks pregnant', '12/100mhgg', 45, 5, 5, 'Overweight', 'dsa', 'dsa', 'dsa', '2023-03-22 15:15:00'),
(6, 'dsa              ', 16, 2, '2023-03-01 13:16:00', 2, '2 weeks pregnant', '12/100mhgg', 53, 5, 5, 'Normal', 'dsa', 'dsa', 'sda', '2023-03-15 13:16:00'),
(7, ' \r\n                    dsad', 16, 2, '2023-03-30 13:17:00', 3, '2 weeks pregnant', '12/100mhgg', 66, 6, 6, 'Underweight', 'dsa', 'dd', 'dsa', '2023-04-20 04:19:00'),
(8, 'd dsa\r\n                    ', 18, 2, '2023-03-01 15:13:00', 0, 'Not sure', '12/100mhgg', 45, 5, 5, 'Normal', 'edw', 'dsad', 'dsa', '2023-03-15 10:13:00'),
(9, ' \r\n                    fsa', 18, 2, '2023-03-14 10:13:00', 3, '11 weeks pregnant', '12/100mhgg', 45, 6, 6, 'Normal', 'dfsa', 'fa', 'dsa', '2023-03-29 10:13:00'),
(10, 'dsad', 18, 2, '2023-03-02 08:27:00', 2, '2 weeks', 'none', 43, 5, 5, 'Underweight', 'dsa', 'dsa', 'dsa', '2023-03-30 10:27:00'),
(11, ' asd\r\n                    ', 23, 2, '2023-03-10 12:28:00', 3, '2 weeks pregnant', '12/100mhgg', 45, 5, 3, 'Normal', 'das', 'dsa', 'dsa', '2023-03-21 12:28:00'),
(12, ' s\r\n                   ', 21, 2, '2023-03-10 12:39:00', 2, '2 weeks pregnant', '12/100mhgg', 45, 5, 5, 'Normal', 's', 's', 's', '2023-03-10 12:39:00'),
(13, ' \r\n                    dasda', 21, 2, '2023-03-28 12:40:00', 3, '2 weeks pregnant', '12/100mhgg', 45, 5, 5, 'Normal', 'dsadsa', 'dasdad', 'sadsa', '2023-04-28 12:40:00'),
(14, ' dsadsa\r\n                    ', 18, 2, '2023-04-05 18:24:00', 1, '2 weeks pregnant', '12/100mhgg', 34, 5, 5, 'Normal', 'dsad', 'dsadsa', 'Tutu@321', '2023-04-19 18:25:00'),
(15, ' Promethazine 2x a day \r\n                    ', 36, 2, '2023-04-12 09:31:00', 2, '2 weeks pregnant', '12/100mhgg', 56, 5, 5, 'Normal', 'FHF: 151 LLQ', 'Consume foods and beverages rich in folate, iron, calcium, and protein.', 'Normal Physical changes\r\n', '2023-04-24 10:32:00'),
(16, ' sdad\r\n                    ', 35, 34, '2023-04-12 10:59:00', 1, '11 weeks pregnant', '12/100mhgg', 45, 5, 5, 'Normal', 'dsad', 'sada', 'sada', '2023-04-20 10:59:00'),
(17, ' \r\n                    dsa', 45, 34, '2023-04-14 11:53:00', 3, '2 weeks pregnant', '12/100mhgg', 45, 5, 5, 'Underweight', 'Sdsa', 'dsa', 'dsa', '2023-04-26 11:54:00'),
(18, ' dsaasdsa\r\n                    ', 48, 47, '2023-04-17 09:24:00', 0, '2 weeks pregnant', '12/100mhgg', 45, 5, 5, 'Underweight', 'F1F', 'dadsad', 'dsda', '2023-04-20 13:24:00'),
(19, ' \r\n                    dsada', 48, 47, '2023-04-17 09:27:00', 0, '4weeks pregnant', '12/100mhgg', 61, 5, 2, 'Overweight', 'dsadsa', 'dsadd', 'dsadas', '2023-04-28 09:25:00'),
(20, 'the midwife will take care of it\r\n', 36, 2, '2023-04-17 09:50:00', 1, '3 weeks pregnant', '12/100mhgg', 45, 5, 3, 'Normal', 'the midwife will take care of it\r\n', 'the midwife will take care of it\r\n', 'the midwife will take care of it\r\n', '2023-04-24 09:51:00'),
(21, ' sada\r\n                    ', 53, 52, '2023-04-17 10:49:00', 1, '2 weeks pregnant', '12/100mhgg', 45, 5, 5, 'Normal', 'sad', 'dsa', 'dsad', '2023-04-26 10:49:00'),
(22, 'the midwife will take care of it\r\n       ', 55, 2, '2023-04-17 03:55:00', 1, '2 weeks pregnant', '12/100mhgg', 49, 5, 5, 'Normal', 'the midwife will take care of it\r\n', 'the midwife will take care of it\r\n', 'the midwife will take care of it\r\n', '2023-04-27 11:07:00'),
(23, ' the midwife will take care of it\r\n\r\n                    ', 11, 2, '2023-04-17 11:29:00', 1, '2', '12/100mhgg', 45, 5, 5, 'Underweight', 'the midwife will take care of it\r\n', 'the midwife will take care of it\r\n', 'the midwife will take care of it\r\n', '2023-04-26 11:29:00'),
(24, ' the midwife will take care of it\r\n\r\n                    ', 56, 2, '2023-04-17 15:54:00', 2, '14  weeks pregnant', '12/100mhgg', 59, 5, 5, 'Overweight', 'the midwife will take care of it\r\n', 'the midwife will take care of it\r\n', 'the midwife will take care of it\r\n', '2023-04-28 15:54:00'),
(25, ' the midwife will take care of it\r\n\r\n                    ', 58, 2, '2023-04-17 15:56:00', 2, '14  weeks pregnant', '12/100mhgg', 62, 5, 8, 'Underweight', 'the midwife will take care of it\r\n', 'the midwife will take care of it\r\n', 'the midwife will take care of it\r\n', '2023-05-03 08:56:00');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `contact_id` int(50) NOT NULL,
  `mobile_number` varchar(50) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`contact_id`, `mobile_number`, `owner_id`, `type`) VALUES
(11, '0908-123-0005', 6, 1),
(39, '0908-123-0322', 2, 1),
(47, '0905-363-2122', 8, 1),
(48, '0932-804-4242', 7, 1),
(51, '0945-404-5613', 12, 1),
(52, '0948-305-2000', 11, 1),
(54, '0915-300-0423', 14, 1),
(57, '0948-200-0314', 16, 1),
(59, '0939-302-1520', 33, 1),
(60, '0905-312-2310', 32, 1),
(61, '0905-400-0293', 31, 1),
(62, '0937-814-6123', 29, 1),
(63, '0948-449-1520', 28, 1),
(65, '0965-430-2120', 17, 1),
(67, '0948-900-0368', 19, 1),
(68, '0981-300-0231', 20, 1),
(69, '0939-423-0003', 21, 1),
(71, '0965-341-3000', 23, 1),
(72, '0938-700-0329', 24, 1),
(73, '0905-451-5000', 25, 1),
(74, '0948-403-0421', 26, 1),
(75, '0905-514-3940', 22, 1),
(76, '0908-123-0002', 3, 1),
(77, '0905-812-3320', 15, 1),
(78, '0912-123-1234', 9, 1),
(79, '0908-123-0004', 5, 1),
(81, '0908-123-0003', 4, 1),
(82, '0908-123-0006', 10, 1),
(83, '0905-815-3480', 13, 1),
(86, '0961-351-0421', 37, 1),
(87, '0951-602-3323', 18, 1),
(88, '0938-951-3410', 38, 1),
(89, '0948-623-3093 ', 27, 1),
(90, '0961-234-5106', 40, 1),
(91, '0948-644-3221', 35, 1),
(92, '0951-200-0438', 41, 1),
(94, '0951-788-5312', 42, 1),
(95, '0951-004-9432', 43, 1),
(96, '0932-321-4012', 44, 1),
(97, '0943-491-4321', 45, 1),
(98, '0951-399-4110', 46, 1),
(99, '0961-699-5499', 48, 1),
(100, '0951-999-4210', 53, 1),
(101, '0939-714-4102', 55, 1),
(103, '0948-051-4029', 56, 1),
(104, '0942-444-1412', 57, 1),
(105, '0941-422-3311', 58, 1),
(106, '0945-232-1231', 59, 1),
(107, '0968-715-5077', 1, 0),
(110, '0939-319-0031', 36, 1),
(111, '0938-421-4111', 60, 1);

-- --------------------------------------------------------

--
-- Table structure for table `footer`
--

CREATE TABLE `footer` (
  `footer_id` int(50) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `fb_link` varchar(255) DEFAULT NULL,
  `schedule` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `footer`
--

INSERT INTO `footer` (`footer_id`, `email`, `address`, `fb_link`, `schedule`) VALUES
(1, 'rhusantacruz2@gmail.com', 'Cailles Street Barangay Poblacion III Santa Cruz, Laguna', 'https://www.facebook.com/MHO.SantaCruzLagunaOfficial', 'Monday to Friday - 8am - 5pm');

-- --------------------------------------------------------

--
-- Table structure for table `infants`
--

CREATE TABLE `infants` (
  `infant_id` int(50) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `sex` varchar(255) NOT NULL,
  `b_date` date NOT NULL,
  `blood_type` varchar(255) NOT NULL,
  `legitimacy` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `infants`
--

INSERT INTO `infants` (`infant_id`, `first_name`, `middle_name`, `last_name`, `nickname`, `sex`, `b_date`, `blood_type`, `legitimacy`, `user_id`) VALUES
(1, 'Bea', NULL, 'Riva', NULL, 'Male', '2021-01-23', 'O+', 0, 8),
(2, 'Reina', NULL, 'Bana', NULL, 'Female', '2021-01-23', 'O+', 1, 9),
(3, 'Bang', 'Cruz', 'Dana', 'Tri', 'Male', '2021-01-23', 'O+', 1, 7),
(4, 'Love', NULL, 'Respect', NULL, 'Female', '2022-12-25', 'O+', 1, 8),
(5, 'Terms', NULL, 'Stigma', NULL, 'Female', '2022-12-25', 'AB+', 1, 8),
(6, 'Right', NULL, 'You', NULL, 'Other', '2022-12-25', 'AB+', 1, 8),
(7, 'Ivan', 'Perona', 'Oblepias', 'Ivan', 'Male', '2019-02-25', 'O', 1, 15),
(8, 'Ivana', 'Alawei', 'Nido', 'tutu45', 'Male', '2023-03-03', 'O+', 1, 18),
(9, 'Renelyn', 'G', 'Bulusan', 'dsadas', 'Male', '2023-03-27', 'O+', 1, 18),
(10, 'Love', 'Reyes', 'Oblepias', 'Love', 'Female', '2023-02-13', 'O+', 1, 35),
(11, 'Pamela', 'Ibara', 'Crisostomo', 'tutu45', 'Female', '2023-04-10', 'O+', 1, 35),
(12, 'Rica Mae', 'Moreno', 'Perez', 'rica123', 'Female', '2023-01-17', 'O+', 1, 7),
(13, 'Akeziah', 'H', 'Durano', 'akez', 'Female', '2023-03-31', 'AB+', 1, 36),
(14, 'Patricia', 'Hipolito', 'Deleon', 'tutu45', 'Female', '2023-04-11', 'AB+', 1, 45),
(15, 'Baby ', 'E', 'Perez', 'babyivan', 'Male', '2023-03-15', 'AB+', 1, 48),
(16, 'Ana Marie', 'P', 'Dimaano', NULL, 'Female', '2022-02-17', 'O+', 1, 55),
(17, 'Maica', 'Robina', 'Dela Paz', 'maicaka', 'Female', '2023-04-10', 'O', 1, 59);

-- --------------------------------------------------------

--
-- Table structure for table `infant_vac_records`
--

CREATE TABLE `infant_vac_records` (
  `infant_vac_rec_id` int(50) NOT NULL,
  `infant_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `infant_vac_records`
--

INSERT INTO `infant_vac_records` (`infant_vac_rec_id`, `infant_id`, `date`, `type`) VALUES
(1, 1, '2022-09-29', 1),
(2, 1, '2022-09-29', 4),
(3, 2, '2022-09-29', 2),
(4, 3, '2022-06-11', 2),
(5, 1, '2022-12-03', 2),
(6, 1, '2022-12-03', 3),
(7, 3, '2022-12-03', 7),
(8, 7, '2023-01-24', 2),
(9, 2, '2023-03-03', 1),
(10, 2, '2023-03-20', 4),
(11, 8, '2023-04-10', 2),
(12, 3, '2023-04-10', 1),
(13, 2, '2023-04-10', 6),
(14, 9, '2023-04-10', 3),
(15, 2, '2023-04-10', 3),
(16, 2, '2023-04-10', 3),
(17, 2, '2023-04-10', 4),
(18, 11, '2023-04-10', 1),
(19, 12, '2023-04-11', 1),
(20, 13, '2023-04-11', 1),
(21, 12, '2023-04-11', 7),
(22, 14, '2023-04-14', 5),
(23, 14, '2023-04-14', 5),
(24, 15, '2023-04-17', 1),
(25, 15, '2023-04-17', 2),
(26, 15, '2023-04-17', 3),
(27, 15, '2023-04-17', 3),
(28, 15, '2023-04-17', 3),
(29, 15, '2023-04-17', 6),
(30, 15, '2023-04-17', 7),
(31, 15, '2023-04-17', 5),
(32, 15, '2023-04-17', 4),
(33, 15, '2023-04-17', 6),
(34, 16, '2023-04-17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `message` varchar(255) NOT NULL,
  `status` int(2) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `status`, `created_date`) VALUES
(1, 8, 'You have appointed to Francis Amazing Oblepias (Midwife) on January 16, 2023 3:59 PM.', 0, '2023-01-15 14:59:27'),
(2, 3, 'You have appointed Bea Facundo(Patient) on January 16, 2023 3:59 PM.', 0, '2023-01-15 14:59:27'),
(3, 3, 'Bea Facundo(Patient) requested an Appointment on January 18, 2023 3:00 PM.', 0, '2023-01-15 15:00:54'),
(4, 8, 'Francis Amazing Oblepias (Midwife) Approved your appointment that set on January 18, 2023 3:00 PM.', 0, '2023-01-15 15:01:24'),
(5, 7, 'You have appointed to Kath Buls(Midwife) on January 17, 2023 11:44 AM.', 0, '2023-01-15 15:45:15'),
(6, 2, 'You have appointed Shane Lived Dana(Patient) on January 17, 2023 11:44 AM.', 1, '2023-01-15 15:45:15'),
(7, 2, 'Alona Oblepias(Patient) requested an Appointment on January 23, 2023 8:25 AM.', 1, '2023-01-22 09:25:19'),
(8, 7, 'You have appointed to Kath Buls(Midwife) on January 31, 2023 9:46 AM.', 0, '2023-01-22 12:47:04'),
(9, 2, 'You have appointed Shane Lived Dana(Patient) on January 31, 2023 9:46 AM.', 1, '2023-01-22 12:47:04'),
(10, 2, 'Angela Nido(Patient) requested an Appointment on January 24, 2023 11:33 AM.', 1, '2023-01-22 14:51:37'),
(11, 2, 'Francis Oblepias(Patient) requested an Appointment on January 24, 2023 9:23 AM.', 1, '2023-01-23 09:23:15'),
(12, 9, 'You have appointed to Kath Buls(Midwife) on January 24, 2023 8:10 AM.', 0, '2023-01-23 09:25:02'),
(13, 2, 'You have appointed Angel Riva(Patient) on January 24, 2023 8:10 AM.', 1, '2023-01-23 09:25:02'),
(14, 2, 'Francis Oblepias(Patient) requested an Appointment on January 24, 2023 12:07 PM.', 1, '2023-01-23 14:07:39'),
(15, 7, 'Kathryn Bulasan(Midwife) Approved your appointment that set on January 24, 2023 9:23 AM.', 0, '2023-01-23 14:08:21'),
(16, 7, 'Kathryn Bulasan(Midwife) Approved your appointment that set on January 24, 2023 12:07 PM.', 0, '2023-01-23 14:08:31'),
(17, 2, 'Francis Oblepias(Patient) requested an Appointment on February 03, 2023 10:54 AM.', 1, '2023-01-23 14:54:33'),
(18, 7, 'Kathryn Bulasan(Midwife) Approved your appointment that set on February 03, 2023 10:54 AM.', 0, '2023-01-23 14:58:10'),
(19, 16, 'Kathryn Bulasan(Midwife) Approved your appointment that set on January 24, 2023 11:33 AM.', 0, '2023-01-23 14:58:19'),
(20, 7, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on February 03, 2023 10:54 AM.', 0, '2023-01-23 15:00:57'),
(21, 9, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on January 24, 2023 08:10 AM.', 0, '2023-01-23 15:02:03'),
(22, 9, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on January 24, 2023 08:10 AM.', 0, '2023-01-23 15:02:17'),
(23, 12, 'Kathryn Bulasan(Midwife) Approved your appointment that set on January 23, 2023 8:25 AM.', 0, '2023-01-23 15:23:37'),
(24, 7, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on January 31, 2023 09:46 AM.', 0, '2023-01-23 15:53:38'),
(25, 7, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on January 24, 2023 12:07 PM.', 0, '2023-01-23 15:54:02'),
(26, 2, 'Francis Oblepias(Patient) requested an Appointment on January 24, 2023 12:54 PM.', 1, '2023-01-23 15:54:51'),
(27, 7, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on January 24, 2023 09:23 AM.', 0, '2023-01-24 07:18:48'),
(28, 2, 'Francis Oblepias(Patient) requested an Appointment on January 25, 2023 9:13 AM.', 1, '2023-01-24 13:13:40'),
(29, 2, 'Francis Oblepias(Patient) requested an Appointment on March 01, 2023 1:12 PM.', 1, '2023-03-01 05:13:06'),
(30, 7, 'Kathryn Bulasan(Midwife) Approved your appointment that set on March 01, 2023 1:12 PM.', 0, '2023-03-01 05:14:11'),
(31, 15, 'You have appointed to Kathryn Bulasan(Midwife) on March 02, 2023 2:23 PM.', 0, '2023-03-01 05:24:12'),
(32, 2, 'You have appointed Francis Oblepias(Patient) on March 02, 2023 2:23 PM.', 1, '2023-03-01 05:24:12'),
(33, 15, 'You have appointed to Kathryn Bulasan(Midwife) on March 01, 2023 4:24 PM.', 0, '2023-03-01 05:24:31'),
(34, 2, 'You have appointed Francis Oblepias(Patient) on March 01, 2023 4:24 PM.', 1, '2023-03-01 05:24:31'),
(35, 16, 'Kathryn Bulasan(Midwife) Approved your appointment that set on March 01, 2023 2:25 PM.', 0, '2023-03-01 05:26:09'),
(36, 9, 'You have appointed to Kathryn Bulasan(Midwife) on March 01, 2023 3:50 PM.', 0, '2023-03-01 05:50:40'),
(37, 2, 'You have appointed Angel Riva(Patient) on March 01, 2023 3:50 PM.', 1, '2023-03-01 05:50:40'),
(38, 2, 'Angel Riva(Patient) requested an Appointment on March 01, 2023 1:51 PM.', 1, '2023-03-01 05:51:17'),
(39, 18, 'You have appointed to Kathryn Bulasan(Midwife) on March 06, 2023 1:53 PM.', 0, '2023-03-01 05:53:34'),
(40, 2, 'You have appointed Ivan Oblepias(Patient) on March 06, 2023 1:53 PM.', 1, '2023-03-01 05:53:34'),
(41, 11, 'You have appointed to Kathryn Bulasan(Midwife) on March 07, 2023 8:24 AM.', 0, '2023-03-01 06:24:18'),
(42, 2, 'You have appointed Angela Nido(Patient) on March 07, 2023 8:24 AM.', 1, '2023-03-01 06:24:18'),
(43, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 14, 2023 02:27 PM.', 0, '2023-03-01 06:28:52'),
(44, 2, 'Ivan Oblepias(Patient) cancelled Appointment set on March 20, 2023 02:30 PM.', 1, '2023-03-01 06:32:01'),
(45, 18, 'Kathryn Bulasan(Midwife) Approved your appointment that set on March 06, 2023 11:54 AM.', 0, '2023-03-01 06:32:43'),
(46, 7, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 01, 2023 01:12 PM.', 0, '2023-03-01 06:38:59'),
(47, 15, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 02, 2023 02:23 PM.', 0, '2023-03-01 06:39:09'),
(48, 15, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 01, 2023 04:24 PM.', 0, '2023-03-01 06:39:16'),
(49, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 01, 2023 02:40 PM.', 0, '2023-03-01 06:42:28'),
(50, 16, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 01, 2023 02:25 PM.', 0, '2023-03-01 06:42:55'),
(51, 9, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 01, 2023 03:50 PM.', 0, '2023-03-01 06:43:03'),
(52, 2, 'Ivan Oblepias(Patient) requested an Appointment on March 01, 2023 2:43 PM.', 1, '2023-03-01 06:43:45'),
(53, 2, 'Ivan Oblepias(Patient) requested an Appointment on March 01, 2023 2:46 PM.', 1, '2023-03-01 06:43:58'),
(54, 2, 'Ivan Oblepias(Patient) cancelled Appointment set on March 01, 2023 02:46 PM.', 1, '2023-03-01 06:44:06'),
(55, 2, 'Ivan Oblepias(Patient) cancelled Appointment set on March 01, 2023 02:44 PM.', 1, '2023-03-01 06:44:52'),
(56, 18, 'Kathryn Bulasan(Midwife) Approved your appointment that set on March 01, 2023 2:43 PM.', 0, '2023-03-01 06:45:19'),
(57, 2, 'Francis Oblepias(Patient) requested an Appointment on March 01, 2023 2:46 PM.', 1, '2023-03-01 06:46:42'),
(58, 7, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 01, 2023 02:46 PM.', 0, '2023-03-01 06:47:44'),
(59, 15, 'You have appointed to Kathryn Bulasan(Midwife) on March 01, 2023 3:51 PM.', 0, '2023-03-01 06:51:58'),
(60, 2, 'You have appointed Francis Oblepias(Patient) on March 01, 2023 3:51 PM.', 1, '2023-03-01 06:51:58'),
(61, 15, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 01, 2023 02:53 PM.', 0, '2023-03-01 06:54:26'),
(62, 2, 'Ivan Oblepias(Patient) requested an Appointment on March 14, 2023 3:04 PM.', 1, '2023-03-01 07:04:39'),
(63, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 30, 2023 03:21 PM.', 0, '2023-03-01 07:22:46'),
(64, 15, 'You have appointed to Kathryn Bulasan(Midwife) on March 08, 2023 3:58 PM.', 0, '2023-03-01 07:58:26'),
(65, 2, 'You have appointed Francis Oblepias(Patient) on March 08, 2023 3:58 PM.', 1, '2023-03-01 07:58:26'),
(66, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 30, 2023 03:40 PM.', 0, '2023-03-01 09:00:43'),
(67, 2, 'Francis Oblepias(Patient) requested an Appointment on March 21, 2023 5:05 PM.', 1, '2023-03-01 09:06:07'),
(68, 2, 'Ivan Oblepias(Patient) requested an Appointment on March 01, 2023 5:06 PM.', 1, '2023-03-01 09:06:48'),
(69, 18, 'Kathryn Bulasan(Midwife) Approved your appointment that set on March 29, 2023 3:06 PM.', 0, '2023-03-01 09:07:34'),
(70, 18, 'Kathryn Bulasan(Midwife) Approved your appointment that set on March 01, 2023 5:06 PM.', 0, '2023-03-01 09:07:46'),
(71, 2, 'Ivan Oblepias(Patient) requested an Appointment on March 16, 2023 7:08 PM.', 1, '2023-03-01 09:09:05'),
(72, 7, 'Kathryn Bulasan(Midwife) Approved your appointment that set on March 31, 2023 12:01 PM.', 0, '2023-03-01 09:11:58'),
(73, 2, 'Francis Oblepias(Patient) cancelled Appointment set on March 21, 2023 05:05 PM.', 1, '2023-03-01 09:28:00'),
(74, 2, 'Ivan Oblepias(Patient) requested an Appointment on March 01, 2023 5:28 PM.', 1, '2023-03-01 09:28:58'),
(75, 16, 'You have appointed to Kathryn Bulasan(Midwife) on March 02, 2023 9:39 AM.', 0, '2023-03-01 09:39:43'),
(76, 2, 'You have appointed Angela Nido(Patient) on March 02, 2023 9:39 AM.', 1, '2023-03-01 09:39:43'),
(77, 2, 'Francis Oblepias(Patient) requested an Appointment on March 02, 2023 9:40 AM.', 1, '2023-03-01 09:40:35'),
(78, 2, 'Francis Oblepias(Patient) requested an Appointment on March 14, 2023 11:27 PM.', 1, '2023-03-01 10:27:18'),
(79, 2, 'Ivan Oblepias(Patient) requested an Appointment on March 09, 2023 2:49 PM.', 1, '2023-03-01 10:49:34'),
(80, 2, 'Ivan Oblepias(Patient) cancelled Appointment set on March 30, 2023 08:49 AM.', 1, '2023-03-01 10:51:00'),
(81, 2, 'Ivan Oblepias(Patient) cancelled Appointment set on March 16, 2023 07:08 PM.', 1, '2023-03-01 10:51:03'),
(82, 2, 'Ivan Oblepias(Patient) cancelled Appointment set on March 14, 2023 03:04 PM.', 1, '2023-03-01 10:51:07'),
(83, 2, 'Ivan Oblepias(Patient) cancelled Appointment set on March 14, 2023 03:04 PM.', 1, '2023-03-01 10:51:13'),
(84, 2, 'Ivan Oblepias(Patient) cancelled Appointment set on March 09, 2023 02:49 PM.', 1, '2023-03-01 10:51:18'),
(85, 2, 'Ivan Oblepias(Patient) cancelled Appointment set on March 01, 2023 05:28 PM.', 1, '2023-03-01 10:51:26'),
(86, 2, 'Ivan Oblepias(Patient) requested an Appointment on March 13, 2023 8:52 AM.', 1, '2023-03-01 10:52:16'),
(87, 2, 'Ivan Oblepias(Patient) requested an Appointment on March 13, 2023 8:53 AM.', 1, '2023-03-01 10:52:46'),
(88, 18, 'Kathryn Bulasan(Midwife) Approved your appointment that set on March 13, 2023 8:52 AM.', 0, '2023-03-01 10:53:13'),
(89, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 13, 2023 08:53 AM.', 0, '2023-03-01 10:53:24'),
(90, 2, 'Ivan Oblepias(Patient) requested an Appointment on March 02, 2023 2:03 PM.', 1, '2023-03-01 11:02:21'),
(91, 18, 'Kathryn Bulasan(Midwife) Approved your appointment that set on March 02, 2023 2:03 PM.', 0, '2023-03-01 11:03:04'),
(92, 2, 'Ivan Oblepias(Patient) requested an Appointment on March 30, 2023 4:12 PM.', 1, '2023-03-01 11:49:05'),
(93, 18, 'You have appointed to Kathryn Bulasan(Midwife) on March 02, 2023 10:34 AM.', 0, '2023-03-01 12:34:56'),
(94, 2, 'You have appointed Ivan Oblepias(Patient) on March 02, 2023 10:34 AM.', 1, '2023-03-01 12:34:56'),
(95, 2, 'Ivan Oblepias(Patient) cancelled Appointment set on March 30, 2023 04:12 PM.', 1, '2023-03-01 13:24:03'),
(96, 2, 'Ivan Oblepias(Patient) requested an Appointment on April 13, 2023 10:11 AM.', 1, '2023-03-01 14:11:56'),
(97, 2, 'Ivan Oblepias(Patient) cancelled Appointment set on April 13, 2023 10:11 AM.', 1, '2023-03-01 14:16:55'),
(98, 2, 'Ivan Oblepias(Patient) requested an Appointment on March 30, 2023 11:19 AM.', 1, '2023-03-01 14:17:10'),
(99, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 01, 2023 05:06 PM.', 0, '2023-03-01 14:18:02'),
(100, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 01, 2023 02:43 PM.', 0, '2023-03-01 14:18:05'),
(101, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 02, 2023 10:34 AM.', 0, '2023-03-01 14:18:14'),
(102, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 02, 2023 12:34 PM.', 0, '2023-03-01 14:18:24'),
(103, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 02, 2023 02:03 PM.', 0, '2023-03-01 14:18:33'),
(104, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 06, 2023 11:54 AM.', 0, '2023-03-01 14:18:43'),
(105, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 06, 2023 01:53 PM.', 0, '2023-03-01 14:18:59'),
(106, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 13, 2023 08:52 AM.', 0, '2023-03-01 14:19:13'),
(107, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 16, 2023 11:26 AM.', 0, '2023-03-01 14:19:44'),
(108, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 28, 2023 10:00 AM.', 0, '2023-03-01 14:19:55'),
(109, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 30, 2023 03:24 PM.', 0, '2023-03-01 14:20:03'),
(110, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 29, 2023 03:06 PM.', 0, '2023-03-01 14:20:10'),
(111, 18, 'Kathryn Bulasan(Midwife) Approved your appointment that set on March 30, 2023 11:19 AM.', 0, '2023-03-01 14:20:20'),
(112, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 30, 2023 11:19 AM.', 0, '2023-03-01 15:52:52'),
(113, 18, 'You have appointed to Kathryn Bulasan(Midwife) on April 04, 2023 12:54 PM.', 0, '2023-03-01 15:53:36'),
(114, 2, 'You have appointed Ivan Oblepias(Patient) on April 04, 2023 12:54 PM.', 1, '2023-03-01 15:53:36'),
(115, 2, 'Francis Oblepias(Patient) cancelled Appointment set on March 14, 2023 11:27 PM.', 1, '2023-03-01 16:38:04'),
(116, 2, 'Francis Oblepias(Patient) cancelled Appointment set on March 02, 2023 09:40 AM.', 1, '2023-03-01 16:38:07'),
(117, 7, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 31, 2023 12:01 PM.', 0, '2023-03-01 16:38:41'),
(118, 15, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 08, 2023 03:58 PM.', 0, '2023-03-01 16:38:44'),
(119, 15, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 01, 2023 03:51 PM.', 0, '2023-03-01 16:38:51'),
(120, 15, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 02, 2023 03:00 PM.', 0, '2023-03-01 16:38:59'),
(121, 2, 'Ivan Oblepias(Patient) requested an Appointment on April 05, 2023 10:05 AM.', 1, '2023-03-02 10:05:20'),
(122, 2, 'Ivan Oblepias(Patient) cancelled Appointment set on April 05, 2023 10:05 AM.', 1, '2023-03-02 10:08:29'),
(123, 2, 'Ivan Oblepias(Patient) requested an Appointment on April 03, 2023 9:09 AM.', 1, '2023-03-02 10:09:48'),
(124, 18, 'Kathryn Bulasan(Midwife) Approved your appointment that set on April 03, 2023 9:09 AM.', 0, '2023-03-02 10:11:12'),
(125, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on April 04, 2023 12:54 PM.', 0, '2023-03-02 15:27:29'),
(126, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on April 03, 2023 09:09 AM.', 0, '2023-03-02 15:27:32'),
(127, 18, 'You have appointed to Kathryn Bulasan(Midwife) on March 14, 2023 12:27 PM.', 0, '2023-03-02 15:27:57'),
(128, 2, 'You have appointed Ivan Oblepias(Patient) on March 14, 2023 12:27 PM.', 1, '2023-03-02 15:27:57'),
(129, 18, 'You have appointed to Kathryn Bulasan(Midwife) on March 06, 2023 11:22 AM.', 0, '2023-03-05 10:23:14'),
(130, 2, 'You have appointed Ivan Oblepias(Patient) on March 06, 2023 11:22 AM.', 1, '2023-03-05 10:23:14'),
(131, 13, 'You have appointed to Kathryn Bulasan(Midwife) on March 13, 2023 8:31 AM.', 0, '2023-03-05 10:31:18'),
(132, 2, 'You have appointed Robin Megino(Patient) on March 13, 2023 8:31 AM.', 1, '2023-03-05 10:31:18'),
(133, 13, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 13, 2023 08:31 AM.', 0, '2023-03-06 01:37:21'),
(134, 13, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 13, 2023 08:31 AM.', 0, '2023-03-06 01:37:39'),
(135, 9, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 07, 2023 09:38 AM.', 0, '2023-03-06 01:38:44'),
(136, 18, 'You have appointed to Kathryn Bulasan(Midwife) on March 06, 2023 10:42 AM.', 0, '2023-03-06 01:42:21'),
(137, 2, 'You have appointed Ivan Oblepias(Patient) on March 06, 2023 10:42 AM.', 1, '2023-03-06 01:42:21'),
(138, 11, 'You have appointed to Kathryn Bulasan(Midwife) on March 06, 2023 3:34 PM.', 0, '2023-03-06 03:34:51'),
(139, 2, 'You have appointed Angela Nido(Patient) on March 06, 2023 3:34 PM.', 1, '2023-03-06 03:34:51'),
(140, 11, 'You have appointed to Kathryn Bulasan(Midwife) on March 06, 2023 3:34 PM.', 0, '2023-03-06 03:35:14'),
(141, 2, 'You have appointed Angela Nido(Patient) on March 06, 2023 3:34 PM.', 1, '2023-03-06 03:35:14'),
(142, 11, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 06, 2023 03:34 PM.', 0, '2023-03-06 03:35:37'),
(143, 18, 'You have appointed to Kathryn Bulasan(Midwife) on April 07, 2023 4:39 PM.', 0, '2023-03-06 08:39:31'),
(144, 2, 'You have appointed Ivan Oblepias(Patient) on April 07, 2023 4:39 PM.', 1, '2023-03-06 08:39:31'),
(145, 18, 'You have appointed to Kathryn Bulasan(Midwife) on April 07, 2023 4:39 PM.', 0, '2023-03-06 08:39:56'),
(146, 2, 'You have appointed Ivan Oblepias(Patient) on April 07, 2023 4:39 PM.', 1, '2023-03-06 08:39:56'),
(147, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on April 07, 2023 04:39 PM.', 0, '2023-03-06 08:40:10'),
(148, 2, 'Ivan Oblepias(Patient) requested an Appointment on March 22, 2023 10:40 AM.', 1, '2023-03-06 08:41:09'),
(149, 18, 'Kathryn Bulasan(Midwife) Approved your appointment that set on March 22, 2023 10:40 AM.', 0, '2023-03-06 08:41:41'),
(150, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on April 07, 2023 04:39 PM.', 0, '2023-03-07 09:40:02'),
(151, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 23, 2023 08:24 AM.', 0, '2023-03-07 09:40:06'),
(152, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 22, 2023 10:40 AM.', 0, '2023-03-07 09:40:12'),
(153, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 14, 2023 12:27 PM.', 0, '2023-03-07 09:40:22'),
(154, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 06, 2023 10:42 AM.', 0, '2023-03-07 09:40:33'),
(155, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 06, 2023 11:22 AM.', 0, '2023-03-07 09:40:42'),
(156, 2, 'Ivan Oblepias(Patient) requested an Appointment on March 22, 2023 11:24 AM.', 1, '2023-03-07 09:41:33'),
(157, 18, 'Kathryn Bulasan(Midwife) Approved your appointment that set on March 22, 2023 11:24 AM.', 0, '2023-03-07 09:42:02'),
(158, 2, 'Kathryn Robredo(Patient) requested an Appointment on March 23, 2023 12:05 PM.', 1, '2023-03-09 14:04:24'),
(159, 2, 'Kathryn Robredo(Patient) requested an Appointment on March 23, 2023 12:05 PM.', 1, '2023-03-09 14:04:46'),
(160, 2, 'Kathryn Robredo(Patient) cancelled Appointment set on March 23, 2023 12:05 PM.', 1, '2023-03-09 14:05:09'),
(161, 19, 'Kathryn Bulasan(Midwife) Approved your appointment that set on March 23, 2023 12:05 PM.', 0, '2023-03-09 14:05:24'),
(162, 19, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 23, 2023 12:05 PM.', 0, '2023-03-09 14:06:09'),
(163, 9, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 30, 2023 03:39 PM.', 0, '2023-03-09 14:31:45'),
(164, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 22, 2023 11:24 AM.', 0, '2023-03-09 14:31:53'),
(165, 18, 'You have appointed to Kathryn Bulasan(Midwife) on March 15, 2023 10:35 AM.', 0, '2023-03-09 14:35:34'),
(166, 2, 'You have appointed Ivan Oblepias(Patient) on March 15, 2023 10:35 AM.', 1, '2023-03-09 14:35:34'),
(167, 2, 'Nanay Efgef(Patient) requested an Appointment on March 15, 2023 11:36 AM.', 1, '2023-03-09 14:36:42'),
(168, 21, 'Kathryn Bulasan(Midwife) Approved your appointment that set on March 15, 2023 11:36 AM.', 0, '2023-03-09 14:37:21'),
(169, 22, 'You have appointed to Kathryn Bulasan(Midwife) on March 28, 2023 11:58 AM.', 0, '2023-03-09 15:58:21'),
(170, 2, 'You have appointed Freddie Reda(Patient) on March 28, 2023 11:58 AM.', 1, '2023-03-09 15:58:21'),
(171, 22, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 28, 2023 11:58 AM.', 0, '2023-03-09 17:02:06'),
(172, 2, 'Mama Mama(Patient) requested an Appointment on March 10, 2023 1:26 PM.', 1, '2023-03-10 04:26:49'),
(173, 23, 'Kathryn Bulasan(Midwife) Approved your appointment that set on March 10, 2023 1:26 PM.', 0, '2023-03-10 04:27:14'),
(174, 23, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 10, 2023 01:26 PM.', 0, '2023-03-10 04:27:57'),
(175, 2, 'Mama Mama(Patient) requested an Appointment on March 10, 2023 3:29 PM.', 1, '2023-03-10 04:29:36'),
(176, 23, 'Kathryn Bulasan(Midwife) Approved your appointment that set on March 10, 2023 3:29 PM.', 0, '2023-03-10 04:30:09'),
(177, 23, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 10, 2023 03:29 PM.', 0, '2023-03-10 04:31:08'),
(178, 2, 'Mama Mama(Patient) requested an Appointment on March 10, 2023 3:31 PM.', 1, '2023-03-10 04:31:37'),
(179, 23, 'Kathryn Bulasan(Midwife) Approved your appointment that set on March 10, 2023 3:31 PM.', 0, '2023-03-10 04:32:16'),
(180, 23, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 10, 2023 03:31 PM.', 0, '2023-03-10 04:33:04'),
(181, 23, 'You have appointed to Kathryn Bulasan(Midwife) on March 14, 2023 12:33 PM.', 0, '2023-03-10 04:33:47'),
(182, 2, 'You have appointed Mama Mama(Patient) on March 14, 2023 12:33 PM.', 1, '2023-03-10 04:33:47'),
(183, 21, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 15, 2023 11:36 AM.', 0, '2023-03-10 04:35:24'),
(184, 2, 'Nanay Efgef(Patient) requested an Appointment on March 20, 2023 12:41 PM.', 1, '2023-03-10 04:41:10'),
(185, 2, 'Nanay Efgef(Patient) cancelled Appointment set on March 20, 2023 12:41 PM.', 1, '2023-03-10 04:41:20'),
(186, 2, 'Nanay Efgef(Patient) requested an Appointment on April 18, 2023 12:41 PM.', 1, '2023-03-10 04:41:31'),
(187, 21, 'Kathryn Bulasan(Midwife) Approved your appointment that set on April 18, 2023 12:41 PM.', 0, '2023-03-10 04:41:45'),
(188, 21, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on April 18, 2023 12:41 PM.', 0, '2023-03-10 05:17:34'),
(189, 21, 'You have appointed to Kathryn Bulasan(Midwife) on March 21, 2023 1:17 PM.', 0, '2023-03-10 05:17:55'),
(190, 2, 'You have appointed Nanay Efgef(Patient) on March 21, 2023 1:17 PM.', 1, '2023-03-10 05:17:56'),
(191, 2, 'Nanay Efgef(Patient) requested an Appointment on March 13, 2023 1:18 PM.', 1, '2023-03-10 05:18:38'),
(192, 21, 'Kathryn Bulasan(Midwife) Approved your appointment that set on March 13, 2023 1:18 PM.', 0, '2023-03-10 05:18:55'),
(193, 21, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 13, 2023 01:18 PM.', 0, '2023-03-10 05:29:17'),
(194, 24, 'You have appointed to Kathryn Bulasan(Midwife) on March 15, 2023 1:29 PM.', 0, '2023-03-10 05:30:02'),
(195, 2, 'You have appointed Angela Marie Oblepias(Patient) on March 15, 2023 1:29 PM.', 1, '2023-03-10 05:30:02'),
(196, 2, 'Ivan Oblepias(Patient) requested an Appointment on March 13, 2023 1:31 PM.', 1, '2023-03-10 05:31:19'),
(197, 18, 'Kathryn Bulasan(Midwife) Approved your appointment that set on March 13, 2023 1:31 PM.', 0, '2023-03-10 05:31:44'),
(198, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 13, 2023 01:31 PM.', 0, '2023-03-10 05:32:17'),
(199, 18, 'You have appointed to Kathryn Bulasan(Midwife) on March 13, 2023 1:32 PM.', 0, '2023-03-10 05:32:39'),
(200, 2, 'You have appointed Ivan Oblepias(Patient) on March 13, 2023 1:32 PM.', 1, '2023-03-10 05:32:39'),
(201, 2, 'Ivan Oblepias(Patient) requested an Appointment on March 13, 2023 4:47 PM.', 1, '2023-03-10 05:47:42'),
(202, 18, 'Kathryn Bulasan(Midwife) Approved your appointment that set on March 13, 2023 4:47 PM.', 0, '2023-03-10 05:47:57'),
(203, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 13, 2023 01:32 PM.', 0, '2023-03-10 05:48:29'),
(204, 18, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 13, 2023 04:47 PM.', 0, '2023-03-10 07:20:04'),
(205, 23, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 14, 2023 12:33 PM.', 0, '2023-03-10 07:25:45'),
(206, 2, 'Mama Mama(Patient) requested an Appointment on March 14, 2023 3:26 PM.', 1, '2023-03-10 07:26:06'),
(207, 23, 'Kathryn Bulasan(Midwife) Approved your appointment that set on March 14, 2023 3:26 PM.', 0, '2023-03-10 07:26:25'),
(208, 23, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 14, 2023 03:26 PM.', 0, '2023-03-10 07:32:59'),
(209, 23, 'You have appointed to Kathryn Bulasan(Midwife) on March 13, 2023 3:33 PM.', 0, '2023-03-10 07:33:16'),
(210, 2, 'You have appointed Mama Mama(Patient) on March 13, 2023 3:33 PM.', 1, '2023-03-10 07:33:17'),
(211, 23, 'You have appointed to Kathryn Bulasan(Midwife) on March 13, 2023 12:35 PM.', 0, '2023-03-10 07:36:11'),
(212, 2, 'You have appointed Mama Mama(Patient) on March 13, 2023 12:35 PM.', 1, '2023-03-10 07:36:11'),
(213, 2, 'Mama Mama(Patient) requested an Appointment on March 13, 2023 8:29 AM.', 1, '2023-03-10 07:36:59'),
(214, 23, 'Kathryn Bulasan(Midwife) Approved your appointment that set on March 13, 2023 8:29 AM.', 0, '2023-03-10 07:37:26'),
(215, 23, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 13, 2023 08:29 AM.', 0, '2023-03-10 08:45:30'),
(216, 2, 'Mama Mama(Patient) requested an Appointment on March 14, 2023 8:45 AM.', 1, '2023-03-10 08:46:05'),
(217, 2, 'Mama Mama(Patient) cancelled Appointment set on March 14, 2023 08:45 AM.', 1, '2023-03-10 08:46:13'),
(218, 2, 'Mama Mama(Patient) requested an Appointment on March 29, 2023 4:46 PM.', 1, '2023-03-10 08:46:30'),
(219, 23, 'Kathryn Bulasan(Midwife) Approved your appointment that set on March 29, 2023 4:46 PM.', 0, '2023-03-10 08:46:45'),
(220, 23, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 13, 2023 12:35 PM.', 0, '2023-03-10 08:47:00'),
(221, 23, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 13, 2023 03:33 PM.', 0, '2023-03-10 08:47:08'),
(222, 23, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 29, 2023 04:46 PM.', 0, '2023-03-10 08:48:30'),
(223, 2, 'Mama Mama(Patient) requested an Appointment on March 13, 2023 11:02 AM.', 1, '2023-03-10 09:02:16'),
(224, 23, 'Kathryn Bulasan(Midwife) Approved your appointment that set on March 13, 2023 11:02 AM.', 0, '2023-03-10 09:02:46'),
(225, 23, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 13, 2023 11:02 AM.', 0, '2023-03-10 10:40:16'),
(226, 2, 'Mama Mama(Patient) requested an Appointment on March 20, 2023 3:41 PM.', 1, '2023-03-10 10:41:10'),
(227, 23, 'Kathryn Bulasan(Midwife) Approved your appointment that set on March 20, 2023 3:41 PM.', 0, '2023-03-10 10:41:26'),
(228, 2, 'Kung Tan(Patient) requested an Appointment on March 30, 2023 11:31 AM.', 1, '2023-03-10 14:31:42'),
(229, 25, 'Kathryn Bulasan(Midwife) Approved your appointment that set on March 30, 2023 11:31 AM.', 0, '2023-03-10 14:32:06'),
(230, 2, 'Mama Mama(Patient) requested an Appointment on March 17, 2023 12:06 PM.', 1, '2023-03-10 16:06:35'),
(231, 23, 'Kathryn Bulasan(Midwife) Approved your appointment that set on March 17, 2023 12:06 PM.', 0, '2023-03-10 16:06:50'),
(232, 23, 'You have appointed to Kathryn Bulasan(Midwife) on March 14, 2023 12:12 PM.', 0, '2023-03-10 16:12:41'),
(233, 2, 'You have appointed Mama Mama(Patient) on March 14, 2023 12:12 PM.', 1, '2023-03-10 16:12:41'),
(234, 23, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 14, 2023 12:12 PM.', 0, '2023-03-10 16:27:24'),
(235, 2, 'Derek Ramse(Patient) cancelled Appointment set on March 16, 2023 09:28 AM.', 1, '2023-03-15 09:28:48'),
(236, 6, 'Rendon Labado(Patient) requested an Appointment on March 28, 2023 9:02 AM.', 0, '2023-03-15 13:02:10'),
(237, 28, 'Angela Oblepias(Midwife) Approved your appointment that set on March 28, 2023 9:02 AM.', 0, '2023-03-15 13:04:32'),
(238, 28, 'Angela Oblepias(Midwife) cancelled your appointment that set on March 28, 2023 09:02 AM.', 0, '2023-03-24 15:16:36'),
(239, 28, 'Angela Oblepias(Midwife) cancelled your appointment that set on March 28, 2023 09:02 AM.', 0, '2023-03-24 15:17:03'),
(240, 9, 'You have appointed to Kathryn Bulasan(Midwife) on March 28, 2023 11:28 AM.', 0, '2023-03-25 13:28:35'),
(241, 2, 'You have appointed Angel Riva(Patient) on March 28, 2023 11:28 AM.', 1, '2023-03-25 13:28:35'),
(242, 9, 'You have appointed to Kathryn Bulasan(Midwife) on March 28, 2023 11:28 AM.', 0, '2023-03-25 13:28:50'),
(243, 2, 'You have appointed Angel Riva(Patient) on March 28, 2023 11:28 AM.', 1, '2023-03-25 13:28:50'),
(244, 9, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 28, 2023 11:28 AM.', 0, '2023-03-25 13:29:34'),
(245, 18, 'You have appointed to Kathryn Bulasan(Midwife) on March 29, 2023 9:29 AM.', 0, '2023-03-25 13:30:10'),
(246, 2, 'You have appointed Ivan Oblepias(Patient) on March 29, 2023 9:29 AM.', 1, '2023-03-25 13:30:10'),
(247, 29, 'You have appointed to Francis Oblepias(Midwife) on March 27, 2023 9:33 AM.', 0, '2023-03-25 13:33:50'),
(248, 5, 'You have appointed Arlan Roque(Patient) on March 27, 2023 9:33 AM.', 0, '2023-03-25 13:33:50'),
(249, 31, 'You have appointed to Janella Rana(Midwife) on April 05, 2023 10:45 AM.', 0, '2023-03-25 13:45:41'),
(250, 30, 'You have appointed Kiana Lim(Patient) on April 05, 2023 10:45 AM.', 0, '2023-03-25 13:45:41'),
(251, 32, 'Janella Rana(Midwife) Approved your appointment that set on March 29, 2023 12:49 PM.', 0, '2023-03-25 13:50:14'),
(252, 15, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on March 30, 2023 10:28 AM.', 0, '2023-03-30 14:29:34'),
(253, 15, 'You have appointed to Kathryn Bulasan(Midwife) on April 03, 2023 10:57 AM.', 0, '2023-03-31 14:57:18'),
(254, 2, 'You have appointed Francis Oblepias(Patient) on April 03, 2023 10:57 AM.', 1, '2023-03-31 14:57:18'),
(255, 15, 'You have appointed to Kathryn Bulasan(Midwife) on April 03, 2023 10:57 AM.', 0, '2023-03-31 14:57:45'),
(256, 2, 'You have appointed Francis Oblepias(Patient) on April 03, 2023 10:57 AM.', 1, '2023-03-31 14:57:45'),
(257, 15, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on April 03, 2023 10:57 AM.', 0, '2023-03-31 15:00:34'),
(258, 15, 'You have appointed to Kathryn Bulasan(Midwife) on April 04, 2023 9:06 AM.', 0, '2023-04-04 01:02:20'),
(259, 2, 'You have appointed Francis Oblepias(Patient) on April 04, 2023 9:06 AM.', 1, '2023-04-04 01:02:20'),
(260, 15, 'You have appointed to Kathryn Bulasan(Midwife) on April 04, 2023 9:06 AM.', 0, '2023-04-04 01:02:43'),
(261, 2, 'You have appointed Francis Oblepias(Patient) on April 04, 2023 9:06 AM.', 1, '2023-04-04 01:02:43'),
(262, 15, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on April 04, 2023 09:06 AM.', 0, '2023-04-04 02:04:42'),
(263, 28, 'Angela Oblepias(Midwife) cancelled your appointment that set on April 04, 2023 09:06 AM.', 0, '2023-04-04 01:33:21'),
(264, 16, 'You have appointed to Kathryn Bulasan(Midwife) on April 05, 2023 11:58 AM.', 0, '2023-04-04 03:58:32'),
(265, 2, 'You have appointed Angela Nido(Patient) on April 05, 2023 11:58 AM.', 0, '2023-04-04 03:58:32'),
(266, 27, 'You have appointed to Kathryn Bulasan(Midwife) on April 28, 2023 11:58 AM.', 0, '2023-04-04 03:59:09'),
(267, 2, 'You have appointed Derek Ramse(Patient) on April 28, 2023 11:58 AM.', 0, '2023-04-04 03:59:09'),
(268, 2, 'Angela Nido(Patient) requested an Appointment on April 05, 2023 2:47 PM.', 0, '2023-04-04 16:47:54'),
(269, 2, 'Angela Nido(Patient) requested an Appointment on April 12, 2023 2:47 PM.', 0, '2023-04-04 16:48:13'),
(270, 2, 'Angela Nido(Patient) cancelled Appointment set on April 12, 2023 02:47 PM.', 0, '2023-04-04 16:48:52'),
(271, 16, 'Kathryn Bulasan(Midwife) Approved your appointment that set on April 05, 2023 2:47 PM.', 0, '2023-04-04 16:49:26'),
(272, 12, 'You have appointed to Kathryn Bulasan(Midwife) on April 10, 2023 3:09 PM.', 0, '2023-04-10 06:09:30'),
(273, 2, 'You have appointed Alona Oblepias(Patient) on April 10, 2023 3:09 PM.', 0, '2023-04-10 06:09:30'),
(274, 7, 'You have appointed to Kathryn Bulasan(Midwife) on April 10, 2023 4:18 PM.', 0, '2023-04-10 06:18:43'),
(275, 2, 'You have appointed Rica Sanchez(Patient) on April 10, 2023 4:18 PM.', 0, '2023-04-10 06:18:43'),
(276, 17, 'You have appointed to Kathryn Bulasan(Midwife) on April 12, 2023 4:07 PM.', 0, '2023-04-10 08:07:58'),
(277, 2, 'You have appointed Rose Anne Rico(Patient) on April 12, 2023 4:07 PM.', 0, '2023-04-10 08:07:58'),
(278, 2, 'Rose Anne Rico(Patient) requested an Appointment on April 25, 2023 4:10 PM.', 0, '2023-04-10 08:10:11'),
(279, 35, 'You have appointed to Romella Guzman(Midwife) on April 10, 2023 4:40 PM.', 0, '2023-04-10 08:39:13'),
(280, 34, 'You have appointed Janice Samonte(Patient) on April 10, 2023 4:40 PM.', 0, '2023-04-10 08:39:13'),
(281, 2, 'Ivan Oblepias(Patient) requested an Appointment on April 13, 2023 11:17 AM.', 0, '2023-04-10 10:17:43'),
(282, 18, 'Kathryn Bulasan(Midwife) Approved your appointment that set on April 13, 2023 11:17 AM.', 0, '2023-04-10 13:16:39'),
(283, 18, 'Kathryn Bulasan(Midwife) Approved your appointment that set on April 11, 2023 10:13 AM.', 0, '2023-04-10 13:17:05'),
(284, 7, 'You have appointed to Kathryn Bulasan(Midwife) on April 11, 2023 4:32 PM.', 0, '2023-04-11 08:31:23'),
(285, 2, 'You have appointed Rica Sanchez(Patient) on April 11, 2023 4:32 PM.', 0, '2023-04-11 08:31:23'),
(286, 7, 'You have appointed to Kathryn Bulasan(Midwife) on April 11, 2023 4:34 PM.', 0, '2023-04-11 08:31:57'),
(287, 2, 'You have appointed Rica Sanchez(Patient) on April 11, 2023 4:34 PM.', 0, '2023-04-11 08:31:57'),
(288, 2, 'Maricar Durano(Patient) requested an Appointment on April 12, 2023 11:28 AM.', 0, '2023-04-11 10:28:35'),
(289, 17, 'Kathryn Bulasan(Midwife) Approved your appointment that set on April 25, 2023 4:10 PM.', 0, '2023-04-11 10:29:54'),
(290, 36, 'Kathryn Bulasan(Midwife) Approved your appointment that set on April 12, 2023 11:28 AM.', 0, '2023-04-11 10:29:59'),
(291, 36, 'You have appointed to Kathryn Bulasan(Midwife) on April 24, 2023 10:32 AM.', 0, '2023-04-11 10:59:58'),
(292, 2, 'You have appointed Maricar Durano(Patient) on April 24, 2023 10:32 AM.', 0, '2023-04-11 10:59:58'),
(293, 2, 'Maricar Durano(Patient) requested an Appointment on April 18, 2023 9:02 AM.', 0, '2023-04-11 11:02:29'),
(294, 2, 'Maricar Durano(Patient) cancelled Appointment set on April 18, 2023 09:02 AM.', 0, '2023-04-11 11:02:49'),
(295, 2, 'Maricar Durano(Patient) requested an Appointment on April 18, 2023 9:02 AM.', 0, '2023-04-11 11:03:00'),
(296, 36, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on April 12, 2023 11:28 AM.', 0, '2023-04-11 11:04:23'),
(297, 36, 'You have appointed to Kathryn Bulasan(Midwife) on April 12, 2023 11:04 AM.', 0, '2023-04-11 11:04:42'),
(298, 2, 'You have appointed Maricar Durano(Patient) on April 12, 2023 11:04 AM.', 0, '2023-04-11 11:04:42'),
(299, 38, 'You have appointed to Janette De Leon(Midwife) on April 25, 2023 8:27 AM.', 0, '2023-04-11 12:28:03'),
(300, 3, 'You have appointed Gynel Dionglay(Patient) on April 25, 2023 8:27 AM.', 0, '2023-04-11 12:28:03'),
(301, 33, 'You have appointed to Kathryn Bulasan(Midwife) on April 12, 2023 1:32 PM.', 0, '2023-04-11 12:32:33'),
(302, 2, 'You have appointed Ramona Munoz(Patient) on April 12, 2023 1:32 PM.', 0, '2023-04-11 12:32:33'),
(303, 36, 'You have appointed to Kathryn Bulasan(Midwife) on June 12, 2023 8:34 AM.', 0, '2023-04-11 12:34:14'),
(304, 2, 'You have appointed Maricar Durano(Patient) on June 12, 2023 8:34 AM.', 0, '2023-04-11 12:34:14'),
(305, 40, 'You have appointed to Arlaine Gutierrez(Midwife) on April 12, 2023 11:07 AM.', 0, '2023-04-12 02:07:39'),
(306, 39, 'You have appointed Grace Anne Garcia(Patient) on April 12, 2023 11:07 AM.', 0, '2023-04-12 02:07:39'),
(307, 41, 'You have appointed to Kathryn Bulasan(Midwife) on April 17, 2023 11:07 AM.', 0, '2023-04-12 03:07:45'),
(308, 2, 'You have appointed Heart Perez(Patient) on April 17, 2023 11:07 AM.', 0, '2023-04-12 03:07:45'),
(309, 2, 'Maricar Durano(Patient) requested an Appointment on April 12, 2023 2:27 PM.', 0, '2023-04-12 04:27:38'),
(310, 36, 'Kathryn Bulasan(Midwife) Approved your appointment that set on April 12, 2023 2:27 PM.', 0, '2023-04-12 04:28:15'),
(311, 36, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on April 12, 2023 11:04 AM.', 0, '2023-04-12 04:29:28'),
(312, 36, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on April 12, 2023 02:27 PM.', 0, '2023-04-12 04:45:35'),
(313, 36, 'You have appointed to Kathryn Bulasan(Midwife) on April 12, 2023 2:39 PM.', 0, '2023-04-12 04:45:58'),
(314, 2, 'You have appointed Maricar Durano(Patient) on April 12, 2023 2:39 PM.', 0, '2023-04-12 04:45:58'),
(315, 36, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on April 12, 2023 02:39 PM.', 0, '2023-04-12 04:48:24'),
(316, 2, 'Maricar Durano(Patient) requested an Appointment on April 12, 2023 2:52 PM.', 0, '2023-04-12 04:52:11'),
(317, 36, 'Kathryn Bulasan(Midwife) Approved your appointment that set on April 12, 2023 2:52 PM.', 0, '2023-04-12 04:52:34'),
(318, 3, 'Ruth Anne Lim(Patient) cancelled Appointment set on April 13, 2023 12:48 PM.', 0, '2023-04-13 04:47:13'),
(319, 3, 'Ruth Anne Lim(Patient) requested an Appointment on April 13, 2023 2:47 PM.', 0, '2023-04-13 04:47:32'),
(320, 44, 'Janette De Leon(Midwife) Approved your appointment that set on April 13, 2023 2:47 PM.', 0, '2023-04-13 04:48:10'),
(321, 11, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on April 13, 2023 01:50 PM.', 0, '2023-04-13 04:51:41'),
(322, 11, 'Kathryn Bulasan(Midwife) Approved your appointment that set on April 21, 2023 4:52 PM.', 0, '2023-04-13 04:53:06'),
(323, 45, 'You have appointed to Romella Guzman(Midwife) on April 14, 2023 11:55 AM.', 0, '2023-04-14 03:55:01'),
(324, 34, 'You have appointed Dimples Deleon(Patient) on April 14, 2023 11:55 AM.', 0, '2023-04-14 03:55:01'),
(325, 48, 'You have appointed to Nenette Perez(Midwife) on April 17, 2023 9:18 AM.', 0, '2023-04-17 01:16:25'),
(326, 47, 'You have appointed Neneth Javier(Patient) on April 17, 2023 9:18 AM.', 0, '2023-04-17 01:16:25'),
(327, 48, 'You have appointed to Nenette Perez(Midwife) on April 17, 2023 9:24 AM.', 0, '2023-04-17 01:21:09'),
(328, 47, 'You have appointed Neneth Javier(Patient) on April 17, 2023 9:24 AM.', 0, '2023-04-17 01:21:09'),
(329, 2, 'Maricar Durano(Patient) cancelled Appointment set on April 18, 2023 09:02 AM.', 0, '2023-04-17 01:39:32'),
(330, 2, 'Maricar Durano(Patient) requested an Appointment on April 19, 2023 2:39 PM.', 0, '2023-04-17 01:39:53'),
(331, 36, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on June 12, 2023 08:34 AM.', 0, '2023-04-17 01:41:23'),
(332, 53, 'You have appointed to Lorna Guanzon(Midwife) on April 17, 2023 10:50 AM.', 0, '2023-04-17 02:48:42'),
(333, 52, 'You have appointed Analette Perez(Patient) on April 17, 2023 10:50 AM.', 0, '2023-04-17 02:48:42'),
(334, 36, 'You have appointed to Kathryn Bulasan(Midwife) on April 19, 2023 11:02 AM.', 0, '2023-04-17 03:02:28'),
(335, 2, 'You have appointed Maricar Durano(Patient) on April 19, 2023 11:02 AM.', 0, '2023-04-17 03:02:28'),
(336, 36, 'You have appointed to Kathryn Bulasan(Midwife) on April 27, 2023 11:07 AM.', 0, '2023-04-17 03:08:00'),
(337, 2, 'You have appointed Maricar Durano(Patient) on April 27, 2023 11:07 AM.', 0, '2023-04-17 03:08:00'),
(338, 36, 'Kathryn Bulasan(Midwife) cancelled your appointment that set on April 27, 2023 11:07 AM.', 0, '2023-04-17 03:08:32'),
(339, 55, 'You have appointed to Kathryn Bulasan(Midwife) on April 27, 2023 11:04 AM.', 0, '2023-04-17 03:09:02'),
(340, 2, 'You have appointed Arianne Dimaano(Patient) on April 27, 2023 11:04 AM.', 0, '2023-04-17 03:09:02'),
(341, 60, 'You have appointed to Lorna Guanzon(Midwife) on April 19, 2023 8:41 AM.', 0, '2023-04-17 06:41:31'),
(342, 52, 'You have appointed Mariz Aguilar(Patient) on April 19, 2023 8:41 AM.', 0, '2023-04-17 06:41:31'),
(343, 2, 'Rica Sanchez(Patient) requested an Appointment on April 20, 2023 4:46 PM.', 0, '2023-04-17 06:54:32'),
(344, 36, 'You have appointed to Kathryn Bulasan(Midwife) on April 18, 2023 3:05 PM.', 0, '2023-04-17 07:05:55'),
(345, 2, 'You have appointed Maricar Durano(Patient) on April 18, 2023 3:05 PM.', 0, '2023-04-17 07:05:55');

-- --------------------------------------------------------

--
-- Table structure for table `patient_details`
--

CREATE TABLE `patient_details` (
  `patient_details_id` int(50) NOT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `barangay_id` int(50) NOT NULL,
  `b_date` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `civil_status` varchar(255) NOT NULL,
  `trimester` int(11) NOT NULL,
  `tetanus` tinyint(1) NOT NULL,
  `diagnosed_condition` varchar(255) DEFAULT NULL,
  `family_history` varchar(255) DEFAULT NULL,
  `allergies` varchar(255) DEFAULT NULL,
  `blood_type` varchar(255) NOT NULL,
  `weight` int(11) NOT NULL,
  `height_ft` int(11) NOT NULL,
  `height_in` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_details`
--

INSERT INTO `patient_details` (`patient_details_id`, `nickname`, `barangay_id`, `b_date`, `address`, `civil_status`, `trimester`, `tetanus`, `diagnosed_condition`, `family_history`, `allergies`, `blood_type`, `weight`, `height_ft`, `height_in`, `user_id`, `status`) VALUES
(1, 'Tutu', 1, '1999-09-12', 'Santo Angel Sur ', 'Single', 1, 1, 'High Blood', 'N/A', 'Hipon at isda', 'O+', 55, 5, 1, 7, 1),
(2, 'B', 2, '1998-07-10', 'Santo Angel Sur , Santa Cruz Laguna', 'Married', 1, 0, 'N/A', 'N/A', 'Fish', 'O+', 60, 5, 11, 8, 1),
(3, NULL, 1, '1999-07-10', 'ZAMORA STREET 3760 SANTO ANGEL SUR ,SANTA CRUZ LAGU', 'Married', 2, 1, 'Hearing Loss', 'Sakit sa puso', 'Fish', 'O+', 45, 5, 5, 9, 1),
(4, 'angela', 1, '2006-10-24', 'Barangay Alipit', 'Married', 1, 0, 'High Blood', 'N/A', 'Fish', 'O+', 45, 5, 5, 11, 1),
(5, NULL, 1, '2001-09-10', NULL, 'Married', 0, 0, 'N/A', 'N/A', 'Fish', 'O+', 60, 5, 5, 12, 1),
(6, 'robina', 1, '2000-07-17', 'Barangay. Alipit', 'Married', 0, 0, 'N/A', 'N/A', 'Fish', 'O+', 55, 5, 5, 13, 1),
(7, NULL, 1, '1973-03-10', '3760 SANTO ANGEL NORTE,SANTA CRUZ LAGUNA', 'Married', 0, 0, 'N/A', 'N/A', 'Fish', 'O+', 56, 5, 5, 14, 1),
(8, 'eika', 1, '1993-07-11', 'TONDO STREET. SANTO ANGEL SUR ,SANTA CRUZ LAGU', 'Single', 1, 0, 'N/A', 'N/A', 'Hipon', 'O+', 45, 5, 5, 15, 1),
(9, 'Angela', 1, '2001-06-22', 'dasad', 'asdsad', 3, 0, 'High Blood', 'N/A', 'Isda', 'O', 55, 5, 6, 16, 1),
(14, 'roseanne', 1, '1986-07-17', 'ZAMORA STREET 3760 SANTO ANGEL SUR ,SANTA CRUZ LAGU', 'Married', 0, 0, 'High Blood, Puso', 'N/A', 'Fish', 'O+', 64, 5, 4, 17, 1),
(15, 'pekto', 1, '2004-07-08', 'Santo Angel Sur Santa Cruz Laguna', 'Single', 1, 1, 'Wala', 'wala', 'wala', 'O+', 34, 5, 5, 18, 1),
(16, 'Kathy', 9, '1976-07-08', 'ZAMORA STREET 3760 SANTO ANGEL SUR ,SANTA CRUZ LAGU', 'Married', 0, 0, 'High Blood', 'Sakit sa Puso', 'Fish', 'O+', 58, 5, 5, 19, 1),
(17, 'Patpat', 9, '2000-03-10', 'ZAMORA STREET 3760 SANTO ANGEL SUR ,SANTA CRUZ LAGU', 'Single', 0, 0, 'N/A', 'N/A', 'Hipon', 'O+', 57, 5, 5, 20, 1),
(18, 'ninay', 1, '1994-03-29', 'ZAMORA STREET 3760 SANTO ANGEL SUR ,SANTA CRUZ LAGU', 'Married', 3, 0, 'High Uric Acid', 'Sakit sa Puso ', 'Fish', 'O+', 45, 5, 5, 21, 1),
(19, 'chesches', 1, '1987-11-18', 'ZAMORA STREET 3760 SANTO ANGEL SUR ,SANTA CRUZLAGUNA', 'Married', 0, 0, 'High Blood', 'SAKIT SA PUSO', 'Fish', 'O+', 57, 5, 5, 22, 1),
(20, 'norma321', 1, '2004-02-10', 'ZAMORA STREET 3760 SANTO ANGEL SUR ,SANTA CRUZ LAGU', 'Single', 3, 1, 'High Blood', 'Sakit sa Colon', 'Hipon', 'O+', 45, 5, 3, 23, 1),
(21, 'sharshar', 1, '1996-07-10', 'ZAMORA STREET 3760 SANTO ANGEL SUR ,SANTA CRUZ LAGU', 'Married', 0, 0, 'Hearing Loss', 'sakit sa baga', 'Hipon', 'O+', 56, 5, 5, 24, 1),
(22, 'mei', 1, '1995-07-10', 'ZAMORA STREET 3760 SANTO ANGEL SUR ,SANTA CRUZ LAGUNA', 'Married', 0, 0, 'Hearing Loss', 'Puso', 'Hipon', 'O+', 57, 5, 5, 25, 1),
(23, 'mich', 1, '1996-07-18', 'ZAMORA STREET 3760 SANTO ANGEL SUR ,SANTA CRUZ LAGUNA', 'Married', 0, 0, 'High Blood', 'Sakit sa puso', 'Fish', 'O+', 54, 5, 5, 26, 1),
(24, 'Jericsaone', 1, '1999-12-16', 'Santo Angel Sur, Santa Cruz Laguna ', 'Single', 0, 1, 'High Blood', 'N/A', 'Hipon', 'O+', 43, 5, 5, 27, 1),
(25, 'Rendon', 7, '2000-07-15', 'Santo Angel Sur, Santa Cruz Laguna', 'Single', 0, 0, 'High Blood', 'Sakit sa Colon', 'Hipon at Isda', 'O+', 55, 5, 5, 28, 1),
(26, 'Arlaine', 6, '1997-06-10', 'ZAMORA STREET 3760 SANTO ANGEL SUR ,SANTA CRUZ LAGU', 'Single', 0, 0, 'High Blood', 'Sakit sa puso', 'Hipon', 'O+', 49, 5, 2, 29, 1),
(27, 'Kiana', 11, '2000-06-27', 'Santo Angel Sur, Santa Cruz Laguna', 'Single', 0, 0, 'High Blood', 'Sakit sa puso ', 'Fish', 'O+', 34, 5, 5, 31, 1),
(28, 'ibon', 11, '1998-07-25', 'ZAMORA STREET 3760 SANTO ANGEL SUR ,SANTA CRUZ LAGU', 'Married', 0, 0, 'High Blood', 'N/A', 'Fish', 'O+', 33, 5, 5, 32, 1),
(29, 'Ramona', 1, '1988-07-27', 'Barangay Oogong Santa Cruz Laguna', 'Married', 0, 0, 'High Blood, Puso', 'Sakit sa baga', 'Fish', 'O+', 55, 5, 2, 33, 1),
(30, 'Janjan', 28, '1994-11-17', 'Zamora St. Santo Angel Sur, Santa Cruz Laguna', 'Married', 1, 0, 'High Blood', 'Sakit sa puso', 'Hipon', 'O+', 47, 5, 5, 35, 1),
(31, 'Mari', 1, '1982-10-12', 'Santo Angel Sur ,Santa Cruz Laguna', 'Married', 1, 0, 'High Blood', 'Sakit sa puso', 'Hipon', 'O+', 45, 5, 3, 36, 1),
(32, 'Sopsop', 1, '1992-10-13', '3231 Barangay Alipit , Santa Cruz Laguna', 'Married', 0, 1, 'High Blood', 'Sakit sa puso', 'Hipon', 'O+', 52, 4, 9, 37, 1),
(33, 'Gynel', 2, '1990-07-19', '3214 Brgy.Bagumbayan ,Santa Cruz Laguna', 'Married', 0, 0, 'High Blood, Puso', 'Sakit sa puso', 'Hipon', 'AB+', 54, 5, 5, 38, 1),
(34, 'Graceanne', 22, '1985-11-20', '3214 Barangay.San Juan, Santa ,Cruz Laguna', 'Married', 0, 0, 'High Blood, Puso', 'Sakit sa puso', 'Hipon', 'AB+', 55, 4, 7, 40, 1),
(35, 'tutu45', 1, '2023-04-12', '4211 Brgy.Alipit, Santa Cruz Laguna', 'Married', 0, 0, 'High Blood', 'Sakit sa puso', 'Fish', 'O+', 4, 5, 6, 41, 1),
(36, 'Labo', 1, '1990-06-19', '3215 Barangay Alipit, SantaCruz Laguna', 'Married', 0, 0, 'High Blood', 'Sakit sa puso', 'Hipon', 'AB+', 43, 5, 5, 42, 1),
(37, 'Marianne', 1, '2000-06-20', '3214 Barangay.Alipit, Santa Cruz Laguna', 'Married', 0, 1, 'High Blood', 'Sakit sa puso', 'Fish', 'AB+', 43, 5, 5, 43, 1),
(38, NULL, 2, '1991-08-13', 'ZAMORA STREET 3760 SANTO ANGEL SUR ,SANTA CRUZ LAGU', 'Single', 0, 0, 'High Blood, Puso', 'Sakit sa puso', 'Fish', 'AB+', 55, 4, 8, 44, 1),
(39, NULL, 26, '1997-08-21', 'ZAMORA STREET 3760 SANTO ANGEL SUR ,SANTA CRUZ LAGU', 'Married', 3, 1, 'High Blood, Puso', 'Sakit sa puso', 'Fish', 'AB+', 45, 5, 5, 45, 1),
(40, 'Maxine', 1, '1991-07-17', 'Barangay Alipit, Santa Cruz Laguna', 'Single', 0, 0, 'High Blood', 'Sakit sa puso', 'Fish', 'A+', 49, 5, 5, 46, 1),
(41, 'netnet', 29, '1988-06-17', 'Santo Angel Sur,Santa Cruz Laguna', 'Single', 0, 0, 'High Blood', 'Sakit sa puso', 'Fish', 'O+', 61, 5, 2, 48, 1),
(42, 'Analette', 17, '2002-07-11', '3213 Barangay Poblacion Iv, Santa Cruz Laguna', 'Single', 1, 0, 'High Blood', 'Sakit sa puso', 'Hipon', 'AB+', 45, 5, 5, 53, 1),
(43, 'Arianne', 9, '1996-08-17', '3214 Barangay.Malinao, Santa Cruz Laguna', 'Married', 1, 0, 'High Blood', 'Sakit sa puso', 'Hipon', 'O+', 49, 5, 5, 55, 1),
(44, 'mari', 9, '1990-07-18', 'Barangay Malinao, Santa Cruz Laguna', 'Single', 2, 0, 'High Blood', 'Sakit sa puso', 'Isda', 'AB+', 59, 5, 5, 56, 1),
(45, 'Erna', 9, '1987-06-17', 'Barangay. Malinao', 'Married', 0, 0, 'High Blood', 'Wala', 'Hipon', 'AB+', 56, 5, 5, 57, 1),
(46, NULL, 9, '1997-02-26', 'ZAMORA STREET 3760 SANTO ANGEL SUR ,SANTA CRUZ LAGU', 'Married', 2, 1, 'High Blood', 'Sakit sa puso', 'Hipon', 'A+', 62, 5, 8, 58, 1),
(47, NULL, 9, '2003-07-17', 'ZAMORA STREET 3760 SANTO ANGEL SUR ,SANTA CRUZ LAGU', 'Single', 0, 0, 'High Blood', 'Sakit sa puso', 'Hipon', 'O', 43, 5, 5, 59, 1),
(48, 'Mawiz', 24, '1985-08-27', 'Zamora St. San Pablo Sur, Santa Cruz Laguna', 'Married', 0, 0, 'High Blood', 'Sakit sa puso', 'Fish', 'O', 59, 5, 8, 60, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `otp` varchar(255) DEFAULT NULL,
  `role` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `otp`, `role`) VALUES
(1, 'emrsystem0123@gmail.com', 'c97fb3941e7298343e1388c5e764bff7', NULL, 1),
(2, 'katherinebulusan39@gmail.com', '1f501d5750358edd1626b196c8eef201', '0801a457294fafbd8fe3116176252636', 0),
(3, 'djanette888@gmail.com', '5e097e8e20ba4aa850421f1326b69fc2', NULL, 0),
(4, 'gracefernandez@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 0),
(5, 'violetagama@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 0),
(6, 'angela1@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 0),
(7, 'rica@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(8, 'bea@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(9, 'angel@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(10, 'clairedelosreyes@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 0),
(11, 'angela12@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(12, 'alona@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(13, 'robina@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(14, 'daniel@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(15, 'chesca@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, -1),
(16, 'angelamarienido@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(17, 'roseanne1@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(18, 'roseannegonzales@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(19, 'kath33@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(20, 'patriciaong@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(21, 'janine.deleon@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(22, 'chelsea.ong@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(23, 'reareyes23@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(24, 'sharlenes@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(25, 'richellefernandez@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(26, 'michellemorales@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(27, 'jerica.dum@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(28, 'roda@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(29, 'arlaine.dum@rocketmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(30, 'janella@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 0),
(31, 'kiana@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(32, 'yvonne.mercado12@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(33, 'ramona12@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(34, 'romellaguzman@gmail.com', '202cb962ac59075b964b07152d234b70', '6dac4227f4c3d1f6619898d70f2f2b52', 0),
(35, 'janicesamonte@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(36, 'maricar.durano12@gmail.com', 'cfcc4a2e918efaf76a83b7a027495901', NULL, -1),
(37, 'chloegonzales@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(38, 'gyneldionglay@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(39, 'arlainegutierrez@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 0),
(40, 'grace.garcia@rocketmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(41, 'heartperez@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(42, 'vernieong@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(43, 'marianne.perez@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(44, 'ruthanne23@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(45, 'dimplesdeleon@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(46, 'maxine.ronabio@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(47, 'ningperez@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 0),
(48, 'nenethjavier@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(49, 'maribelconstacia@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 0),
(50, 'cherrygutierrez@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 0),
(51, 'princessdelima@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 0),
(52, 'lornaguanzon@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 0),
(53, 'analetteperez@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(54, 'vienliwagan@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 0),
(55, 'ariannedimaano@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(56, 'maribelparil@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(57, 'ernaidlawan@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(58, 'aizelponce@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(59, 'arlettedelapaz@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(60, 'marizaguilar@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1);

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `user_details_id` int(50) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `user_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`user_details_id`, `first_name`, `middle_name`, `last_name`, `profile_picture`, `user_id`) VALUES
(1, 'Kathryn', 'S', 'Bulasan', NULL, 2),
(2, 'Janette', 'Reyes', 'De Leon', NULL, 3),
(3, 'Grace', 'Romblon', 'Fernandez', NULL, 4),
(4, 'Violeta', 'P', 'Gama', NULL, 5),
(5, 'Angela', 'Herradura', 'Oblepias', NULL, 6),
(6, 'Rica', 'Mendez', 'Sanchez', '7.jpg', 7),
(7, 'Bea', 'Edo', 'Facundo', NULL, 8),
(8, 'Angel', 'Aga', 'Riva', NULL, 9),
(9, 'Claire', 'Goma', 'Delos Reyes', NULL, 10),
(10, 'Angela', 'Rena', 'Aguila', NULL, 11),
(11, 'Alona', 'Perona', 'Oblepias', NULL, 12),
(12, 'Robina', 'Andrew', 'Morales', NULL, 13),
(13, 'Daniela', 'Aguado', 'Lim', NULL, 14),
(14, 'Ramona', 'Punzalan', 'Obmerga', NULL, 15),
(15, 'Angela', 'H', 'Nido', '16.jpg', 16),
(20, 'Rose Anne', 'Ena', 'Rico', NULL, 17),
(21, 'Rose Anne', 'P.', 'De leon ', '18.png', 18),
(22, 'Kathryn', 'Guanzon', 'Reyes', NULL, 19),
(23, 'Patricia', 'De Leon', 'Ong', NULL, 20),
(24, 'Janine', 'Mercado', 'Deleon', NULL, 21),
(25, 'Chelsea', 'P', 'Ong', NULL, 22),
(26, 'Rea ', 'Angela', 'Reyes', NULL, 23),
(27, 'Sharlene', 'Nido', 'San Roque', NULL, 24),
(28, 'Richelle', 'Lavendia', 'Fernandez', NULL, 25),
(29, 'Michelle', 'Mendez', 'Morales', NULL, 26),
(30, 'Jerica', 'Rosalinda', 'Reyes', NULL, 27),
(31, 'Rhoda', 'Obmerga', 'Ong', NULL, 28),
(32, 'Arlanie', 'Aguilos', 'Roque', NULL, 29),
(33, 'Janella', 'R', 'Rana', NULL, 30),
(34, 'Kiana', 'Mercado', 'Aguila', NULL, 31),
(35, 'Yvonone', 'Reba', 'Mercado', NULL, 32),
(36, 'Ramona', 'Gil', 'Munoz', NULL, 33),
(37, 'Romella', 'Dorano', 'Guzman', NULL, 34),
(38, 'Janice', 'Ronoa', 'Samonte', NULL, 35),
(39, 'Maricar', 'Hernandez', 'Durano', '36.jpg', 36),
(40, 'Chloe Sophia', 'Gomez', 'Gonzales', NULL, 37),
(41, 'Gynel', 'Arsenio', 'Dionglay', NULL, 38),
(42, 'Arlaine', 'Lyn', 'Gutierrez', NULL, 39),
(43, 'Grace Anne', 'Romero', 'Garcia', NULL, 40),
(44, 'Heart', 'Macatangay', 'Perez', NULL, 41),
(45, 'Vernie', 'Labo', 'Ong', NULL, 42),
(46, 'Marianne ', 'Luyon', 'Perez', NULL, 43),
(47, 'Ruth Anne', 'Roque', 'Lim', NULL, 44),
(48, 'Dimples', 'Roset', 'Deleon', NULL, 45),
(49, 'Maxine', 'Bonza', 'Ronabio', NULL, 46),
(50, 'Nenette', 'Luyon', 'Perez', NULL, 47),
(51, 'Neneth', 'Muli', 'Javier', NULL, 48),
(52, 'Maribel', 'Eduardo', 'Constacia', NULL, 49),
(53, 'Cherry', 'Grepo', 'Gutierrez', NULL, 50),
(54, 'Princess', 'Perez', 'De Lima', NULL, 51),
(55, 'Lorna', 'Roque', 'Guanzon', NULL, 52),
(56, 'Analette', 'Perona', 'Perez', NULL, 53),
(57, 'Vien', 'Cortez', 'Liwagan', NULL, 54),
(58, 'Arianne', 'Perez', 'Dimaano', NULL, 55),
(59, 'Maribel', 'Durano', 'Paril', NULL, 56),
(60, 'Erna', 'Perez', 'Idlawan', NULL, 57),
(61, 'Aizel', 'Perona', 'Ponce', NULL, 58),
(62, 'Arlette', 'R', 'Dela Paz', NULL, 59),
(63, 'Mariz', 'Rowena', 'Aguilar', NULL, 60);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `midwife_id` (`midwife_id`);

--
-- Indexes for table `barangays`
--
ALTER TABLE `barangays`
  ADD PRIMARY KEY (`barangay_id`),
  ADD KEY `assigned_midwife` (`assigned_midwife`);

--
-- Indexes for table `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`consultation_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `midwife_appointed` (`midwife_appointed`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `footer`
--
ALTER TABLE `footer`
  ADD PRIMARY KEY (`footer_id`);

--
-- Indexes for table `infants`
--
ALTER TABLE `infants`
  ADD PRIMARY KEY (`infant_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `infant_vac_records`
--
ALTER TABLE `infant_vac_records`
  ADD PRIMARY KEY (`infant_vac_rec_id`),
  ADD KEY `infant_id` (`infant_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_details`
--
ALTER TABLE `patient_details`
  ADD PRIMARY KEY (`patient_details_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`user_details_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT for table `barangays`
--
ALTER TABLE `barangays`
  MODIFY `barangay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `consultation_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `contact_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `footer`
--
ALTER TABLE `footer`
  MODIFY `footer_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `infants`
--
ALTER TABLE `infants`
  MODIFY `infant_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `infant_vac_records`
--
ALTER TABLE `infant_vac_records`
  MODIFY `infant_vac_rec_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=346;

--
-- AUTO_INCREMENT for table `patient_details`
--
ALTER TABLE `patient_details`
  MODIFY `patient_details_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `user_details_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`midwife_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `barangays`
--
ALTER TABLE `barangays`
  ADD CONSTRAINT `barangays_ibfk_1` FOREIGN KEY (`assigned_midwife`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `consultations`
--
ALTER TABLE `consultations`
  ADD CONSTRAINT `consultations_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `consultations_ibfk_2` FOREIGN KEY (`midwife_appointed`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `infants`
--
ALTER TABLE `infants`
  ADD CONSTRAINT `infants_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `infant_vac_records`
--
ALTER TABLE `infant_vac_records`
  ADD CONSTRAINT `infant_vac_records_ibfk_1` FOREIGN KEY (`infant_id`) REFERENCES `infants` (`infant_id`);

--
-- Constraints for table `patient_details`
--
ALTER TABLE `patient_details`
  ADD CONSTRAINT `patient_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `user_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
