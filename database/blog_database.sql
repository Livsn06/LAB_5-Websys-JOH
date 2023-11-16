-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2023 at 04:01 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`username`, `password`, `status`) VALUES
('James Vill', 'eba2346346bce6e941a9ff0a0c96e0e9d4282b658bd72ca2bc93d81021de08d0', 'inactive'),
('Joel Gutlay', 'f77cbd0385f7f2d7c8180bcef7931a8828e1e226a50e1aa461f888e248bbdfea', 'active'),
('Mike Anthony', '541bf3ce2c00becc8012af585a3fa01210c046c10039dab2f7990b5ea84c2312', 'inactive');

-- --------------------------------------------------------

--
-- Table structure for table `accounts_profile`
--

CREATE TABLE `accounts_profile` (
  `username` varchar(100) NOT NULL,
  `profile` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts_profile`
--

INSERT INTO `accounts_profile` (`username`, `profile`) VALUES
('James Vill', '../images/profile/james.jpg'),
('Joel Gutlay', '../images/profile/joel.jpg'),
('Mike Anthony', '../images/profile/mike.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `commentID` int(11) NOT NULL,
  `blogID` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `Comment` varchar(800) NOT NULL,
  `DateTime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`commentID`, `blogID`, `username`, `Comment`, `DateTime`) VALUES
(34, 31, 'Joel Gutlay', 'My favorite dish in raidy day... \r\nLooks so delicious !', '2023-11-15 20:13:02'),
(35, 31, 'Joel Gutlay', 'hatdog', '2023-11-16 09:56:14');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `blogID` int(11) NOT NULL,
  `blog_title` varchar(200) NOT NULL,
  `blog_content` varchar(800) NOT NULL,
  `dateTime_created` datetime NOT NULL DEFAULT current_timestamp(),
  `blog_cat` varchar(100) NOT NULL,
  `blog_pic` varchar(100) NOT NULL,
  `username` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`blogID`, `blog_title`, `blog_content`, `dateTime_created`, `blog_cat`, `blog_pic`, `username`) VALUES
(30, 'Lets play minecraft everyone!!', 'if you have an account, lets play with my friendss.. its so fun to do so!..', '2023-11-15 20:01:39', 'Game and Sports', '../images/upload/Screenshot (4).png', 'Joel Gutlay'),
(31, 'Lets eat guyss', 'My favorite sinigang is always the best!!.', '2023-11-15 20:04:30', 'Food and Cooking', '../images/upload/sinigang.jpg', 'James Vill'),
(32, 'Travel is the best medicinee.....', 'camping with my friends, with such a nice view..', '2023-11-15 20:10:06', 'Leisure & Travel', '../images/upload/guy-mountain.jpg', 'Mike Anthony');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `accounts_profile`
--
ALTER TABLE `accounts_profile`
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentID`),
  ADD KEY `comment_by` (`username`),
  ADD KEY `commented_to` (`blogID`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`blogID`),
  ADD KEY `posted` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `blogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts_profile`
--
ALTER TABLE `accounts_profile`
  ADD CONSTRAINT `profile of` FOREIGN KEY (`username`) REFERENCES `accounts` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_by` FOREIGN KEY (`username`) REFERENCES `accounts` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commented_to` FOREIGN KEY (`blogID`) REFERENCES `post` (`blogID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `posted` FOREIGN KEY (`username`) REFERENCES `accounts` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
