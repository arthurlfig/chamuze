-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: chamuze
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `avaliacao`
--

DROP TABLE IF EXISTS `avaliacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `avaliacao` (
  `id_avaliacao` int(11) NOT NULL AUTO_INCREMENT,
  `nota` int(11) NOT NULL,
  `id_avaliado` int(11) DEFAULT NULL,
  `id_avaliador` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_avaliacao`),
  KEY `id_avaliado` (`id_avaliado`),
  KEY `id_avaliador` (`id_avaliador`),
  CONSTRAINT `avaliacao_ibfk_1` FOREIGN KEY (`id_avaliado`) REFERENCES `usuario` (`id_usuario`) ON DELETE SET NULL,
  CONSTRAINT `avaliacao_ibfk_2` FOREIGN KEY (`id_avaliador`) REFERENCES `usuario` (`id_usuario`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avaliacao`
--

LOCK TABLES `avaliacao` WRITE;
/*!40000 ALTER TABLE `avaliacao` DISABLE KEYS */;
INSERT INTO `avaliacao` VALUES (1,3,11,19),(2,1,11,19),(3,2,11,19),(4,2,11,19),(5,4,11,19),(6,3,11,19),(7,3,11,19),(8,3,11,19),(9,3,11,19),(10,2,11,19),(11,1,11,19),(12,2,11,19),(13,2,11,19),(14,2,11,19),(15,2,11,19),(16,2,11,19),(17,2,11,19),(18,2,11,19),(19,2,11,19),(20,3,11,19),(21,3,11,19),(22,3,11,19),(23,3,11,19),(24,2,11,19),(25,3,11,19),(26,3,11,19),(27,5,11,19),(28,3,11,19),(29,1,11,19),(30,1,11,19),(31,1,11,19),(32,1,11,19),(33,1,11,19),(34,5,11,19),(35,4,11,19),(36,3,11,19),(37,5,14,19),(38,2,14,19),(39,3,14,19),(40,4,14,19),(41,3,14,19),(42,5,14,19),(43,4,14,19),(44,4,14,19),(45,3,14,19),(46,0,11,11),(47,3,11,11),(48,5,19,11),(49,2,19,11),(50,3,19,11),(51,5,19,11),(52,2,19,11),(53,3,5,11),(54,1,5,11),(55,2,5,11),(56,3,5,11),(57,5,5,11),(58,4,19,11),(59,3,5,11),(60,3,19,11),(61,4,5,11),(62,3,19,11),(63,3,4,19),(64,5,4,19),(65,2,14,19),(66,4,4,19),(67,4,19,11),(68,3,19,11),(69,4,19,11),(70,0,19,11),(71,0,19,11),(72,0,19,11),(73,0,19,11),(74,0,19,11),(75,0,19,11),(76,0,19,11),(77,0,19,11),(78,0,19,11),(79,0,19,11),(80,0,19,11),(81,0,19,11),(82,0,19,11),(83,0,19,11),(84,0,19,11),(85,0,19,11),(86,0,19,11),(87,4,19,11),(88,2,19,11),(89,0,11,30),(90,2,11,30);
/*!40000 ALTER TABLE `avaliacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `endereco`
--

DROP TABLE IF EXISTS `endereco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `endereco` (
  `id_endereco` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(100) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `bairro` varchar(150) NOT NULL,
  `logradouro` varchar(150) NOT NULL,
  `numero_casa` int(11) NOT NULL,
  `cep` varchar(50) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_endereco`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `endereco_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `endereco`
--

LOCK TABLES `endereco` WRITE;
/*!40000 ALTER TABLE `endereco` DISABLE KEYS */;
INSERT INTO `endereco` VALUES (3,'PR','Curitiba','Centro','Rua Desembargador Westphalen',4,'80010110',30),(4,'SC','Limeira','Vila da Glória','Rua do Rosário',12,'13484015',31);
/*!40000 ALTER TABLE `endereco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mensagem`
--

DROP TABLE IF EXISTS `mensagem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mensagem` (
  `id_mensagem` int(11) NOT NULL AUTO_INCREMENT,
  `id_remetente` int(11) NOT NULL,
  `id_destinatario` int(11) NOT NULL,
  `mensagem` text NOT NULL,
  `data_envio` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_mensagem`),
  KEY `id_remetente` (`id_remetente`),
  KEY `id_destinatario` (`id_destinatario`),
  CONSTRAINT `mensagem_ibfk_1` FOREIGN KEY (`id_remetente`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE,
  CONSTRAINT `mensagem_ibfk_2` FOREIGN KEY (`id_destinatario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mensagem`
--

LOCK TABLES `mensagem` WRITE;
/*!40000 ALTER TABLE `mensagem` DISABLE KEYS */;
INSERT INTO `mensagem` VALUES (1,11,19,'OII','2025-05-29 09:27:29'),(2,11,19,' oii 2','2025-05-29 09:28:05'),(4,11,19,'Bom dia ','2025-05-29 09:47:28'),(5,11,19,'Olá','2025-05-29 09:47:57'),(6,19,19,'Olá','2025-05-29 09:49:43'),(7,19,19,'Oláaa','2025-05-29 09:50:26'),(8,11,21,'Olá','2025-05-29 09:58:21'),(9,19,11,'Olá','2025-05-29 09:58:56'),(10,19,11,'Bom dia','2025-05-29 10:01:31'),(11,19,11,'oiii','2025-05-29 10:02:00'),(12,19,11,'Boa tarde. Gostaria de conversar sobre o valor do serviço','2025-05-29 16:53:44'),(13,11,19,'Claro podemos conversar sim','2025-05-29 16:54:32'),(14,14,19,'Bom dia. Gostaria de mais informações sobre o corte de grama. Me mande o nome da sua rua e o número da sua casa.','2025-05-29 17:06:42'),(15,14,19,'Olá','2025-05-29 17:10:12'),(16,4,19,'Bom dia Senhora. Como vai?','2025-05-29 17:12:12'),(17,19,4,'Olá','2025-05-29 17:13:20'),(20,19,19,'olá','2025-05-29 17:40:41'),(21,19,4,'Olá','2025-05-30 08:16:43');
/*!40000 ALTER TABLE `mensagem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagamento`
--

DROP TABLE IF EXISTS `pagamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pagamento` (
  `id_pagamento` int(11) NOT NULL AUTO_INCREMENT,
  `data_pagamento` date NOT NULL,
  `status_pagamento` enum('pago','pendente') NOT NULL,
  `valor_pagamento` decimal(10,2) NOT NULL,
  `id_solicitante` int(11) DEFAULT NULL,
  `id_prestador` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pagamento`),
  KEY `id_solicitante` (`id_solicitante`),
  KEY `id_prestador` (`id_prestador`),
  CONSTRAINT `pagamento_ibfk_1` FOREIGN KEY (`id_solicitante`) REFERENCES `solicitante` (`id_solicitante`),
  CONSTRAINT `pagamento_ibfk_2` FOREIGN KEY (`id_prestador`) REFERENCES `prestador` (`id_prestador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagamento`
--

LOCK TABLES `pagamento` WRITE;
/*!40000 ALTER TABLE `pagamento` DISABLE KEYS */;
/*!40000 ALTER TABLE `pagamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prestador`
--

DROP TABLE IF EXISTS `prestador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prestador` (
  `id_prestador` int(11) NOT NULL,
  `cnpj` varchar(14) NOT NULL,
  `img_rg` varchar(255) NOT NULL,
  `chave_pix` varchar(100) NOT NULL,
  `status_avaliacao` enum('aprovado','naoverificado') NOT NULL,
  PRIMARY KEY (`id_prestador`),
  CONSTRAINT `prestador_ibfk_1` FOREIGN KEY (`id_prestador`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestador`
--

LOCK TABLES `prestador` WRITE;
/*!40000 ALTER TABLE `prestador` DISABLE KEYS */;
INSERT INTO `prestador` VALUES (2,'12345678000199','prestador_rg.jpg','prestador_pix@bank.com','aprovado'),(4,'12345678000199','prestador2_rg.jpg','prestador2_pix@bank.com','aprovado'),(11,'34352353453453','../uploads/rg/680a2481eb5d1.jpg','123','aprovado'),(14,'34352353453453','../uploads/rg/680a50cf39ac9.jpg','123','aprovado'),(31,'12345678000195','../uploads/rg/6840dc924bc4c.jpg','123','naoverificado');
/*!40000 ALTER TABLE `prestador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proposta`
--

DROP TABLE IF EXISTS `proposta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proposta` (
  `id_proposta` int(11) NOT NULL AUTO_INCREMENT,
  `id_servico` int(11) NOT NULL,
  `id_prestador` int(11) DEFAULT NULL,
  `id_solicitante` int(11) DEFAULT NULL,
  `valor_proposta` decimal(10,2) NOT NULL,
  `justificativa` text NOT NULL,
  PRIMARY KEY (`id_proposta`),
  KEY `id_solicitante` (`id_solicitante`),
  KEY `id_prestador` (`id_prestador`),
  KEY `id_servico` (`id_servico`),
  CONSTRAINT `id_servico` FOREIGN KEY (`id_servico`) REFERENCES `servico` (`id_servico`) ON DELETE CASCADE,
  CONSTRAINT `proposta_ibfk_1` FOREIGN KEY (`id_servico`) REFERENCES `servico` (`id_servico`),
  CONSTRAINT `proposta_ibfk_2` FOREIGN KEY (`id_solicitante`) REFERENCES `solicitante` (`id_solicitante`),
  CONSTRAINT `proposta_ibfk_3` FOREIGN KEY (`id_prestador`) REFERENCES `prestador` (`id_prestador`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proposta`
--

LOCK TABLES `proposta` WRITE;
/*!40000 ALTER TABLE `proposta` DISABLE KEYS */;
INSERT INTO `proposta` VALUES (29,12,11,21,123.00,'dkwondownqdow'),(30,12,11,21,45.00,'3423f');
/*!40000 ALTER TABLE `proposta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servico`
--

DROP TABLE IF EXISTS `servico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `servico` (
  `id_servico` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` text NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `img_servico` varchar(255) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `status_servico` enum('disponivel','aceito','concluido') DEFAULT 'disponivel',
  `local_servico` varchar(100) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `id_solicitante` int(11) DEFAULT NULL,
  `id_prestador` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_servico`),
  KEY `id_solicitante` (`id_solicitante`),
  KEY `id_prestador` (`id_prestador`),
  CONSTRAINT `servico_ibfk_1` FOREIGN KEY (`id_solicitante`) REFERENCES `solicitante` (`id_solicitante`),
  CONSTRAINT `servico_ibfk_2` FOREIGN KEY (`id_prestador`) REFERENCES `prestador` (`id_prestador`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servico`
--

LOCK TABLES `servico` WRITE;
/*!40000 ALTER TABLE `servico` DISABLE KEYS */;
INSERT INTO `servico` VALUES (12,'Preciso cortar minha grama, pois está bem alta.\r\nMinha disponibilidade é na sexta-feira 25/04/2025 13:00','Corte de Grama','../uploads/servicos/680b60d74d8e4.jpg','jardinagem','disponivel','butiatuvinha',89.00,21,NULL),(15,'Preciso cortar minha grama. Está com 1,2m de altura em um terreno de 12m quadrados.','Corte de Grama','../uploads/servicos/682b718b442ac.jpg','jardinagem','aceito','batel',150.00,19,11),(16,'Preciso cortar minha grama. Está com 1,2m de altura em um terreno de 12m quadrados.','Corte de Grama 2.0','../uploads/servicos/682b71b436e32.jpg','jardinagem','concluido','batel',150.00,19,11),(17,'Preciso cortar minha grama. Está com 1,2m de altura em um terreno de 12m quadrados.','Corte de Grama 3.0','../uploads/servicos/68308d12bc6aa.jpg','jardinagem','concluido','abranches',150.00,19,14),(19,'Preciso cortar minha grama. Está com 1,2m de altura em um terreno de 12m quadrados.','Corte de Grama 5.0','../uploads/servicos/68324b21abfd6.jpg','jardinagem','aceito','batel',150.00,19,11),(20,'Preciso cortar minha grama. Está com 1,2m de altura em um terreno de 12m quadrados.','Corte de Grama 6.0','../uploads/servicos/68324b493d84e.jpg','jardinagem','concluido','batel',150.00,19,11);
/*!40000 ALTER TABLE `servico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solicitante`
--

DROP TABLE IF EXISTS `solicitante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `solicitante` (
  `id_solicitante` int(11) NOT NULL,
  PRIMARY KEY (`id_solicitante`),
  CONSTRAINT `solicitante_ibfk_1` FOREIGN KEY (`id_solicitante`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitante`
--

LOCK TABLES `solicitante` WRITE;
/*!40000 ALTER TABLE `solicitante` DISABLE KEYS */;
INSERT INTO `solicitante` VALUES (3),(5),(19),(21),(30);
/*!40000 ALTER TABLE `solicitante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `sobrenome` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `telefone` varchar(30) NOT NULL,
  `nacionalidade` varchar(50) NOT NULL,
  `data_nascimento` date NOT NULL,
  `nota_reputacao` decimal(3,2) NOT NULL,
  `genero` enum('F','M','O') NOT NULL,
  `tipo_perfil` enum('administrador','prestador','solicitante') NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'Administrador','Teste','admin@teste.com','$2y$10$iJsLDgYFSEG6vrb6GidjB.OYPTS1EDOZGPr.7/KJYG8LE0diZyT1e','00000000001','419989092','Brasileiro','1990-01-01',5.00,'O','administrador'),(2,'Prestador','Teste','prestador@teste.com','$2y$10$iJsLDgYFSEG6vrb6GidjB.OYPTS1EDOZGPr.7/KJYG8LE0diZyT1e','00000000002','11999990002','Brasileiro','1992-02-02',4.50,'M','prestador'),(3,'Solicitante','Teste','solicitante@teste.com','$2y$10$iJsLDgYFSEG6vrb6GidjB.OYPTS1EDOZGPr.7/KJYG8LE0diZyT1e','00000000003','11999990003','Brasileiro','1995-03-03',4.80,'F','solicitante'),(4,'Prestador2','Teste2','prestador2@teste.com','$2y$10$iJsLDgYFSEG6vrb6GidjB.OYPTS1EDOZGPr.7/KJYG8LE0diZyT1e','00000000002','11999990002','Brasileiro','1992-02-02',4.00,'M','prestador'),(5,'Juliana','Solicitante','julianas@gmail.com','$2y$10$xWv5iiOKfTtRoFjpyeY8q.dhND2soAkZ8b/.sVuKOMDRds6mAlnNG','12345678910','Brasileiro','4199999999','2006-02-17',3.00,'F','solicitante'),(6,'João','Silva','joao.silva@email.com','$2y$10$xWv5iiOKfTtRoFjpyeY8q.dhND2soAkZ8b/.sVuKOMDRds6mAlnNG','12345678901','999999999','Brasileiro','1990-05-15',4.50,'M','prestador'),(11,'Juliana','Pereira','prestador@gmail.com','$2y$10$f9LKzai0BY67uzzyY4Dk2OGfUR4NA6.ZNs8gztn5FMXGgQXxjzp7S','14923829917','Brasileiro','41999999999','0123-03-12',2.33,'F','prestador'),(14,'prestador3@teste.com','prestador3@teste.com','prestador3@teste.com','$2y$10$r1/cRtPooq2oT/heyP5/AeXaODIipYaTrPxiEDpkW3QXgkM255lwy','14905829917','Brasileiro','4199999999','1908-03-23',3.50,'F','prestador'),(19,'Juliana','Teste','solicitante@gmail.com','$2y$10$Mpb2Z5Uey2kSv9iiffOY7uytv4aayZLQHaMjaaKpzhsWTkr5AegzO','12345678910','Brasileiro','41999999999','1009-03-31',1.47,'M','solicitante'),(21,'Juliana','Aparecida','julianasolicitante@gmail.com','$2y$10$vDQ9xqJsc19IwMtRZkZLPu89r1IdY5KYTQ2l5ZFC4XE/klYFGGohm','12345678910','Brasileiro','41999999999','2006-02-17',0.00,'F','solicitante'),(29,'ADM','Teste','admin2@teste.com','$2y$10$KVD3ehP2EE071Dolu.J1Z.m0VCtyTLwiodjX7W6WoeCf/GsZH3NDW','15148766060','419999988888888888888888888888','Brasileiro','2014-01-04',0.00,'F','administrador'),(30,'Juliana','Solicitante','solicitantejuliana@gmail.com','$2y$10$0hKF/U0B6T7xAUmeocX8TeA79P6f72JGlrdu14CoY6b7DhouutvWa','32148796090','41912345678','Brasileiro','2006-02-17',0.00,'F','solicitante'),(31,'Juliana','Prestador','prestadorjuliana@gmail.com','$2y$10$sslV0YpV2Q1jySq1jaQJQu8OVElnxXdfSlVQcph6Fa6vps90Xl7g2','39852104061','41999999999','Brasileiro','2006-02-17',0.00,'F','prestador');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-04 21:09:13
