-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for eindopdrachtraket
DROP DATABASE IF EXISTS `eindopdrachtraket`;
CREATE DATABASE IF NOT EXISTS `eindopdrachtraket` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `eindopdrachtraket`;

-- Dumping structure for table eindopdrachtraket.contact
DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `contactID` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`contactID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table eindopdrachtraket.contact: ~7 rows (approximately)
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
INSERT INTO `contact` (`contactID`, `name`, `email`, `message`) VALUES
	(1, 'Minas ', 'minasabeer@hotmail.com', 'werfghj'),
	(2, 'Minas ', 'minasabeer@hotmail.com', 'asdfghjkl;'),
	(3, 'asdfghj', 'minasabeer@hotmail.com', 'ertyuiop[]'),
	(4, 'Minas ', 'minasabeer@hotmail.com', '1234567890-098765432'),
	(5, 'werfghj', 'minasabeer@hotmail.com', 'sxcvbhjiuytrdfcvbnjuytrdf '),
	(6, 'Minas ', 'minasabeer@hotmail.com', 'asdfghjklkjhgfd'),
	(7, '', '', ''),
	(8, 'Minas Abeer', 'ms.abeer@student.alfa-college.nl', 'JO ik ben Minas');
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;

-- Dumping structure for table eindopdrachtraket.content
DROP TABLE IF EXISTS `content`;
CREATE TABLE IF NOT EXISTS `content` (
  `contentId` int(10) NOT NULL AUTO_INCREMENT,
  `moduleID` int(10) NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL DEFAULT '0',
  `page_content` longtext,
  `img` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`contentId`),
  UNIQUE KEY `contentId` (`contentId`),
  KEY `moduleID` (`moduleID`),
  CONSTRAINT `moduleID` FOREIGN KEY (`moduleID`) REFERENCES `module` (`moduleID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table eindopdrachtraket.content: ~3 rows (approximately)
/*!40000 ALTER TABLE `content` DISABLE KEYS */;
INSERT INTO `content` (`contentId`, `moduleID`, `title`, `page_content`, `img`) VALUES
	(1, 1, 'Home', 'sdfhnm', './module/Minas/logo.png'),
	(2, 3, 'Contact', 'Minas is echt de beste!', './module/Minas/logo.png');
/*!40000 ALTER TABLE `content` ENABLE KEYS */;

-- Dumping structure for table eindopdrachtraket.logo
DROP TABLE IF EXISTS `logo`;
CREATE TABLE IF NOT EXISTS `logo` (
  `logoID` int(11) NOT NULL DEFAULT '0',
  `logoPath` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table eindopdrachtraket.logo: ~0 rows (approximately)
/*!40000 ALTER TABLE `logo` DISABLE KEYS */;
INSERT INTO `logo` (`logoID`, `logoPath`) VALUES
	(1, './img/logo.webp');
/*!40000 ALTER TABLE `logo` ENABLE KEYS */;

-- Dumping structure for table eindopdrachtraket.module
DROP TABLE IF EXISTS `module`;
CREATE TABLE IF NOT EXISTS `module` (
  `moduleID` int(10) NOT NULL AUTO_INCREMENT,
  `pagina` varchar(150) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`moduleID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table eindopdrachtraket.module: ~3 rows (approximately)
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT INTO `module` (`moduleID`, `pagina`) VALUES
	(1, 'Home'),
	(2, 'Teams'),
	(3, 'Contact');
/*!40000 ALTER TABLE `module` ENABLE KEYS */;

-- Dumping structure for table eindopdrachtraket.teams
DROP TABLE IF EXISTS `teams`;
CREATE TABLE IF NOT EXISTS `teams` (
  `teamID` int(2) NOT NULL AUTO_INCREMENT,
  `teamName` varchar(3) NOT NULL,
  `captain` varchar(50) DEFAULT NULL,
  `teamData` text NOT NULL,
  `img` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`teamID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table eindopdrachtraket.teams: ~5 rows (approximately)
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` (`teamID`, `teamName`, `captain`, `teamData`, `img`) VALUES
	(1, 'A1', 'Minas Abeer', 'sdfgbh', './module/teams/team_img/A1rode-raket.webp'),
	(2, 'A2', 'Minas', 'lkjh', ''),
	(3, 'A3', 'Minas Abeer', 'Dit is team A3', NULL),
	(4, 'B1', 'Minas Abeer', 'Dit is team B1', NULL),
	(5, 'B2', 'Minas Abeer', 'Dit is Team B2 ', NULL);
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;

-- Dumping structure for table eindopdrachtraket.userdata
DROP TABLE IF EXISTS `userdata`;
CREATE TABLE IF NOT EXISTS `userdata` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `birthday` date NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- Dumping data for table eindopdrachtraket.userdata: ~0 rows (approximately)
/*!40000 ALTER TABLE `userdata` DISABLE KEYS */;
INSERT INTO `userdata` (`id`, `firstname`, `lastname`, `birthday`, `username`, `password`) VALUES
	(21, 'Minas', 'Abeer', '2003-11-24', 'Minas', '$2y$10$CcFt7llAuWcPKeavwNcxzupJqC8NTx3mIW0Za6cp02tKDPAdvkw3G');
/*!40000 ALTER TABLE `userdata` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
