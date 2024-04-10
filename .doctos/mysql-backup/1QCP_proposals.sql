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
-- Table structure for table `proposals`
--

DROP TABLE IF EXISTS `proposals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proposals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `titulo_geral` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_cover` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_cover` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titulo_images` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `titulo_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `addition_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `additional_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `thanks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `building_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `proposals_building_id_foreign` (`building_id`),
  CONSTRAINT `proposals_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proposals`
--

LOCK TABLES `proposals` WRITE;
/*!40000 ALTER TABLE `proposals` DISABLE KEYS */;
INSERT INTO `proposals` VALUES (1,'TURN PAINT AND CLEAN - 2024 Proposal','John Zirpolo','01HSESVXD4AMRJM4JZ7JN8YK1D.jpg','01HSEST8DBRQ79VRGVC24T77TR.jpg',NULL,NULL,'Unit Turns Description:','<ul><li>Cover entire floor perimeter with drop cloth&nbsp;</li><li>Paint doors and trim - 1 coat</li><li>Paint baseboards - 1 coat</li><li>Paint walls - 1 coat</li><li>Paint front door&nbsp; - 1 coat</li><li>Paint with brush and rollers only (no spray)</li><li>No paint on sprinklers</li><li>Professional cleaning after paint job.</li></ul>','<p><em>Please note that 2 coats, drywall repairs and excessive amounts of patching or caulking will be charged extra</em><br><br></p>','<ul><li>All Osha safety procedures always followed.</li><li>Workers in company shirts.</li><li>End of day job area cleanup.</li><li>All materials and equipment included (except paint).</li></ul>','<p>Thank you for your business. <br>Its a pleasure to work with you on your project.<br>Sincerely yours,<br><strong>One Quality Services Inc.</strong></p>',2,'2024-03-20 04:30:36','2024-03-20 20:46:57'),(2,'TURN PAINT AND CLEAN - 2024 Proposal','Stanley ','01HSKK3DT14759E2WZX44G5VP8.jpg','01HSKK3DS5FMH3MNKD6KVZA331.jpg',NULL,NULL,'Unit Turns Description:','<ul><li>Cover entire floor perimeter with drop cloth&nbsp;</li><li>Paint doors and trim - 1 coat</li><li>Paint baseboards - 1 coat</li><li>Paint walls - 1 coat</li><li>Paint front door&nbsp; - 1 coat</li><li>Paint with brush and rollers only (no spray)</li><li>No paint on sprinklers</li><li>Professional cleaning after paint job.</li><li>Check list maintenance&nbsp;</li></ul><p><br></p>','<p><strong>Please note that 2 coats, drywall repairs and excessive amounts of patching or caulking will be charged extra</strong></p>','<ul><li>All Osha safety procedures always followed.</li><li>Workers in company shirts.</li><li>End of day job area cleanup.</li><li>All materials and equipment included (except paint).</li></ul><p><br><br><br></p><p><br></p><p><br><br></p>','<p><strong>* We’ll provide one technician to complete the standard maintenance checklist provided by the property.</strong><br><br><br>Thank you for your business. It\'s a pleasure to work with you on your project.</p><p>Sincerely yours,</p><p><strong>One Quality Services Inc.</strong></p>',4,'2024-03-22 17:24:55','2024-03-22 17:24:55'),(3,'TURN PAINT AND CLEAN - 2024 Proposal','Eric Higdon','01HTRSWG4WQYW44D42MQZGKYFF.jpg','01HTRSWG4TP584NK23G6YCNC59.jpg',NULL,NULL,'Unit Turns Description:','<ul><li>Cover entire floor perimeter with drop cloth&nbsp;</li><li>Paint doors and trim - 1 coat&nbsp;</li><li>Paint baseboards - 1 coat</li><li>Paint walls - 1 coat</li><li>Paint front door - 1 coat</li><li>Paint with brush and rollers only (no spray)</li><li>No paint on sprinklers</li><li>Professional cleaning after paint job.&nbsp;</li><li>Carpet shampoo</li></ul><p><br></p>','<p>&nbsp;*Please note that 2 coats, drywall repairs and excessive amounts of patching or caulking will be charged extra&nbsp;</p>','<p>&nbsp;Additional Notes:&nbsp;</p>','<ul><li>All Osha safety procedures always followed.&nbsp;</li><li>Workers in company shirts.&nbsp;</li><li>End of day job area cleanup.&nbsp;</li><li>All materials and equipment included (except paint).&nbsp;</li></ul>',5,'2024-03-26 18:34:33','2024-04-06 00:15:22');
/*!40000 ALTER TABLE `proposals` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-04-09 21:11:21
