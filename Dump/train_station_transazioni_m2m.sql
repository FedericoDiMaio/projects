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
-- Table structure for table `transazioni_m2m`
--

DROP TABLE IF EXISTS `transazioni_m2m`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transazioni_m2m` (
  `TransazioneM2MID` int(11) NOT NULL AUTO_INCREMENT,
  `URLInviante` varchar(255) NOT NULL,
  `URLRisposta` varchar(255) NOT NULL,
  `EsercenteID` int(11) DEFAULT NULL,
  `Descrizione` varchar(255) NOT NULL,
  `PrezzoTransazione` decimal(10,2) NOT NULL,
  PRIMARY KEY (`TransazioneM2MID`),
  KEY `EsercenteID` (`EsercenteID`),
  CONSTRAINT `transazioni_m2m_ibfk_1` FOREIGN KEY (`EsercenteID`) REFERENCES `esercenti` (`EsercenteID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transazioni_m2m`
--

LOCK TABLES `transazioni_m2m` WRITE;
/*!40000 ALTER TABLE `transazioni_m2m` DISABLE KEYS */;
INSERT INTO `transazioni_m2m` VALUES (1,'https://webstudenti.unimarconi.it/f.dimaio/projects/train_station/client.php','https://webstudenti.unimarconi.it/f.dimaio/projects/train_station/server.php',1,'biglietto treno',7.20),(2,'https://webstudenti.unimarconi.it/f.dimaio/projects/train_station/client.php','https://webstudenti.unimarconi.it/f.dimaio/projects/train_station/server.php',1,'biglietto treno',7.20);
/*!40000 ALTER TABLE `transazioni_m2m` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-07 11:08:12
