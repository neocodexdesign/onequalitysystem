-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: 1QCP
-- ------------------------------------------------------
-- Server version	8.0.36-0ubuntu0.23.10.1

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
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `building_id` bigint unsigned DEFAULT NULL,
  `teamleader_id` bigint unsigned DEFAULT NULL,
  `service_id` bigint unsigned DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `from` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `unit` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `service_date` datetime DEFAULT NULL,
  `startDate` datetime DEFAULT NULL,
  `endDate` datetime DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paint_date` datetime DEFAULT NULL,
  `cleaning_date` datetime DEFAULT NULL,
  `startDateTime` datetime DEFAULT NULL,
  `endDateTime` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `building` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `team` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `building_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_building_id_foreign` (`building_id`),
  KEY `orders_service_id_foreign` (`service_id`),
  KEY `orders_teamleader_id_foreign` (`teamleader_id`),
  CONSTRAINT `orders_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_teamleader_id_foreign` FOREIGN KEY (`teamleader_id`) REFERENCES `teamleaders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=525 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (481,5,9,1,NULL,'Automatic Created Order From OQS 1.0',NULL,'J-1014','2',NULL,'2024-04-01 00:00:00',NULL,NULL,'DONE',NULL,NULL,NULL,NULL,'2024-04-01 14:45:59','2024-04-04 10:54:41',NULL,NULL,NULL),(482,5,12,3,NULL,'Automatic Created Order From OQS 1.0',NULL,'J-1014','2',NULL,'2024-04-02 00:00:00',NULL,NULL,'DONE',NULL,NULL,NULL,NULL,'2024-04-01 14:45:59','2024-04-05 11:34:21',NULL,NULL,NULL),(483,5,9,1,'PAULO + CLAUDEMIR','Automatic Created Order From OQS 1.0',NULL,'G-0204','1',NULL,'2024-04-02 00:00:00',NULL,NULL,'DONE',NULL,NULL,NULL,NULL,'2024-04-01 14:45:59','2024-04-04 10:57:18',NULL,NULL,NULL),(484,5,12,3,NULL,'Automatic Created Order From OQS 1.0',NULL,'G-0204','1',NULL,'2024-04-03 00:00:00',NULL,NULL,'DONE',NULL,NULL,NULL,NULL,'2024-04-01 14:45:59','2024-04-05 11:34:40',NULL,NULL,NULL),(485,5,9,1,'1 BED','Automatic Created Order From OQS 1.0',NULL,'G-0216','1',NULL,'2024-04-02 00:00:00',NULL,NULL,'DONE',NULL,NULL,NULL,NULL,'2024-04-01 14:45:59','2024-04-04 10:58:01',NULL,NULL,NULL),(486,5,12,3,NULL,'Automatic Created Order From OQS 1.0',NULL,'G-0216','1',NULL,'2024-04-03 00:00:00',NULL,NULL,'DONE',NULL,NULL,NULL,NULL,'2024-04-01 14:45:59','2024-04-05 11:34:59',NULL,NULL,NULL),(487,2,1,1,'Teste aqui','Automatic Created Order From OQS 1.0',NULL,'G-0802','1',NULL,'2024-04-08 00:00:00',NULL,NULL,'DONE',NULL,NULL,NULL,NULL,'2024-04-01 14:45:59','2024-04-06 21:31:32',NULL,NULL,NULL),(488,2,12,3,NULL,'Automatic Created Order From OQS 1.0',NULL,'G-0802','1',NULL,'2024-04-09 00:00:00',NULL,NULL,'DONE',NULL,NULL,NULL,NULL,'2024-04-01 14:45:59','2024-04-05 12:10:09',NULL,NULL,NULL),(489,5,NULL,1,NULL,'Automatic Created Order From OQS 1.0',NULL,'G-1212',NULL,NULL,'2024-04-09 00:00:00',NULL,NULL,'CREATED',NULL,NULL,NULL,NULL,'2024-04-01 14:46:00','2024-04-01 14:46:00',NULL,NULL,NULL),(490,2,1,3,'Troquei aqui ','Automatic Created Order From OQS 1.0',NULL,'G-1212','2',NULL,'2024-04-10 00:00:00',NULL,NULL,'DONE',NULL,NULL,NULL,NULL,'2024-04-01 14:46:00','2024-04-06 21:32:21',NULL,NULL,NULL),(491,5,NULL,1,NULL,'Automatic Created Order From OQS 1.0',NULL,'J-0210',NULL,NULL,'2024-04-09 00:00:00',NULL,NULL,'CREATED',NULL,NULL,NULL,NULL,'2024-04-01 14:46:00','2024-04-01 14:46:00',NULL,NULL,NULL),(492,5,NULL,3,NULL,'Automatic Created Order From OQS 1.0',NULL,'J-0210',NULL,NULL,'2024-04-10 00:00:00',NULL,NULL,'CREATED',NULL,NULL,NULL,NULL,'2024-04-01 14:46:00','2024-04-01 14:46:00',NULL,NULL,NULL),(493,5,NULL,1,NULL,'Automatic Created Order From OQS 1.0',NULL,'G-0212',NULL,NULL,'2024-04-15 00:00:00',NULL,NULL,'CREATED',NULL,NULL,NULL,NULL,'2024-04-01 14:46:00','2024-04-01 14:46:00',NULL,NULL,NULL),(494,5,NULL,3,NULL,'Automatic Created Order From OQS 1.0',NULL,'G-0212',NULL,NULL,'2024-04-16 00:00:00',NULL,NULL,'CREATED',NULL,NULL,NULL,NULL,'2024-04-01 14:46:00','2024-04-01 14:46:00',NULL,NULL,NULL),(495,5,NULL,1,NULL,'Automatic Created Order From OQS 1.0',NULL,'G-0412',NULL,NULL,'2024-04-16 00:00:00',NULL,NULL,'CREATED',NULL,NULL,NULL,NULL,'2024-04-01 14:46:00','2024-04-01 14:46:00',NULL,NULL,NULL),(496,5,NULL,3,NULL,'Automatic Created Order From OQS 1.0',NULL,'G-0412',NULL,NULL,'2024-04-17 00:00:00',NULL,NULL,'CREATED',NULL,NULL,NULL,NULL,'2024-04-01 14:46:00','2024-04-01 14:46:00',NULL,NULL,NULL),(497,5,NULL,1,NULL,'Automatic Created Order From OQS 1.0',NULL,'G-0313',NULL,NULL,'2024-04-19 00:00:00',NULL,NULL,'CREATED',NULL,NULL,NULL,NULL,'2024-04-01 14:46:00','2024-04-01 14:46:00',NULL,NULL,NULL),(498,5,NULL,3,NULL,'Automatic Created Order From OQS 1.0',NULL,'G-0313',NULL,NULL,'2024-04-22 00:00:00',NULL,NULL,'CREATED',NULL,NULL,NULL,NULL,'2024-04-01 14:46:00','2024-04-01 14:46:00',NULL,NULL,NULL),(499,5,NULL,1,NULL,'Automatic Created Order From OQS 1.0',NULL,'G-1313',NULL,NULL,'2024-04-22 00:00:00',NULL,NULL,'CREATED',NULL,NULL,NULL,NULL,'2024-04-01 14:46:00','2024-04-01 14:46:00',NULL,NULL,NULL),(500,5,NULL,3,NULL,'Automatic Created Order From OQS 1.0',NULL,'G-1313',NULL,NULL,'2024-04-23 00:00:00',NULL,NULL,'CREATED',NULL,NULL,NULL,NULL,'2024-04-01 14:46:00','2024-04-01 14:46:00',NULL,NULL,NULL),(501,5,NULL,1,NULL,'Automatic Created Order From OQS 1.0',NULL,'G-0615',NULL,NULL,'2024-04-24 00:00:00',NULL,NULL,'CREATED',NULL,NULL,NULL,NULL,'2024-04-01 14:46:00','2024-04-01 14:46:00',NULL,NULL,NULL),(502,5,NULL,3,NULL,'Automatic Created Order From OQS 1.0',NULL,'G-0615',NULL,NULL,'2024-04-25 00:00:00',NULL,NULL,'CREATED',NULL,NULL,NULL,NULL,'2024-04-01 14:46:00','2024-04-01 14:46:00',NULL,NULL,NULL),(503,5,NULL,1,NULL,'Automatic Created Order From OQS 1.0',NULL,'J-0619',NULL,NULL,'2024-04-29 00:00:00',NULL,NULL,'CREATED',NULL,NULL,NULL,NULL,'2024-04-01 14:46:01','2024-04-01 14:46:01',NULL,NULL,NULL),(504,5,NULL,3,NULL,'Automatic Created Order From OQS 1.0',NULL,'J-0619',NULL,NULL,'2024-04-30 00:00:00',NULL,NULL,'CREATED',NULL,NULL,NULL,NULL,'2024-04-01 14:46:01','2024-04-01 14:46:01',NULL,NULL,NULL),(505,5,NULL,1,NULL,'Automatic Created Order From OQS 1.0',NULL,'J-0418',NULL,NULL,'2024-05-01 00:00:00',NULL,NULL,'CREATED',NULL,NULL,NULL,NULL,'2024-04-01 14:46:01','2024-04-01 14:46:01',NULL,NULL,NULL),(506,5,NULL,3,NULL,'Automatic Created Order From OQS 1.0',NULL,'J-0418',NULL,NULL,'2024-05-02 00:00:00',NULL,NULL,'CREATED',NULL,NULL,NULL,NULL,'2024-04-01 14:46:01','2024-04-01 14:46:01',NULL,NULL,NULL),(507,5,NULL,1,NULL,'Automatic Created Order From OQS 1.0',NULL,'J-0812',NULL,NULL,'2024-05-01 00:00:00',NULL,NULL,'CREATED',NULL,NULL,NULL,NULL,'2024-04-01 14:46:01','2024-04-01 14:46:01',NULL,NULL,NULL),(508,5,NULL,3,NULL,'Automatic Created Order From OQS 1.0',NULL,'J-0812',NULL,NULL,'2024-05-02 00:00:00',NULL,NULL,'CREATED',NULL,NULL,NULL,NULL,'2024-04-01 14:46:01','2024-04-01 14:46:01',NULL,NULL,NULL),(509,5,NULL,1,NULL,'Automatic Created Order From OQS 1.0',NULL,'J-1908',NULL,NULL,'2024-05-01 00:00:00',NULL,NULL,'CREATED',NULL,NULL,NULL,NULL,'2024-04-01 14:46:01','2024-04-01 14:46:01',NULL,NULL,NULL),(510,5,NULL,3,NULL,'Automatic Created Order From OQS 1.0',NULL,'J-1908',NULL,NULL,'2024-05-02 00:00:00',NULL,NULL,'CREATED',NULL,NULL,NULL,NULL,'2024-04-01 14:46:01','2024-04-01 14:46:01',NULL,NULL,NULL),(511,5,NULL,1,NULL,'Automatic Created Order From OQS 1.0',NULL,'G-0520',NULL,NULL,'2024-05-02 00:00:00',NULL,NULL,'CREATED',NULL,NULL,NULL,NULL,'2024-04-01 14:46:01','2024-04-01 14:46:01',NULL,NULL,NULL),(512,5,NULL,3,NULL,'Automatic Created Order From OQS 1.0',NULL,'G-0520',NULL,NULL,'2024-05-03 00:00:00',NULL,NULL,'CREATED',NULL,NULL,NULL,NULL,'2024-04-01 14:46:01','2024-04-01 14:46:01',NULL,NULL,NULL),(513,5,NULL,1,NULL,'Automatic Created Order From OQS 1.0',NULL,'G-1211',NULL,NULL,'2024-05-02 00:00:00',NULL,NULL,'CREATED',NULL,NULL,NULL,NULL,'2024-04-01 14:46:01','2024-04-01 14:46:01',NULL,NULL,NULL),(514,5,NULL,3,NULL,'Automatic Created Order From OQS 1.0',NULL,'G-1211',NULL,NULL,'2024-05-03 00:00:00',NULL,NULL,'CREATED',NULL,NULL,NULL,NULL,'2024-04-01 14:46:01','2024-04-01 14:46:01',NULL,NULL,NULL),(515,5,NULL,1,NULL,'Automatic Created Order From OQS 1.0',NULL,'G-0822',NULL,NULL,'2024-05-06 00:00:00',NULL,NULL,'CREATED',NULL,NULL,NULL,NULL,'2024-04-01 14:46:01','2024-04-01 14:46:01',NULL,NULL,NULL),(516,5,NULL,3,NULL,'Automatic Created Order From OQS 1.0',NULL,'G-0822',NULL,NULL,'2024-05-07 00:00:00',NULL,NULL,'CREATED',NULL,NULL,NULL,NULL,'2024-04-01 14:46:01','2024-04-01 14:46:01',NULL,NULL,NULL),(521,5,NULL,13,'I have 2 doors there that need to wither have the hungers moved on them or a new door to be cut and installed ',NULL,NULL,'J1603','1',NULL,'2024-04-01 10:50:06',NULL,NULL,'DONE',NULL,NULL,NULL,NULL,'2024-04-04 10:51:54','2024-04-04 10:51:54',NULL,NULL,NULL),(522,5,NULL,13,'UNIDADE ESTA BEM DETONADA - FIX',NULL,NULL,'J305','2',NULL,'2024-04-02 10:58:58',NULL,NULL,'DONE',NULL,NULL,NULL,NULL,'2024-04-04 10:59:18','2024-04-04 10:59:18',NULL,NULL,NULL),(523,5,NULL,14,'1 BED - Gastou 3 Horas.\nGastou 30$ de Material',NULL,NULL,'G308','1',NULL,'2024-04-02 10:59:55',NULL,NULL,'DONE',NULL,NULL,NULL,NULL,'2024-04-04 11:01:43','2024-04-04 11:01:43',NULL,NULL,NULL),(524,5,NULL,13,'MIRROR PAINT',NULL,NULL,'MIRROR PAINT',NULL,NULL,'2024-04-06 11:05:30',NULL,NULL,'SCHEDULE',NULL,NULL,NULL,NULL,'2024-04-04 11:06:31','2024-04-04 11:06:31',NULL,NULL,NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-04-09 21:11:45