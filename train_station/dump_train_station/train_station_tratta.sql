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
-- Table structure for table `tratta`
--

DROP TABLE IF EXISTS `tratta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tratta` (
  `id_tratta` int(11) NOT NULL AUTO_INCREMENT,
  `distanza_km` decimal(8,3) NOT NULL,
  `costo_biglietto` decimal(8,3) NOT NULL,
  `id_stazione_partenza` int(11) NOT NULL,
  `id_stazione_arrivo` int(11) NOT NULL,
  `data_orario_partenza` datetime NOT NULL,
  PRIMARY KEY (`id_tratta`),
  KEY `id_stazione_partenza_fk` (`id_stazione_partenza`),
  KEY `id_stazione_arrivo_fk` (`id_stazione_arrivo`),
  CONSTRAINT `id_stazione_arrivo_fk` FOREIGN KEY (`id_stazione_arrivo`) REFERENCES `stazione` (`id_stazione`),
  CONSTRAINT `id_stazione_partenza_fk` FOREIGN KEY (`id_stazione_partenza`) REFERENCES `stazione` (`id_stazione`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tratta`
--

LOCK TABLES `tratta` WRITE;
/*!40000 ALTER TABLE `tratta` DISABLE KEYS */;
INSERT INTO `tratta` VALUES (15,31.500,7.875,1,7,'2023-12-14 10:53:37'),(16,12.680,3.170,1,4,'2023-12-14 10:55:34'),(17,12.680,3.170,1,4,'2023-12-14 10:56:56'),(18,7.580,1.895,1,3,'2023-12-14 14:24:12'),(19,16.900,4.225,1,5,'2023-12-14 14:36:09');
/*!40000 ALTER TABLE `tratta` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-14 14:38:42
