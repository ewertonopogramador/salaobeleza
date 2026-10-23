-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: salaobeleza
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `salaobeleza`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `salaobeleza` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `salaobeleza`;

--
-- Table structure for table `agendamentos`
--

DROP TABLE IF EXISTS `agendamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `agendamentos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `data_agendamento` date NOT NULL,
  `horario_agendamento` time NOT NULL,
  `id_servico` bigint unsigned NOT NULL,
  `id_cliente` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agendamentos_id_servico_foreign` (`id_servico`),
  KEY `agendamentos_id_cliente_foreign` (`id_cliente`),
  CONSTRAINT `agendamentos_id_cliente_foreign` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `agendamentos_id_servico_foreign` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agendamentos`
--

LOCK TABLES `agendamentos` WRITE;
/*!40000 ALTER TABLE `agendamentos` DISABLE KEYS */;
INSERT INTO `agendamentos` VALUES (1,'2026-10-27','20:39:00',6,9,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(2,'2026-11-02','12:00:00',6,6,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(3,'2026-10-30','23:50:00',1,2,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(4,'2026-10-26','14:59:00',2,7,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(5,'2026-11-18','17:56:00',1,2,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(6,'2026-10-31','10:21:00',1,6,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(7,'2026-11-09','09:59:00',3,10,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(8,'2026-11-13','06:15:00',2,1,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(9,'2026-10-26','00:56:00',1,9,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(10,'2026-11-13','08:25:00',3,6,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(11,'2026-11-17','03:55:00',1,5,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(12,'2026-11-14','20:40:00',4,5,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(13,'2026-10-23','12:04:00',3,10,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(14,'2026-11-11','08:32:00',1,4,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(15,'2026-10-29','05:27:00',4,1,'2026-10-23 03:55:15','2026-10-23 03:55:15');
/*!40000 ALTER TABLE `agendamentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(130) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cpf` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `endereco` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imagem` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clientes_cpf_unique` (`cpf`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (1,'Stephanie Schultz I','041.906.220-72','(21) 99978-8909','6641 Jaqueline Forks Suite 161','thompson.lionel@example.net',NULL,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(2,'Juana Bartoletti','569.889.295-75','(80) 99914-6290','625 Emard Oval Suite 675','zita43@example.com',NULL,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(3,'Dr. Darron Gulgowski III','629.917.816-67','(28) 99279-5706','7803 Rohan Crescent Apt. 947','derrick.cormier@example.net',NULL,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(4,'Dr. Austen Ullrich','400.820.218-12','(51) 92386-2825','124 Berge Wall','ejacobi@example.com',NULL,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(5,'Prof. Pablo Hahn','804.663.153-19','(09) 97027-1941','575 Mante Village Apt. 697','joanny47@example.net',NULL,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(6,'Aditya Fadel Jr.','179.535.425-02','(13) 92224-5104','98433 Koepp Drive Apt. 592','enola.jast@example.org',NULL,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(7,'Prof. Alexandre Botsford IV','215.885.647-62','(50) 98953-5478','77409 Wehner Plaza','pfeffer.deanna@example.net',NULL,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(8,'Wilbert Monahan','483.844.943-14','(30) 91457-4075','291 Funk Canyon Apt. 879','orpha.borer@example.com',NULL,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(9,'Ana Osinski','333.362.132-59','(06) 97504-7802','7395 Adrain Bridge','reynolds.ida@example.org',NULL,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(10,'Mrs. Carmen Willms','916.207.164-57','(93) 98454-2905','9606 Runolfsdottir Ferry','emelia45@example.net',NULL,'2026-10-23 03:55:15','2026-10-23 03:55:15');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2026_08_31_000001_create_clientes_table',1),(6,'2026_08_31_000002_create_servicos_table',1),(7,'2026_08_31_000003_create_agendamentos_table',1),(8,'2026_10_21_031151_create_produtos_table',1),(9,'2026_10_21_031344_create_profissionals_table',1),(10,'2026_10_22_220000_alter_clientes_add_endereco_email',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produtos`
--

DROP TABLE IF EXISTS `produtos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produtos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(130) COLLATE utf8mb4_unicode_ci NOT NULL,
  `preco` decimal(8,2) NOT NULL,
  `estoque` int NOT NULL,
  `imagem` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtos`
--

LOCK TABLES `produtos` WRITE;
/*!40000 ALTER TABLE `produtos` DISABLE KEYS */;
INSERT INTO `produtos` VALUES (1,'Shampoo Hidratante',29.90,40,NULL,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(2,'Condicionador',27.90,35,NULL,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(3,'Máscara Capilar',49.90,20,NULL,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(4,'Esmalte',9.90,80,NULL,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(5,'Óleo para Barba',34.90,15,NULL,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(6,'Secador de Cabelo',189.90,5,NULL,'2026-10-23 03:55:15','2026-10-23 03:55:15');
/*!40000 ALTER TABLE `produtos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profissionais`
--

DROP TABLE IF EXISTS `profissionais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profissionais` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(130) COLLATE utf8mb4_unicode_ci NOT NULL,
  `especialidade` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagem` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `profissionais_user_id_unique` (`user_id`),
  CONSTRAINT `profissionais_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profissionais`
--

LOCK TABLES `profissionais` WRITE;
/*!40000 ALTER TABLE `profissionais` DISABLE KEYS */;
INSERT INTO `profissionais` VALUES (1,'Hallie Aufderhar','Manicure','(22) 95551-3620',NULL,NULL,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(2,'Asa Goodwin','Esteticista','(56) 97850-9239',NULL,NULL,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(3,'Myah Kutch','Esteticista','(20) 92295-4597',NULL,NULL,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(4,'Dr. Judy Bogisich DVM','Cabeleireiro','(66) 90983-2674',NULL,NULL,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(5,'Carissa Nikolaus','Barbeiro','(65) 96789-5568',NULL,NULL,'2026-10-23 03:55:15','2026-10-23 03:55:15');
/*!40000 ALTER TABLE `profissionais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicos`
--

DROP TABLE IF EXISTS `servicos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `servicos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nome_servico` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci,
  `preco` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicos`
--

LOCK TABLES `servicos` WRITE;
/*!40000 ALTER TABLE `servicos` DISABLE KEYS */;
INSERT INTO `servicos` VALUES (1,'Corte de Cabelo','Corte feminino ou masculino',60.00,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(2,'Barba Completa','Barba com toalha quente e acabamento',40.00,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(3,'Coloração','Coloração completa dos fios',120.00,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(4,'Manicure','Cuidado e esmaltação das unhas',35.00,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(5,'Pedicure','Cuidado e esmaltação dos pés',40.00,'2026-10-23 03:55:15','2026-10-23 03:55:15'),(6,'Hidratação','Hidratação profunda dos cabelos',80.00,'2026-10-23 03:55:15','2026-10-23 03:55:15');
/*!40000 ALTER TABLE `servicos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrador','adm@gmail.com',NULL,'$2y$12$s1JmVlf/En0Mfel9xd7CsOsYi0oHdN8952eGsaGZCc29w27sO86tG',NULL,'2026-10-23 03:55:15','2026-10-23 03:55:15');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-22 21:55:15
