-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 17, 2018 at 05:02 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `basescores`
--

CREATE TABLE `basescores` (
  `BS_ID` int(11) NOT NULL,
  `BaseScore` text NOT NULL,
  `Value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `basescores`
--

INSERT INTO `basescores` (`BS_ID`, `BaseScore`, `Value`) VALUES
(1, 'Hostage_Rescued', 500),
(2, 'Hostage_Damage', -50),
(3, 'Bomb_Planted', 100),
(4, 'Bomb_Successful', 400),
(5, 'Bomb_Defusal', 500),
(6, 'Team_Kill', -200),
(7, 'Suicide', -200),
(8, 'Kill_Assist', 50),
(9, 'Headshot', 150),
(10, 'Penetration', 150),
(11, 'Headshot Penetration', 200),
(12, 'Kill_Base', 100);

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
  `Misc_1` text COMMENT 'Misc info relating to event E.G. gun name',
  `Misc_2` text COMMENT '2nd misc field, used for misc data, E.G. player name',
  `Misc_3` text COMMENT '3rd misc field, used for joining score related tables',
  `XYZ_1` text COMMENT 'coordinates of event',
  `XYZ_2` text COMMENT 'co-ordinates of a victim if applicable',
  `score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `weaponweighting`
--

CREATE TABLE `weaponweighting` (
  `WW_ID` int(11) NOT NULL,
  `Weapon` text NOT NULL,
  `Weighting` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `weaponweighting`
--

INSERT INTO `weaponweighting` (`WW_ID`, `Weapon`, `Weighting`) VALUES
(1, 'ak47', 1),
(2, 'aug', 1),
(3, 'awp', 0.8),
(4, 'bizon', 1.2),
(5, 'cz75a', 1.5),
(6, 'deagle', 0.8),
(7, 'elite', 1.2),
(8, 'famas', 1.1),
(9, 'fiveseven', 1.5),
(10, 'g3sg1', 1.5),
(11, 'galilar', 1.1),
(12, 'glock', 1.5),
(13, 'hkp2000', 1.5),
(14, 'knife', 2),
(15, 'knifegg', 2),
(16, 'm249', 0.8),
(17, 'm4a1', 1),
(18, 'm4a1_silencer', 1),
(19, 'mac10', 1.2),
(20, 'mag7', 1.2),
(21, 'mp5sd', 1.2),
(22, 'mp7', 1.2),
(23, 'mp9', 1.2),
(24, 'negev', 0.8),
(25, 'nova', 1.2),
(26, 'p250', 1.5),
(27, 'p90', 1.1),
(28, 'sawedoff', 1.2),
(29, 'scar20', 0.8),
(30, 'sg556', 1),
(31, 'taser', 2),
(32, 'tec9', 1.2),
(33, 'ump45', 1.2),
(34, 'usp_silencer', 1.5),
(35, 'xm1014', 1.2),
(36, 'revolver', 1),
(37, 'hegrenade', 1),
(38, 'decoy', 1.5),
(39, 'inferno', 1.2),
(40, 'ssg08', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `basescores`
--
ALTER TABLE `basescores`
  ADD PRIMARY KEY (`BS_ID`);

--
-- Indexes for table `logdata`
--
ALTER TABLE `logdata`
  ADD UNIQUE KEY `CSID` (`CSID`);

--
-- Indexes for table `weaponweighting`
--
ALTER TABLE `weaponweighting`
  ADD PRIMARY KEY (`WW_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `basescores`
--
ALTER TABLE `basescores`
  MODIFY `BS_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `logdata`
--
ALTER TABLE `logdata`
  MODIFY `CSID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `weaponweighting`
--
ALTER TABLE `weaponweighting`
  MODIFY `WW_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
