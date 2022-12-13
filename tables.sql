-- MariaDB dump 10.19  Distrib 10.8.3-MariaDB, for osx10.17 (x86_64)
--
-- Host: localhost    Database: learning_application
-- ------------------------------------------------------
-- Server version	10.8.3-MariaDB

-- DATA FOR CLASSES FALL 2023 --

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `CMPS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CMPS` (
  `class_nbr` int NOT NULL,
  `class_nm` char(50) NOT NULL,
  `section` char(50) NOT NULL,
  `days` char(50) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `room` char(50) NOT NULL,
  `instructor` char(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `mode` char(50) NOT NULL,
  `class_capacity` int NOT NULL,
  PRIMARY KEY (`class_nbr`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `CMPS` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `CMPS` VALUES 
(32337,'CMPS 1200','01-LEC Regular','MoWeFr','11:00:00','11:50:00','Science 3 239','Shahrzad Sheibani','2023-01-23','2023-05-19','Face-to-Face',35);
(32424,'CMPS 2010','03-DIS Regular','MoWeFr','08:00:00','08:50:00','Science 3 311','William Royer','2023-01-23','2023-05-19','Face-to-Face',35);
(32425,'CMPS 2010','04-LAB Regular','Tu','07:20:00','09:50:00','Science 3 311','William Royer','2023-01-23','2023-05-19','Face-to-Face',35);
(32406,'CMPS 2020','03-DIS Regular','MoWe','17:30:00','18:45:00','Science 3 240','Michael Sarr','2023-01-23','2023-05-19','Face-to-Face',35);
(32407,'CMPS 2020','04-LAB Regular','MoWe','19:00:00','20:15:00','Science 3 240','Michael Sarr','2023-01-23','2023-05-19','Face-to-Face',35);
(33045,'CMPS 2240','01-LEC Regular','MoWeFr','09:00:00','09:50:00','Science 3 311','Anthony Bianchi','2023-01-23','2023-05-19','Face-to-Face',35);
(33046,'CMPS 2240','02-LAB Regular','Th','13:00:00','15:30:00','Science 3 315','Anthony Bianchi','2023-01-23','2023-05-19','Face-to-Face',35);
(32428,'CMPS 2680','01-LEC Regular','MoWeFr','11:00:00','11:50:00','Science 3 315','William Royer','2023-01-23','2023-05-19','Face-to-Face',35);
(32435,'CMPS 3240','01-LEC Regular','MoWe','16:00:00','17:15:00','Science 3 311','Alberto Cruz','2023-01-23','2023-05-19','Face-to-Face',35);
(32436,'CMPS 3240','02-LAB Regular','Fr','13:00:00','15:30:00','Science 3 311','Alberto Cruz','2023-01-23','2023-05-19','Face-to-Face',35);
(33161,'CMPS 3300','01-LEC Regular','MoWe','11:50:00','13:30:00','Science 3 105','Qiwei Sheng','2023-01-23','2023-05-19','Face-to-Face',30);
(32440,'CMPS 3350','01-LEC Regular','MoWeFr','09:00:00','09:50:00','Science 3 240','Gordon Griesel','2023-01-23','2023-05-19','Face-to-Face',35);
(32441,'CMPS 3350','02-LAB Regular','Tu','07:20:00','09:50:00','Science 3 240','Gordon Griesel','2023-01-23','2023-05-19','Face-to-Face',35);
(32431,'CMPS 3390','01-DIS Regular','MoWe','13:00:00','14:15:00','Science 3 240','Vincent On','2023-01-23','2023-05-19','Face-to-Face',35);
(32432,'CMPS 3390','02-LAB Regular','Tu','13:00:00','15:30:00','Science 3 240','Vincent On','2023-01-23','2023-05-19','Face-to-Face',35);
(32453,'CMPS 3420','01-LEC Regular','MoWe','13:00:00','14:15:00','Science 3 311','Nick Toothman','2023-01-23','2023-05-19','Face-to-Face',35);
(32454,'CMPS 3420','02-LAB Regular','Th','13:00:00','15:30:00','Science 3 311','Nick Toothman','2023-01-23','2023-05-19','Face-to-Face',35);
(32429,'CMPS 3560','01-LEC Regular','MoWe','10:00:00','10:50:00','Science 3 311','Vincent On','2023-01-23','2023-05-19','Face-to-Face',35);
(32430,'CMPS 3560','02-LAB Regular','Tu','10:00:00','12:30:00','Science 3 311','Vincent On','2023-01-23','2023-05-19','Face-to-Face',35);
(32446,'CMPS 3620','01-LEC Regular','MoWeFr','12:00:00','12:50:00','Science 3 311','Anthony Bianchi','2023-01-23','2023-05-19','Face-to-Face',35);
(32447,'CMPS 3620','02-LAB Regular','Th','10:00:00','12:30:00','Science 3 311','Anthony Bianchi','2023-01-23','2023-05-19','Face-to-Face',35);
(32418,'CMPS 3640','01-DIS Regular','MoWe','13:00:00','13:50:00','Science 3 315','Kanwalinderjit Kaur','2023-01-23','2023-05-19','Face-to-Face',35);
(32419,'CMPS 3640','02-LAB Regular','Tu','13:00:00','15:30:00','Science 3 315','Kanwalinderjit Kaur','2023-01-23','2023-05-19','Face-to-Face',35);
(32426,'CMPS 3680','01-DIS Regular','MoWe','09:00:00','09:50:00','Science 3 315','William Royer','2023-01-23','2023-05-19','Face-to-Face',35);
(32427,'CMPS 3680','02-ACT Regular','Th','07:20:00','09:50:00','Science 3 315','William Royer','2023-01-23','2023-05-19','Face-to-Face',35);
(32438,'CMPS 4350','01-LEC Regular','MoWeFr','08:00:00','08:50:00','Science 3 240','Gordon Griesel','2023-01-23','2023-05-19','Face-to-Face',35);
(32439,'CMPS 4350','02-LAB Regular','Th','07:20:00','09:50:00','Science 3 240','Gordon Griesel','2023-01-23','2023-05-19','Face-to-Face',35);
(32450,'CMPS 4910','01-DIS Regular','Fr','13:00:00','14:40:00','Science 3 315','Anthony Bianchi','2023-01-23','2023-05-19','Face-to-Face',15);
(32422,'CMPS 4910','02-DIS Regular','Fr','08:00:00','09:40:00','Science 3 315','Kanwalinderjit Kaur','2023-01-23','2023-05-19','Face-to-Face',15);


/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `creator`
--
