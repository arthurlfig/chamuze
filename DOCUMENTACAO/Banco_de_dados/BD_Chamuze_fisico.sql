/*Criação do banco*/
CREATE DATABASE chamuze 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

/*Usando o banco de dados*/
USE chamuze;

/*Criação da tabela usuario - Generalização - */
CREATE TABLE usuario (
	id_usuario INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nome VARCHAR(100) NOT NULL,
    sobrenome VARCHAR(150) NOT NULL,
	email VARCHAR(150) NOT NULL,
	senha VARCHAR(255) NOT NULL,
    cpf VARCHAR(11) NOT NULL,
    telefone VARCHAR(30) NOT NULL,
    nacionalidade VARCHAR(50) NOT NULL,
    data_nascimento DATE NOT NULL,
	nota_reputacao DECIMAL(3,2) NOT NULL,
    genero ENUM('F','M','O') NOT NULL,
	tipo_perfil ENUM('administrador','prestador','solicitante') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Criação da tabela prestador - Especialização - */
CREATE TABLE prestador (
	id_prestador INTEGER NOT NULL PRIMARY KEY,
	FOREIGN KEY (id_prestador) REFERENCES usuario(id_usuario),
	cnpj VARCHAR(14) NOT NULL,
	img_rg VARCHAR(255) NOT NULL,
	chave_pix VARCHAR(100) NOT NULL,
	status_avaliacao ENUM('aprovado','naoverificado') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Criação da tabela solicitante - Especialização - */
CREATE TABLE solicitante (
	id_solicitante INTEGER NOT NULL PRIMARY KEY,
	FOREIGN KEY (id_solicitante) REFERENCES usuario(id_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Criação da tabela endereco */
CREATE TABLE endereco (
	id_endereco INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    estado VARCHAR(100) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    bairro VARCHAR(150) NOT NULL,
    logradouro VARCHAR(150) NOT NULL,
    numero_casa INTEGER NOT NULL,
    cep VARCHAR(50) NOT NULL,
    id_usuario INTEGER,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Criação da tabela servico */
CREATE TABLE servico (
    id_servico INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    descricao TEXT NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    img_servico VARCHAR(255) NOT NULL,
    categoria VARCHAR(255) NOT NULL,
    status_servico ENUM('disponivel','aceito','concluido') DEFAULT 'disponivel',
    local_servico VARCHAR(100) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    id_solicitante INTEGER,
    id_prestador INTEGER,
    FOREIGN KEY (id_solicitante) REFERENCES solicitante(id_solicitante),
    FOREIGN KEY (id_prestador) REFERENCES prestador(id_prestador) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Criação da tabela proposta */
CREATE TABLE proposta (
	id_proposta INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_servico INTEGER NOT NULL,
	id_prestador INTEGER,
	id_solicitante INTEGER,
	valor_proposta DECIMAL(10,2) NOT NULL,
    justificativa TEXT NOT NULL,
    FOREIGN KEY (id_servico) REFERENCES servico(id_servico) ON DELETE CASCADE,
    FOREIGN KEY (id_solicitante) REFERENCES solicitante(id_solicitante),
    FOREIGN KEY (id_prestador) REFERENCES prestador(id_prestador) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Criação da tabela mensagem*/
CREATE TABLE mensagem (
    id_mensagem INT AUTO_INCREMENT PRIMARY KEY,
    id_remetente INT NOT NULL,
    id_destinatario INT NOT NULL,
    mensagem TEXT NOT NULL,
    data_envio DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_remetente) REFERENCES usuario(id_usuario) ON DELETE CASCADE,
	FOREIGN KEY (id_destinatario) REFERENCES usuario(id_usuario) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Criação da tabela avaliação*/
CREATE TABLE avaliacao (
    id_avaliacao INT AUTO_INCREMENT PRIMARY KEY,
    nota INT NOT NULL,
    id_avaliado INT,
    id_avaliador INT,
    FOREIGN KEY (id_avaliado) REFERENCES usuario(id_usuario) ON DELETE SET NULL,
	FOREIGN KEY (id_avaliador) REFERENCES usuario(id_usuario) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Criação da tabela pagamento*/
CREATE TABLE pagamento (
    id_pagamento INT AUTO_INCREMENT PRIMARY KEY,
    data_pagamento DATE NOT NULL,
    status_pagamento ENUM('pago','pendente') NOT NULL,
    valor_pagamento DECIMAL(10,2) NOT NULL,
    id_solicitante INTEGER,
    id_prestador INTEGER,
    FOREIGN KEY (id_solicitante) REFERENCES solicitante(id_solicitante),
    FOREIGN KEY (id_prestador) REFERENCES prestador(id_prestador)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/* ===== INSERÇÃO DE DADOS ===== */

/* Inserindo usuários */
INSERT INTO usuario VALUES 
(1,'Administrador','Teste','admin@teste.com','$2y$10$iJsLDgYFSEG6vrb6GidjB.OYPTS1EDOZGPr.7/KJYG8LE0diZyT1e','00000000001','419989092','Brasileiro','1990-01-01',5.00,'O','administrador'),
(2,'Prestador','Teste','prestador@teste.com','$2y$10$iJsLDgYFSEG6vrb6GidjB.OYPTS1EDOZGPr.7/KJYG8LE0diZyT1e','00000000002','11999990002','Brasileiro','1992-02-02',4.50,'M','prestador'),
(3,'Solicitante','Teste','solicitante@teste.com','$2y$10$iJsLDgYFSEG6vrb6GidjB.OYPTS1EDOZGPr.7/KJYG8LE0diZyT1e','00000000003','11999990003','Brasileiro','1995-03-03',4.80,'F','solicitante'),
(4,'Prestador2','Teste2','prestador2@teste.com','$2y$10$iJsLDgYFSEG6vrb6GidjB.OYPTS1EDOZGPr.7/KJYG8LE0diZyT1e','00000000002','11999990002','Brasileiro','1992-02-02',4.00,'M','prestador'),
(5,'Juliana','Solicitante','julianas@gmail.com','$2y$10$xWv5iiOKfTtRoFjpyeY8q.dhND2soAkZ8b/.sVuKOMDRds6mAlnNG','12345678910','4199999999','Brasileiro','2006-02-17',3.00,'F','solicitante'),
(6,'João','Silva','joao.silva@email.com','$2y$10$xWv5iiOKfTtRoFjpyeY8q.dhND2soAkZ8b/.sVuKOMDRds6mAlnNG','12345678901','999999999','Brasileiro','1990-05-15',4.50,'M','prestador'),
(11,'Juliana','Pereira','prestador@gmail.com','$2y$10$f9LKzai0BY67uzzyY4Dk2OGfUR4NA6.ZNs8gztn5FMXGgQXxjzp7S','14923829917','41999999999','Brasileiro','0123-03-12',2.33,'F','prestador'),
(14,'prestador3@teste.com','prestador3@teste.com','prestador3@teste.com','$2y$10$r1/cRtPooq2oT/heyP5/AeXaODIipYaTrPxiEDpkW3QXgkM255lwy','14905829917','4199999999','Brasileiro','1908-03-23',3.50,'F','prestador'),
(19,'Juliana','Teste','solicitante@gmail.com','$2y$10$Mpb2Z5Uey2kSv9iiffOY7uytv4aayZLQHaMjaaKpzhsWTkr5AegzO','12345678910','41999999999','Brasileiro','1009-03-31',1.47,'M','solicitante'),
(21,'Juliana','Aparecida','julianasolicitante@gmail.com','$2y$10$vDQ9xqJsc19IwMtRZkZLPu89r1IdY5KYTQ2l5ZFC4XE/klYFGGohm','12345678910','41999999999','Brasileiro','2006-02-17',0.00,'F','solicitante'),
(29,'ADM','Teste','admin2@teste.com','$2y$10$KVD3ehP2EE071Dolu.J1Z.m0VCtyTLwiodjX7W6WoeCf/GsZH3NDW','15148766060','419999988888888888888888888888','Brasileiro','2014-01-04',0.00,'F','administrador'),
(30,'Juliana','Solicitante','solicitantejuliana@gmail.com','$2y$10$0hKF/U0B6T7xAUmeocX8TeA79P6f72JGlrdu14CoY6b7DhouutvWa','32148796090','41912345678','Brasileiro','2006-02-17',0.00,'F','solicitante'),
(31,'Juliana','Prestador','prestadorjuliana@gmail.com','$2y$10$sslV0YpV2Q1jySq1jaQJQu8OVElnxXdfSlVQcph6Fa6vps90Xl7g2','39852104061','41999999999','Brasileiro','2006-02-17',0.00,'F','prestador');

/* Inserindo prestadores */
INSERT INTO prestador VALUES 
(2,'12345678000199','prestador_rg.jpg','prestador_pix@bank.com','aprovado'),
(4,'12345678000199','prestador2_rg.jpg','prestador2_pix@bank.com','aprovado'),
(11,'34352353453453','../uploads/rg/680a2481eb5d1.jpg','123','aprovado'),
(14,'34352353453453','../uploads/rg/680a50cf39ac9.jpg','123','aprovado'),
(31,'12345678000195','../uploads/rg/6840dc924bc4c.jpg','123','naoverificado');

/* Inserindo solicitantes */
INSERT INTO solicitante VALUES (3),(5),(19),(21),(30);

/* Inserindo endereços */
INSERT INTO endereco VALUES 
(3,'PR','Curitiba','Centro','Rua Desembargador Westphalen',4,'80010110',30),
(4,'SC','Limeira','Vila da Glória','Rua do Rosário',12,'13484015',31);

/* Inserindo serviços */
INSERT INTO servico VALUES 
(12,'Preciso cortar minha grama, pois está bem alta.\r\nMinha disponibilidade é na sexta-feira 25/04/2025 13:00','Corte de Grama','../uploads/servicos/680b60d74d8e4.jpg','jardinagem','disponivel','butiatuvinha',89.00,21,NULL),
(15,'Preciso cortar minha grama. Está com 1,2m de altura em um terreno de 12m quadrados.','Corte de Grama','../uploads/servicos/682b718b442ac.jpg','jardinagem','aceito','batel',150.00,19,11),
(16,'Preciso cortar minha grama. Está com 1,2m de altura em um terreno de 12m quadrados.','Corte de Grama 2.0','../uploads/servicos/682b71b436e32.jpg','jardinagem','concluido','batel',150.00,19,11),
(17,'Preciso cortar minha grama. Está com 1,2m de altura em um terreno de 12m quadrados.','Corte de Grama 3.0','../uploads/servicos/68308d12bc6aa.jpg','jardinagem','concluido','abranches',150.00,19,14),
(19,'Preciso cortar minha grama. Está com 1,2m de altura em um terreno de 12m quadrados.','Corte de Grama 5.0','../uploads/servicos/68324b21abfd6.jpg','jardinagem','aceito','batel',150.00,19,11),
(20,'Preciso cortar minha grama. Está com 1,2m de altura em um terreno de 12m quadrados.','Corte de Grama 6.0','../uploads/servicos/68324b493d84e.jpg','jardinagem','concluido','batel',150.00,19,11);

/* Inserindo propostas */
INSERT INTO proposta VALUES 
(29,12,11,21,123.00,'dkwondownqdow'),
(30,12,11,21,45.00,'3423f');

/* Inserindo mensagens */
INSERT INTO mensagem VALUES 
(1,11,19,'OII','2025-05-29 09:27:29'),
(2,11,19,' oii 2','2025-05-29 09:28:05'),
(4,11,19,'Bom dia ','2025-05-29 09:47:28'),
(5,11,19,'Olá','2025-05-29 09:47:57'),
(6,19,19,'Olá','2025-05-29 09:49:43'),
(7,19,19,'Oláaa','2025-05-29 09:50:26'),
(8,11,21,'Olá','2025-05-29 09:58:21'),
(9,19,11,'Olá','2025-05-29 09:58:56'),
(10,19,11,'Bom dia','2025-05-29 10:01:31'),
(11,19,11,'oiii','2025-05-29 10:02:00'),
(12,19,11,'Boa tarde. Gostaria de conversar sobre o valor do serviço','2025-05-29 16:53:44'),
(13,11,19,'Claro podemos conversar sim','2025-05-29 16:54:32'),
(14,14,19,'Bom dia. Gostaria de mais informações sobre o corte de grama. Me mande o nome da sua rua e o número da sua casa.','2025-05-29 17:06:42'),
(15,14,19,'Olá','2025-05-29 17:10:12'),
(16,4,19,'Bom dia Senhora. Como vai?','2025-05-29 17:12:12'),
(17,19,4,'Olá','2025-05-29 17:13:20'),
(20,19,19,'olá','2025-05-29 17:40:41'),
(21,19,4,'Olá','2025-05-30 08:16:43');

/* Inserindo avaliações */
INSERT INTO avaliacao VALUES 
(1,3,11,19),(2,1,11,19),(3,2,11,19),(4,2,11,19),(5,4,11,19),(6,3,11,19),(7,3,11,19),(8,3,11,19),(9,3,11,19),(10,2,11,19),
(11,1,11,19),(12,2,11,19),(13,2,11,19),(14,2,11,19),(15,2,11,19),(16,2,11,19),(17,2,11,19),(18,2,11,19),(19,2,11,19),(20,3,11,19),
(21,3,11,19),(22,3,11,19),(23,3,11,19),(24,2,11,19),(25,3,11,19),(26,3,11,19),(27,5,11,19),(28,3,11,19),(29,1,11,19),(30,1,11,19),
(31,1,11,19),(32,1,11,19),(33,1,11,19),(34,5,11,19),(35,4,11,19),(36,3,11,19),(37,5,14,19),(38,2,14,19),(39,3,14,19),(40,4,14,19),
(41,3,14,19),(42,5,14,19),(43,4,14,19),(44,4,14,19),(45,3,14,19),(46,0,11,11),(47,3,11,11),(48,5,19,11),(49,2,19,11),(50,3,19,11),
(51,5,19,11),(52,2,19,11),(53,3,5,11),(54,1,5,11),(55,2,5,11),(56,3,5,11),(57,5,5,11),(58,4,19,11),(59,3,5,11),(60,3,19,11),
(61,4,5,11),(62,3,19,11),(63,3,4,19),(64,5,4,19),(65,2,14,19),(66,4,4,19),(67,4,19,11),(68,3,19,11),(69,4,19,11),(70,0,19,11),
(71,0,19,11),(72,0,19,11),(73,0,19,11),(74,0,19,11),(75,0,19,11),(76,0,19,11),(77,0,19,11),(78,0,19,11),(79,0,19,11),(80,0,19,11),
(81,0,19,11),(82,0,19,11),(83,0,19,11),(84,0,19,11),(85,0,19,11),(86,0,19,11),(87,4,19,11),(88,2,19,11),(89,0,11,30),(90,2,11,30);