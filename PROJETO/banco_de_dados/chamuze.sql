-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Tempo de geração: 10-Out-2025 às 15:33
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `chamuze`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacao`
--

CREATE TABLE `avaliacao` (
  `id_avaliacao` int(11) NOT NULL,
  `nota` int(11) NOT NULL,
  `id_avaliado` int(11) DEFAULT NULL,
  `id_avaliador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `avaliacao`
--

INSERT INTO `avaliacao` (`id_avaliacao`, `nota`, `id_avaliado`, `id_avaliador`) VALUES
(1, 3, 11, 19),
(2, 1, 11, 19),
(3, 2, 11, 19),
(4, 2, 11, 19),
(5, 4, 11, 19),
(6, 3, 11, 19),
(7, 3, 11, 19),
(8, 3, 11, 19),
(9, 3, 11, 19),
(10, 2, 11, 19),
(11, 1, 11, 19),
(12, 2, 11, 19),
(13, 2, 11, 19),
(14, 2, 11, 19),
(15, 2, 11, 19),
(16, 2, 11, 19),
(17, 2, 11, 19),
(18, 2, 11, 19),
(19, 2, 11, 19),
(20, 3, 11, 19),
(21, 3, 11, 19),
(22, 3, 11, 19),
(23, 3, 11, 19),
(24, 2, 11, 19),
(25, 3, 11, 19),
(26, 3, 11, 19),
(27, 5, 11, 19),
(28, 3, 11, 19),
(29, 1, 11, 19),
(30, 1, 11, 19),
(31, 1, 11, 19),
(32, 1, 11, 19),
(33, 1, 11, 19),
(34, 5, 11, 19),
(35, 4, 11, 19),
(36, 3, 11, 19),
(37, 5, 14, 19),
(38, 2, 14, 19),
(39, 3, 14, 19),
(40, 4, 14, 19),
(41, 3, 14, 19),
(42, 5, 14, 19),
(43, 4, 14, 19),
(44, 4, 14, 19),
(45, 3, 14, 19),
(46, 0, 11, 11),
(47, 3, 11, 11),
(48, 5, 19, 11),
(49, 2, 19, 11),
(50, 3, 19, 11),
(51, 5, 19, 11),
(52, 2, 19, 11),
(53, 3, 5, 11),
(54, 1, 5, 11),
(55, 2, 5, 11),
(56, 3, 5, 11),
(57, 5, 5, 11),
(58, 4, 19, 11),
(59, 3, 5, 11),
(60, 3, 19, 11),
(61, 4, 5, 11),
(62, 3, 19, 11),
(63, 3, 4, 19),
(64, 5, 4, 19),
(65, 2, 14, 19),
(66, 4, 4, 19),
(67, 4, 19, 11),
(68, 3, 19, 11),
(69, 4, 19, 11),
(70, 0, 19, 11),
(71, 0, 19, 11),
(72, 0, 19, 11),
(73, 0, 19, 11),
(74, 0, 19, 11),
(75, 0, 19, 11),
(76, 0, 19, 11),
(77, 0, 19, 11),
(78, 0, 19, 11),
(79, 0, 19, 11),
(80, 0, 19, 11),
(81, 0, 19, 11),
(82, 0, 19, 11),
(83, 0, 19, 11),
(84, 0, 19, 11),
(85, 0, 19, 11),
(86, 0, 19, 11),
(87, 4, 19, 11),
(88, 2, 19, 11);

-- --------------------------------------------------------

--
-- Estrutura da tabela `endereco`
--

