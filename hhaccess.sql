# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: hhaccess.com (MySQL 5.1.73)
# Database: demo
# Generation Time: 2015-01-23 12:14:46 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table assignments
# ------------------------------------------------------------

CREATE TABLE `assignments` (
  `assignmentClient` int(11) DEFAULT NULL,
  `assignmentAttendant` int(11) DEFAULT NULL,
  `assignmentUser` int(11) DEFAULT NULL,
  `assignmentActive` tinyint(1) DEFAULT '1',
  `assignmentRemovalDate` timestamp NULL DEFAULT NULL,
  `assignmentRemovalUser` int(11) DEFAULT NULL,
  `assignmentStatus` enum('IN','OUT') DEFAULT 'OUT',
  `assignmentDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `assignmentID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`assignmentID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table attendants
# ------------------------------------------------------------

CREATE TABLE `attendants` (
  `attendantName` varchar(100) DEFAULT NULL,
  `attendantPhone` varchar(20) DEFAULT NULL,
  `attendantAddress` varchar(100) DEFAULT NULL,
  `attendantCity` varchar(50) DEFAULT NULL,
  `attendantState` varchar(50) DEFAULT NULL,
  `attendantZip` varchar(10) DEFAULT NULL,
  `attendantNotes` text,
  `attendantSecret` smallint(5) DEFAULT NULL,
  `attendantActive` tinyint(1) DEFAULT '1',
  `attendantID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`attendantID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `attendants` WRITE;
/*!40000 ALTER TABLE `attendants` DISABLE KEYS */;

INSERT INTO `attendants` (`attendantName`, `attendantPhone`, `attendantAddress`, `attendantCity`, `attendantState`, `attendantZip`, `attendantNotes`, `attendantSecret`, `attendantActive`, `attendantID`)
VALUES
	('Annie Attendant','2122039069','123 Caregiver Lane','New York','NY','10001','A great caregiver',12345,1,54321);

/*!40000 ALTER TABLE `attendants` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table calls
# ------------------------------------------------------------

CREATE TABLE `calls` (
  `callCid` varchar(10) DEFAULT NULL,
  `callStatus` enum('IN','OUT') DEFAULT 'OUT',
  `callClient` int(11) DEFAULT NULL,
  `callAttendant` int(11) DEFAULT NULL,
  `callDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `callApproved` tinyint(1) DEFAULT '0',
  `callCounted` tinyint(1) DEFAULT '0',
  `callJson` text,
  `callLang` char(2) DEFAULT NULL,
  `callActive` tinyint(1) DEFAULT '1',
  `callID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`callID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table clients
# ------------------------------------------------------------

CREATE TABLE `clients` (
  `clientName` varchar(100) DEFAULT NULL,
  `clientPhone` varchar(20) DEFAULT NULL,
  `clientAddress` varchar(100) DEFAULT NULL,
  `clientCity` varchar(50) DEFAULT NULL,
  `clientState` varchar(50) DEFAULT NULL,
  `clientZip` varchar(10) DEFAULT NULL,
  `clientNotes` text,
  `clientActive` tinyint(1) DEFAULT '1',
  `clientID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`clientID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;

INSERT INTO `clients` (`clientName`, `clientPhone`, `clientAddress`, `clientCity`, `clientState`, `clientZip`, `clientNotes`, `clientActive`, `clientID`)
VALUES
	('Grateful Client','2123752553','456 There Court','New York','NY','10024','A nice person',1,1);

/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table forms
# ------------------------------------------------------------

CREATE TABLE `forms` (
  `formID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `formActive` tinyint(1) DEFAULT '1',
  `formName` varchar(100) DEFAULT NULL,
  `formFile` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`formID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `forms` WRITE;
/*!40000 ALTER TABLE `forms` DISABLE KEYS */;

INSERT INTO `forms` (`formID`, `formActive`, `formName`, `formFile`)
VALUES
	(1,1,'cms1500','cms1500.pdf');

/*!40000 ALTER TABLE `forms` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table sessions
# ------------------------------------------------------------

CREATE TABLE `sessions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sessionUser` int(11) DEFAULT NULL,
  `sessionAddress` varchar(40) DEFAULT NULL,
  `sessionValue` varchar(40) DEFAULT NULL,
  `sessionDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table users
# ------------------------------------------------------------

CREATE TABLE `users` (
  `userName` varchar(50) DEFAULT NULL,
  `userEmail` varchar(100) DEFAULT NULL,
  `userLogin` varchar(30) DEFAULT NULL,
  `userPass` varchar(30) DEFAULT NULL,
  `userPhone` varchar(10) DEFAULT NULL,
  `userAddress` varchar(100) DEFAULT NULL,
  `userCity` varchar(100) DEFAULT NULL,
  `userState` varchar(30) DEFAULT NULL,
  `userZip` varchar(10) DEFAULT NULL,
  `userNotes` text,
  `userActive` tinyint(1) DEFAULT '1',
  `userID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`userID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`userName`, `userEmail`, `userLogin`, `userPass`, `userPhone`, `userAddress`, `userCity`, `userState`, `userZip`, `userNotes`, `userActive`, `userID`)
VALUES
	('Loyal User','user@example.com','luser','password','2122039012','153 W 78th St 1A','New York','NY','10002','Full Time dispatcher / Employee',1,1);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

