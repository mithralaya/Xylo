-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.5.16-log


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema sellezee
--

CREATE DATABASE IF NOT EXISTS sellezee;
USE sellezee;

--
-- Definition of table `business`
--

DROP TABLE IF EXISTS `business`;
CREATE TABLE `business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `website` varchar(100) DEFAULT NULL,
  `firstName` varchar(80) DEFAULT NULL,
  `lastName` varchar(80) DEFAULT NULL,
  `jobTitle` varchar(45) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `clientId` int(11) NOT NULL,
  `sourceId` int(11) NOT NULL,
  `channelId` int(11) NOT NULL,
  `categoryId` int(11) DEFAULT NULL,
  `assignedTo` int(11) DEFAULT NULL,
  `potentialValue` decimal(8,2) DEFAULT NULL,
  `stageChangedOn` timestamp NULL DEFAULT NULL,
  `stageId` int(11) NOT NULL,
  `subStageId` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_Business_Clients1` (`clientId`),
  KEY `fk_Business_Source1` (`sourceId`),
  KEY `fk_Business_Channels1` (`channelId`),
  KEY `fk_Business_Categories1` (`categoryId`),
  KEY `fk_Business_Users1` (`assignedTo`),
  KEY `fk_Business_Stages1` (`stageId`),
  KEY `fk_Business_SubStages1` (`subStageId`),
  CONSTRAINT `fk_Business_Categories1` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Business_Channels1` FOREIGN KEY (`channelId`) REFERENCES `channels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Business_Clients1` FOREIGN KEY (`clientId`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Business_Source1` FOREIGN KEY (`sourceId`) REFERENCES `source` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Business_Stages1` FOREIGN KEY (`stageId`) REFERENCES `stages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Business_SubStages1` FOREIGN KEY (`subStageId`) REFERENCES `substages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Business_Users1` FOREIGN KEY (`assignedTo`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `business`
--

/*!40000 ALTER TABLE `business` DISABLE KEYS */;
/*!40000 ALTER TABLE `business` ENABLE KEYS */;


--
-- Definition of table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `clientId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Categories_Clients1` (`clientId`),
  CONSTRAINT `fk_Categories_Clients1` FOREIGN KEY (`clientId`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`,`name`,`clientId`) VALUES 
 (1,'Food & Drink',1),
 (2,'Entertainment',1),
 (3,'Shopping',1);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;


--
-- Definition of table `channels`
--

DROP TABLE IF EXISTS `channels`;
CREATE TABLE `channels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `clientId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Channels_Clients1` (`clientId`),
  CONSTRAINT `fk_Channels_Clients1` FOREIGN KEY (`clientId`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `channels`
--

/*!40000 ALTER TABLE `channels` DISABLE KEYS */;
INSERT INTO `channels` (`id`,`name`,`clientId`) VALUES 
 (1,'Online',1),
 (2,'Offline',1),
 (3,'Multichannel',1);
/*!40000 ALTER TABLE `channels` ENABLE KEYS */;


--
-- Definition of table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `createdBy` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Clients_Users1` (`createdBy`),
  CONSTRAINT `fk_Clients_Users1` FOREIGN KEY (`createdBy`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients`
--

/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` (`id`,`name`,`timestamp`,`phone`,`createdBy`) VALUES 
 (1,'Microsoft','2012-03-25 14:53:18','122334332',2);
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;


--
-- Definition of table `contacted`
--

DROP TABLE IF EXISTS `contacted`;
CREATE TABLE `contacted` (
  `businessId` int(11) NOT NULL,
  `salesPersonId` int(11) NOT NULL,
  `notes` text,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`businessId`,`salesPersonId`),
  KEY `fk_Business_has_Users_Users1` (`salesPersonId`),
  KEY `fk_Business_has_Users_Business1` (`businessId`),
  CONSTRAINT `fk_Business_has_Users_Business1` FOREIGN KEY (`businessId`) REFERENCES `business` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Business_has_Users_Users1` FOREIGN KEY (`salesPersonId`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contacted`
--

/*!40000 ALTER TABLE `contacted` DISABLE KEYS */;
/*!40000 ALTER TABLE `contacted` ENABLE KEYS */;


--
-- Definition of table `sales`
--

DROP TABLE IF EXISTS `sales`;
CREATE TABLE `sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` decimal(8,2) NOT NULL,
  `desc` text,
  `timestamp` timestamp NULL DEFAULT NULL,
  `businessId` int(11) NOT NULL,
  `closedBy` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Sales_Business1` (`businessId`),
  KEY `fk_Sales_Users1` (`closedBy`),
  CONSTRAINT `fk_Sales_Business1` FOREIGN KEY (`businessId`) REFERENCES `business` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Sales_Users1` FOREIGN KEY (`closedBy`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;


--
-- Definition of table `source`
--

DROP TABLE IF EXISTS `source`;
CREATE TABLE `source` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `clientId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Source_Clients1` (`clientId`),
  CONSTRAINT `fk_Source_Clients1` FOREIGN KEY (`clientId`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `source`
--

/*!40000 ALTER TABLE `source` DISABLE KEYS */;
INSERT INTO `source` (`id`,`name`,`clientId`) VALUES 
 (1,'Inbound Lead',1),
 (2,'Outbound Lead',1),
 (3,'Other',1);
/*!40000 ALTER TABLE `source` ENABLE KEYS */;


--
-- Definition of table `stages`
--

DROP TABLE IF EXISTS `stages`;
CREATE TABLE `stages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `clientId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Stages_Clients1` (`clientId`),
  CONSTRAINT `fk_Stages_Clients1` FOREIGN KEY (`clientId`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stages`
--

/*!40000 ALTER TABLE `stages` DISABLE KEYS */;
INSERT INTO `stages` (`id`,`name`,`clientId`) VALUES 
 (1,'Leads',1),
 (2,'Potentials',1),
 (3,'Accounts',1);
/*!40000 ALTER TABLE `stages` ENABLE KEYS */;


--
-- Definition of table `substages`
--

DROP TABLE IF EXISTS `substages`;
CREATE TABLE `substages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `stageId` int(11) NOT NULL,
  `clientId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_SubStages_Stages1` (`stageId`),
  KEY `fk_SubStages_Clients1` (`clientId`),
  CONSTRAINT `fk_SubStages_Clients1` FOREIGN KEY (`clientId`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_SubStages_Stages1` FOREIGN KEY (`stageId`) REFERENCES `stages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `substages`
--

/*!40000 ALTER TABLE `substages` DISABLE KEYS */;
INSERT INTO `substages` (`id`,`name`,`stageId`,`clientId`) VALUES 
 (1,'All',2,1),
 (2,'Contacted',2,1),
 (3,'Pitched',2,1),
 (4,'In person meeting',2,1),
 (5,'Negotiating',2,1);
/*!40000 ALTER TABLE `substages` ENABLE KEYS */;


--
-- Definition of table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(40) NOT NULL,
  `lastName` varchar(45) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(45) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `clientId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Users_Clients1` (`clientId`),
  CONSTRAINT `fk_Users_Clients1` FOREIGN KEY (`clientId`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`,`firstName`,`lastName`,`email`,`password`,`timestamp`,`clientId`) VALUES 
 (2,'Bill','Gates','bill.gates@microsoft.com','5f449d04949e0dea571398850a5c0c60','2012-03-24 20:44:15',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
