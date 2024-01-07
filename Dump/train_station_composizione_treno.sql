-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: train_station
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.28-MariaDB

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
-- Table structure for table `composizione_treno`
--

DROP TABLE IF EXISTS `composizione_treno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `composizione_treno` (
  `id_treno` int(11) NOT NULL AUTO_INCREMENT,
  `id_carrozze` varchar(45) NOT NULL,
  `id_locomotive` varchar(45) NOT NULL,
  `numero_posti_totale` int(11) NOT NULL,
  `data_inizio_servizio` datetime NOT NULL,
  `data_fine_servizio` datetime NOT NULL,
  PRIMARY KEY (`id_treno`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `composizione_treno`
--

LOCK TABLES `composizione_treno` WRITE;
/*!40000 ALTER TABLE `composizione_treno` DISABLE KEYS */;
INSERT INTO `composizione_treno` VALUES (5,'1,2,3,4','2,3',156,'2023-10-30 00:00:00','2024-02-04 00:00:00'),(7,'2,3','1,2',72,'2023-12-25 00:00:00','2024-02-04 00:00:00'),(9,'1,2,3,4','2,3',156,'2023-08-28 00:00:00','2023-09-28 00:00:00'),(10,'1,2,3','2',108,'2023-11-27 00:00:00','2023-12-29 00:00:00'),(14,'1,2,3,4','2,3',156,'2023-12-25 00:00:00','2024-02-01 00:00:00');
/*!40000 ALTER TABLE `composizione_treno` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-07 11:08:11
