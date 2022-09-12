-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2022 at 08:49 AM
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
-- Database: `emr`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(50) NOT NULL,
  `patient_id` int(50) NOT NULL,
  `date` datetime NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`id`, `patient_id`, `date`, `status`) VALUES
(1, 30, '2022-09-22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `barangay`
--

CREATE TABLE `barangay` (
  `id` int(50) NOT NULL,
  `health_center` varchar(255) NOT NULL,
  `assigned_midwife` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barangay`
--

INSERT INTO `barangay` (`id`, `health_center`, `assigned_midwife`) VALUES
(2, 'Barangay 23', 23),
(5, 'asdf', 23),
(8, 'Pagsawitan Laguna', 27),
(9, 'Santo Angel Norte', 29),
(10, 'another barangay', 21),
(11, 'isa pang brgy', 33);

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

CREATE TABLE `details` (
  `id` int(50) NOT NULL,
  `contact_no` varchar(255) NOT NULL,
  `b_date` date NOT NULL,
  `barangay_id` int(50) DEFAULT NULL,
  `med_history_id` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `details`
--

INSERT INTO `details` (`id`, `contact_no`, `b_date`, `barangay_id`, `med_history_id`) VALUES
(1, '0908-123-1231', '1999-07-28', 5, 2),
(2, '0908-123-1231', '1999-07-28', 2, 1),
(3, '1234-123-1234', '1999-08-10', NULL, NULL),
(4, '1234-123-1234', '1090-12-12', NULL, NULL),
(5, '1234-123-1234', '1234-03-12', NULL, NULL),
(6, '1234-123-1234', '1234-03-12', 2, 3),
(7, '0951-602-7781', '2006-06-08', NULL, NULL),
(9, '0951-602-7781', '2022-09-30', NULL, NULL),
(10, '0951-602-7781', '2022-09-02', NULL, NULL),
(11, '0951-602-7781', '2001-06-05', NULL, NULL),
(12, '1234-123-1234', '2022-09-16', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `infant_record`
--

CREATE TABLE `infant_record` (
  `id` int(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `updated_at` date NOT NULL,
  `legitimacy` tinyint(1) NOT NULL,
  `measles` tinyint(1) NOT NULL, 
  `penta` tinyint(1) NOT NULL, 
  `polio` tinyint(1) NOT NULL, 
  `patient_id` int(50) NOT NULL,
  `pneumococcal` tinyint(1) NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `infant_record`
--

INSERT INTO `infant_record` (`id`, `name`, `date`, `updated_at`, `legitimacy`, `measles`, `penta`, `polio`, `pneumococcal`, `patient_id`) VALUES
(1, 'Baby Sangol', '2012-02-14','2022-09-12', 1, 1, 0, 1, 0, 30),
(2, 'Isa Pang Sangol', '2012-02-14','2022-09-12', 0, 0, 0, 0, 0, 30);

-- --------------------------------------------------------

--
-- Table structure for table `med_history`
--

CREATE TABLE `med_history` (
  `id` int(50) NOT NULL,
  `height_ft` int(50) NOT NULL,
  `height_in` int(50) NOT NULL,
  `weight` int(50) NOT NULL,
  `blood_type` varchar(255) NOT NULL,
  `diagnosed_condition` varchar(255) NOT NULL,
  `allergies` varchar(255) NOT NULL,
  `tetanus` tinyint(1) NOT NULL,
  `trimester` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `med_history`
--

INSERT INTO `med_history` (`id`, `height_ft`, `height_in`, `weight`, `blood_type`, `diagnosed_condition`, `allergies`, `tetanus`, `trimester`) VALUES
(1, 5, 11, 50, 'O', 'None', 'Peanuts', 1, 1),
(2, 5, 11, 50, 'B-', 'Oblepias', 'Seafood', 1, 1),
(3, 5, 11, 40, 'B+', 'Coco Addiction', 'Coco', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `treat_med`
--

CREATE TABLE `treat_med` (
  `id` int(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `category` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `treat_med`
--

INSERT INTO `treat_med` (`id`, `name`, `description`, `category`) VALUES
(1, 'Treatment 1', 'This is te first treatment.', 1),
(2, 'Medicine 1', 'This is te first medicine.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `treat_med_record`
--

CREATE TABLE `treat_med_record` (
  `id` int(50) NOT NULL,
  `treat_med_id` int(50) NOT NULL,
  `date` datetime NOT NULL,
  `treatment_file` varchar(255) DEFAULT NULL,
  `patient_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `treat_med_record`
--

INSERT INTO `treat_med_record` (`id`, `treat_med_id`, `date`, `patient_id`) VALUES
(1, 1, '2022-08-22 09:30:00', 30),
(2, 2, '2022-08-22 02:59:00', 30);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `mid_initial` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `admin` int(11) NOT NULL,
  `otp` varchar(255) DEFAULT NULL,
  `details_id` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `mid_initial`, `last_name`, `email`, `password`, `status`, `admin`, `otp`, `details_id`) VALUES
(20, 'Elmina', 'R.', 'Monteza', 'monteza@gmail.com', '202cb962ac59075b964b07152d234b70', 1, 1, '', NULL),
(21, 'Cathy', 'R.', 'Bulusan', 'cathybulusan@gmail.com', '202cb962ac59075b964b07152d234b70', 0, 0, '', 7),
(23, 'Francis', 'Perona', 'Oblepias', 'francisoblepias123@gmaill.com', '202cb962ac59075b964b07152d234b70', 1, 0, '', 9),
(27, 'Francis', 'R', 'Oblepias', 'francisoblepias@gmaill.com', '202cb962ac59075b964b07152d234b70', 0, 0, '', 10),
(28, 'Francis', 'P', 'Oblepias', 'francisoblepias120@gmaill.com', '202cb962ac59075b964b07152d234b70', 0, 1, '', NULL),
(29, 'Angela', 'Herradura', 'Oblepias', 'angela1@gmail.com', '202cb962ac59075b964b07152d234b70', 1, 0, '', 11),
(30, 'Patient', 'C', 'D', 'patient2@gmail.com', '202cb962ac59075b964b07152d234b70', 0, -1, '', 2),
(31, 'Patient', 'E', 'F', 'patient3@gmaill.com', '202cb962ac59075b964b07152d234b70', 1, -1, '', 6),
(32, 'Patient', 'A', 'B', 'patient1@gmail.com', '202cb962ac59075b964b07152d234b70', 1, -1, '', 1),
(33, 'Another Midwife', '', 'Some Surname', 'mw@gmail.com', '202cb962ac59075b964b07152d234b70', 1, 0, '', 12);

-- --------------------------------------------------------

--
-- Table structure for table `vaccine`
--

CREATE TABLE `vaccine` (
  `id` int(50) NOT NULL,
  `batch` varchar(255) NOT NULL,
  `count` int(50) NOT NULL,
  `used_count` int(50) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `status` int(50) NOT NULL,
  `expiration` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vaccine`
--

INSERT INTO `vaccine` VALUES
(1, 'tetanus-batch2022', 100, 50, 1, 1, '2023-12-12 00:00:00'),
(2, 'measles-batch2021', 100, 50, 0, 1, '2023-12-12 00:00:00'),
(3, 'penta-batch2022', 100, 50, 0, 1, '2023-12-12 00:00:00'),
(4, 'polio-batch2022', 100, 50, 0, 1, '2023-12-12 00:00:00'),
(5, 'pneumococcal-batch2022', 100, 50, 0, 1, '2023-12-12 00:00:00'),
(6, 'measles-batch2023', 100, 0, 0, 0, '2024-12-12 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barangay`
--
ALTER TABLE `barangay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `details`
--
ALTER TABLE `details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `infant_record`
--
ALTER TABLE `infant_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `med_history`
--
ALTER TABLE `med_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `treat_med`
--
ALTER TABLE `treat_med`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `treat_med_record`
--
ALTER TABLE `treat_med_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vaccine`
--
ALTER TABLE `vaccine`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `barangay`
--
ALTER TABLE `barangay`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `details`
--
ALTER TABLE `details`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `infant_record`
--
ALTER TABLE `infant_record`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `med_history`
--
ALTER TABLE `med_history`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `treat_med`
--
ALTER TABLE `treat_med`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `treat_med_record`
--
ALTER TABLE `treat_med_record`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `vaccine`
--
ALTER TABLE `vaccine`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
