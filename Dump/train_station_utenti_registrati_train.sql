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
-- Table structure for table `utenti_registrati_train`
--

DROP TABLE IF EXISTS `utenti_registrati_train`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `utenti_registrati_train` (
  `id_utente` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `cognome` varchar(45) NOT NULL,
  `codice_fiscale` varchar(255) NOT NULL,
  `data_di_nascita` datetime NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ruolo` varchar(45) NOT NULL DEFAULT 'registrato',
  PRIMARY KEY (`id_utente`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utenti_registrati_train`
--

LOCK TABLES `utenti_registrati_train` WRITE;
/*!40000 ALTER TABLE `utenti_registrati_train` DISABLE KEYS */;
INSERT INTO `utenti_registrati_train` VALUES (1,'Train','Station','STTTRN24S01F205Z','2024-01-01 00:00:00','train.station@esercizio.it','$2y$10$iQPsSUaVzCnOFtYfBzHrQ.q1mZ875NtzHf3xE5wQnPWFqXazaTFZa','esercizio'),(2,'Carlo','Rossi','RSSCRL70A01F205W','1970-01-01 00:00:00','carlo.rossi@amministrativo.it','$2y$10$k3s7ZhIKzp.kY9oWAyzs1OgJRzFZ74yG3tHBxgqzJFUDd/K2Hk3Tu','amministrativo'),(3,'Federico','Di Maio','DMIFRC90D04F205J','1990-04-04 00:00:00','f.dimaio@registrato.it','$2y$10$4IruR.AXjoMEwzb5O4jZpeZTISIQWhM7me6l1bThAmWI63YRRD.N6','registrato');
/*!40000 ALTER TABLE `utenti_registrati_train` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-07 11:08:10
