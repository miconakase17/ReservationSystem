-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: reservation_system
-- ------------------------------------------------------
-- Server version	9.2.0

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
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
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
  `paymentMethod` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `paymentStatus` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `transactionReference` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `createdAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `lastUpdate` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`paymentID`),
  KEY `userID` (`userID`),
  KEY `reservationID` (`reservationID`),
  CONSTRAINT `fk_payments_reservations` FOREIGN KEY (`reservationID`) REFERENCES `reservations` (`reservationID`),
  CONSTRAINT `fk_payments_users` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,15,16,1000.00,'2025-10-22 19:05:16','GCash','Pending',NULL,'2025-10-23 01:05:16','2025-10-23 01:05:16'),(2,15,17,600.00,'2025-10-23 04:30:37','GCash','Pending','76536789943','2025-10-23 10:30:37','2025-10-23 10:30:37');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recording_options`
--

LOCK TABLES `recording_options` WRITE;
/*!40000 ALTER TABLE `recording_options` DISABLE KEYS */;
INSERT INTO `recording_options` VALUES (1,18,'MultiTrack',1,'2025-10-23 02:33:55'),(2,19,'MultiTrack',1,'2025-10-23 02:35:36'),(3,20,'MultiTrack',1,'2025-10-23 02:43:00');
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
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation_additionals`
--

LOCK TABLES `reservation_additionals` WRITE;
/*!40000 ALTER TABLE `reservation_additionals` DISABLE KEYS */;
INSERT INTO `reservation_additionals` VALUES (1,5,1),(2,5,2),(3,5,3),(4,5,4),(5,5,5),(6,5,6),(7,6,1),(8,6,2),(9,6,3),(10,6,4),(11,6,5),(12,6,6),(13,7,1),(14,7,2),(15,7,3),(16,7,4),(17,7,5),(18,7,6),(19,8,1),(20,8,2),(21,8,3),(22,8,4),(23,8,5),(24,8,6),(25,9,1),(26,9,2),(27,9,3),(28,9,4),(29,9,5),(30,9,6),(31,10,1),(32,10,2),(33,10,3),(34,10,4),(35,10,5),(36,10,6),(37,11,1),(38,11,2),(39,11,3),(40,11,4),(41,11,5),(42,11,6),(43,12,1),(44,12,2),(45,12,3),(46,12,4),(47,12,5),(48,12,6),(49,13,1),(50,13,2),(51,13,3),(52,13,4),(53,13,5),(54,13,6),(55,14,1),(56,14,2),(57,14,3),(58,14,4),(59,14,5),(60,14,6),(61,15,1),(62,15,2),(63,15,3),(64,15,4),(65,15,5),(66,15,6),(67,16,1),(68,16,2),(69,16,3),(70,16,4),(71,16,5),(72,16,6),(73,17,1),(74,17,2),(75,17,3),(76,17,4),(77,17,5),(78,17,6);
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation_receipts`
--

LOCK TABLES `reservation_receipts` WRITE;
/*!40000 ALTER TABLE `reservation_receipts` DISABLE KEYS */;
INSERT INTO `reservation_receipts` VALUES (1,14,'receipt','1761152242_About Page.png','2025-10-22 16:57:22'),(2,15,'receipt','1761152435_About Page.png','2025-10-22 17:00:35'),(3,16,'receipt','1761152716_About Page.png','2025-10-22 17:05:16'),(4,17,'receipt','1761186637_About Page.png','2025-10-23 02:30:37');
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
  `bandName` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
