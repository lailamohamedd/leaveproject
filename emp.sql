-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2021 at 10:26 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emp`
--

-- --------------------------------------------------------

--
-- Table structure for table `depart`
--

CREATE TABLE `depart` (
  `departID` int(11) NOT NULL,
  `departName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `depart`
--

INSERT INTO `depart` (`departID`, `departName`) VALUES
(1, 'Information Technology'),
(2, 'Human Resourcr'),
(4, 'operation'),
(5, 'New department');

-- --------------------------------------------------------

--
-- Table structure for table `gender`
--

CREATE TABLE `gender` (
  `genderid` int(11) NOT NULL,
  `genderName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gender`
--

INSERT INTO `gender` (`genderid`, `genderName`) VALUES
(1, 'Male'),
(2, 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `leavapply`
--

CREATE TABLE `leavapply` (
  `LeaveID` int(11) NOT NULL,
  `DateFrom` date NOT NULL,
  `DateTo` date NOT NULL,
  `TypeLeave` varchar(255) NOT NULL,
  `Disc` varchar(255) NOT NULL,
  `PostDate` datetime NOT NULL,
  `status` varchar(255) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `leavapply`
--

INSERT INTO `leavapply` (`LeaveID`, `DateFrom`, `DateTo`, `TypeLeave`, `Disc`, `PostDate`, `status`, `UserID`) VALUES
(3, '2021-04-02', '2021-04-30', 'Medical Leave test', 'kjkjkj kjkj kjk', '2021-04-28 15:11:23', 'Not Approve', 3),
(4, '2021-03-31', '2021-04-08', 'Medical Leave test', 'iuiuiuoinnbnbjhj', '2021-04-29 13:52:53', 'Approve', 4),
(7, '2021-04-02', '2021-04-30', 'Restricted Holiday(RH)', 'Waitting Approve Waitting Approve', '2021-04-29 15:50:05', 'Not Approve', 4),
(8, '2021-03-30', '2021-05-05', 'Restricted Holiday(RH)', 'Description Description Description', '2021-04-30 21:58:57', 'Not Approve', 3),
(9, '2021-04-28', '2021-05-22', 'Medical Leave test', 'hghjghgh jhjhj', '2021-05-04 00:47:46', 'Waitting Approve', 3),
(10, '2021-04-29', '2021-05-28', 'Medical Leave test', 'new disc edit ', '2021-05-19 14:37:39', 'Approve', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Pasword` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Fullname` varchar(255) NOT NULL,
  `departID` int(11) NOT NULL,
  `Phone` int(11) NOT NULL,
  `genderid` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `Birth` date NOT NULL,
  `Country` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `Regdate` date NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT 0,
  `RegStatus` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Username`, `Pasword`, `Email`, `Fullname`, `departID`, `Phone`, `genderid`, `city`, `Birth`, `Country`, `address`, `Regdate`, `GroupID`, `RegStatus`) VALUES
(1, 'Admin', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'lailacloud2016@gmail.com', 'Admin', 1, 1010579244, '1', 'sohag', '1994-11-07', 'Egypt', '', '0000-00-00', 1, 0),
(3, 'laila', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'lailacloud2016@gmail.com', 'Laila Mohamed', 1, 1234567895, '2', 'Sohag', '1994-11-07', 'Egypt', 'awlad naseer', '2021-04-27', 0, 1),
(4, 'Mohamed123', '2707c21cd6e3204c5645724efa79e7f0af1aa29f', 'mohamed@gmail.com', 'mohamed ahmed', 1, 1245637541, '1', 'Cairo', '1989-08-17', 'Egypt', 'sssssssssssssss', '2021-04-28', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `depart`
--
ALTER TABLE `depart`
  ADD PRIMARY KEY (`departID`);

--
-- Indexes for table `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`genderid`);

--
-- Indexes for table `leavapply`
--
ALTER TABLE `leavapply`
  ADD PRIMARY KEY (`LeaveID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `depart`
--
ALTER TABLE `depart`
  MODIFY `departID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `gender`
--
ALTER TABLE `gender`
  MODIFY `genderid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `leavapply`
--
ALTER TABLE `leavapply`
  MODIFY `LeaveID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
