-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 20, 2018 at 04:37 PM
-- Server version: 5.7.24-log
-- PHP Version: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `candystats`
--
CREATE DATABASE IF NOT EXISTS `candystats` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `candystats`;

-- --------------------------------------------------------

--
-- Table structure for table `logdata`
--

CREATE TABLE `logdata` (
  `CSID` int(11) NOT NULL,
  `SessionID` text NOT NULL COMMENT 'Effectively the Log Name',
  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Time and date of the event',
  `TAG1` text NOT NULL COMMENT 'User defined tag',
  `TAG2` text NOT NULL COMMENT 'User defined tag',
  `TAG3` text NOT NULL COMMENT 'User defined tag',
  `Name` text NOT NULL COMMENT 'Name of Player',
  `SteamID` text COMMENT 'SteamID of player',
  `Team` text COMMENT 'Team of Player',
  `EventType` text NOT NULL COMMENT 'Type of Event',
  `EventVariable` text NOT NULL COMMENT 'Event Variable',
  `Misc` text COMMENT 'Misc info relating to event',
  `XYZ` text COMMENT 'coordinates of event'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `logdata`
--
ALTER TABLE `logdata`
  ADD UNIQUE KEY `CSID` (`CSID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `logdata`
--
ALTER TABLE `logdata`
  MODIFY `CSID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
