-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2025 at 12:29 PM
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
-- Database: `employeemngmtsys`
--

-- --------------------------------------------------------

--
-- Table structure for table `educations`
--

CREATE TABLE `educations` (
  `Eduid` int(11) NOT NULL,
  `Eduname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `educations`
--

INSERT INTO `educations` (`Eduid`, `Eduname`) VALUES
(2, 'Bachelor\'s'),
(1, 'High School'),
(3, 'Master\'s'),
(4, 'PhD');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `Eid` int(11) NOT NULL,
  `EName` varchar(50) NOT NULL,
  `Ephone` varchar(20) NOT NULL,
  `Ebirth_date` date NOT NULL,
  `Egender` enum('Male','Female','Other') NOT NULL,
  `Edescription` text DEFAULT NULL,
  `Efile_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`Eid`, `EName`, `Ephone`, `Ebirth_date`, `Egender`, `Edescription`, `Efile_path`) VALUES
(1, 'Shubham Nakashe', '1234567859', '2002-05-28', 'Male', 'Hey there i am shubham Nakashe here, a Computer Engineer.', '67e53435a865f_sample.pdf'),
(3, 'Dharmesh Marathe', '0000000000', '2002-05-29', 'Male', 'Hey there its me Dharmesh marathe. I am a Full stack Computer Engineer. How are you ?', '67e4f036b8a0d_download.jpg'),
(5, 'Om Achrekar', '0000000000', '2002-10-22', 'Male', 'Hey there its me OM Achrekar, I am a Full stack dev + AI Engineer. Above everything i am damnnn Depressed person fr.😑 i like being depressed as it is my 1st job of being depressed.  I love being depressed 😂. ', '67e4f6eddd761_download.jpg'),
(7, 'Aarya  Padte', '0000000000', '2005-10-19', 'Female', 'Hey i am Aarya here, Nice to meet you. I am a Vet doctor in making.', '67e534ec6e81a_sample.pdf'),
(14, 'Mitali Rawat', '0000000000', '2002-05-16', 'Female', 'Hey i am Mitali Rawat here.', '67e52f74b902a_sample.pdf'),
(15, 'Radha Vishwakarma', '0000000000', '2002-08-19', 'Female', 'HEy i am radha', ''),
(16, 'Aboli Patil', '0000000000', '1997-04-09', 'Female', 'Hey i am Aboli Patil', '67e5357ca5058_sample.pdf'),
(17, 'Sayli  Sawant', '0000000000', '2002-05-05', 'Female', 'Hey i am Sayli Sawant', '67e536474b106_sample.pdf'),
(18, 'Aditya  Patil', '0000000000', '2001-06-15', 'Male', 'Hey i am Aditya', '67e536b37f949_sample.pdf'),
(19, 'Alok Singh', '0000000000', '2001-08-14', 'Male', 'Hey i am Alok', '67e536eed3328_sample.pdf'),
(20, 'Praful  Satpal', '0000000000', '2001-08-12', 'Male', 'Hey i am Praful', '67e5373b3d2ea_download.jpg'),
(21, 'Mithila Dali', '0000000000', '2000-06-14', 'Female', 'Hey i am Mithila', '67e537a0a8d3d_sample.pdf'),
(22, 'Akash Kanojiya', '0000000000', '1999-12-09', 'Male', 'Hey i am Akash', '67e5383c417d9_sample.pdf'),
(23, 'Ram naik', '0000000000', '1994-05-29', 'Male', 'Hey i am Ram.', '67e538ae54ea1_download.jpg'),
(24, 'Sumeet Vishwakarma', '0000000000', '1999-09-13', 'Male', 'Hey i am Sumeet.', '67e53935511bd_sample.pdf'),
(25, 'Ashwini Sutar', '0000000000', '1997-08-03', 'Female', 'Hey i am Ashwini', '67e5398f64a6d_sample.pdf'),
(26, 'Abhay Singh', '0000000000', '2001-05-24', 'Male', 'Hey i am Abay.', '67e539fd3645a_sample.pdf'),
(27, 'Darshal Verma', '0000000000', '2001-04-22', 'Male', 'Hey i am Darsheel', '67e53a9f26a22_sample.pdf'),
(28, 'Aditya  Padte', '0000000000', '2005-10-19', 'Male', 'Hey i am Aditya.', '67e53e2cd409f_download.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `employee_educations`
--

CREATE TABLE `employee_educations` (
  `employee_id` int(11) NOT NULL,
  `education_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_educations`
--

INSERT INTO `employee_educations` (`employee_id`, `education_id`) VALUES
(1, 2),
(3, 1),
(3, 2),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(7, 1),
(14, 1),
(14, 2),
(15, 1),
(15, 2),
(16, 1),
(16, 2),
(16, 3),
(17, 1),
(17, 2),
(18, 1),
(18, 2),
(19, 1),
(19, 2),
(20, 1),
(20, 2),
(21, 1),
(21, 2),
(22, 1),
(22, 2),
(22, 3),
(23, 1),
(23, 2),
(23, 3),
(24, 1),
(24, 2),
(25, 1),
(25, 2),
(25, 3),
(26, 1),
(26, 2),
(27, 1),
(27, 2),
(27, 3),
(28, 1);

-- --------------------------------------------------------

--
-- Table structure for table `employee_hobbies`
--

CREATE TABLE `employee_hobbies` (
  `employee_id` int(11) NOT NULL,
  `hobby_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_hobbies`
--

INSERT INTO `employee_hobbies` (`employee_id`, `hobby_id`) VALUES
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(3, 1),
(3, 4),
(3, 5),
(7, 1),
(7, 2),
(7, 3),
(7, 6),
(7, 7),
(14, 1),
(14, 2),
(14, 4),
(14, 5),
(14, 6),
(15, 1),
(15, 3),
(15, 5),
(16, 3),
(16, 6),
(16, 7),
(17, 5),
(18, 2),
(18, 3),
(18, 4),
(18, 5),
(18, 6),
(18, 7),
(19, 1),
(19, 2),
(19, 3),
(19, 4),
(19, 7),
(20, 1),
(20, 2),
(20, 3),
(20, 4),
(20, 5),
(21, 1),
(21, 3),
(21, 5),
(21, 6),
(21, 7),
(22, 1),
(22, 2),
(22, 3),
(22, 4),
(22, 5),
(23, 1),
(23, 2),
(23, 4),
(23, 5),
(23, 7),
(24, 3),
(24, 5),
(24, 6),
(24, 7),
(25, 1),
(25, 2),
(25, 3),
(25, 5),
(25, 6),
(26, 1),
(26, 2),
(26, 3),
(26, 5),
(26, 7),
(27, 1),
(27, 2),
(28, 1),
(28, 2),
(28, 3),
(28, 5);

-- --------------------------------------------------------

--
-- Table structure for table `hobbies`
--

CREATE TABLE `hobbies` (
  `Hid` int(11) NOT NULL,
  `Hname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hobbies`
--

INSERT INTO `hobbies` (`Hid`, `Hname`) VALUES
(3, 'Cooking'),
(6, 'Dancing'),
(8, 'drawing'),
(7, 'Esports'),
(5, 'Music'),
(1, 'Reading'),
(4, 'Sports'),
(2, 'Traveling');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(4, 'Shubham Nakashe', 's.d.nakashe2002@gmail.com', '$2y$10$J.Z7vNz9gvvahvYFhnjS4uUokLVOx8YtfsDA6eB8FO5gYyR0qPKv2'),
(5, 'Dharmesh Marathe', 'dhamu@gmail.com', '$2y$10$ujKIP5Pd1hOrm5JJ6AUFP.gEytu79yrFY6OD4w7toA6MwACiwr6.q'),
(6, 'Aarya Padte', 'Aarya@gmail.com', '$2y$10$8V0x0oNzMTRUNZMfnxTHPeyQ9bI2PyQJs.gv4GYFY9IEED.kr6iZe'),
(7, 'Radha Vishwakarma', 'Radha@gmail.com', '$2y$10$d34iDZPcD3ypk2vy3b40cOh9GVzvujy.2Hii6/tLYFi64HLSlPoK6'),
(8, 'Mitali Rawat', 'Mitali@gmail.com', '$2y$10$1MT41SZKZcGjyspty7hum.t7p0YRu.75Q/FPLfM3tEWYs5wJHL2Pu'),
(9, 'om Achrekar', 'om@gmail.com', '$2y$10$NhO9xjmeNHy7vRv6marHuOpNyyv2WyPjpFxFNKXHJcox/gwNBwO4C'),
(21, 'Test user', 'testuser@testmail.com', '$2y$10$TOl2oWbTrNnLip3AeDOrBO1fYUpsfuRIKpS93wzOe0CGPp3hJqJjW'),
(22, 'Test user2', 'testuser2@testmail.com', '$2y$10$ezXURF95kXeFhSv3rOOrne3OM3LMVdDiyGYb/kcGtca8naEogYDdq');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `educations`
--
ALTER TABLE `educations`
  ADD PRIMARY KEY (`Eduid`),
  ADD UNIQUE KEY `Eduname` (`Eduname`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`Eid`);

--
-- Indexes for table `employee_educations`
--
ALTER TABLE `employee_educations`
  ADD PRIMARY KEY (`employee_id`,`education_id`),
  ADD KEY `employee_educations_ibfk_2` (`education_id`);

--
-- Indexes for table `employee_hobbies`
--
ALTER TABLE `employee_hobbies`
  ADD PRIMARY KEY (`employee_id`,`hobby_id`),
  ADD KEY `employee_hobbies_ibfk_2` (`hobby_id`);

--
-- Indexes for table `hobbies`
--
ALTER TABLE `hobbies`
  ADD PRIMARY KEY (`Hid`),
  ADD UNIQUE KEY `Hname` (`Hname`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `educations`
--
ALTER TABLE `educations`
  MODIFY `Eduid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `Eid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `hobbies`
--
ALTER TABLE `hobbies`
  MODIFY `Hid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee_educations`
--
ALTER TABLE `employee_educations`
  ADD CONSTRAINT `employee_educations_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`Eid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_educations_ibfk_2` FOREIGN KEY (`education_id`) REFERENCES `educations` (`Eduid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_hobbies`
--
ALTER TABLE `employee_hobbies`
  ADD CONSTRAINT `employee_hobbies_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`Eid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_hobbies_ibfk_2` FOREIGN KEY (`hobby_id`) REFERENCES `hobbies` (`Hid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
