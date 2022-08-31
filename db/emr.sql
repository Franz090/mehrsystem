-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 20, 2022 at 12:20 PM
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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `mid_initial` varchar(255),
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` BOOLEAN NOT NULL,
  `admin` INT NOT NULL,
  `otp` varchar(255),
  `details_id` int(50), PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

 
INSERT INTO `users` (`id`, `email`,`first_name`,`mid_initial`,`last_name`, `password`,`otp`,`status`,`admin`, `details_id`) VALUES
(1, 'francisoblepias@gmail.com','Francis','','Oblepias', '202cb962ac59075b964b07152d234b70','',1,1,null), 
(2, 'francisoblepias7@gmail.com','Francis','','Oblepias', '202cb962ac59075b964b07152d234b70','',1,0,1), 
(3, 'a@gmail.com','A','','B', '202cb962ac59075b964b07152d234b70','',0,-1,2);
-- (4, 'francisoblepias1@gmail.com','Francis1','','Oblepias', '202cb962ac59075b964b07152d234b70','',1,1,null), 
-- (5, 'francisoblepias2@gmail.com','Francis2','','Oblepias', '202cb962ac59075b964b07152d234b70','',1,1,null), 
-- (6, 'francisoblepias3@gmail.com','Francis3','','Oblepias', '202cb962ac59075b964b07152d234b70','',1,1,null), 
-- (7, 'francisoblepias4@gmail.com','Francis4','','Oblepias', '202cb962ac59075b964b07152d234b70','',1,1,null), 
-- (8, 'francisoblepias5@gmail.com','Francis5','','Oblepias', '202cb962ac59075b964b07152d234b70','',1,1,null), 
-- (9, 'francisoblepias6@gmail.com','Francis6','','Oblepias', '202cb962ac59075b964b07152d234b70','',1,1,null), 
-- (10, 'francisoblepias7@gmail.com','Francis7','','Oblepias', '202cb962ac59075b964b07152d234b70','',1,1,null), 
-- (11, 'francisoblepias8@gmail.com','Francis8','','Oblepias', '202cb962ac59075b964b07152d234b70','',1,1,null), 
-- (12, 'francisoblepias9@gmail.com','Francis9','','Oblepias', '202cb962ac59075b964b07152d234b70','',1,1,null),
-- (13, 'francisoblepias10@gmail.com','Francis10','','Oblepias', '202cb962ac59075b964b07152d234b70','',1,1,null),
-- (14, 'francisoblepias11@gmail.com','Francis11','','Oblepias', '202cb962ac59075b964b07152d234b70','',1,1,null);
-- nurse
-- midwife
-- patient
--
-- Table structure for table `details`
-- 
CREATE TABLE `details` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `contact_no` varchar(255) NOT NULL,
  `b_date` DATE NOT NULL,
  `barangay_id` int(50) NOT NULL,
  `med_history_id` int(50) ,PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `details`
-- 
 
INSERT INTO `details` (`id`, `contact_no`,`b_date`,`barangay_id`,`med_history_id`) VALUES
(1, '0908-123-1231', '1999-07-28',1,null),
(2, '0908-123-1231', '1999-07-28',2,1);
   
--
-- Table structure for table `med_history`
--

CREATE TABLE `med_history` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `height` varchar(255) NOT NULL,
  `weight` varchar(255),
  `blood_type` varchar(255) NOT NULL,
  `diagnosed_condition` varchar(255) NOT NULL,
  `allergies` varchar(255) NOT NULL, PRIMARY KEY (`id`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `med_history`
--

 
INSERT INTO `med_history` (`id`, `height` , `weight` ,`blood_type` ,  `diagnosed_condition` ,  `allergies`   ) VALUES
(1, '129m','50kg','O','None', 'Peanuts'),
(2, '129m','50kg','B-','Oblepias', 'Seafood');
 
 
--
-- Table structure for table `barangay`
--

CREATE TABLE `barangay` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `health_center` varchar(255) NOT NULL,
  `status` BOOLEAN NOT NULL , PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barangay`
--

 
INSERT INTO `barangay` (`id`, `health_center`, `status` ) VALUES
(1, 'Barangay 1',1),
(2, 'Barangay 2',0);
 
 
--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `patient_id` int(50) NOT NULL,
  `midwife_id` int(50) NOT NULL,
  `treatment_record_id` int(50) NOT NULL,
  `medicine_record_id` int(50) NOT NULL,
  `date` DATE NOT NULL,
  `status` BOOLEAN NOT NULL ,PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appointment`
--
 
INSERT INTO `appointment` (`id`, `patient_id` ,  `midwife_id` ,  `treatment_record_id` ,  `medicine_record_id` ,  `date` ,  `status`  ) VALUES
(1, 3,2,1,1,'2022-08-22',1);
 
 
--
-- Table structure for table `treat_med_record`
--

CREATE TABLE `treat_med_record` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `treat_med_id` int(50) NOT NULL, 
  `date` DATE NOT NULL, PRIMARY KEY (`id`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 
--
-- Dumping data for table `treat_med_record`
--
 
INSERT INTO `treat_med_record` (`id`, `treat_med_id`,   `date`    ) VALUES
(1, 1,'2022-08-22' ),
(2, 2,'2022-08-22' );
 
 

--
-- Table structure for table `treat_med`
--

CREATE TABLE `treat_med` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL, 
  `description` varchar(255) NOT NULL, 
  `category` BOOLEAN NOT NULL, 
  `status` BOOLEAN NOT NULL 
 ,PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 
-- treatment type / name of medicine
-- 0 medicine, 1 treatment
-- 0 ongoing, 1 completed
--
-- Dumping data for table `treat_med`
--



INSERT INTO `treat_med` (`id`, `name`  ,  `description`  ,  `category`  ,  `status`  ) VALUES
(1, "Treatment 1",'This is te first treatment.',1,0 ),
(2, "Medicine 1",'This is te first medicine.',0,0 );
 
 

--
-- Table structure for table `vaccine`
--

CREATE TABLE `vaccine` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `count` int(50) NOT NULL,
  `type` BOOLEAN NOT NULL, 
  `status` INT(50) NOT NULL,  
  `expiration` DATE NOT NULL, 
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 
-- 0 infant, 1 adult/patient 
-- 1 used,  0 arrived, -1 upcoming,
--
-- Dumping data for table `vaccine`
--
 
INSERT INTO `vaccine` (`id`, `count`, `type`, `status`, `expiration`) VALUES
(1, 2,1,0, '2022-12-12'),
(2, 4,0,0, '2022-12-12'); 
 

--
-- Table structure for table `infant_record`
--

CREATE TABLE `infant_record` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,  
  `date` DATE NOT NULL, 
  `legitimacy` BOOLEAN NOT NULL, 
  `status` BOOLEAN NOT NULL, 
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 
-- 0 illegit, 1 legit
-- 0 pending, 1 vaccinated
--
-- Dumping data for table `infant_record`
--

INSERT INTO `infant_record` (`id`, `name`  ,   `date`  ,   `legitimacy`  ,   `status`     ) VALUES
(1, "Baby Sangol", '2012-02-14', 1,0 ),
(2, "Isa Pang Sangol", '2012-02-14', 0,0 );
 
  

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
