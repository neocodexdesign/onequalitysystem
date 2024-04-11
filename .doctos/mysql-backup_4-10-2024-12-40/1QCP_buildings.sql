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
-- Table structure for table `buildings`
--

DROP TABLE IF EXISTS `buildings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `buildings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_wwd` varchar(145) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contract` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `property_id` bigint unsigned NOT NULL,
  `assistant_id` bigint unsigned NOT NULL,
  `maintenance_id` bigint unsigned NOT NULL,
  `technician_id` bigint unsigned NOT NULL,
  `wwdpay_id` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `buildings_property_id_foreign` (`property_id`),
  KEY `buildings_assistant_id_foreign` (`assistant_id`),
  KEY `buildings_maintenance_id_foreign` (`maintenance_id`),
  KEY `buildings_technician_id_foreign` (`technician_id`),
  CONSTRAINT `buildings_assistant_id_foreign` FOREIGN KEY (`assistant_id`) REFERENCES `assistants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `buildings_maintenance_id_foreign` FOREIGN KEY (`maintenance_id`) REFERENCES `maintenances` (`id`) ON DELETE CASCADE,
  CONSTRAINT `buildings_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE,
  CONSTRAINT `buildings_technician_id_foreign` FOREIGN KEY (`technician_id`) REFERENCES `technicians` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buildings`
--

LOCK TABLES `buildings` WRITE;
/*!40000 ALTER TABLE `buildings` DISABLE KEYS */;
INSERT INTO `buildings` VALUES (1,'PROSPECT UNION SQUARE','PROSPECT UNION SQUARE','(877) 432-6303','Robert.Ferdinand@bozzuto.com','www.prospectunionsquare.com','50 Prospect Street','Somerville','Massachusetts','02143','United States',NULL,NULL,1,1,1,1,1,'2024-03-18 18:45:16','2024-04-07 22:05:01'),(2,'J WOBURN HEIGHTS','J WOBURN','(339) 220-4428','jzirpolo@jagmgt.com','https://jwoburnheightsapartments.com','1042 Main Street','Woburn','Massachusetts','01801','United States',NULL,NULL,1,1,1,1,1,'2024-03-18 18:56:28','2024-04-07 22:06:42'),(3,'The Aven at Newton Highlands','The Aven ','(617) 332-9332','theavenleadmaint@willowbridgepc.com','https://www.theavenapts.com','99 Needham Street','Newton','Massachusetts','02461','United States',NULL,NULL,1,1,1,1,1,'2024-03-18 19:02:31','2024-04-07 22:08:12'),(4,'UDR Union Place','UDR','(508) 657-3907','slaroche@udr.com','https://www.udr.com/boston-apartments/franklin/union-place/','10 Independence Way','Franklin','Massachusetts','02038','United States',NULL,'[\"01HSK8KT9MEEEK7K8DT7081NJH.pdf\"]',1,1,1,1,1,'2024-03-18 19:10:59','2024-04-07 22:09:44'),(5,'PARK LANE SEAPORT ','PARK LANE','(833) 822-4399','parklane@bozzuto.com','https://www.parklaneseaport.com/','One Park Lane ','Boston','MA','02210 ','United States',NULL,'[\"01HT5JQRQZD14W0A907YWAWHQE.pdf\"]',1,1,1,1,1,'2024-03-26 17:46:58','2024-04-07 21:52:25');
/*!40000 ALTER TABLE `buildings` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-04-10  0:40:30