CREATE TABLE `endereco` (
  `id_endereco` int(11) NOT NULL,
  `estado` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cidade` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bairro` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logradouro` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_casa` int(11) NOT NULL,
  `cep` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `endereco`
--

INSERT INTO `endereco` (`id_endereco`, `estado`, `cidade`, `bairro`, `logradouro`, `numero_casa`, `cep`, `id_usuario`) VALUES
(1, 'TO', 'Teste', 'Teste', 'Tesre', 12, '83430000', 27),
(2, 'PE', 'adsad', 'sasdas', 'Avasybds', 1, '83880000', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagem`
--

CREATE TABLE `mensagem` (
  `id_mensagem` int(11) NOT NULL,
  `id_remetente` int(11) NOT NULL,
  `id_destinatario` int(11) NOT NULL,
  `mensagem` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_envio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `mensagem`
--

INSERT INTO `mensagem` (`id_mensagem`, `id_remetente`, `id_destinatario`, `mensagem`, `data_envio`) VALUES
(1, 11, 19, 'OII', '2025-05-29 09:27:29'),
(2, 11, 19, ' oii 2', '2025-05-29 09:28:05'),
(4, 11, 19, 'Bom dia ', '2025-05-29 09:47:28'),
(5, 11, 19, 'Olá', '2025-05-29 09:47:57'),
(6, 19, 19, 'Olá', '2025-05-29 09:49:43'),
(7, 19, 19, 'Oláaa', '2025-05-29 09:50:26'),
(8, 11, 21, 'Olá', '2025-05-29 09:58:21'),
(9, 19, 11, 'Olá', '2025-05-29 09:58:56'),
(10, 19, 11, 'Bom dia', '2025-05-29 10:01:31'),
(11, 19, 11, 'oiii', '2025-05-29 10:02:00'),
(12, 19, 11, 'Boa tarde. Gostaria de conversar sobre o valor do serviço', '2025-05-29 16:53:44'),
(13, 11, 19, 'Claro podemos conversar sim', '2025-05-29 16:54:32'),
(14, 14, 19, 'Bom dia. Gostaria de mais informações sobre o corte de grama. Me mande o nome da sua rua e o número da sua casa.', '2025-05-29 17:06:42'),
(15, 14, 19, 'Olá', '2025-05-29 17:10:12'),
(16, 4, 19, 'Bom dia Senhora. Como vai?', '2025-05-29 17:12:12'),
(17, 19, 4, 'Olá', '2025-05-29 17:13:20'),
(18, 15, 19, 'Bom diaaaa', '2025-05-29 17:20:13'),
(19, 19, 15, 'Olá', '2025-05-29 17:31:46'),
(20, 19, 19, 'olá', '2025-05-29 17:40:41'),
(21, 19, 19, 'ola', '2025-05-30 10:17:55');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamento`
--

CREATE TABLE `pagamento` (
  `id_pagamento` int(11) NOT NULL,
  `data_pagamento` date NOT NULL,
  `status_pagamento` enum('pago','pendente') COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor_pagamento` decimal(10,2) NOT NULL,
  `id_solicitante` int(11) DEFAULT NULL,
  `id_prestador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `prestador`
--

CREATE TABLE `prestador` (
  `id_prestador` int(11) NOT NULL,
  `cnpj` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_rg` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chave_pix` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_avaliacao` enum('aprovado','naoverificado') COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_ingresso_facul` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `prestador`
--

INSERT INTO `prestador` (`id_prestador`, `cnpj`, `img_rg`, `chave_pix`, `status_avaliacao`, `data_ingresso_facul`) VALUES
(4, '12345678000199', 'prestador2_rg.jpg', 'prestador2_pix@bank.com', 'aprovado', NULL),
(11, '34352353453453', '../uploads/rg/680a2481eb5d1.jpg', '123', 'aprovado', NULL),
(14, '34352353453453', '../uploads/rg/680a50cf39ac9.jpg', '123', 'aprovado', NULL),
(15, '34352353453453', '../uploads/rg/680a84cadef30.jpg', '123', 'aprovado', NULL),
(22, '34352353453489', '../uploads/rg/680b6999df0be.png', '123', 'aprovado', NULL),
(24, '34352353453453', '../uploads/rg/680b6c6485437.png', 'in23ug9d3g', 'naoverificado', NULL),
(26, '12345678123567', '../uploads/rg/680b74058807a.png', '12345678', 'aprovado', NULL),
(27, '22222222222222', '../uploads/rg/6838602b26e71.jpg', '123', 'aprovado', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `proposta`
--

CREATE TABLE `proposta` (
  `id_proposta` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `id_prestador` int(11) DEFAULT NULL,
  `id_solicitante` int(11) DEFAULT NULL,
  `valor_proposta` decimal(10,2) NOT NULL,
  `justificativa` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `proposta`
--

INSERT INTO `proposta` (`id_proposta`, `id_servico`, `id_prestador`, `id_solicitante`, `valor_proposta`, `justificativa`) VALUES
(20, 6, 4, 3, '90.00', 'Por conta dos curos adicionais preciso cobrar 15 reais acima do valor proprorto por você.'),
(26, 9, 11, 5, '250.00', 'Muito longe de onde moro'),
(27, 10, 11, 3, '234.00', '21w'),
(28, 14, 26, 25, '120.00', 'muito baixo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `servico`
--

CREATE TABLE `servico` (
  `id_servico` int(11) NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_servico` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoria` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_servico` enum('disponivel','aceito','concluido') COLLATE utf8mb4_unicode_ci DEFAULT 'disponivel',
  `local_servico` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `id_solicitante` int(11) DEFAULT NULL,
  `id_prestador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `servico`
--

INSERT INTO `servico` (`id_servico`, `descricao`, `titulo`, `img_servico`, `categoria`, `status_servico`, `local_servico`, `preco`, `id_solicitante`, `id_prestador`) VALUES
(6, 'cdvukvucvavcab', 'Conserto de texxAAlhado', '../uploads/servicosimg_680a280d14e3a.jpg', 'encanamento', 'aceito', 'abranches', '50.00', 3, 4),
(9, 'Conserto de telhado', 'Conserto de telhado', '../uploads/servicos/680a23ed66574.jpg', 'construcao', 'aceito', 'cachoeira', '234.00', 5, 11),
(10, 'Corte de GramaCorte de GramaCorte de Grama', 'Corte de GramaCorte de Grama', '../uploads/servicos/680a4fa106e17.jpg', 'encanamento', 'aceito', 'boqueirao', '50.00', 3, 26),
(12, 'Preciso cortar minha grama, pois está bem alta.\r\nMinha disponibilidade é na sexta-feira 25/04/2025 13:00', 'Corte de Grama', '../uploads/servicos/680b60d74d8e4.jpg', 'jardinagem', 'disponivel', 'butiatuvinha', '89.00', 21, NULL),
(14, 'asd', 'Corte de Grama rosa MODIFICADO Novamente', '../uploads/servicos/680b737d4fec5.jpg', 'construcao', 'aceito', 'abranches', '100.00', 25, 26),
(15, 'Preciso cortar minha grama. Está com 1,2m de altura em um terreno de 12m quadrados.', 'Corte de Grama', '../uploads/servicos/682b718b442ac.jpg', 'jardinagem', 'aceito', 'batel', '150.00', 19, 11),
(16, 'Preciso cortar minha grama. Está com 1,2m de altura em um terreno de 12m quadrados.', 'Corte de Grama 2.0', '../uploads/servicos/682b71b436e32.jpg', 'jardinagem', 'concluido', 'batel', '150.00', 19, 11),
(17, 'Preciso cortar minha grama. Está com 1,2m de altura em um terreno de 12m quadrados.', 'Corte de Grama 3.0', '../uploads/servicos/68308d12bc6aa.jpg', 'jardinagem', 'concluido', 'abranches', '150.00', 19, 14),
(18, 'Preciso cortar minha grama. Está com 1,2m de altura em um terreno de 12m quadrados.', 'Corte de Grama 4.0', '../uploads/servicos/6832236b4588b.jpg', 'jardinagem', 'concluido', 'abranches', '150.00', 19, 4),
(19, 'Preciso cortar minha grama. Está com 1,2m de altura em um terreno de 12m quadrados.', 'Corte de Grama 5.0', '../uploads/servicos/68324b21abfd6.jpg', 'jardinagem', 'aceito', 'batel', '150.00', 19, 11),
(20, 'Preciso cortar minha grama. Está com 1,2m de altura em um terreno de 12m quadrados.', 'Corte de Grama 6.0', '../uploads/servicos/68324b493d84e.jpg', 'jardinagem', 'concluido', 'batel', '150.00', 19, 11),
(21, 'Serviço Teste', 'Serviço Teste', '../uploads/servicos/68376c2307765.jpg', 'construcao', 'disponivel', 'abranches', '123.00', 19, NULL),
(22, 'faffafaf', 'daada', '../uploads/servicos/68e908b97dba9.png', 'cuidados_animais', 'aceito', 'boqueirao', '222.00', 3, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `solicitante`
--

CREATE TABLE `solicitante` (
  `id_solicitante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `solicitante`
--

INSERT INTO `solicitante` (`id_solicitante`) VALUES
(3),
(5),
(19),
(21),
(25);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sobrenome` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cpf` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nacionalidade` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_nascimento` date NOT NULL,
  `nota_reputacao` decimal(3,2) NOT NULL,
  `genero` enum('F','M','O') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_perfil` enum('administrador','prestador','solicitante') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome`, `sobrenome`, `email`, `senha`, `cpf`, `telefone`, `nacionalidade`, `data_nascimento`, `nota_reputacao`, `genero`, `tipo_perfil`) VALUES
(1, 'Administrador', 'Teste', 'admin@teste.com', '$2y$10$iJsLDgYFSEG6vrb6GidjB.OYPTS1EDOZGPr.7/KJYG8LE0diZyT1e', '00000000001', '11999990001', 'Brasileiro', '1990-01-01', '5.00', 'O', 'administrador'),
(3, 'Solicitante', 'Teste', 'solicitante@teste.com', '$2y$10$iJsLDgYFSEG6vrb6GidjB.OYPTS1EDOZGPr.7/KJYG8LE0diZyT1e', '00000000003', '11999990003', 'Brasileiro', '1995-03-03', '4.80', 'F', 'solicitante'),
(4, 'Prestador2', 'Teste2', 'prestador2@teste.com', '$2y$10$iJsLDgYFSEG6vrb6GidjB.OYPTS1EDOZGPr.7/KJYG8LE0diZyT1e', '00000000002', '11999990002', 'Brasileiro', '1992-02-02', '4.00', 'M', 'prestador'),
(5, 'Juliana', 'Solicitante', 'julianas@gmail.com', '$2y$10$xWv5iiOKfTtRoFjpyeY8q.dhND2soAkZ8b/.sVuKOMDRds6mAlnNG', '12345678910', 'Brasileiro', '4199999999', '2006-02-17', '3.00', 'F', 'solicitante'),
(6, 'João', 'Silva', 'joao.silva@email.com', '$2y$10$xWv5iiOKfTtRoFjpyeY8q.dhND2soAkZ8b/.sVuKOMDRds6mAlnNG', '12345678901', '999999999', 'Brasileiro', '1990-05-15', '4.50', 'M', 'prestador'),
(11, 'Juliana', 'pp', 'prestador@gmail.com', '$2y$10$f9LKzai0BY67uzzyY4Dk2OGfUR4NA6.ZNs8gztn5FMXGgQXxjzp7S', '14923829917', 'Brasileiro', '41999999999', '0123-03-12', '2.39', 'F', 'prestador'),
(14, 'prestador3@teste.com', 'prestador3@teste.com', 'prestador3@teste.com', '$2y$10$r1/cRtPooq2oT/heyP5/AeXaODIipYaTrPxiEDpkW3QXgkM255lwy', '14905829917', 'Brasileiro', '4199999999', '1908-03-23', '3.50', 'F', 'prestador'),
(15, 'solicitante@teste2.com', 'solicitante@teste2.com', 'solicitante@teste2.com', '$2y$10$/TKWO/stXjb43LDdCw6K6u5obEdIsa7etYvlTJ.R2XW2iKEtIgE6m', '14905829917', 'Brasileiro', '4199999999', '2009-03-12', '0.00', 'M', 'prestador'),
(19, 'Juliana', 'Teste', 'solicitante@gmail.com', '$2y$10$Mpb2Z5Uey2kSv9iiffOY7uytv4aayZLQHaMjaaKpzhsWTkr5AegzO', '12345678910', 'Brasileiro', '41999999999', '1009-03-31', '1.47', 'M', 'solicitante'),
(21, 'Juliana', 'Aparecida', 'julianasolicitante@gmail.com', '$2y$10$vDQ9xqJsc19IwMtRZkZLPu89r1IdY5KYTQ2l5ZFC4XE/klYFGGohm', '12345678910', 'Brasileiro', '41999999999', '2006-02-17', '0.00', 'F', 'solicitante'),
(22, 'Roberto', 'Silva', 'robertosilva@gmail.com', '$2y$10$6FjaDKUjUpaCUbXoLPqPNOWqqqnsE6O6OazgN.IJfcncnGzY.nEmq', '12345678914', 'Brasileiro', '41993452342', '1970-03-23', '0.00', 'F', 'prestador'),
(24, 'Julia', 'Aparecida', 'juliaaparecida@gmail.com', '$2y$10$Rqipe/DjViu7hmCq02XWb.uH.1U15vAP0oNWgaN2VXxzt9ad2eHFS', '14905829917', 'Brasileiro', '41999999999', '1989-03-04', '0.00', 'F', 'prestador'),
(25, 'Rafael', 'Souza', 'rafael@teste.com', '$2y$10$C8OmiEZI6BVzu24F0oHiUOnGX6EI/XMLmbnq/z7SwgiYXzrnECbXq', '14905829917', 'Brasileiro', '41999999999', '2000-02-12', '0.00', 'M', 'solicitante'),
(26, 'Caio', 'Caio', 'caio@gmail.com', '$2y$10$T4viqQKdnjjOHOrYvxAz3.1HbY0v7uT9rpLOsYX9wzTU4I2hGbjmW', '12345612345', 'Brasileiro', '41999999999', '1999-03-12', '0.00', 'M', 'prestador'),
(27, 'Caio', 'Filipi', 'caio123@gmail.com', '$2y$10$uPt4mDwGTX3WSVjoFuHe8uCEp21VwzMB2PIkSZ7/D/apEAfoBeS2m', '12333333333', '41999999999', 'Brasileiro', '2025-05-17', '0.00', 'M', 'prestador');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD PRIMARY KEY (`id_avaliacao`),
  ADD KEY `id_avaliado` (`id_avaliado`),
  ADD KEY `id_avaliador` (`id_avaliador`);

--
-- Índices para tabela `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`id_endereco`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices para tabela `mensagem`
--
ALTER TABLE `mensagem`
  ADD PRIMARY KEY (`id_mensagem`),
  ADD KEY `id_remetente` (`id_remetente`),
  ADD KEY `id_destinatario` (`id_destinatario`);

--
-- Índices para tabela `pagamento`
--
ALTER TABLE `pagamento`
  ADD PRIMARY KEY (`id_pagamento`),
  ADD KEY `id_solicitante` (`id_solicitante`),
  ADD KEY `id_prestador` (`id_prestador`);

--
-- Índices para tabela `prestador`
--
ALTER TABLE `prestador`
  ADD PRIMARY KEY (`id_prestador`);

--
-- Índices para tabela `proposta`
--
ALTER TABLE `proposta`
  ADD PRIMARY KEY (`id_proposta`),
  ADD KEY `id_solicitante` (`id_solicitante`),
  ADD KEY `id_prestador` (`id_prestador`),
  ADD KEY `id_servico` (`id_servico`);

--
-- Índices para tabela `servico`
--
ALTER TABLE `servico`
  ADD PRIMARY KEY (`id_servico`),
  ADD KEY `id_solicitante` (`id_solicitante`),
  ADD KEY `id_prestador` (`id_prestador`);

--
-- Índices para tabela `solicitante`
--
ALTER TABLE `solicitante`
  ADD PRIMARY KEY (`id_solicitante`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  MODIFY `id_avaliacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT de tabela `endereco`
--
ALTER TABLE `endereco`
  MODIFY `id_endereco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `mensagem`
--
ALTER TABLE `mensagem`
  MODIFY `id_mensagem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `pagamento`
--
ALTER TABLE `pagamento`
  MODIFY `id_pagamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `proposta`
--
ALTER TABLE `proposta`
  MODIFY `id_proposta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `servico`
--
ALTER TABLE `servico`
  MODIFY `id_servico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD CONSTRAINT `avaliacao_ibfk_1` FOREIGN KEY (`id_avaliado`) REFERENCES `usuario` (`id_usuario`) ON DELETE SET NULL,
  ADD CONSTRAINT `avaliacao_ibfk_2` FOREIGN KEY (`id_avaliador`) REFERENCES `usuario` (`id_usuario`) ON DELETE SET NULL;

--
-- Limitadores para a tabela `endereco`
--
ALTER TABLE `endereco`
  ADD CONSTRAINT `endereco_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Limitadores para a tabela `mensagem`
--
ALTER TABLE `mensagem`
  ADD CONSTRAINT `mensagem_ibfk_1` FOREIGN KEY (`id_remetente`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `mensagem_ibfk_2` FOREIGN KEY (`id_destinatario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `pagamento`
--
ALTER TABLE `pagamento`
  ADD CONSTRAINT `pagamento_ibfk_1` FOREIGN KEY (`id_solicitante`) REFERENCES `solicitante` (`id_solicitante`),
  ADD CONSTRAINT `pagamento_ibfk_2` FOREIGN KEY (`id_prestador`) REFERENCES `prestador` (`id_prestador`);

--
-- Limitadores para a tabela `prestador`
--
ALTER TABLE `prestador`
  ADD CONSTRAINT `prestador_ibfk_1` FOREIGN KEY (`id_prestador`) REFERENCES `usuario` (`id_usuario`);

--
-- Limitadores para a tabela `proposta`
--
ALTER TABLE `proposta`
  ADD CONSTRAINT `id_servico` FOREIGN KEY (`id_servico`) REFERENCES `servico` (`id_servico`) ON DELETE CASCADE,
  ADD CONSTRAINT `proposta_ibfk_1` FOREIGN KEY (`id_servico`) REFERENCES `servico` (`id_servico`),
  ADD CONSTRAINT `proposta_ibfk_2` FOREIGN KEY (`id_solicitante`) REFERENCES `solicitante` (`id_solicitante`),
  ADD CONSTRAINT `proposta_ibfk_3` FOREIGN KEY (`id_prestador`) REFERENCES `prestador` (`id_prestador`);

--
-- Limitadores para a tabela `servico`
--
ALTER TABLE `servico`
  ADD CONSTRAINT `servico_ibfk_1` FOREIGN KEY (`id_solicitante`) REFERENCES `solicitante` (`id_solicitante`),
  ADD CONSTRAINT `servico_ibfk_2` FOREIGN KEY (`id_prestador`) REFERENCES `prestador` (`id_prestador`);

--
-- Limitadores para a tabela `solicitante`
--
ALTER TABLE `solicitante`
  ADD CONSTRAINT `solicitante_ibfk_1` FOREIGN KEY (`id_solicitante`) REFERENCES `usuario` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
CREATE TABLE `notificacao` (
  `id_notificacao` int(11) NOT NULL AUTO_INCREMENT,
  `id_remetente` int(11) NOT NULL,
  `id_destinatario` int(11) NOT NULL,
  `id_servico` int(11) DEFAULT NULL,
  `tipo_notificacao` enum('solicitacao','aceito','rejeitado') COLLATE utf8mb4_unicode_ci NOT NULL,
  `mensagem` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lida` tinyint(1) DEFAULT 0,
  `data_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_notificacao`),
  KEY `id_remetente` (`id_remetente`),
  KEY `id_destinatario` (`id_destinatario`),
  KEY `id_servico` (`id_servico`),
  CONSTRAINT `notificacao_ibfk_1` FOREIGN KEY (`id_remetente`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE,
  CONSTRAINT `notificacao_ibfk_2` FOREIGN KEY (`id_destinatario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE,
  CONSTRAINT `notificacao_ibfk_3` FOREIGN KEY (`id_servico`) REFERENCES `servico` (`id_servico`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;