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
-- Table structure for table `drumlesson_sessions`
--

DROP TABLE IF EXISTS `drumlesson_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `drumlesson_sessions` (
  `sessionID` int NOT NULL AUTO_INCREMENT,
  `reservationID` int NOT NULL,
  `date` date NOT NULL,
  `startTime` time NOT NULL,
  `endTime` time NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sessionID`),
  KEY `reservationID` (`reservationID`),
  CONSTRAINT `drumlesson_sessions_ibfk_1` FOREIGN KEY (`reservationID`) REFERENCES `reservations` (`reservationID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `drumlesson_sessions`
--

LOCK TABLES `drumlesson_sessions` WRITE;
/*!40000 ALTER TABLE `drumlesson_sessions` DISABLE KEYS */;
INSERT INTO `drumlesson_sessions` VALUES (1,5,'2025-11-17','12:00:00','14:00:00','2025-11-05 04:07:54'),(2,5,'2025-11-24','12:00:00','14:00:00','2025-11-05 04:07:54'),(3,5,'2025-12-01','12:00:00','14:00:00','2025-11-05 04:07:54'),(4,5,'2025-12-08','12:00:00','14:00:00','2025-11-05 04:07:54'),(5,5,'2025-12-15','12:00:00','14:00:00','2025-11-05 04:07:54'),(6,5,'2025-12-22','12:00:00','14:00:00','2025-11-05 04:07:54'),(7,5,'2025-12-29','12:00:00','14:00:00','2025-11-05 04:07:54'),(8,5,'2026-01-05','12:00:00','14:00:00','2025-11-05 04:07:54'),(9,5,'2026-01-12','12:00:00','14:00:00','2025-11-05 04:07:54'),(10,5,'2026-01-19','12:00:00','14:00:00','2025-11-05 04:07:54'),(11,5,'2026-01-26','12:00:00','14:00:00','2025-11-05 04:07:54'),(12,5,'2026-02-02','12:00:00','14:00:00','2025-11-05 04:07:54'),(13,9,'2025-11-20','15:00:00','17:00:00','2025-11-05 04:34:42'),(14,9,'2025-11-27','15:00:00','17:00:00','2025-11-05 04:34:42'),(15,9,'2025-12-04','15:00:00','17:00:00','2025-11-05 04:34:42'),(16,9,'2025-12-11','15:00:00','17:00:00','2025-11-05 04:34:42'),(17,9,'2025-12-18','15:00:00','17:00:00','2025-11-05 04:34:42'),(18,9,'2025-12-25','15:00:00','17:00:00','2025-11-05 04:34:42'),(19,9,'2026-01-01','15:00:00','17:00:00','2025-11-05 04:34:42'),(20,9,'2026-01-08','15:00:00','17:00:00','2025-11-05 04:34:42'),(21,9,'2026-01-15','15:00:00','17:00:00','2025-11-05 04:34:42'),(22,9,'2026-01-22','15:00:00','17:00:00','2025-11-05 04:34:42'),(23,9,'2026-01-29','15:00:00','17:00:00','2025-11-05 04:34:42'),(24,9,'2026-02-05','15:00:00','17:00:00','2025-11-05 04:34:42'),(25,14,'2025-11-26','17:00:00','22:00:00','2025-11-06 05:56:08'),(26,14,'2025-12-03','17:00:00','22:00:00','2025-11-06 05:56:08'),(27,14,'2025-12-10','17:00:00','22:00:00','2025-11-06 05:56:08'),(28,14,'2025-12-17','17:00:00','22:00:00','2025-11-06 05:56:08'),(29,14,'2025-12-24','17:00:00','22:00:00','2025-11-06 05:56:08'),(30,14,'2025-12-31','17:00:00','22:00:00','2025-11-06 05:56:08'),(31,14,'2026-01-07','17:00:00','22:00:00','2025-11-06 05:56:08'),(32,14,'2026-01-14','17:00:00','22:00:00','2025-11-06 05:56:08'),(33,14,'2026-01-21','17:00:00','22:00:00','2025-11-06 05:56:08'),(34,14,'2026-01-28','17:00:00','22:00:00','2025-11-06 05:56:08'),(35,14,'2026-02-04','17:00:00','22:00:00','2025-11-06 05:56:08'),(36,14,'2026-02-11','17:00:00','22:00:00','2025-11-06 05:56:08');
/*!40000 ALTER TABLE `drumlesson_sessions` ENABLE KEYS */;
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
-- Table structure for table `otp_requests`
--

DROP TABLE IF EXISTS `otp_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `otp_requests` (
  `otpID` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `otpCode` varchar(10) NOT NULL,
  `expiresAt` datetime NOT NULL,
  `isUsed` tinyint(1) DEFAULT '0',
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`otpID`),
  KEY `userID` (`userID`),
  CONSTRAINT `otp_requests_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `otp_requests`
--

LOCK TABLES `otp_requests` WRITE;
/*!40000 ALTER TABLE `otp_requests` DISABLE KEYS */;
INSERT INTO `otp_requests` VALUES (1,38,'114188','2025-11-04 11:14:18',0,'2025-11-04 10:04:18'),(2,38,'848579','2025-11-04 11:14:30',0,'2025-11-04 10:04:30'),(3,41,'546305','2025-11-04 11:15:49',0,'2025-11-04 10:05:49'),(4,41,'965949','2025-11-04 11:16:17',0,'2025-11-04 10:06:17'),(5,41,'731448','2025-11-04 11:16:35',0,'2025-11-04 10:06:35'),(6,41,'742658','2025-11-04 11:16:52',0,'2025-11-04 10:06:52'),(7,41,'419755','2025-11-04 11:16:54',0,'2025-11-04 10:06:54'),(8,41,'495995','2025-11-04 11:18:37',0,'2025-11-04 10:08:37'),(9,41,'790685','2025-11-04 11:20:27',0,'2025-11-04 10:10:27'),(10,41,'603004','2025-11-04 11:23:55',0,'2025-11-04 10:13:55'),(11,41,'651519','2025-11-04 11:46:16',1,'2025-11-04 10:36:16'),(12,41,'458800','2025-11-04 11:47:55',0,'2025-11-04 10:37:55'),(13,41,'108216','2025-11-04 11:50:07',0,'2025-11-04 10:40:07'),(14,1,'254155','2025-11-04 15:04:03',0,'2025-11-04 13:54:03'),(15,1,'949794','2025-11-04 15:05:55',0,'2025-11-04 13:55:55'),(16,1,'608585','2025-11-04 15:06:25',0,'2025-11-04 13:56:25'),(17,1,'665316','2025-11-04 15:06:55',0,'2025-11-04 13:56:55'),(18,1,'107092','2025-11-04 22:50:02',0,'2025-11-04 21:40:02'),(19,1,'385575','2025-11-04 23:12:22',1,'2025-11-04 22:02:22'),(20,1,'267081','2025-11-04 23:14:54',1,'2025-11-04 22:04:54'),(21,1,'389587','2025-11-05 05:00:15',1,'2025-11-05 03:50:15'),(22,3,'541207','2025-11-05 05:14:20',1,'2025-11-05 04:04:20'),(23,4,'886012','2025-11-05 05:57:18',1,'2025-11-05 04:47:18'),(24,5,'963290','2025-11-05 06:08:49',0,'2025-11-05 04:58:49'),(25,1,'117861','2025-11-05 16:36:51',1,'2025-11-05 15:26:51'),(26,6,'715778','2025-11-06 06:53:11',0,'2025-11-06 05:43:11'),(27,6,'636665','2025-11-06 06:53:19',0,'2025-11-06 05:43:19'),(28,9,'737985','2025-11-08 10:23:33',0,'2025-11-08 09:13:33'),(29,9,'724749','2025-11-08 10:23:41',0,'2025-11-08 09:13:41'),(30,9,'212481','2025-11-08 10:23:46',1,'2025-11-08 09:13:46'),(31,10,'382402','2025-11-08 10:43:15',1,'2025-11-08 09:33:15'),(32,11,'690777','2025-11-10 10:23:38',0,'2025-11-10 09:13:38'),(33,12,'874975','2025-11-10 10:26:12',0,'2025-11-10 09:16:12'),(34,12,'521605','2025-11-10 10:26:50',1,'2025-11-10 09:16:50');
/*!40000 ALTER TABLE `otp_requests` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,1,1,150.00,'2025-11-04 14:19:31','GCash','Pending','23123123123','2025-11-04 21:19:31','2025-11-04 21:19:31'),(2,1,2,285.00,'2025-11-04 14:20:12','GCash','Pending','13123123','2025-11-04 21:20:12','2025-11-04 21:20:12'),(3,1,3,135.00,'2025-11-04 14:24:59','GCash','Pending','12313','2025-11-04 21:24:59','2025-11-04 21:24:59'),(4,3,5,3750.00,'2025-11-05 05:07:54','GCash','Pending','123123123123','2025-11-05 12:07:54','2025-11-05 12:07:54'),(5,3,6,420.00,'2025-11-05 05:11:59','GCash','Pending','123123123123123','2025-11-05 12:11:59','2025-11-05 12:11:59'),(6,3,7,2250.00,'2025-11-05 05:13:59','GCash','Pending','123123123123123','2025-11-05 12:13:59','2025-11-05 12:13:59'),(7,4,8,160.00,'2025-11-05 05:33:25','GCash','Pending','234234234234','2025-11-05 12:33:25','2025-11-05 12:33:25'),(8,4,9,3750.00,'2025-11-05 05:34:42','GCash','Pending','1212','2025-11-05 12:34:42','2025-11-05 12:34:42'),(9,5,10,135.00,'2025-11-05 05:57:59','GCash','Pending','123123123123123','2025-11-05 12:57:59','2025-11-05 12:57:59'),(10,4,11,800.00,'2025-11-05 13:28:56','GCash','Pending','98798798','2025-11-05 20:28:56','2025-11-05 20:28:56'),(11,6,12,685.00,'2025-11-06 06:42:05','GCash','Pending','213243256767676','2025-11-06 13:42:05','2025-11-06 13:42:05'),(12,7,13,170.00,'2025-11-06 06:49:13','GCash','Pending','123123123123','2025-11-06 13:49:13','2025-11-06 13:49:13'),(13,8,14,3750.00,'2025-11-06 06:56:08','GCash','Pending','123123123','2025-11-06 13:56:08','2025-11-06 13:56:08'),(14,9,15,335.00,'2025-11-08 10:09:40','GCash','Pending','123123123123123','2025-11-08 17:09:40','2025-11-08 17:09:40'),(15,10,16,275.00,'2025-11-08 10:32:17','GCash','Pending','123123','2025-11-08 17:32:17','2025-11-08 17:32:17'),(16,11,17,260.00,'2025-11-10 10:12:15','GCash','Pending','123123123123','2025-11-10 17:12:15','2025-11-10 17:12:15'),(17,12,19,325.00,'2025-11-10 10:21:44','GCash','Pending','123123123123123','2025-11-10 17:21:44','2025-11-10 17:21:44'),(18,1,20,270.00,'2025-11-13 23:31:12','GCash','Pending','123123123123','2025-11-14 06:31:12','2025-11-14 06:31:12'),(19,13,21,335.00,'2025-11-14 05:15:28','GCash','Pending','13123123','2025-11-14 12:15:28','2025-11-14 12:15:28');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recording_options`
--

LOCK TABLES `recording_options` WRITE;
/*!40000 ALTER TABLE `recording_options` DISABLE KEYS */;
INSERT INTO `recording_options` VALUES (1,7,'MultiTrack',1,'2025-11-05 04:13:59'),(2,11,'LiveTrack',0,'2025-11-05 12:28:55');
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
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation_additionals`
--

LOCK TABLES `reservation_additionals` WRITE;
/*!40000 ALTER TABLE `reservation_additionals` DISABLE KEYS */;
INSERT INTO `reservation_additionals` VALUES (1,1,1),(2,1,3),(3,1,5),(4,3,1),(5,4,1),(6,4,3),(7,4,5),(8,1,1),(9,1,3),(10,2,1),(11,2,3),(12,2,5),(13,3,1),(14,4,1),(15,6,1),(16,6,2),(17,6,3),(18,6,5),(19,8,1),(20,10,1),(21,12,1),(22,12,2),(23,12,3),(24,12,4),(25,12,5),(26,12,6),(27,13,1),(28,13,2),(29,13,3),(30,13,6),(31,15,1),(32,15,3),(33,15,5),(34,16,4),(35,16,5),(36,16,6),(37,17,1),(38,18,5),(39,19,3),(40,19,5),(41,20,1),(42,20,5),(43,21,1),(44,21,3),(45,21,5);
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation_receipts`
--

LOCK TABLES `reservation_receipts` WRITE;
/*!40000 ALTER TABLE `reservation_receipts` DISABLE KEYS */;
INSERT INTO `reservation_receipts` VALUES (1,1,'receipt','1762262371_Screenshot 2025-10-28 160436.png','2025-11-04 13:19:31'),(2,2,'receipt','1762262412_20251025_194224_0000.png','2025-11-04 13:20:12'),(3,3,'receipt','1762262699_Screenshot 2025-10-28 160436.png','2025-11-04 13:24:59'),(4,4,'receipt','1762315397_Picsart_25-10-25_20-28-12-386.png','2025-11-05 04:03:17'),(5,5,'receipt','1762315674_Picsart_25-10-25_20-28-12-386.png','2025-11-05 04:07:54'),(6,6,'receipt','1762315919_Picsart_25-10-25_20-28-12-386.png','2025-11-05 04:11:59'),(7,7,'receipt','1762316039_Picsart_25-10-25_20-28-12-386.png','2025-11-05 04:13:59'),(8,8,'receipt','1762317205_Picsart_25-10-25_20-28-12-386.png','2025-11-05 04:33:25'),(9,9,'receipt','1762317282_Picsart_25-10-25_20-28-12-386.png','2025-11-05 04:34:42'),(10,10,'receipt','1762318679_Contacts.png','2025-11-05 04:57:59'),(11,11,'receipt','1762345736_Screenshot 2025-10-28 160436.png','2025-11-05 12:28:56'),(12,12,'receipt','1762407725_Screenshot 2025-10-28 160436.png','2025-11-06 05:42:05'),(13,13,'receipt','1762408153_LogIn.png','2025-11-06 05:49:13'),(14,14,'receipt','1762408568_LogIn.png','2025-11-06 05:56:08'),(15,15,'receipt','1762592979_Screenshot 2025-10-28 160436.png','2025-11-08 09:09:39'),(16,16,'receipt','1762594337_Picsart_25-10-25_20-28-12-386.png','2025-11-08 09:32:17'),(17,17,'receipt','1762765935_Screenshot 2025-10-28 160436.png','2025-11-10 09:12:15'),(18,18,'receipt','1762766369_Picsart_25-10-25_20-28-12-386.png','2025-11-10 09:19:29'),(19,19,'receipt','1762766504_LogIn.png','2025-11-10 09:21:44'),(20,20,'receipt','1763073072_Picsart_25-11-07_19-21-59-545.png','2025-11-13 22:31:12'),(21,21,'receipt','1763093728_Picsart_25-11-07_19-21-59-545.png','2025-11-14 04:15:28');
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
INSERT INTO `reservations` VALUES (1,1,'asdasd',1,'2025-11-05','09:00:00','10:00:00',300.00,1,'2025-11-04 21:19:31'),(2,1,'asdasd',1,'2025-11-05','10:00:00','12:00:00',570.00,1,'2025-11-04 21:20:12'),(3,1,'qweqwe',1,'2025-11-04','21:00:00','22:00:00',270.00,1,'2025-11-04 21:24:59'),(4,3,'REMM Band',1,'2025-11-05','12:00:00','14:00:00',300.00,2,'2025-11-05 12:03:17'),(5,3,'',3,'2025-11-17','12:00:00','14:00:00',7500.00,1,'2025-11-05 12:07:54'),(6,3,'REMM Band',1,'2025-11-06','21:00:00','00:00:00',840.00,1,'2025-11-05 12:11:59'),(7,3,'',2,'2025-11-07','09:00:00','15:00:00',4500.00,1,'2025-11-05 12:13:59'),(8,4,'asdasda',1,'2025-11-07','09:00:00','10:00:00',320.00,1,'2025-11-05 12:33:25'),(9,4,'',3,'2025-11-20','15:00:00','17:00:00',7500.00,2,'2025-11-05 12:34:42'),(10,5,'n/a',1,'2025-11-13','22:00:00','23:00:00',270.00,1,'2025-11-05 12:57:59'),(11,4,'',2,'2025-11-17','12:00:00','14:00:00',1600.00,1,'2025-11-05 20:28:55'),(12,6,'Shabu shabu',1,'2025-11-11','13:00:00','18:00:00',1370.00,1,'2025-11-06 13:42:05'),(13,7,'Banda Dito',1,'2025-12-04','13:00:00','14:00:00',340.00,1,'2025-11-06 13:49:13'),(14,8,'',3,'2025-11-26','17:00:00','22:00:00',7500.00,1,'2025-11-06 13:56:08'),(15,9,'syntax error',1,'2025-11-14','10:00:00','12:00:00',670.00,2,'2025-11-08 17:09:39'),(16,10,'tomtom',1,'2025-11-27','12:00:00','14:00:00',550.00,1,'2025-11-08 17:32:17'),(17,11,'Andrei',1,'2025-11-19','10:00:00','12:00:00',520.00,1,'2025-11-10 17:12:15'),(18,12,'asdasd',1,'2025-11-15','10:00:00','12:00:00',0.00,1,'2025-11-10 17:19:29'),(19,12,'Dclass6',1,'2025-11-16','10:00:00','12:00:00',650.00,1,'2025-11-10 17:21:44'),(20,1,'Dclass6',1,'2025-11-18','10:00:00','12:00:00',540.00,2,'2025-11-14 06:31:12'),(21,13,'Dclass6',1,'2025-11-16','13:00:00','15:00:00',670.00,2,'2025-11-14 12:15:28');
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
INSERT INTO `user_details` VALUES (1,'Nakase','Mico','','09665270518','miconakaseyt@gmail.com','2025-11-14 06:28:58'),(2,'One','Admin','','09911111111','admin1@gmail.com','2025-11-04 20:59:32'),(3,'Kismundo','Mhyca','','09519614271','varonamhics@gmail.com','2025-11-05 12:06:06'),(4,'Esteban','Mac','','00000000','sfics.resteban@gmail.com','2025-11-05 12:28:25'),(5,'Pandaan','Sally','Borres','09454971983','pandaansally05@gmail.com','2025-11-05 12:55:56'),(6,'Tompong','Marc Francis','','09564162369','marcfrancis0119@gmail.com','2025-11-06 13:42:49'),(7,'Azucena','Robert Jasper','','09677839672','zakrider520@gmail.com','2025-11-06 13:47:52'),(8,'fuellas','joyce','Bangayan','09361858852','fuellasjoyce@gmail.com','2025-11-06 13:54:16'),(9,'Ragas','Chabs','','09993036971','ragasbella@gmail.com','2025-11-08 17:12:34'),(10,'Bangayan','Vanessa','Celaje','09897654345','vanessabangayan0105@gmail.com','2025-11-08 17:30:49'),(11,'Doe','Kaiden','','09877787765','alejandro1@gmail.com','2025-11-10 17:13:01'),(12,'Libunao','Alejandro','','09877787765','alejandrolibunao1@gmail.com','2025-11-10 17:16:36'),(13,'Buniel','Jennina Mae','Camacho','09877787765','jenninamaecb@gmail.com','2025-11-14 12:13:27'),(14,'Azucena','RJ','','09877787765','admin69@gmail.com','2025-11-18 19:18:54');
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'miconakase17','$2y$10$pyGqsdxWsKTk4tAhb4X7.uy71TfWmnktx/XXo6mRBinj0qhIj4doC',2,'2025-11-04 13:58:06',1),(2,'admin1','$2y$10$cvaPOrBKBwj8V318Ep7Dq.X1bmhpmKBFzGYJjVsKu.tf4HKe9kF6C',1,'2025-11-04 13:59:32',1),(3,'Mhics','$2y$10$.6GLQ6hLy633cuzJYiDxyOO.Z.YlA71swyHpb65R0qaa0osQ.cyGu',2,'2025-11-05 05:00:59',1),(4,'macesteban','$2y$10$7rxn5g41sYYR0iFhw625Ze4x05ePzmVmAt9jpU8CBxdCkMZ/QKG/6',2,'2025-11-05 05:28:25',1),(5,'lly05','$2y$10$8Z7fEJLl21kVS7tznhTgUeCqFJ3m/Oqz4sR.ep3AF31c4k4Tf4JbC',2,'2025-11-05 05:55:56',1),(6,'marcfrancis05','$2y$10$7bTMje6PyQVoA0wMGsLATemzCj/xHd70pRrdpfhixZpSe8oOTgXv2',2,'2025-11-06 06:40:56',1),(7,'rj_azucena','$2y$10$FHZHV/OBJg5U7ipRFZryiONEeryrRQPE80p1IBSHxQIjszDY4yqGu',2,'2025-11-06 06:46:58',1),(8,'jayxxxiii','$2y$10$g7w1Ny8dAwIh8.jAMFFf3OgRRr9oef7JzxXxHOf.2ms5pRyDeuXwq',2,'2025-11-06 06:54:16',1),(9,'itsmechargs','$2y$10$eNILT.xxzxSZS3Yu2Fe94.oTQ0orDT7Iq8yC4ZBdvKHCf6MnnBxri',2,'2025-11-08 10:05:49',1),(10,'vanessatomtom10','$2y$10$NIw9PylNSTDj6EEnQ0SkqOn/7qAFftXC.PsCbbMm3qGijbsfB0wqO',2,'2025-11-08 10:30:49',1),(11,'mrbeast','$2y$10$Zy5iFNxUpqOFjIYCUgqFLOKO1edB4S/4yhIYpnHrhhlGMJcBBCfmi',2,'2025-11-10 10:10:46',1),(12,'andrei','$2y$10$2ZL.wm9b3nzvyMqEnJh.g.o//xvv7jItrEmVGZvPyQCTyQZ6JXkny',2,'2025-11-10 10:15:33',1),(13,'jennina123','$2y$10$5b9mFvSCHNd.CEtBwY8De.RQcKqjz1vmetCxNnZxcqDL/Ud2JH9zi',2,'2025-11-14 05:13:27',1),(14,'rjmabangis','$2y$10$84fp52rO.UEzzjGHB0SXwuyog/JkL0br2XUNhM5iXFOV5QShyNo1C',1,'2025-11-18 12:18:54',1);
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

-- Dump completed on 2025-11-19 14:35:53
