-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2022 at 06:48 PM
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
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(50) NOT NULL,
  `patient_id` int(50) NOT NULL,
  `midwife_id` int(50) DEFAULT NULL,
  `date` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `trimester` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `patient_id`, `midwife_id`, `date`, `status`, `trimester`) VALUES
(1, 7, NULL, '2022-09-29 00:00:00', 0, 0),
(2, 8, NULL, '2022-09-29 00:00:00', -1, 0),
(3, 9, NULL, '2022-09-29 00:00:00', 1, 0),
(4, 9, 3, '2022-09-26 00:00:00', 1, 0),
(5, 9, NULL, '2022-09-29 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `barangays`
--

CREATE TABLE `barangays` (
  `barangay_id` int(11) NOT NULL,
  `health_center` varchar(255) NOT NULL,
  `assigned_midwife` int(11) DEFAULT NULL,
  `archived` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(9, 'Malinao', NULL, 0),
(10, 'Oogong', NULL, 0),
(11, 'Pagsawitan', NULL, 0),
(12, 'Palasan', NULL, 1),
(13, 'Patimbao', NULL, 1),
(14, 'Poblacion I', NULL, 1),
(15, 'Poblacion II', NULL, 1),
(16, 'Poblacion III', NULL, 1),
(17, 'Poblacion IV', NULL, 1),
(18, 'Poblacion V', NULL, 1),
(19, 'Poblacion VI New', NULL, 1),
(20, 'Poblacion VII New', NULL, 1),
(21, 'Poblacion VIII New', NULL, 1),
(22, 'San Jose', NULL, 1),
(23, 'San Juan', NULL, 1),
(24, 'San Pablo Norte', NULL, 1),
(25, 'San Pablo Sur', NULL, 1),
(26, 'Santisima Cruz', NULL, 1),
(27, 'Santo Angel Central', NULL, 1),
(28, 'Santo Angel Norte', NULL, 1),
(29, 'Santo Angel Sur', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `consultations`
--

CREATE TABLE `consultations` (
  `consultation_id` int(50) NOT NULL,
  `treatment` varchar(255) DEFAULT NULL,
  `prescription` varchar(255) DEFAULT NULL,
  `treatment_file` varchar(255) DEFAULT NULL,
  `patient_id` int(50) NOT NULL,
  `midwife_appointed` int(50) NOT NULL,
  `date` datetime NOT NULL,
  `trimester` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `consultations`
--

INSERT INTO `consultations` (`consultation_id`, `treatment`, `prescription`, `treatment_file`, `patient_id`, `midwife_appointed`, `date`, `trimester`) VALUES
(1, 'A treatment', 'A prescription', NULL, 9, 3, '2022-09-29 00:00:00', 0),
(2, NULL, 'Another Prescription', NULL, 9, 3, '2022-09-28 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `contact_id` int(50) NOT NULL,
  `mobile_number` varchar(50) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`contact_id`, `mobile_number`, `owner_id`, `type`) VALUES
(1, '0908-123-1234', 9, 1),
(2, '0908-123-1234', 7, 1),
(3, '0908-123-1234', 1, 0),
(4, '0908-123-4321', 1, 0),
(5, '0908-123-3141', 9, 1),
(6, '0908-123-1234', 8, 1),
(7, '0908-123-0001', 2, 1),
(8, '0908-123-0002', 3, 1),
(9, '0908-123-0003', 4, 1),
(10, '0908-123-0004', 5, 1),
(11, '0908-123-0005', 6, 1),
(12, '0908-123-0006', 10, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `footer`
--

INSERT INTO `footer` (`footer_id`, `email`, `address`, `fb_link`, `schedule`) VALUES
(1, 'some@email.com', 'Some Address', 'https://facebook.com', '8-5 sched');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `infants`
--

INSERT INTO `infants` (`infant_id`, `first_name`, `middle_name`, `last_name`, `nickname`, `sex`, `b_date`, `blood_type`, `legitimacy`, `user_id`) VALUES
(1, 'Boy', 'Aga', 'Riva', NULL, 'Male', '2021-01-23', 'O+', 1, 8),
(2, 'Reina', NULL, 'Bana', NULL, 'Female', '2021-01-23', 'O+', 1, 9),
(3, 'Bang', 'Cruz', 'Dana', 'Tri', 'Male', '2021-01-23', 'O+', 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `infant_vac_records`
--

CREATE TABLE `infant_vac_records` (
  `infant_vac_rec_id` int(50) NOT NULL,
  `infant_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `infant_vac_records`
--

INSERT INTO `infant_vac_records` (`infant_vac_rec_id`, `infant_id`, `date`, `type`) VALUES
(1, 1, '2022-09-29 00:00:00', 1),
(2, 1, '2022-09-29 00:00:00', 4),
(3, 2, '2022-09-29 00:00:00', 2),
(4, 3, '2022-09-29 00:00:00', 3);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patient_details`
--

INSERT INTO `patient_details` (`patient_details_id`, `nickname`, `barangay_id`, `b_date`, `address`, `civil_status`, `trimester`, `tetanus`, `diagnosed_condition`, `family_history`, `allergies`, `blood_type`, `weight`, `height_ft`, `height_in`, `user_id`, `status`) VALUES
(1, 'Shen', 1, '1999-09-12', NULL, 'Married', 0, 0, NULL, NULL, NULL, 'O+', 60, 5, 11, 9, 1),
(2, 'B', 2, '1999-09-12', NULL, 'Married', 0, 0, NULL, NULL, NULL, 'O+', 60, 5, 11, 7, 1),
(3, NULL, 1, NULL, NULL, 'Married', 0, 0, NULL, NULL, NULL, 'O+', 60, 5, 11, 8, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `otp`, `role`) VALUES
(1, 'mendoza@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 1),
(2, 'kath@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 0),
(3, 'francisoblepias123@gmaill.com', '202cb962ac59075b964b07152d234b70', NULL, 0),
(4, 'francisoblepias@gmaill.com', '202cb962ac59075b964b07152d234b70', NULL, 0),
(5, 'francisoblepias120@gmaill.com', '202cb962ac59075b964b07152d234b70', NULL, 0),
(6, 'angela1@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 0),
(7, 'shane@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(8, 'bea@gmaill.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(9, 'angel@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(10, 'mw@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`user_details_id`, `first_name`, `middle_name`, `last_name`, `profile_picture`, `user_id`) VALUES
(1, 'Kath', 'Rita', 'Buls', NULL, 2),
(2, 'Francis', 'Perona', 'Oblepias', NULL, 3),
(3, 'Francis', 'Ra', 'Oblepias', NULL, 4),
(4, 'Francis', 'Pe', 'Oblepias', NULL, 5),
(5, 'Angela', 'Herradura', 'Oblepias', NULL, 6),
(6, 'Shane', 'Cruz', 'Dana', NULL, 7),
(7, 'Bea', 'Edo', 'Facundo', NULL, 8),
(8, 'Angel', 'Aga', 'Riva', NULL, 9),
(9, 'Rey', NULL, 'Bana', NULL, 10);

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
  MODIFY `appointment_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `barangays`
--
ALTER TABLE `barangays`
  MODIFY `barangay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `consultation_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `contact_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `footer`
--
ALTER TABLE `footer`
  MODIFY `footer_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `infants`
--
ALTER TABLE `infants`
  MODIFY `infant_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `infant_vac_records`
--
ALTER TABLE `infant_vac_records`
  MODIFY `infant_vac_rec_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `patient_details`
--
ALTER TABLE `patient_details`
  MODIFY `patient_details_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `user_details_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
