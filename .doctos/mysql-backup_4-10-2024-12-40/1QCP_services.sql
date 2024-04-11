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
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_order` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,'Turn Cost With Paint Included (1 Coat)','PAINT','2024-03-19 19:42:51','2024-03-19 19:42:51'),(2,'Turn Cost Without Paint (1 coat)','PAINT WITH PAINT','2024-03-19 19:43:17','2024-03-19 19:43:17'),(3,'Professional Cleaning','CLEANING','2024-03-19 19:43:25','2024-03-26 18:25:36'),(4,'Carpet Shampoo','CARPET SHAMPOO','2024-03-19 19:43:35','2024-03-19 19:43:35'),(5,'Accent Wall','ACCENT WALL','2024-03-19 19:43:48','2024-03-19 19:43:48'),(6,'Patch works*','PATCH WORKS','2024-03-22 17:25:25','2024-03-26 18:26:39'),(7,'Small Patch','SMALL PATCH','2024-03-22 17:25:27','2024-03-22 17:26:50'),(8,'Big Patch','BIG PATCH','2024-03-22 17:26:09','2024-03-22 17:26:09'),(9,'Bedroom Units (1 coat) / Cleaning / Maintenance','Bedroom Units (1 coat) / Cleaning / Maintenance','2024-03-22 17:27:16','2024-03-22 17:27:16'),(10,'Bedroom Units (1 coat) / Cleaning / Maintenance','Bedroom Units (1 coat) / Cleaning / Maintenance','2024-03-22 17:27:34','2024-03-22 17:27:34'),(11,'Ceiling Paint - 1 Coat','CEILING PAINT - 1 COAT','2024-03-26 18:28:09','2024-03-26 18:28:09'),(13,'Special Service / Mantenance','Special Service / Mantenance','2024-04-04 10:51:29','2024-04-04 10:51:29'),(14,'Drywall Repair','Drywall Repair','2024-04-04 11:01:28','2024-04-04 11:01:28');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-04-10  0:40:36
