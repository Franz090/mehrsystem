-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2022 at 02:51 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

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
  `midwife_id` int(50) NOT NULL,
  `treatment_record_id` int(50) NOT NULL,
  `medicine_record_id` int(50) NOT NULL,
  `date` date NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appointment`
--

 
INSERT INTO `appointment` (`id`, `patient_id`, `midwife_id`, `treatment_record_id`, `medicine_record_id`, `date`, `status`) VALUES
(1, 3, 2, 1, 1, '2022-08-22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `barangay`
--

CREATE TABLE `barangay` (
  `id` int(50) NOT NULL,
  `health_center` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barangay`
--

INSERT INTO `barangay` (`id`, `health_center`, `status`) VALUES
(2, 'Barangay 23', 0),
(5, 'asdf', 0);

-- --------------------------------------------------------
 
--
-- Table structure for table `details`
--

CREATE TABLE `details` (
 
  `id` int(50) NOT NULL,
  `contact_no` varchar(255) NOT NULL,
  `b_date` date NOT NULL, 
  `barangay_id` int(50) NOT NULL,
  `med_history_id` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `details`
 
--

INSERT INTO `details` (`id`, `contact_no`, `b_date`, `barangay_id`, `med_history_id`) VALUES
(1, '0908-123-1231', '1999-07-28', 5, 2),
(2, '0908-123-1231', '1999-07-28', 2, 1),
(3, '1234-123-1234', '1999-08-10', 2, NULL),
(4, '1234-123-1234', '1090-12-12', 2, NULL),
(5, '1234-123-1234', '1234-03-12', 5, NULL),
(6, '1234-123-1234', '1234-03-12', 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `infant_record`
--

CREATE TABLE `infant_record` (
  `id` int(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `legitimacy` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `infant_record`
--

INSERT INTO `infant_record` (`id`, `name`, `date`, `legitimacy`, `status`) VALUES
(1, 'Baby Sangol', '2012-02-14', 1, 0),
(2, 'Isa Pang Sangol', '2012-02-14', 0, 0);

-- --------------------------------------------------------
 
--
-- Table structure for table `med_history`
--

CREATE TABLE `med_history` (
  `id` int(50) NOT NULL,
  `height` varchar(255) NOT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `blood_type` varchar(255) NOT NULL,
  `diagnosed_condition` varchar(255) NOT NULL,
  `allergies` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `med_history`
--

INSERT INTO `med_history` (`id`, `height`, `weight`, `blood_type`, `diagnosed_condition`, `allergies`) VALUES
(1, '129m', '50kg', 'O', 'None', 'Peanuts'),
(2, '129m', '50kg', 'B-', 'Oblepias', 'Seafood'),
(3, '120m', '40kg', 'B+', 'Coco Addiction', 'Coco');

-- --------------------------------------------------------

--
-- Table structure for table `treat_med`
--

CREATE TABLE `treat_med` (
  `id` int(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `category` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `treat_med`
--

INSERT INTO `treat_med` (`id`, `name`, `description`, `category`, `status`) VALUES
(1, 'Treatment 1', 'This is te first treatment.', 1, 0),
(2, 'Medicine 1', 'This is te first medicine.', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `treat_med_record`
--

CREATE TABLE `treat_med_record` (
  `id` int(50) NOT NULL,
  `treat_med_id` int(50) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `treat_med_record`
--

INSERT INTO `treat_med_record` (`id`, `treat_med_id`, `date`) VALUES
(1, 1, '2022-08-22'),
(2, 2, '2022-08-22');

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
(1, 'Francis', '', 'Oblepias', 'francisoblepias@gmail.com', '202cb962ac59075b964b07152d234b70', 1, 1, '', NULL),
(2, 'Francis', '', 'Oblepias', 'francisoblepias7@gmail.com', '202cb962ac59075b964b07152d234b70', 0, 0, '', 1),
(3, 'A', '', 'B', 'a@gmail.com', '4297f44b13955235245b2497399d7a93', 0, -1, '', 2),
(8, 'd', 'a', 'e', 'd@gmail.com', '202cb962ac59075b964b07152d234b70', 0, 0, '', 3),
(14, 'g', '', 'h', 'g@gmail', '202cb962ac59075b964b07152d234b70', 1, 0, '', 4),
(16, 'h', 'a', 'i', 'h@gmail.com', '202cb962ac59075b964b07152d234b70', 0, 0, '', 5),
(19, 'Pa', 'T', 'Ient', 'patient@gmail.com', '202cb962ac59075b964b07152d234b70', 0, -1, '', 6),
(4, 'francisoblepias1@gmail.com','Francis1','','Oblepias', '202cb962ac59075b964b07152d234b70',1,1,'',null), 
(5, 'francisoblepias2@gmail.com','Francis2','','Oblepias', '202cb962ac59075b964b07152d234b70',1,1,'',null), 
(6, 'francisoblepias3@gmail.com','Francis3','','Oblepias', '202cb962ac59075b964b07152d234b70',1,1,'',null), 
(7, 'francisoblepias4@gmail.com','Francis4','','Oblepias', '202cb962ac59075b964b07152d234b70',1,1,'',null), 
(9, 'francisoblepias6@gmail.com','Francis6','','Oblepias', '202cb962ac59075b964b07152d234b70',1,1,'',null), 
(11, 'francisoblepias8@gmail.com','Francis8','','Oblepias', '202cb962ac59075b964b07152d234b70',1,1,'',null), 
(12, 'francisoblepias9@gmail.com','Francis9','','Oblepias', '202cb962ac59075b964b07152d234b70',1,1,'',null),
(13, 'francisoblepias10@gmail.com','Francis10','','Oblepias', '202cb962ac59075b964b07152d234b70',1,1,'',null),
(15, 'francisoblepias10@gmail.com','Francis10','','Oblepias', '202cb962ac59075b964b07152d234b70',1,1,'',null),
(17, 'francisoblepias10@gmail.com','Francis10','','Oblepias', '202cb962ac59075b964b07152d234b70',1,1,'',null),
(18, 'francisoblepias10@gmail.com','Francis10','','Oblepias', '202cb962ac59075b964b07152d234b70',1,1,'',null);

-- --------------------------------------------------------

--
-- Table structure for table `vaccine`
--

CREATE TABLE `vaccine` (
  `id` int(50) NOT NULL,
  `count` int(50) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `status` int(50) NOT NULL,
  `expiration` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vaccine`
--

INSERT INTO `vaccine` (`id`, `count`, `type`, `status`, `expiration`) VALUES
(1, 2, 1, 0, '2022-12-12'),
(2, 4, 0, 0, '2022-12-12');

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
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `details`
--
ALTER TABLE `details`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `vaccine`
--
ALTER TABLE `vaccine`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
