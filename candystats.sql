-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 24, 2019 at 08:29 AM
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
(1, 'Rescued_A_Hostage', 500),
(2, 'Hostage_Damage', -50),
(3, 'Planted_The_Bomb', 100),
(4, 'Bomb_Successful', 400),
(5, 'Bomb_Defusal', 500),
(6, 'Team_Kill', -200),
(7, 'Suicide', -200),
(8, 'Kill_Assist', 50),
(9, 'Headshot', 125),
(10, 'Penetrated', 110),
(11, 'Headshot Penetrated', 135),
(12, 'Kill_Base', 100),
(13, 'Begin_Bomb_Defuse_Without_Kit', 0);

-- --------------------------------------------------------

--
-- Table structure for table `itemdetails`
--

CREATE TABLE `itemdetails` (
  `WW_ID` int(11) NOT NULL,
  `Weapon` text NOT NULL,
  `Weighting` float NOT NULL,
  `Price` float NOT NULL,
  `FriendlyName` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `itemdetails`
--

INSERT INTO `itemdetails` (`WW_ID`, `Weapon`, `Weighting`, `Price`, `FriendlyName`) VALUES
(1, 'ak47', 1.1, 2700, 'AK-47'),
(2, 'aug', 1.1, 3150, 'AUG'),
(3, 'awp', 0.7, 4750, 'AWP'),
(4, 'bizon', 1.3, 1400, 'PP-Bizon'),
(5, 'cz75a', 1.6, 500, 'CZ75-Auto'),
(6, 'deagle', 0.9, 700, 'Desert Eagle'),
(7, 'elite', 1.3, 400, 'Dual Berettas'),
(8, 'famas', 1.2, 2250, 'FAMAS'),
(9, 'fiveseven', 1.5, 500, 'Five-Seven'),
(10, 'g3sg1', 1.6, 5000, 'G3SG1'),
(11, 'galilar', 1.2, 2000, 'Galil AR'),
(12, 'glock', 1.6, 200, 'Glock-18'),
(13, 'hkp2000', 1.6, 200, 'P2000'),
(14, 'knife', 1.9, 0, 'Knife'),
(15, 'knifegg', 1.9, 0, 'Golden Knife'),
(16, 'm249', 0.9, 5200, 'M249'),
(17, 'm4a1', 1.1, 3100, 'M4A1'),
(18, 'm4a1_silencer', 1.1, 3100, 'M4A1 (silenced)'),
(19, 'mac10', 1.3, 1050, 'MAC-10'),
(20, 'mag7', 1.3, 1800, 'MAG-7'),
(21, 'mp5sd', 1.3, 1500, 'MP5SD'),
(22, 'mp7', 1.3, 1500, 'MP7'),
(23, 'mp9', 1.3, 1250, 'MP9'),
(24, 'negev', 0.9, 1700, 'Negev'),
(25, 'nova', 1.3, 1200, 'Nova'),
(26, 'p250', 1.6, 300, 'P250'),
(27, 'p90', 1.2, 2350, 'P90'),
(28, 'sawedoff', 1.3, 1200, 'Sawed-Off'),
(29, 'scar20', 0.9, 5000, 'Scar-20'),
(30, 'sg556', 1.1, 2750, 'SG 553'),
(31, 'taser', 1.9, 200, 'Zeus x27'),
(32, 'tec9', 1.3, 500, 'Tec-9'),
(33, 'ump45', 1.3, 1200, 'UMP-45'),
(34, 'usp_silencer', 1.6, 200, 'USP-S'),
(35, 'xm1014', 1.3, 2000, 'XM1014'),
(36, 'revolver', 1.1, 600, 'R8 Revolver'),
(37, 'hegrenade', 1.1, 300, 'High Explosive Grenade'),
(38, 'decoy', 1.6, 50, 'Decoy Grenade'),
(39, 'inferno', 1.3, 600, 'Fire'),
(40, 'ssg08', 1.1, 1700, 'SSG 08'),
(41, 'item_assaultsuit', 1, 1000, 'Kevlar and Helmet'),
(42, 'item_kevlar', 1, 650, 'Kevlar'),
(43, 'item_defuser', 1, 400, 'Defuse Kit'),
(47, 'incgrenade', 1.3, 600, 'Incendiary Grenade'),
(48, 'c4', 0, 0, 'C4'),
(49, 'flashbang', 2, 200, 'Flashbang'),
(50, 'molotov', 1.3, 400, 'Molotov'),
(51, 'smokegrenade', 2, 300, 'Smoke Grenade');

-- --------------------------------------------------------

--
-- Table structure for table `itempricing`
--

CREATE TABLE `itempricing` (
  `PRICE_ID` int(11) NOT NULL,
  `Item` text NOT NULL,
  `Price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `itempricing`
--

INSERT INTO `itempricing` (`PRICE_ID`, `Item`, `Price`) VALUES
(1, 'ak47', 2700),
(2, 'aug', 3150),
(3, 'awp', 4750),
(4, 'bizon', 1400),
(5, 'cz75a', 500),
(6, 'deagle', 700),
(7, 'elite', 400),
(8, 'famas', 2250),
(9, 'fiveseven', 500),
(10, 'g3sg1', 5000),
(11, 'galilar', 2000),
(12, 'glock', 200),
(13, 'hkp2000', 200),
(14, 'knife', 0),
(15, 'knifegg', 0),
(16, 'm249', 5200),
(17, 'm4a1', 3100),
(18, 'm4a1_silencer', 3100),
(19, 'mac10', 1050),
(20, 'mag7', 1800),
(21, 'mp5sd', 1500),
(22, 'mp7', 1500),
(23, 'mp9', 1250),
(24, 'negev', 1700),
(25, 'nova', 1200),
(26, 'p250', 300),
(27, 'p90', 2350),
(28, 'sawedoff', 1200),
(29, 'scar20', 5000),
(30, 'sg556', 2750),
(31, 'taser', 200),
(32, 'tec9', 500),
(33, 'ump45', 1200),
(34, 'usp_silencer', 200),
(35, 'xm1014', 2000),
(36, 'revolver', 600),
(37, 'hegrenade', 300),
(38, 'decoy', 50),
(39, 'inferno', 600),
(40, 'ssg08', 1700),
(41, 'item_assaultsuit', 1000),
(42, 'item_kevlar', 650),
(43, 'item_defuser', 400);

-- --------------------------------------------------------

--
-- Table structure for table `logdata`
--

CREATE TABLE `logdata` (
  `CSID` int(11) NOT NULL,
  `SessionID` text NOT NULL COMMENT 'Effectively the Log Name',
  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Time and date of the event',
  `TAGS` text NOT NULL COMMENT 'User defined tags',
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
  `score` int(11) DEFAULT NULL,
  `MapInfo` text,
  `RoundInfo` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sessiontags`
--

CREATE TABLE `sessiontags` (
  `TagID` int(11) NOT NULL,
  `Tag` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sessiontags`
--

INSERT INTO `sessiontags` (`TagID`, `Tag`) VALUES
(1, 'ISLELAN'),
(2, 'SOMETHING ELSE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `basescores`
--
ALTER TABLE `basescores`
  ADD PRIMARY KEY (`BS_ID`);

--
-- Indexes for table `itemdetails`
--
ALTER TABLE `itemdetails`
  ADD PRIMARY KEY (`WW_ID`);

--
-- Indexes for table `itempricing`
--
ALTER TABLE `itempricing`
  ADD PRIMARY KEY (`PRICE_ID`);

--
-- Indexes for table `logdata`
--
ALTER TABLE `logdata`
  ADD UNIQUE KEY `CSID` (`CSID`);

--
-- Indexes for table `sessiontags`
--
ALTER TABLE `sessiontags`
  ADD UNIQUE KEY `UNIQUE` (`TagID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `basescores`
--
ALTER TABLE `basescores`
  MODIFY `BS_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `itemdetails`
--
ALTER TABLE `itemdetails`
  MODIFY `WW_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `itempricing`
--
ALTER TABLE `itempricing`
  MODIFY `PRICE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `logdata`
--
ALTER TABLE `logdata`
  MODIFY `CSID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sessiontags`
--
ALTER TABLE `sessiontags`
  MODIFY `TagID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
