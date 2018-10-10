-- MySQL dump 10.13  Distrib 5.1.62, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: imp_desc
-- ------------------------------------------------------
-- Server version	5.1.62-0ubuntu0.10.04.1-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `imp_desc`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `imp_desc` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `imp_desc`;

--
-- Table structure for table `ceilings`
--

DROP TABLE IF EXISTS `ceilings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ceilings` (
  `ceiling` varchar(30) DEFAULT NULL,
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `parent` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ceiling` (`ceiling`),
  KEY `parent` (`parent`),
  CONSTRAINT `ceilings_ibfk_1` FOREIGN KEY (`ceiling`) REFERENCES `posvals` (`ceiling`),
  CONSTRAINT `ceilings_ibfk_2` FOREIGN KEY (`parent`) REFERENCES `parentage` (`area_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ceilings`
--

LOCK TABLES `ceilings` WRITE;
/*!40000 ALTER TABLE `ceilings` DISABLE KEYS */;
INSERT INTO `ceilings` VALUES ('on',1,8),('fire',2,10),('fire',3,9),('fire',4,6),('fire',5,4),('on',7,9);
/*!40000 ALTER TABLE `ceilings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dimensions`
--

DROP TABLE IF EXISTS `dimensions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dimensions` (
  `height` decimal(10,3) DEFAULT NULL,
  `width` decimal(10,3) DEFAULT NULL,
  `length` decimal(10,3) DEFAULT NULL,
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `parent` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  CONSTRAINT `dimensions_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `parentage` (`area_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dimensions`
--

LOCK TABLES `dimensions` WRITE;
/*!40000 ALTER TABLE `dimensions` DISABLE KEYS */;
INSERT INTO `dimensions` VALUES ('9.350','100.000','99.900',1,7),('1000.000','1000.000','1000.000',2,3),('0.110','0.110','0.200',3,9);
/*!40000 ALTER TABLE `dimensions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doors`
--

DROP TABLE IF EXISTS `doors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doors` (
  `door_frame` varchar(30) DEFAULT NULL,
  `door_style` varchar(30) DEFAULT NULL,
  `door_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `door_position` varchar(30) DEFAULT NULL,
  `door_insets` varchar(30) DEFAULT NULL,
  `parent` mediumint(9) NOT NULL,
  PRIMARY KEY (`door_id`),
  KEY `door_frame` (`door_frame`),
  KEY `door_style` (`door_style`),
  KEY `door_position` (`door_position`),
  KEY `door_insets` (`door_insets`),
  KEY `parent` (`parent`),
  CONSTRAINT `doors_ibfk_1` FOREIGN KEY (`door_frame`) REFERENCES `posvals` (`frame`),
  CONSTRAINT `doors_ibfk_2` FOREIGN KEY (`door_style`) REFERENCES `posvals` (`style`),
  CONSTRAINT `doors_ibfk_3` FOREIGN KEY (`door_position`) REFERENCES `posvals` (`position`),
  CONSTRAINT `doors_ibfk_4` FOREIGN KEY (`door_insets`) REFERENCES `posvals` (`insets`),
  CONSTRAINT `doors_ibfk_5` FOREIGN KEY (`parent`) REFERENCES `parentage` (`area_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doors`
--

LOCK TABLES `doors` WRITE;
/*!40000 ALTER TABLE `doors` DISABLE KEYS */;
INSERT INTO `doors` VALUES ('circle','ye olde',1,'exterior','acht',3),('square','ye olde',2,'exterior','acht',3),('square','swedes',3,'interior','acht',7),('triangle','swedes',4,'interior','neun',6);
/*!40000 ALTER TABLE `doors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fixtures`
--

DROP TABLE IF EXISTS `fixtures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fixtures` (
  `fixture_type` varchar(30) DEFAULT NULL,
  `fixture_finish` varchar(30) DEFAULT NULL,
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `parent` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fixture_type` (`fixture_type`),
  KEY `fixture_finish` (`fixture_finish`),
  KEY `parent` (`parent`),
  CONSTRAINT `fixtures_ibfk_1` FOREIGN KEY (`fixture_type`) REFERENCES `posvals` (`fixture`),
  CONSTRAINT `fixtures_ibfk_2` FOREIGN KEY (`fixture_finish`) REFERENCES `posvals` (`finish`),
  CONSTRAINT `fixtures_ibfk_3` FOREIGN KEY (`parent`) REFERENCES `parentage` (`area_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fixtures`
--

LOCK TABLES `fixtures` WRITE;
/*!40000 ALTER TABLE `fixtures` DISABLE KEYS */;
INSERT INTO `fixtures` VALUES ('shower','papier mache',1,6),('sink','papier mache',2,6),('sink','papier mache',3,10),('sink','papier mache',4,12);
/*!40000 ALTER TABLE `fixtures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `floors`
--

DROP TABLE IF EXISTS `floors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `floors` (
  `floor` varchar(30) DEFAULT NULL,
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `parent` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `floor` (`floor`),
  KEY `parent` (`parent`),
  CONSTRAINT `floors_ibfk_1` FOREIGN KEY (`floor`) REFERENCES `posvals` (`floor`),
  CONSTRAINT `floors_ibfk_2` FOREIGN KEY (`parent`) REFERENCES `parentage` (`area_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `floors`
--

LOCK TABLES `floors` WRITE;
/*!40000 ALTER TABLE `floors` DISABLE KEYS */;
INSERT INTO `floors` VALUES ('carpet',2,1),('dirt',3,1),('dirt',4,3),('dirt',5,4),('dirt',6,5),('carpet',7,6),('carpet',8,7),('tile',9,7),('tile',10,8),('tile',11,9),('dirt',12,10),('dirt',13,11),('dirt',14,12),('dirt',15,13),('dirt',16,14);
/*!40000 ALTER TABLE `floors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `foundations`
--

DROP TABLE IF EXISTS `foundations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `foundations` (
  `foundation` varchar(30) DEFAULT NULL,
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `parent` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `foundation` (`foundation`),
  KEY `parent` (`parent`),
  CONSTRAINT `foundations_ibfk_1` FOREIGN KEY (`foundation`) REFERENCES `posvals` (`foundation`),
  CONSTRAINT `foundations_ibfk_2` FOREIGN KEY (`parent`) REFERENCES `parentage` (`area_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `foundations`
--

LOCK TABLES `foundations` WRITE;
/*!40000 ALTER TABLE `foundations` DISABLE KEYS */;
INSERT INTO `foundations` VALUES ('hopes and dreams',1,1),('hopes and dreams',2,3),('dirt',3,2),('thin air',4,4);
/*!40000 ALTER TABLE `foundations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `heat_and_air`
--

DROP TABLE IF EXISTS `heat_and_air`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `heat_and_air` (
  `power` varchar(50) DEFAULT NULL,
  `fire_places` varchar(30) DEFAULT NULL,
  `unit_type` varchar(30) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `zoned_control` char(1) DEFAULT NULL,
  `capacities` varchar(50) DEFAULT NULL,
  `placement` varchar(50) DEFAULT NULL,
  `distribution` varchar(50) DEFAULT NULL,
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `parent` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  CONSTRAINT `heat_and_air_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `parentage` (`area_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `heat_and_air`
--

LOCK TABLES `heat_and_air` WRITE;
/*!40000 ALTER TABLE `heat_and_air` DISABLE KEYS */;
/*!40000 ALTER TABLE `heat_and_air` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lighting`
--

DROP TABLE IF EXISTS `lighting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lighting` (
  `lighting_support` varchar(30) DEFAULT NULL,
  `lighting_type` varchar(30) DEFAULT NULL,
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `parent` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lighting_support` (`lighting_support`),
  KEY `lighting_type` (`lighting_type`),
  KEY `parent` (`parent`),
  CONSTRAINT `lighting_ibfk_1` FOREIGN KEY (`lighting_support`) REFERENCES `posvals` (`lighting_support`),
  CONSTRAINT `lighting_ibfk_2` FOREIGN KEY (`lighting_type`) REFERENCES `posvals` (`lighting_type`),
  CONSTRAINT `lighting_ibfk_3` FOREIGN KEY (`parent`) REFERENCES `parentage` (`area_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lighting`
--

LOCK TABLES `lighting` WRITE;
/*!40000 ALTER TABLE `lighting` DISABLE KEYS */;
/*!40000 ALTER TABLE `lighting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notes` (
  `name` varchar(30) DEFAULT NULL,
  `content` text,
  `area_id` mediumint(9) DEFAULT NULL,
  `parc_id` mediumint(9) NOT NULL,
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `area_id` (`area_id`),
  KEY `parc_id` (`parc_id`),
  CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`area_id`) REFERENCES `parentage` (`area_id`),
  CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`parc_id`) REFERENCES `parcels` (`super_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notes`
--

LOCK TABLES `notes` WRITE;
/*!40000 ALTER TABLE `notes` DISABLE KEYS */;
/*!40000 ALTER TABLE `notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parcels`
--

DROP TABLE IF EXISTS `parcels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parcels` (
  `tax_map` varchar(4) DEFAULT NULL,
  `grp` varchar(2) DEFAULT NULL,
  `parcnum1` varchar(3) DEFAULT NULL,
  `parcnum2` varchar(2) DEFAULT NULL,
  `spec_int` varchar(3) DEFAULT NULL,
  `super_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `pri` varchar(30) DEFAULT NULL,
  `sec` varchar(30) DEFAULT NULL,
  `gen` varchar(30) DEFAULT NULL,
  `spe` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`super_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parcels`
--

LOCK TABLES `parcels` WRITE;
/*!40000 ALTER TABLE `parcels` DISABLE KEYS */;
INSERT INTO `parcels` VALUES ('107C','G','012','04','789',1,'Bourbonsville Manor','Improved','Commercial','Apartments','5+ Units'),('117','J','111','11','090',2,'Booooooooom','Vacant','Residential','Acreage',NULL);
/*!40000 ALTER TABLE `parcels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parentage`
--

DROP TABLE IF EXISTS `parentage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parentage` (
  `area_name` varchar(30) DEFAULT NULL,
  `template_name` varchar(30) DEFAULT NULL,
  `area_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `super_id` mediumint(9) NOT NULL,
  `parent` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`area_id`),
  KEY `super_id` (`super_id`),
  KEY `parent` (`parent`),
  CONSTRAINT `parentage_ibfk_1` FOREIGN KEY (`super_id`) REFERENCES `parcels` (`super_id`),
  CONSTRAINT `parentage_ibfk_2` FOREIGN KEY (`parent`) REFERENCES `parentage` (`area_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parentage`
--

LOCK TABLES `parentage` WRITE;
/*!40000 ALTER TABLE `parentage` DISABLE KEYS */;
INSERT INTO `parentage` VALUES ('building 1','building',1,1,NULL),('building 2','building',2,1,NULL),('main offices','building',3,1,NULL),('building 1','building',4,2,NULL),('building 2','building',5,2,NULL),('heyheyheyshed','building',6,2,NULL),('room 1','room',7,2,NULL),('room 2','room',8,2,1),('room 3','room',9,2,1),('room 1','room',10,2,2),('room 2','room',11,2,2),('room 3','room',12,2,2),('room 1','room',13,2,4),('room 2','room',14,2,4),('bunny brain corner',NULL,15,2,6),('nope.jpg','Room',16,2,6),('tgtgt','Room',17,1,2),('','Room',18,1,1),('saaassf','Building',19,2,2),('fnarr','Room',20,1,1),('fnarr','Room',21,1,1),('fnarr','Room',22,1,1),('b','Building',23,1,1),('ggggggg','Room',24,2,6),('sasasfar','Room',25,1,2),('room 6','Room',26,1,2),('ohohohoh','Room',27,2,6),('look mad','Room',28,1,3),('kkkkkkkk','Room',29,2,6),('doooooooo','Room',30,1,2),('yar','Room',31,1,3),('empty','Room',32,2,6),('windondown','Room',33,1,2),('dress.mov','Room',34,2,6),('bassssssssss','Room',35,1,2),('buildingfooo','Building',36,1,1),('not abuildig','Room',37,2,2),('rovo','Room',38,2,6),('popopopopo','Room',39,1,1),('MOAR','Room',40,1,1),('opooooooooooooo','Room',41,2,2),('hello i am superfluous','Room',42,2,15),('f','Room',43,2,6),('twilight zone','Room',44,2,2),('thriller','Room',45,1,3),('sfda','Room',46,1,1),('b','Room',47,2,2),('g','Room',48,2,2);
/*!40000 ALTER TABLE `parentage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poscols`
--

DROP TABLE IF EXISTS `poscols`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poscols` (
  `col_name` varchar(30) DEFAULT NULL,
  KEY `col_name` (`col_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poscols`
--

LOCK TABLES `poscols` WRITE;
/*!40000 ALTER TABLE `poscols` DISABLE KEYS */;
INSERT INTO `poscols` VALUES ('ceilings'),('dimensions'),('doors'),('fixtures'),('floors'),('foundations'),('heat_and_air'),('lighting'),('roof'),('trim'),('walls'),('windows');
/*!40000 ALTER TABLE `poscols` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posvals`
--

DROP TABLE IF EXISTS `posvals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posvals` (
  `lighting_support` varchar(30) DEFAULT NULL,
  `floor` varchar(30) DEFAULT NULL,
  `cond` varchar(30) DEFAULT NULL,
  `style` varchar(30) DEFAULT NULL,
  `frame` varchar(30) DEFAULT NULL,
  `sheathing` varchar(30) DEFAULT NULL,
  `cover` varchar(30) DEFAULT NULL,
  `construction` varchar(30) DEFAULT NULL,
  `insets` varchar(30) DEFAULT NULL,
  `fixture` varchar(30) DEFAULT NULL,
  `finish` varchar(30) DEFAULT NULL,
  `foundation` varchar(30) DEFAULT NULL,
  `ceiling` varchar(30) DEFAULT NULL,
  `trim` varchar(30) DEFAULT NULL,
  `wall` varchar(30) DEFAULT NULL,
  `lighting_type` varchar(30) DEFAULT NULL,
  `position` varchar(30) DEFAULT NULL,
  `pid` mediumint(9) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`pid`),
  KEY `lighting` (`lighting_support`),
  KEY `floor` (`floor`),
  KEY `cond` (`cond`),
  KEY `style` (`style`),
  KEY `frame` (`frame`),
  KEY `sheathing` (`sheathing`),
  KEY `cover` (`cover`),
  KEY `construction` (`construction`),
  KEY `insets` (`insets`),
  KEY `fixture` (`fixture`),
  KEY `finish` (`finish`),
  KEY `foundation` (`foundation`),
  KEY `ceiling` (`ceiling`),
  KEY `trim` (`trim`),
  KEY `wall` (`wall`),
  KEY `lighting_type` (`lighting_type`),
  KEY `position` (`position`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posvals`
--

LOCK TABLES `posvals` WRITE;
/*!40000 ALTER TABLE `posvals` DISABLE KEYS */;
INSERT INTO `posvals` VALUES ('recessed','hardwood','good','ye olde','triangle','nope','porch','1','ein','tiolet','posterboard','concrete slab on grade','roof','flab','sheetrock','halogen','exterior',1),('hanging','tile','bad','retro','square',NULL,'awning','2','zwei','sink','varnish','dirt','on','fat','hardwood','incandescent','interior',2),('standing','concrete','ugly','victorian english','circle',NULL,'lawn chairs','3','drei','shower','papier mache','thin air','fire','budget','tile','candles',NULL,3),(NULL,'carpet',NULL,'swedes',NULL,NULL,NULL,NULL,'vier',NULL,'spackle','hopes and dreams',NULL,NULL,'spackled','flourescent',NULL,4),(NULL,'dirt',NULL,NULL,NULL,NULL,NULL,NULL,'funf',NULL,NULL,NULL,NULL,NULL,'postboard',NULL,NULL,5),(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'sechs',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,6),(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'sieben',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,7),(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'acht',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,8),(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'neun',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,9),(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'zehn',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,10),(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'elf',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,11),(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'zwolf',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,12);
/*!40000 ALTER TABLE `posvals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roof`
--

DROP TABLE IF EXISTS `roof`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roof` (
  `roof_frame` varchar(30) DEFAULT NULL,
  `roof_style` varchar(30) DEFAULT NULL,
  `roof_sheathing` varchar(30) DEFAULT NULL,
  `roof_cover` varchar(30) DEFAULT NULL,
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `parent` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `roof_frame` (`roof_frame`),
  KEY `roof_style` (`roof_style`),
  KEY `roof_sheathing` (`roof_sheathing`),
  KEY `roof_cover` (`roof_cover`),
  KEY `parent` (`parent`),
  CONSTRAINT `roof_ibfk_1` FOREIGN KEY (`roof_frame`) REFERENCES `posvals` (`frame`),
  CONSTRAINT `roof_ibfk_2` FOREIGN KEY (`roof_style`) REFERENCES `posvals` (`style`),
  CONSTRAINT `roof_ibfk_3` FOREIGN KEY (`roof_sheathing`) REFERENCES `posvals` (`sheathing`),
  CONSTRAINT `roof_ibfk_4` FOREIGN KEY (`roof_cover`) REFERENCES `posvals` (`cover`),
  CONSTRAINT `roof_ibfk_5` FOREIGN KEY (`parent`) REFERENCES `parentage` (`area_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roof`
--

LOCK TABLES `roof` WRITE;
/*!40000 ALTER TABLE `roof` DISABLE KEYS */;
/*!40000 ALTER TABLE `roof` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `templates`
--

DROP TABLE IF EXISTS `templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `templates` (
  `Room` varchar(30) DEFAULT NULL,
  `Building` varchar(30) DEFAULT NULL,
  `template_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`template_id`),
  KEY `Room` (`Room`),
  KEY `Building` (`Building`),
  CONSTRAINT `templates_ibfk_1` FOREIGN KEY (`Room`) REFERENCES `poscols` (`col_name`),
  CONSTRAINT `templates_ibfk_2` FOREIGN KEY (`Building`) REFERENCES `poscols` (`col_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `templates`
--

LOCK TABLES `templates` WRITE;
/*!40000 ALTER TABLE `templates` DISABLE KEYS */;
INSERT INTO `templates` VALUES ('floors','foundations',2),('walls','walls',3),('ceilings','roof',4),('windows','doors',5);
/*!40000 ALTER TABLE `templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trim`
--

DROP TABLE IF EXISTS `trim`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trim` (
  `trim` varchar(30) DEFAULT NULL,
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `parent` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `trim` (`trim`),
  KEY `parent` (`parent`),
  CONSTRAINT `trim_ibfk_1` FOREIGN KEY (`trim`) REFERENCES `posvals` (`trim`),
  CONSTRAINT `trim_ibfk_2` FOREIGN KEY (`parent`) REFERENCES `parentage` (`area_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trim`
--

LOCK TABLES `trim` WRITE;
/*!40000 ALTER TABLE `trim` DISABLE KEYS */;
INSERT INTO `trim` VALUES ('fat',1,6),('flab',3,7);
/*!40000 ALTER TABLE `trim` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `walls`
--

DROP TABLE IF EXISTS `walls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `walls` (
  `wall` varchar(30) DEFAULT NULL,
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `parent` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `wall` (`wall`),
  KEY `parent` (`parent`),
  CONSTRAINT `walls_ibfk_1` FOREIGN KEY (`wall`) REFERENCES `posvals` (`wall`),
  CONSTRAINT `walls_ibfk_2` FOREIGN KEY (`parent`) REFERENCES `parentage` (`area_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `walls`
--

LOCK TABLES `walls` WRITE;
/*!40000 ALTER TABLE `walls` DISABLE KEYS */;
INSERT INTO `walls` VALUES ('tile',1,7),('sheetrock',2,7),('hardwood',3,7),('postboard',4,7);
/*!40000 ALTER TABLE `walls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `windows`
--

DROP TABLE IF EXISTS `windows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `windows` (
  `window_frame` varchar(30) DEFAULT NULL,
  `window_style` varchar(30) DEFAULT NULL,
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `parent` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `window_frame` (`window_frame`),
  KEY `window_style` (`window_style`),
  KEY `parent` (`parent`),
  CONSTRAINT `windows_ibfk_1` FOREIGN KEY (`window_frame`) REFERENCES `posvals` (`frame`),
  CONSTRAINT `windows_ibfk_2` FOREIGN KEY (`window_style`) REFERENCES `posvals` (`style`),
  CONSTRAINT `windows_ibfk_3` FOREIGN KEY (`parent`) REFERENCES `parentage` (`area_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `windows`
--

LOCK TABLES `windows` WRITE;
/*!40000 ALTER TABLE `windows` DISABLE KEYS */;
/*!40000 ALTER TABLE `windows` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-04-27 18:15:11
