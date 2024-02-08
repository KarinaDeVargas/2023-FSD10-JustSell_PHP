-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Oct 25, 2023 at 07:32 PM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

USE fsd10_uniform;


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Database: `fsd10_uniform`

-- Table structure for table `admins`
DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `AdminID` int(11) NOT NULL,
  `LoginID` int(11) NOT NULL,
  `FirstName` varchar(30) NOT NULL,
  `LastName` varchar(30) NOT NULL,
  `Email` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Table structure for table `agents`
DROP TABLE IF EXISTS `agents`;
CREATE TABLE IF NOT EXISTS `agents` (
  `AgentID` int(11) NOT NULL,
  `LoginID` int(11) NOT NULL,
  `FirstName` varchar(30) NOT NULL,
  `LastName` varchar(30) NOT NULL,
  `Phone` varchar(15) NOT NULL,
  `Email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Table structure for table `image`
DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `ImageID` int(11) NOT NULL,
  `PropertyID` int(11) NOT NULL,
  `ImagePath` varchar(255) NOT NULL,
  `ImageFileName` varchar(255) NOT NULL,
  `Description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Table structure for table `logins`
DROP TABLE IF EXISTS `logins`;
CREATE TABLE IF NOT EXISTS `logins` (
  `LoginID` int(11) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Permission` tinyint(4) NOT NULL DEFAULT '1' -- 1 for users, 2 for agents and 3 for ADM ??
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Table structure for table `properties`
DROP TABLE IF EXISTS `properties]`;
CREATE TABLE IF NOT EXISTS `properties` (
  `PropertyID` int(11) NOT NULL,
  `AgentID` int(11) NOT NULL,
  `StreetNum` mediumint(8) UNSIGNED NOT NULL,
  `StreetName` varchar(60) NOT NULL,
  `City` varchar(30) NOT NULL,
  `Province` varchar(30) NOT NULL,
  `Postal` varchar(10) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Price` float NOT NULL,
  `Bathrooms` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `Bedrooms` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `Floors` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `size` float DEFAULT NULL,
  `furnished` tinyint(1) NOT NULL DEFAULT '0',
  `PropertyType` varchar(30) NOT NULL DEFAULT 'House',
  `YearOfBuilt` smallint(5) UNSIGNED NOT NULL,
  `Amenities` varchar(100) NOT NULL,
  `sellOption` varchar(30) NOT NULL,
  `ConstructionStatus` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Table structure for table `propertyoffers`
DROP TABLE IF EXISTS `propertyoffers`;
CREATE TABLE IF NOT EXISTS `propertyoffers` (
  `OfferID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `PropertyID` int(11) NOT NULL,
  `OfferAmount` float UNSIGNED NOT NULL,
  `OfferStatus` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- Table structure for table `users`
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `UserID` int(11) NOT NULL,
  `LoginID` int(11) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `FirstName` varchar(30) NOT NULL,
  `LastName` varchar(30) NOT NULL,
  `Phone` varchar(15) DEFAULT NULL,
  `StreetNum` mediumint(9) DEFAULT NULL,
  `StreetName` varchar(30) DEFAULT NULL,
  `City` varchar(30) DEFAULT NULL,
  `Province` varchar(30) DEFAULT NULL,
  `Postal` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`AdminID`),
  ADD KEY `FK_AD_LG` (`LoginID`);

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`AgentID`),
  ADD KEY `FK_AG_LG` (`LoginID`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`ImageID`),
  ADD KEY `FK_IM_PR` (`PropertyID`);

--
-- Indexes for table `logins`
--
ALTER TABLE `logins`
  ADD PRIMARY KEY (`LoginID`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`PropertyID`),
  ADD KEY `FK_PRTY_AG` (`AgentID`);

--
-- Indexes for table `propertyoffers`
--
ALTER TABLE `propertyoffers`
  ADD PRIMARY KEY (`OfferID`),
  ADD KEY `FK_PO_USER` (`UserID`),
  ADD KEY `FK_PO_PRTY` (`PropertyID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD KEY `FK_USER_LG` (`LoginID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `AgentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `ImageID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logins`
--
ALTER TABLE `logins`
  MODIFY `LoginID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `PropertyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `propertyoffers`
--
ALTER TABLE `propertyoffers`
  MODIFY `OfferID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `FK_AD_LG` FOREIGN KEY (`LoginID`) REFERENCES `logins` (`LoginID`);

--
-- Constraints for table `agents`
--
ALTER TABLE `agents`
  ADD CONSTRAINT `FK_AG_LG` FOREIGN KEY (`LoginID`) REFERENCES `logins` (`LoginID`);

--
-- Constraints for table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `FK_IM_PR` FOREIGN KEY (`PropertyID`) REFERENCES `properties` (`PropertyID`);

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `FK_PRTY_AG` FOREIGN KEY (`AgentID`) REFERENCES `agents` (`AgentID`);

--
-- Constraints for table `propertyoffers`
--
ALTER TABLE `propertyoffers`
  ADD CONSTRAINT `FK_PO_PRTY` FOREIGN KEY (`PropertyID`) REFERENCES `properties` (`PropertyID`),
  ADD CONSTRAINT `FK_PO_USER` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_USER_LG` FOREIGN KEY (`LoginID`) REFERENCES `logins` (`LoginID`);
COMMIT;

-- Dumping data for table `logins`
INSERT IGNORE INTO `logins` (`LoginID`, `Username`, `Password`, `Permission`) VALUES
(1, 'SuperAdmin', '$2y$10$p24agRR3OK355PsQBA2nle8wRIAiVQ.Z03BFT3a2mb/QyoJglk4h6', 3),
(2, 'AgentJohn', '$2y$10$jWqfgHkaQ7s4lNqou2bEbeEkg2ky6yNdrKup1LeFI8BzLeFxPicWm', 2),
(3, 'BobbyBob', '$2y$10$wUaeaX7Gt8WN13L/Om6wZOBCjZWkk9z3wI7t3GU.aeu5a7If8ivDO', 1),
(4, 'JimJoe', '$2y$10$oxr5NosTsSEGbkSBLXeASudOssW5cjsfGy2XcAd5itHfjyPR7TM5a', 1),
(5, 'AgentJane', '$2y$10$jWqfgHkaQ7s4lNqou2bEbeEkg2ky6yNdrKup1LeFI8BzLeFxPicWm', 2),
(6, 'AbelAlbert', '$2y$10$wUaeaX7Gt8WN13L/Om6wZOBCjZWkk9z3wI7t3GU.aeu5a7If8ivDO', 1),
(7, 'ChrissyCrass', '$2y$10$wUaeaX7Gt8WN13L/Om6wZOBCjZWkk9z3wI7t3GU.aeu5a7If8ivDO', 1);

-- Dumping data for table `admins`
INSERT IGNORE INTO `admins` (`AdminID`, `LoginID`, `FirstName`, `LastName`, `Email`) VALUES
(1, 1, 'Super', 'Admin', 'teamuniformFSD10@GMAIL.COM');


-- Dumping data for table `agents`

INSERT IGNORE INTO `agents` (`AgentID`, `LoginID`, `FirstName`, `LastName`, `Phone`, `Email`) VALUES
(1, 2, 'John', 'Doe', '514 909 0909', 'AgentJohnDoe@agentjustsell.ca'),
(2, 5, 'Jane', 'Doe', '514 090 9090', 'JaneDoe@agentjustsell.ca');

-- Insert 6 records into the properties table
INSERT IGNORE INTO `properties` 
(`PropertyID`, `AgentID`, `StreetNum`, `StreetName`, `City`, `Province`, `Postal`, `Description`, `Price`, `Bathrooms`, `Bedrooms`, `Floors`, `size`, `furnished`, `PropertyType`, `YearOfBuilt`, `Amenities`, `sellOption`, `ConstructionStatus`) VALUES
(1, 1, '11', 'Broadway', 'New York', 'NY', 'NY10101', 'Historic apartment in the theater district. A piece of New York history.', 1200000.00, 2, 2, 1, '1234567', 'furnished', 'House', 2020, 'Pool, Sauna, Deck', 'Sale', 'Ready to Move'),
(2, 1, '9401', 'Union St', 'San Francisco', 'CA', 'CA10101', 'Contemporary penthouse with stunning city views. Ideal for urban living.', 1800000.00, 3, 2, 2, '1234567', 'furnished', 'Apartment', 2021, 'Pool, Sauna', 'Resale', 'Ready to Move'),
(3, 1, '604601', 'River Rd', 'Chicago', 'IL', 'IL10101', 'Cozy townhouse near the Chicago River. Perfect for a small family.', 500000.00, 1, 2, 2, '1234567', 'furnished', 'House', 2019, 'Sauna, Deck', 'Leasing', 'Ready to Move'),
(4, 2, 'A0602', 'Garden Ave', 'Chicago', 'IL', 'IL10101', 'Charming bungalow with a spacious garden. A great starter home.', 350000.00, 2, 2, 1, '1234567', 'furnished', 'Apartment', 2000, 'Please contact us', 'Sale', 'Under Construction'),
(5, 2, '11603', 'Lake St', 'Chicago', 'IL', 'IL10101', 'Lakefront condominium with panoramic lake views. Enjoy the city and the water.', 900000.00, 2, 3, 3, '1234567', 'furnished', 'Comercial Building', 2017, 'Pool', 'Resale', 'Under Construction'),
(6, 2, '331', 'Beach Blvd', 'Miami', 'FL', 'FL10101', 'Tropical paradise with a private beach. Escape to your own slice of heaven.', 3500000.00, 4, 5, 2, '1234567', 'furnished', 'Apartment', 2005, 'No Amenities Included', 'Sale', 'Ready to Move');

-- Insert records into the image table
INSERT IGNORE INTO `image` (`ImageID`, `PropertyID`, `ImagePath`, `ImageFileName`, `Description`) VALUES
(0101, 01, 'images/PropertiesImages', 'House_01(1).jpg', 'Front'),
(0102, 01, 'images/PropertiesImages', 'House_01(2).jpg','Back'),
(0103, 01, 'images/PropertiesImages', 'House_01(3).jpg','Location'),
(0104, 01, 'images/PropertiesImages', 'House_01(4).jpg','Location'),
(0105, 01, 'images/PropertiesImages', 'House_01(5).jpg','Location'),
(0201, 02, 'images/PropertiesImages', 'Ap_02(1).jpg', 'Front'),
(0202, 02, 'images/PropertiesImages', 'Ap_02(2).jpg','Back'),
(0203, 02, 'images/PropertiesImages', 'Ap_02(3).jpg','Location'),
(0204, 02, 'images/PropertiesImages', 'Ap_02(4).jpg','Location'),
(0205, 02, 'images/PropertiesImages', 'Ap_02(5).jpg','Location'),
(0301, 03, 'images/PropertiesImages', 'House_03(1).jpg', 'Front'),
(0302, 03, 'images/PropertiesImages', 'House_03(2).jpg','Back'),
(0303, 03, 'images/PropertiesImages', 'House_03(3).jpg','Location'),
(0304, 03, 'images/PropertiesImages', 'House_03(4).jpg','Location'),
(0305, 03, 'images/PropertiesImages', 'House_03(5).jpg','Location'),
(0401, 04, 'images/PropertiesImages', 'Ap_04(1).jpg', 'Front'),
(0402, 04, 'images/PropertiesImages', 'Ap_04(2).jpg','Back'),
(0403, 04, 'images/PropertiesImages', 'Ap_04(3).jpg','Location'),
(0404, 04, 'images/PropertiesImages', 'Ap_04(4).jpg','Location'),
(0405, 04, 'images/PropertiesImages', 'Ap_04(5).jpg','Location'),
(0501, 05, 'images/PropertiesImages', 'ComercialBuilding_01(1).jpg', 'Front'),
(0502, 05, 'images/PropertiesImages', 'ComercialBuilding_01(2).jpg','Back'),
(0503, 05, 'images/PropertiesImages', 'ComercialBuilding_01(3).jpg','Location'),
(0504, 05, 'images/PropertiesImages', 'ComercialBuilding_01(4).jpg','Location'),
(0505, 05, 'images/PropertiesImages', 'ComercialBuilding_01(5).jpg','Location'),
(0601, 06, 'images/PropertiesImages', 'Ap_06(1).jpg', 'Front'),
(0602, 06, 'images/PropertiesImages', 'Ap_06(2).jpg','Back'),
(0603, 06, 'images/PropertiesImages', 'Ap_06(3).jpg','Location'),
(0604, 06, 'images/PropertiesImages', 'Ap_06(4).jpg','Location'),
(0605, 06, 'images/PropertiesImages', 'Ap_06(5).jpg','Location'),
(0606, 06, 'images/PropertiesImages', 'Ap_06(6).jpg','Location');

-- Insert records into the users table
INSERT IGNORE INTO `users` (`UserID`,`LoginID`, `Email`, `FirstName`, `LastName`, `Phone`, `StreetNum`, `StreetName`, `City`, `Province`, `Postal`) VALUES
(1, 3, 'Bob@email.com', 'Bobby', 'Bob', '123-456-7890', 123, 'Main St', 'New York', 'NY', '10001'),
(2, 4, 'Jim@Joemail.com', 'Jimmy', 'Jones', '987-654-3210', 456, 'Elm St', 'Los Angeles', 'CA', '90001'),
(3, 6, 'AAlbert@gmail.com', 'Abel', 'Albert', '432-234-4321', 123, 'That St', 'Toronto', 'ON' 'O1N 1N2')
(4, 7, 'Crissy@hotmail.com', 'Chirstina', 'Crass', '555-123-4567', 789, 'Oak St', 'Chicago', 'IL', '60601');


-- Insert records into the propertyoffers table
INSERT IGNORE INTO `propertyoffers` (`OfferID`, `UserID`, `PropertyID`, `OfferAmount`, `OfferStatus`) VALUES
(1, 7, 1, 125000.00, 'Pending'),
(2, 8, 2, 195000.00, 'Pending'),
(3, 9, 3, 522000.00, 'Pending'),
(4, 10, 1, 320000.00, 'Pending'),
(5, 11, 2, 900000.00, 'Pending'),
(6, 12, 2, 2750000.00, 'Rejected'),
(7, 13, 1, 1190000.00, 'Pending'),
(8, 14, 2, 200000.00, 'Accepted'),
(9, 7, 3, 450000.00, 'Pending'),
(10, 8, 3, 350000.00, 'Pending'),
(11, 9, 3, 750000.00, 'Rejected'),
(12, 10, 1, 3000000.00, 'Pending'),
(13, 11, 1, 11000.00, 'Rejected'),
(14, 12, 2, 110000.00, 'Rejected'),
(15, 13, 3, 600000.00, 'Pending');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

