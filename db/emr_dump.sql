drop table contacts;
drop table barangays;
drop table user_details;
drop table patient_details; 
drop table appointments ;
drop table consultations; 
drop table infant_vac_records; 
drop table footer; 
drop table infants;
drop table treat_med;
drop table users;

CREATE TABLE `users` (
  `user_id` int(50) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `otp` int(50) DEFAULT NULL,
  `role` int(50) not NULL,
  PRIMARY KEY (user_id) 
);
CREATE TABLE `user_details` (
  `user_details_id` int(50) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
    `middle_name` varchar(255) DEFAULT NULL,
    `last_name` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `user_id` int(50) not NULL,
     PRIMARY KEY (user_details_id),
    FOREIGN KEY  (user_id) REFERENCES users(user_id)
);

CREATE TABLE `patient_details` (
  `patient_details_id` int(50) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(255) DEFAULT NULL,
     `barangay_id` int(50) NOT NULL,
    `b_date` date DEFAULT NULL,
    `address` varchar(255) DEFAULT NULL,
  `civil_status` varchar(255) NOT NULL,
   `trimester` INT NOT NULL,
     `tetanus` tinyint(1) NOT NULL,
     `diagnosed_condition` varchar(255) DEFAULT NULL,
     `family_history` varchar(255) DEFAULT NULL,
    `allergies` varchar(255) DEFAULT NULL,
    `blood_type` varchar(255) NOT NULL,
    `weight` INT NOT NULL,
    `height_ft` INT NOT NULL, 
    `height_in` INT NOT NULL,
      `user_id` INT NOT NULL,
     PRIMARY KEY (patient_details_id),
    FOREIGN KEY  (user_id) REFERENCES users(user_id)
);

CREATE TABLE `barangays` (
  `barangay_id` INT NOT NULL AUTO_INCREMENT,
  `health_center` varchar(255) NOT NULL,
  `assigned_midwife` INT DEFAULT NULL, 
   PRIMARY KEY (barangay_id),
    FOREIGN KEY (assigned_midwife) REFERENCES users(user_id)
);
CREATE TABLE `appointments` (
    `appointment_id` int(50) NOT NULL AUTO_INCREMENT,
    `patient_id` int(50) NOT NULL,
    `midwife_id` int(50) DEFAULT NULL,
    `date` datetime NOT NULL,
    `status` INT NOT NULL,
    `trimester` INT NOT NULL,
    PRIMARY KEY (`appointment_id`),
    FOREIGN key (`patient_id`) references users(user_id),
    FOREIGN key (midwife_id) references users(user_id) 
);


CREATE TABLE `infants` (
    `infant_id` int(50) NOT NULL AUTO_INCREMENT,
      `first_name` varchar(255) NOT NULL,
      `middle_name` varchar(255) DEFAULT NULL,
      `last_name` varchar(255) NOT NULL,
      `nickname` varchar(255) DEFAULT NULL,
      `sex` varchar(50) NOT NULL,
    `b_date` date NOT NULL,
      `blood_type` varchar(255) NOT NULL,
    `legitimacy` tinyint(1) not NULL,
    `user_id` int NOT NULL,
    PRIMARY KEY (`infant_id`),
    FOREIGN key (`user_id`) references users(user_id) 
);

CREATE TABLE `treat_med` (
    `treat_med_id` int(50) NOT NULL AUTO_INCREMENT, 
        `name` varchar(255) not NULL,
        `description` varchar(255) not NULL,
          `type` tinyint(1) NOT NULL,
    PRIMARY KEY (`treat_med_id`)
);
CREATE TABLE `consultations` (
    `consultation_id` int(50) NOT NULL AUTO_INCREMENT,
    `treatment_id` int(50) DEFAULT NULL,
    `prescription_id` int(50) DEFAULT NULL,
      `treatment_file` varchar(255) DEFAULT NULL,
    `patient_id` int(50) not NULL,
    `midwife_appointed` int(50) not NULL,
    `date` datetime NOT NULL,
    `trimester` INT NOT NULL,
    PRIMARY KEY (`consultation_id`),
    FOREIGN key (`patient_id`) references users(user_id),
    FOREIGN key (midwife_appointed) references users(user_id),
    FOREIGN key (treatment_id) references treat_med(treat_med_id),
    FOREIGN key (prescription_id) references treat_med(treat_med_id)
);
CREATE TABLE `infant_vac_records` (
    `infant_vac_rec_id` int(50) NOT NULL AUTO_INCREMENT, 
        `infant_id` int not NULL,
       `date` datetime NOT NULL,
          `type` int not NULL,
    PRIMARY KEY (`infant_vac_rec_id`),
    FOREIGN key (`infant_id`) REFERENCES infants(infant_id)
);
CREATE TABLE `footer` (
    `footer_id` int(50) NOT NULL, 
       `email` varchar(255) DEFAULT NULL,
       `address` varchar(255) DEFAULT NULL,
       `fb_link` varchar(255) DEFAULT NULL,
       `schedule` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`footer_id`)
);
CREATE TABLE `contacts` (
    `contact_id` int(50) NOT NULL AUTO_INCREMENT, 
        `mobile_number` varchar(50) not NULL,
       `owner_id` int NOT NULL, 
       `type` tinyint(1) not null,
    PRIMARY KEY (`contact_id`)
);

