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
  `id_utente` int(11) NOT NULL,
  `posto` int(11) NOT NULL,
  PRIMARY KEY (`id_tratta`),
  KEY `id_stazione_partenza_fk` (`id_stazione_partenza`),
  KEY `id_stazione_arrivo_fk` (`id_stazione_arrivo`),
  KEY `id_utente_fk` (`id_utente`),
  CONSTRAINT `id_stazione_arrivo_fk` FOREIGN KEY (`id_stazione_arrivo`) REFERENCES `stazione` (`id_stazione`),
  CONSTRAINT `id_stazione_partenza_fk` FOREIGN KEY (`id_stazione_partenza`) REFERENCES `stazione` (`id_stazione`),
  CONSTRAINT `id_utente_fk` FOREIGN KEY (`id_utente`) REFERENCES `utenti_registrati_train` (`id_utente`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tratta`
--

LOCK TABLES `tratta` WRITE;
/*!40000 ALTER TABLE `tratta` DISABLE KEYS */;
INSERT INTO `tratta` VALUES (1,28.800,7.200,2,7,'2024-01-07 09:56:29',3,99);
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

-- Dump completed on 2024-01-07 11:08:11
