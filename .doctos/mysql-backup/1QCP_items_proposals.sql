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
-- Table structure for table `items_proposals`
--

DROP TABLE IF EXISTS `items_proposals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `items_proposals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` decimal(8,2) NOT NULL,
  `proposal_id` bigint unsigned NOT NULL,
  `service_id` bigint unsigned NOT NULL,
  `item_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `items_proposals_proposal_id_foreign` (`proposal_id`),
  KEY `items_proposals_service_id_foreign` (`service_id`),
  KEY `items_proposals_item_id_foreign` (`item_id`),
  CONSTRAINT `items_proposals_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `items_proposals_proposal_id_foreign` FOREIGN KEY (`proposal_id`) REFERENCES `proposals` (`id`) ON DELETE CASCADE,
  CONSTRAINT `items_proposals_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items_proposals`
--

LOCK TABLES `items_proposals` WRITE;
/*!40000 ALTER TABLE `items_proposals` DISABLE KEYS */;
INSERT INTO `items_proposals` VALUES (1,NULL,1.00,1,1,1,'2024-03-20 04:33:21','2024-03-20 04:33:21'),(2,NULL,12.00,1,1,2,'2024-03-20 04:33:21','2024-03-20 04:33:21'),(3,NULL,123.00,1,1,3,'2024-03-20 04:33:21','2024-03-20 04:33:21'),(4,NULL,2.00,1,3,1,'2024-03-20 15:40:16','2024-03-20 15:40:16'),(5,NULL,22.00,1,3,2,'2024-03-20 15:40:16','2024-03-20 15:40:16'),(6,NULL,223.00,1,3,3,'2024-03-20 15:40:16','2024-03-20 15:40:16'),(7,NULL,33.00,1,4,1,'2024-03-20 15:40:16','2024-03-20 15:40:16'),(8,NULL,331.00,1,4,2,'2024-03-20 15:40:16','2024-03-20 15:40:16'),(9,NULL,441.00,1,5,2,'2024-03-20 15:40:17','2024-03-20 15:40:17'),(10,NULL,925.00,2,9,2,'2024-03-22 17:24:55','2024-03-22 17:28:31'),(11,NULL,925.00,2,10,4,'2024-03-22 17:28:31','2024-03-22 17:28:31'),(12,NULL,470.00,3,2,1,'2024-03-26 18:34:34','2024-03-26 18:34:34'),(13,NULL,515.00,3,2,2,'2024-03-26 18:34:34','2024-03-26 18:34:34'),(14,NULL,615.00,3,2,4,'2024-03-26 18:34:34','2024-03-26 18:34:34'),(15,NULL,705.00,3,2,7,'2024-03-26 18:34:34','2024-03-26 18:34:34'),(16,NULL,125.00,3,11,1,'2024-03-26 18:34:34','2024-03-26 18:34:34'),(17,NULL,200.00,3,11,2,'2024-03-26 18:34:34','2024-03-26 18:34:34'),(18,NULL,250.00,3,11,4,'2024-03-26 18:34:34','2024-03-26 18:34:34'),(19,NULL,300.00,3,11,7,'2024-03-26 18:34:34','2024-03-26 18:34:34'),(20,NULL,220.00,3,3,1,'2024-03-26 18:34:34','2024-03-26 18:34:34'),(21,NULL,220.00,3,3,2,'2024-03-26 18:34:34','2024-03-26 18:34:34'),(22,NULL,230.00,3,3,4,'2024-03-26 18:34:34','2024-03-26 18:34:34'),(23,NULL,240.00,3,3,7,'2024-03-26 18:34:34','2024-03-26 18:34:34'),(24,NULL,135.00,3,5,1,'2024-03-26 18:34:34','2024-03-26 18:34:34'),(25,NULL,150.00,3,6,1,'2024-03-26 18:34:34','2024-03-26 18:34:34');
/*!40000 ALTER TABLE `items_proposals` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-04-09 21:11:10
