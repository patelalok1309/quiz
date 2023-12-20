-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2023 at 07:07 AM
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
-- Database: `quiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `sno` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `timestamp` datetime NOT NULL,
  `result` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`sno`, `username`, `timestamp`, `result`) VALUES
(5, 'yash', '2023-12-18 02:39:17', '1'),
(6, 'yash', '2023-12-18 02:40:00', '5'),
(7, 'yash', '2023-12-18 02:41:08', '0'),
(8, 'alok', '2023-12-19 05:39:42', '8'),
(9, 'alok', '2023-12-19 05:44:24', '1'),
(10, 'alok', '2023-12-19 06:07:45', '1'),
(11, 'alok', '2023-12-19 06:12:16', '6'),
(12, 'alok', '2023-12-19 06:50:16', '0'),
(13, 'alok', '2023-12-19 06:51:25', '0'),
(26, 'alok', '2023-12-19 10:58:32', '4'),
(27, 'alok', '2023-12-19 11:01:25', '0'),
(28, 'xyz', '2023-12-19 11:06:53', '5'),
(29, 'vaibhav', '2023-12-19 11:38:42', '3'),
(30, 'vaibhav', '2023-12-19 11:49:35', '1'),
(31, 'vaibhav', '2023-12-19 12:48:25', '3'),
(32, 'alok', '2023-12-19 01:29:23', '0'),
(33, 'alok', '2023-12-19 01:31:02', '0'),
(34, 'alok', '2023-12-19 01:59:56', '0'),
(35, 'alok', '2023-12-19 02:01:10', '0'),
(36, 'alok', '2023-12-19 02:04:03', '1'),
(37, 'alok', '2023-12-19 02:05:07', '0'),
(38, 'alok', '2023-12-19 02:15:34', '2'),
(39, 'alok', '2023-12-19 02:18:09', '10'),
(40, 'vraj patel', '2023-12-19 02:20:05', '10'),
(41, 'alok', '2020-12-23 05:38:51', '10'),
(42, 'alok', '2020-12-23 05:51:07', '2'),
(43, 'vraj patel', '2020-12-23 06:05:07', '10'),
(44, 'vraj patel', '2020-12-23 06:08:23', '4'),
(45, 'alok', '2020-12-23 06:09:08', '6'),
(46, 'alok', '2020-12-23 06:52:30', '10');

-- --------------------------------------------------------

--
-- Table structure for table `quizques`
--

CREATE TABLE `quizques` (
  `sno` int(11) NOT NULL,
  `question` text NOT NULL,
  `opt1` text NOT NULL,
  `opt2` text NOT NULL,
  `opt3` text NOT NULL,
  `answer` text NOT NULL,
  `opt4` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizques`
--

INSERT INTO `quizques` (`sno`, `question`, `opt1`, `opt2`, `opt3`, `answer`, `opt4`) VALUES
(6, '5+5', '10', '40', '20', '10', '30'),
(23, 'what is the height of burj khalifa', '828 meters', '850 meters', '830 meters', '828 meters', '835 meters'),
(24, 'OOPS means ?', 'Object Oriented Programming', 'other oriented programming', '', 'Object Oriented Programming', ''),
(25, 'Which planet is known as the \"Red Planet\"?', 'mars', 'earth', 'venus', 'mars', 'saturn'),
(26, 'Who wrote the famous play \"Romeo and Juliet\"?', 'Rohan Parmar', 'Tarang ', 'William Shakespeare', 'William Shakespeare', 'vaibhav'),
(27, 'what is the capital of india ?', 'delhi', 'ahmedabad', 'gandhinagar', 'delhi', 'mumbai'),
(29, 'india won world cup in ?', '2011', '2007', '2012', '2011', '1982'),
(30, 'who is the Prime minister of India  ?', 'Narendra Modi', 'Lal bahadur shastri', 'amit shah', 'Narendra Modi', 'Bhupendra Patel'),
(32, 'What is the largest mammal in the world?', 'dog', 'cat', 'Blue whale', 'Blue whale', ''),
(34, 'AI means...', 'Artificial Intelisense', 'Abort intelligence', 'Artificial intelligence', 'Artificial intelligence', ''),
(38, 'water boils at?', '100 C', '200 C', '', '100 C', ''),
(41, 'who captain of the world cup winning team in 2011?', 'Rohit sharma', 'M S Dhoni', 'Virat Kohli', 'M S Dhoni', 'Gautam Gambhir'),
(45, 'What country has the highest life expectancy?', 'Hong Kong', 'India', 'Pakistan', 'Hong Kong', 'North Korea'),
(46, 'Which language has the more native speakers: English or Spanish?', 'English', 'Spanish', 'Gujarati', 'Spanish', 'Hindi'),
(47, 'What is the most common surname in the United States?', 'Patel', 'Smith', 'Williamson', 'Smith', ''),
(48, 'What disease commonly spread on pirate ships?', 'Scurvy', 'fever', 'headache', 'Scurvy', 'None of the Above'),
(49, 'In a website browser address bar, what does “www” stand for?', 'World Wide Web', 'Woman Wide Web', 'Wildly Wide Web', 'World Wide Web', 'Worse Wide Web'),
(50, 'Originally, Amazon only sold what kind of product?', 'Books', 'Pens', 'Pencils', 'Books', ''),
(51, 'Which month has 28 days?', 'June', 'February', 'January', 'February', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `sno` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'member'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`sno`, `username`, `email`, `password`, `role`) VALUES
(1, 'alok', 'alokdholu10@gmail.com', 'alok@123', 'admin'),
(2, 'rohan', 'rahan123@gmail.com', 'rohan\r\n', 'member'),
(3, 'yash', 'alokdholu1890@gmail.com', 'yash', 'member'),
(4, 'tarang', 't@gmail.com', 't', 'member'),
(5, 'tp', 'tp@gmail.com', 'tp', 'member'),
(6, 'tpt', 'sadf@gmail.com', 'tpt', 'member'),
(8, 'vraj patel', 'patelvraju07@gmail.com', 'vp098', 'member'),
(9, 'pp', 'pp@gmail.com', 'pp', 'member'),
(10, 'xyz', 'xyz@gmail.com', '1234', 'member'),
(11, 'vaibhav', 'vaibhav@gmail.com', 'vaibhav', 'member');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `quizques`
--
ALTER TABLE `quizques`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`sno`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `quizques`
--
ALTER TABLE `quizques`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
