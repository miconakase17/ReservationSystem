-- MySQL dump 10.13  Distrib 8.0.44, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: reservation_system
-- ------------------------------------------------------
-- Server version	8.0.42

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `additionals`
--

DROP TABLE IF EXISTS `additionals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `additionals` (
  `addID` int unsigned NOT NULL AUTO_INCREMENT,
  `addName` varchar(45) DEFAULT NULL,
  `price` int DEFAULT NULL,
  PRIMARY KEY (`addID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `additionals`
--

LOCK TABLES `additionals` WRITE;
/*!40000 ALTER TABLE `additionals` DISABLE KEYS */;
INSERT INTO `additionals` VALUES (1,'Electric Guitar',20),(2,'Bass Guitar',20),(3,'Drum Sticks',30),(4,'Guitar Pick',10),(5,'Stage Lights',20),(6,'Microphone',20);
/*!40000 ALTER TABLE `additionals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `messageID` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `createdAt` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`messageID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,'Mhyca Varona','mhycavarona@yahoo.com','Hi beb','2025-05-28 06:10:17'),(2,'Julie AnAn','juliemabangisxz@yahoo.com','Pwede ka ba sapakin?','2025-05-28 06:11:38'),(3,'Arvin Bananini','arvintusta@gmail.com','I love Valerina Cappuccino','2025-05-28 06:13:28'),(4,'Eriz Pisot','erizpisot@gmail.com','I love dinosaurs','2025-05-28 06:21:14'),(5,'Rowdolf','ashketchum@yahoo.com','asdasdasdasdasdasd','2025-10-21 21:17:59'),(6,'Rowdolf','ashketchum@yahoo.com','Hello haha','2025-10-21 21:18:14'),(7,'Rowdolf','ashketchum@yahoo.com','hello HAHAHAHAH','2025-10-21 21:19:26'),(8,'mhics','varonamhics@gmail.com','gegege','2025-10-23 12:53:29');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `paymentID` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `reservationID` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `paymentDate` datetime NOT NULL,
  `paymentMethod` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `paymentStatus` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `transactionReference` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `createdAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `lastUpdate` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`paymentID`),
  KEY `userID` (`userID`),
  KEY `reservationID` (`reservationID`),
  CONSTRAINT `fk_payments_reservations` FOREIGN KEY (`reservationID`) REFERENCES `reservations` (`reservationID`),
  CONSTRAINT `fk_payments_users` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (3,28,21,360.00,'2025-10-29 08:09:37','GCash','Pending','123123123123123','2025-10-29 15:09:37','2025-10-29 15:09:37'),(4,28,22,1000.00,'2025-10-29 14:09:32','GCash','Pending','123123123123123','2025-10-29 21:09:32','2025-10-29 21:09:32'),(5,28,23,600.00,'2025-10-29 14:18:29','GCash','Pending','123123123123123','2025-10-29 21:18:29','2025-10-29 21:18:29'),(6,28,30,0.00,'2025-11-01 13:28:26','GCash','Pending','','2025-11-01 20:28:26','2025-11-01 20:28:26'),(7,28,31,0.00,'2025-11-01 13:32:59','GCash','Pending','','2025-11-01 20:32:59','2025-11-01 20:32:59'),(8,28,32,0.00,'2025-11-01 13:51:35','GCash','Pending','','2025-11-01 20:51:35','2025-11-01 20:51:35');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recording_options`
--

DROP TABLE IF EXISTS `recording_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recording_options` (
  `recordingID` int NOT NULL AUTO_INCREMENT,
  `reservationID` int NOT NULL,
  `mode` enum('MultiTrack','LiveTrack') DEFAULT 'MultiTrack',
  `mixAndMaster` tinyint(1) DEFAULT '0',
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`recordingID`),
  KEY `reservationID` (`reservationID`),
  CONSTRAINT `recording_options_ibfk_1` FOREIGN KEY (`reservationID`) REFERENCES `reservations` (`reservationID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recording_options`
--

LOCK TABLES `recording_options` WRITE;
/*!40000 ALTER TABLE `recording_options` DISABLE KEYS */;
INSERT INTO `recording_options` VALUES (1,18,'MultiTrack',1,'2025-10-23 02:33:55'),(2,19,'MultiTrack',1,'2025-10-23 02:35:36'),(3,20,'MultiTrack',1,'2025-10-23 02:43:00'),(4,24,'MultiTrack',1,'2025-10-30 00:39:52'),(5,25,'MultiTrack',1,'2025-10-30 00:48:11'),(6,26,'MultiTrack',0,'2025-10-30 02:55:10'),(7,28,'LiveTrack',1,'2025-10-30 06:30:49'),(8,29,'LiveTrack',1,'2025-11-01 12:21:43'),(9,30,'LiveTrack',1,'2025-11-01 12:28:26');
/*!40000 ALTER TABLE `recording_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recording_options_prices`
--

DROP TABLE IF EXISTS `recording_options_prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recording_options_prices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recording_options_prices`
--

LOCK TABLES `recording_options_prices` WRITE;
/*!40000 ALTER TABLE `recording_options_prices` DISABLE KEYS */;
INSERT INTO `recording_options_prices` VALUES (1,'MultiTrack',500.00),(2,'LiveTrack',800.00),(3,'MixAndMaster',1500.00);
/*!40000 ALTER TABLE `recording_options_prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation_additionals`
--

DROP TABLE IF EXISTS `reservation_additionals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservation_additionals` (
  `ResAddID` int NOT NULL AUTO_INCREMENT,
  `reservationID` int NOT NULL,
  `addID` int unsigned NOT NULL,
  PRIMARY KEY (`ResAddID`),
  KEY `reservationID` (`reservationID`),
  KEY `addID` (`addID`),
  CONSTRAINT `reservation_additionals_ibfk_1` FOREIGN KEY (`reservationID`) REFERENCES `reservations` (`reservationID`) ON DELETE CASCADE,
  CONSTRAINT `reservation_additionals_ibfk_2` FOREIGN KEY (`addID`) REFERENCES `additionals` (`addID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation_additionals`
--

LOCK TABLES `reservation_additionals` WRITE;
/*!40000 ALTER TABLE `reservation_additionals` DISABLE KEYS */;
INSERT INTO `reservation_additionals` VALUES (1,5,1),(2,5,2),(3,5,3),(4,5,4),(5,5,5),(6,5,6),(7,6,1),(8,6,2),(9,6,3),(10,6,4),(11,6,5),(12,6,6),(13,7,1),(14,7,2),(15,7,3),(16,7,4),(17,7,5),(18,7,6),(19,8,1),(20,8,2),(21,8,3),(22,8,4),(23,8,5),(24,8,6),(25,9,1),(26,9,2),(27,9,3),(28,9,4),(29,9,5),(30,9,6),(31,10,1),(32,10,2),(33,10,3),(34,10,4),(35,10,5),(36,10,6),(37,11,1),(38,11,2),(39,11,3),(40,11,4),(41,11,5),(42,11,6),(43,12,1),(44,12,2),(45,12,3),(46,12,4),(47,12,5),(48,12,6),(49,13,1),(50,13,2),(51,13,3),(52,13,4),(53,13,5),(54,13,6),(55,14,1),(56,14,2),(57,14,3),(58,14,4),(59,14,5),(60,14,6),(61,15,1),(62,15,2),(63,15,3),(64,15,4),(65,15,5),(66,15,6),(67,16,1),(68,16,2),(69,16,3),(70,16,4),(71,16,5),(72,16,6),(73,17,1),(74,17,2),(75,17,3),(76,17,4),(77,17,5),(78,17,6),(79,21,1),(80,21,2),(81,21,3),(82,21,4),(83,21,5),(84,21,6),(85,22,1),(86,22,2),(87,22,3),(88,22,4),(89,22,5),(90,22,6),(91,23,1),(92,23,2),(93,23,3),(94,23,4),(95,23,5),(96,23,6),(97,27,1),(98,31,1),(99,31,4),(100,32,1),(101,32,4),(102,34,3),(103,35,1);
/*!40000 ALTER TABLE `reservation_additionals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation_receipts`
--

DROP TABLE IF EXISTS `reservation_receipts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservation_receipts` (
  `receiptID` int NOT NULL AUTO_INCREMENT,
  `reservationID` int NOT NULL,
  `uploadType` varchar(50) NOT NULL COMMENT 'e.g., receipt, recording_receipt',
  `fileName` varchar(255) NOT NULL,
  `uploadedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`receiptID`),
  KEY `reservationID` (`reservationID`),
  CONSTRAINT `reservation_receipts_ibfk_1` FOREIGN KEY (`reservationID`) REFERENCES `reservations` (`reservationID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation_receipts`
--

LOCK TABLES `reservation_receipts` WRITE;
/*!40000 ALTER TABLE `reservation_receipts` DISABLE KEYS */;
INSERT INTO `reservation_receipts` VALUES (1,14,'receipt','1761152242_About Page.png','2025-10-22 16:57:22'),(2,15,'receipt','1761152435_About Page.png','2025-10-22 17:00:35'),(3,16,'receipt','1761152716_About Page.png','2025-10-22 17:05:16'),(4,17,'receipt','1761186637_About Page.png','2025-10-23 02:30:37'),(5,21,'receipt','1761721777_Screenshot 2025-10-28 160436.png','2025-10-29 07:09:37'),(6,22,'receipt','1761743372_images (8).png','2025-10-29 13:09:32'),(7,23,'receipt','1761743909_Screenshot 2025-10-28 160436.png','2025-10-29 13:18:29'),(8,27,'receipt','1761800521_calendar.png','2025-10-30 05:02:01'),(9,31,'receipt','1762000379_images (8).png','2025-11-01 12:32:59'),(10,32,'receipt','1762001495_images (8).png','2025-11-01 12:51:35');
/*!40000 ALTER TABLE `reservation_receipts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservations` (
  `reservationID` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `bandName` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `serviceID` int NOT NULL,
  `date` date NOT NULL,
  `startTime` time NOT NULL,
  `endTime` time NOT NULL,
  `totalCost` decimal(10,2) NOT NULL,
  `statusID` int NOT NULL,
  `createdAt` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`reservationID`),
  KEY `userID` (`userID`),
  KEY `serviceID` (`serviceID`),
  KEY `statusID` (`statusID`),
  CONSTRAINT `fk_reservations_roles` FOREIGN KEY (`serviceID`) REFERENCES `services` (`serviceID`),
  CONSTRAINT `fk_reservations_status` FOREIGN KEY (`statusID`) REFERENCES `status` (`statusID`),
  CONSTRAINT `fk_reservations_users` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
INSERT INTO `reservations` VALUES (21,28,'Customer1',1,'2025-10-31','17:00:00','19:00:00',720.00,1,'2025-10-29 15:09:36'),(22,28,'Customer2',1,'2025-11-01','15:00:00','20:00:00',1620.00,4,'2025-10-29 21:09:32'),(23,28,'Customer3',1,'2025-10-30','15:00:00','20:00:00',1370.00,4,'2025-10-29 21:18:29'),(24,28,'',2,'2025-11-02','10:00:00','12:00:00',2500.00,2,'2025-10-30 08:39:52'),(25,28,'',2,'2025-11-03','13:00:00','15:00:00',2500.00,4,'2025-10-30 08:48:11'),(26,28,'',2,'2025-10-31','15:00:00','17:00:00',1000.00,2,'2025-10-30 10:55:10'),(27,28,'asdasd',1,'2025-11-04','14:00:00','15:00:00',270.00,1,'2025-10-30 13:02:01'),(28,28,'',2,'2025-11-08','10:00:00','12:00:00',3100.00,1,'2025-10-30 14:30:49'),(29,28,'',2,'2025-12-05','17:00:00','18:00:00',2300.00,1,'2025-11-01 20:21:43'),(30,28,'',2,'2025-11-07','20:00:00','22:00:00',3100.00,1,'2025-11-01 20:28:26'),(31,28,'Dclass6',1,'2025-11-15','22:00:00','23:00:00',330.00,1,'2025-11-01 20:32:59'),(32,28,'Dclass6',1,'2025-11-21','22:00:00','23:00:00',330.00,1,'2025-11-01 20:51:35'),(33,28,'Dclass6',1,'2025-11-21','10:00:00','00:00:00',0.00,1,'2025-11-02 22:13:51'),(34,28,'Dclass6',1,'2025-11-21','10:00:00','12:00:00',0.00,1,'2025-11-02 22:14:32'),(35,28,'hahaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',1,'2025-11-20','09:00:00','10:00:00',0.00,1,'2025-11-02 22:15:46');
/*!40000 ALTER TABLE `reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `roleID` int NOT NULL AUTO_INCREMENT,
  `roleName` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`roleID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin'),(2,'Customer');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_pricings`
--

DROP TABLE IF EXISTS `service_pricings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service_pricings` (
  `servicePriceID` int NOT NULL AUTO_INCREMENT,
  `serviceID` int NOT NULL,
  `weekdayFrom` tinyint unsigned NOT NULL COMMENT '1=Mon .. 7=Sun',
  `weekdayTo` tinyint unsigned NOT NULL COMMENT '1=Mon .. 7=Sun',
  `hourlyRate` int NOT NULL COMMENT 'amount in smallest currency unit e.g. PHP pesos (no decimals)',
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`servicePriceID`),
  KEY `serviceID` (`serviceID`),
  CONSTRAINT `service_pricings_ibfk_1` FOREIGN KEY (`serviceID`) REFERENCES `services` (`serviceID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_pricings`
--

LOCK TABLES `service_pricings` WRITE;
/*!40000 ALTER TABLE `service_pricings` DISABLE KEYS */;
INSERT INTO `service_pricings` VALUES (1,1,1,4,250,'2025-10-09 02:19:01'),(2,1,5,7,300,'2025-10-09 02:19:01');
/*!40000 ALTER TABLE `service_pricings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `serviceID` int NOT NULL,
  `serviceName` varchar(45) NOT NULL,
  PRIMARY KEY (`serviceID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,'Studio Rental'),(2,'Recording'),(3,'Drum Lesson');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `status` (
  `statusID` int NOT NULL AUTO_INCREMENT,
  `statusName` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`statusID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` VALUES (1,'Pending'),(2,'Confirmed'),(3,'Cancelled'),(4,'Completed'),(5,'Rejected');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_details`
--

DROP TABLE IF EXISTS `user_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_details` (
  `userID` int NOT NULL,
  `lastName` varchar(45) NOT NULL,
  `firstName` varchar(45) NOT NULL,
  `middleName` varchar(45) DEFAULT NULL,
  `phoneNumber` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `lastUpdate` varchar(45) NOT NULL,
  KEY `fk_user_details_users` (`userID`),
  CONSTRAINT `fk_user_details_users` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_details`
--

LOCK TABLES `user_details` WRITE;
/*!40000 ALTER TABLE `user_details` DISABLE KEYS */;
INSERT INTO `user_details` VALUES (28,'Doe','John','','09999999999','customer1@gmail.com','2025-10-28 21:45:39'),(29,'Dela','Juan','Cruz','09999999999','admin1@gmail.com','2025-10-29 18:09:09'),(30,'Alonte','Anton','','09877787765','ashketchum@yahoo.com','2025-10-30 11:50:09'),(31,'Carpio','Julie Ann','Bonguit','09877787765','julieanncarpio55@gmail.com','2025-10-30 11:59:48'),(32,'Nakase','Mico','Libunao','admin2','miconakaseyt@gmail.com','2025-10-30 12:16:40'),(33,'Gavino','John Rey','','09877787765','miconakaseyt@gmail.com','2025-10-30 12:24:30'),(34,'Libunao','Lexter','Bisoy','09877787765','ashketchum@yahoo.com','2025-10-30 12:32:23'),(35,'Sena','Mark','','09877787765','miconakaseyt@gmail.com','2025-10-30 12:35:45'),(36,'Esteban','Mac','','09877787765','miconakaseyt@gmail.com','2025-10-30 12:44:21'),(37,'Varona','Mhyca','','09877787765','admin7@gmail.com','2025-11-03 11:01:04'),(38,'Batumbakal','Snowie','','09877787765','meow@gmail.com','2025-11-03 00:55:46'),(40,'Bantug','Eriz','','09877787765','miconakaseyt@gmail.com','2025-11-03 11:28:36'),(41,'Compuesto','Jenny Rose','','09665270518','truchorus.official@gmail.com','2025-11-03 14:31:56');
/*!40000 ALTER TABLE `user_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `userID` int NOT NULL AUTO_INCREMENT,
  `username` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `roleID` int DEFAULT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isActive` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`userID`),
  KEY `fk_user_roles` (`roleID`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (28,'customer1','$2y$10$DGyLY14Ju71kBUdrTIznK.Vpgano/VYR7mSEuH0LNVUoVEcKlaMBO',2,'2025-10-28 14:45:39',1),(29,'admin1','$2y$10$sn05a01nsyrGcT0dVZqWCexnSSa.JXkDgdZkkSk52KYc./ute1eNu',1,'2025-10-29 11:09:09',1),(30,'customer2','$2y$10$idYB5eyKjzjDyAqU/ds6hOQaIBkHPUrx26KPpGssy5Dc1m.jQEWZi',2,'2025-10-30 04:50:09',1),(31,'customer3','$2y$10$eCKc4l7NcMU2kR7K/xBfeuDWcbEa5r33IsP9BQdha/LWSlyTqbu0i',2,'2025-10-30 04:59:48',1),(32,'admin2','$2y$10$lRkHkTdGWvNJf08dJfuS2eJjF9RLTESCvQdM/usWuY1P7kzjDHh5e',2,'2025-10-30 05:16:40',1),(33,'admin3','$2y$10$qWyRt3pE2940paDlM8YMzeUTRxS3lJdGlgHE5r5Aj3sqaUsw1maS.',1,'2025-10-30 05:24:30',1),(34,'admin4','$2y$10$ogvMBaULFO48ktBOTSPYQeRzVz9Fyl7tpBRBBwWTb/L8FchXw8Fp6',1,'2025-10-30 05:32:23',1),(35,'admin5','$2y$10$tMsHQavvYAclmj.AU12qSuPNCaN8XdqOvtyTk4Gj42l734bNnk8rq',1,'2025-10-30 05:35:45',1),(36,'admin6','$2y$10$2luZvexT7QBe6CMVjbm0BObfzbA5JrxG/OT6MtxytPWyw1amJ2H6.',1,'2025-10-30 05:44:21',1),(37,'admin7','$2y$10$.iobBotCQ56z.xJ10pQ0uOiEPipqYB/sYH11xgK4Jg77oP.JA9VKS',1,'2025-11-02 17:54:51',1),(38,'customer4','$2y$10$/Gz.Ao8Er65MN4Y.YJvhxODJ/gab3Ti.XMD8C8FVCas04nWvOtfPe',2,'2025-11-02 17:55:46',1),(39,'admin7','$2y$10$g/cE7bjyD5tmaqQQgvnDDes4EpcfgePUszzg1flF0cil1xVJMFDrW',1,'2025-11-03 04:01:04',1),(40,'asdsad','$2y$10$FGPjKmujO7KCekfRqYalBeCfDZ8/iRKymCvj/KAi236lFJSonj8Bi',1,'2025-11-03 04:28:36',1),(41,'jinjinmasarap','$2y$10$vXIooBHcnw3ozVWyy6mnYOW97EtUftNzmHALVykGfXBHDCeJJLRo.',2,'2025-11-03 07:31:56',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-03 14:38:45