INSERT INTO `users`  VALUES
(1,  'mendoza@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 1),
(2,  'kath@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 0),
(3,  'francisoblepias123@gmaill.com', '202cb962ac59075b964b07152d234b70', NULL, 0),
(4, 'francisoblepias@gmaill.com', '202cb962ac59075b964b07152d234b70', NULL, 0),
(5,  'francisoblepias120@gmaill.com', '202cb962ac59075b964b07152d234b70', NULL, 0),
(6,  'angela1@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 0 ),
(7,  'patient2@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(8,  'patient3@gmaill.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(9,  'patient1@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, -1),
(10,  'mw@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 0);

INSERT INTO `user_details`  VALUES
(1,'Kath', 'Rita', 'Buls', NULL, 2),
(2,'Francis', 'Perona', 'Oblepias', NULL,  3),        
(3, 'Francis', 'Ra', 'Oblepias',  NULL, 4),
(4,'Francis', 'Pe', 'Oblepias', NULL, 5),
(5,'Angela', 'Herradura', 'Oblepias', NULL,  6),
(6,'Patient', 'Cs', 'D', NULL, 7),
(7,'Patient', 'Ed', 'F', NULL, 8),
(8,'Patient', 'Ae', 'B', NULL,  9),
(9,'Another Midwife', '', 'Some Surname', NULL,  10);


INSERT INTO `barangays` VALUES
(1, 'Pagsawitan Laguna', 3),
(2, 'Santo Angel Norte', 4),
(3, 'Barangay 23', 3),
(4, 'asdf', 2),
(5, 'another barangay', 5),
(6, 'isa pang brgy', NULL);

INSERT INTO `patient_details` VALUES
(1,'Ed', 1, '1999-09-12', NULL, "Single", 0, 0, NULL, NULL, NULL, "O+", 60, 5,11, 6),
(2,'Cis', 2, '1999-09-12', NULL,  "Single", 0, 0, NULL, NULL, NULL, "O+", 60, 5,11, 7),        
(3, NULL, 1, '1999-09-12',  NULL, "Single", 0, 0, NULL, NULL, NULL, "O+", 60, 5,11, 8);

INSERT INTO `appointments` VALUES
(1, 7, NULL,"2022-09-29", 0, 0),
(2, 8, NULL,"2022-09-29", -1, 0),
(3, 6, NULL,"2022-09-29", 1, 0),
(4, 6, 3,"2022-09-26", 1, 0),
(5, 6, NULL,"2022-09-29", 0, 0);

INSERT INTO `infants` VALUES
(1, "Sanggol 1", "Ae", "B", NULL, "Male", "2021-01-23", "O+", 1, 8),
(2, "Sanggol 2", "Cs", "D", NULL, "Female", "2021-01-23", "O+", 1, 6),
(3, "Sanggol 3", "Ed", "F", "Tri", "Male", "2021-01-23", "O+", 1, 7);

INSERT INTO `treat_med` VALUES
(1, 'Treatment 1', 'This is te first treatment.', 1),
(2, 'Medicine 1', 'This is te first medicine.', 0);

INSERT INTO `consultations` VALUES
(1, NULL, 2, NULL, 6, 3, "2022-09-29", 0),
(2, 1, 2, NULL, 6, 3, "2022-09-28", 0);

INSERT INTO `infant_vac_records` VALUES
(1, 1, "2022-09-29", 1), 
(2, 1, "2022-09-29", 4), 
(3, 2, "2022-09-29", 2), 
(4, 3, "2022-09-29", 3);

INSERT INTO `footer` VALUES
(1, "some@email.com", "Some Address", "https://facebook.com", "8-5 sched");

INSERT INTO `contacts` VALUES
(1, "0908-123-1234", 6, 1),
(2, "0908-123-1234", 7, 1),
(3, "0908-123-1234", 1, 0),
(4, "0908-123-4321", 1, 0),
(5, "0908-123-1234", 8, 1);

-- 'El', 'Rota', 'Mendoza',
-- 'Kath', 'Rita', 'Buls',
-- 'Francis', 'Perona', 'Oblepias',
-- 'Francis', 'Ra', 'Oblepias', 
-- 'Francis', 'Pe', 'Oblepias',
-- 'Angela', 'Herradura', 'Oblepias',
-- 'Patient', 'Cs', 'D',
-- 'Patient', 'Ed', 'F',
-- 'Patient', 'Ae', 'B',
-- 'Another Midwife', '', 'Some Surname',