INSERT INTO `reservations` VALUES (4,15,NULL,1,'2025-10-24','11:00:00','12:00:00',0.00,1,'2025-10-22 23:10:35'),(5,15,NULL,1,'2025-10-24','11:00:00','12:00:00',0.00,1,'2025-10-22 23:23:52'),(6,15,NULL,1,'2025-10-24','11:00:00','12:00:00',0.00,1,'2025-10-22 23:28:41'),(7,15,NULL,1,'2025-10-24','11:00:00','12:00:00',0.00,1,'2025-10-22 23:29:44'),(8,15,NULL,1,'2025-10-31','10:00:00','11:00:00',0.00,1,'2025-10-23 00:26:05'),(9,15,'Mico',1,'2025-10-31','10:00:00','11:00:00',0.00,1,'2025-10-23 00:36:38'),(10,15,'Mico',1,'2025-10-31','10:00:00','11:00:00',420.00,1,'2025-10-23 00:40:41'),(11,15,'Mico',1,'2025-10-31','10:00:00','11:00:00',420.00,1,'2025-10-23 00:42:27'),(12,15,'Dclass6',1,'2025-10-25','10:00:00','15:00:00',1620.00,1,'2025-10-23 00:53:35'),(13,15,'Dclass6',1,'2025-10-25','10:00:00','15:00:00',1620.00,1,'2025-10-23 00:56:07'),(14,15,'Dclass6',1,'2025-10-25','10:00:00','15:00:00',1620.00,1,'2025-10-23 00:57:22'),(15,15,'Dclass6',1,'2025-10-25','10:00:00','15:00:00',1620.00,1,'2025-10-23 01:00:35'),(16,15,'Dclass6',1,'2025-10-25','10:00:00','15:00:00',1620.00,1,'2025-10-23 01:05:16'),(17,15,'annann',1,'2025-10-24','13:00:00','15:00:00',720.00,1,'2025-10-23 10:30:36'),(18,15,'',2,'2025-10-25','00:00:00','00:00:00',2000.00,1,'2025-10-23 10:33:55'),(19,15,'',2,'2025-10-25','00:00:00','00:00:00',2000.00,1,'2025-10-23 10:35:36'),(20,15,'',2,'2025-10-25','00:00:00','00:00:00',2000.00,1,'2025-10-23 10:43:00');
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
  `roleName` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`roleID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'0'),(2,'0');
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
  `statusName` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`statusID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` VALUES (1,'Active'),(2,'Inactive');
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
INSERT INTO `user_details` VALUES (15,'Nakase','Mico','Libunao','09665270518','miconakaseyt@gmail.com','2025-09-11 05:41:00'),(16,'Carpio','Julie Ann','','09877787765','julieanncarpio55@gmail.com','2025-10-21 19:45:17'),(19,'Reg','Rowdolf Almie','Libunao','09877787765','palasimba@gmail.com','2025-10-21 19:47:59'),(20,'Reg','Rowdolf Almie','Libunao','09877787765','ashketchum@yahoo.com','2025-10-21 19:49:03'),(21,'Varona','Mhics','Gacilo','09519614277','dasdasdsd@gmail.com','2025-10-23 13:01:38'),(22,'Tung','Arvin','Saur','09519614278','arvinsaur@gmail.com','2025-10-23 13:05:39'),(23,'Verstappen','Max','Emilian','09159413872','max_verstappen@gmail.com','2025-10-23 13:10:02'),(24,'Mohatmas','Sosiua','Tungtung','09123456789','sosiua@gmail.com','2025-10-23 14:38:56');
/*!40000 ALTER TABLE `user_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_roles` (
  `userID` int NOT NULL,
  `roleID` int NOT NULL,
  KEY `fk_user_roles_roles` (`roleID`),
  KEY `fk_user_roles_users` (`userID`),
  CONSTRAINT `fk_user_roles_roles` FOREIGN KEY (`roleID`) REFERENCES `roles` (`roleID`),
  CONSTRAINT `fk_user_roles_users` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_roles`
--

LOCK TABLES `user_roles` WRITE;
/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `userID` int NOT NULL AUTO_INCREMENT,
  `username` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isActive` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (15,'miconakase17','$2y$10$DBsrkK9coVmhiJwlLe4une1aS.CXCO77OrWrDDairlpWnKv6IUVFK','2025-09-11 05:41:00',1),(16,'annann21','$2y$10$a63BTEqn0dUUQbyi2jPruuz8Jlcl2tECWOC2pjVLCpDI7cmPOUPGS','2025-10-21 13:41:34',1),(17,'annann21','$2y$10$7f2dTXYvbxpHxuAB9sAyV.qKtnrSmk54TcDwfLzDe3PxnP8Sh.Lea','2025-10-21 13:41:45',1),(18,'annann21','$2y$10$TB6z5qqhKphMQ4P3e4f1Q.DC/L6d2jGGajjLMWJKyN7VGlEZ.z3Ca','2025-10-21 13:45:17',1),(19,'rowdolf15','$2y$10$b3auNbI71cppvpI9ElX1EuhMn/ajmvpaNXohoe4kLpLNIRqTia3zu','2025-10-21 13:47:59',1),(20,'asdasd','$2y$10$Xohli6WUfd8O.j9cZBdt3etaYqEhUM9POPdNoXzpQCA5D64vggp5W','2025-10-21 13:49:03',1),(21,'Mish','$2y$10$.aDbhAXf6Wq5aQLCZt1xCeiLQYp5ms6VCCYfmAeD38Milts83.sfy','2025-10-23 07:01:38',1),(22,'ArvinTanders','$2y$10$8/R1jFaVfRvv5WGb9XGsUeUD5yYYY48/IiyB/.1lBhB6yDRXiO9Za','2025-10-23 07:05:39',1),(23,'mverstappen','$2y$10$CO1eWVE23gjD4U48CdpOueSiI6Gj1XyJ1yUrPFjEyTIIRlN8ELYOq','2025-10-23 07:10:02',1),(24,'sosiua','$2y$10$in455rxy8YQprMKhGMF.xO24Mj.TFDuDQRT4UlzgWz3Z9yElymliK','2025-10-23 08:38:56',1);
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

-- Dump completed on 2025-10-23 15:55:52
