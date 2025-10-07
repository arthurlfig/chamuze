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
	tipo_perfil ENUM('administrador','prestador','solicitante')NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Criação da tabela prestador - Especialização - */
CREATE TABLE prestador (
	id_prestador INTEGER NOT NULL PRIMARY KEY,
	FOREIGN KEY (id_prestador) REFERENCES usuario(id_usuario),
	cnpj VARCHAR(14) NOT NULL,
	img_rg VARCHAR(255) NOT NULL,
	chave_pix VARCHAR(255) NOT NULL,
	status_avaliacao ENUM('aprovado','reprovado','naoverificado') NOT NULL
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
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Criação da tabela servico */
CREATE TABLE servico (
    id_servico INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    descricao TEXT NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    img_servico VARCHAR(255) NOT NULL,
    categoria VARCHAR(255) NOT NULL,
    status_servico ENUM('aceito','disponivel', 'concluido') NOT NULL,
    local_servico VARCHAR(100) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    id_solicitante INTEGER,
    id_prestador INTEGER,
    FOREIGN KEY (id_solicitante) REFERENCES solicitante(id_solicitante),
    FOREIGN KEY (id_prestador) REFERENCES prestador(id_prestador)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Criação da tabela proposta */
CREATE TABLE proposta (
	id_proposta INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_servico INTEGER NOT NULL,
	id_prestador INTEGER,
	id_solicitante INTEGER,
	valor_proposta DECIMAL(10,2) NOT NULL,
    justificativa TEXT NOT NULL,
    FOREIGN KEY (id_servico) REFERENCES servico(id_servico),
    FOREIGN KEY (id_solicitante) REFERENCES solicitante(id_solicitante),
    FOREIGN KEY (id_prestador) REFERENCES prestador(id_prestador)
);

/*Criação da tabela mensagem*/
CREATE TABLE mensagem (
    id_mensagem INT AUTO_INCREMENT PRIMARY KEY,
    id_remetente INT NOT NULL,
    id_destinatario INT NOT NULL,
    mensagem TEXT NOT NULL,
    data_envio DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    FOREIGN KEY (id_remetente) REFERENCES usuario(id_usuario) ON DELETE CASCADE,
	FOREIGN KEY (id_destinatario) REFERENCES usuario(id_usuario) ON DELETE CASCADE
);

/*Criação da tabela avaliação*/
CREATE TABLE avaliacao (
    id_avaliacao INT AUTO_INCREMENT PRIMARY KEY,
    id_avaliado INT NOT NULL,
    id_avaliador INT NOT NULL,
    nota INTEGER NOT NULL,
    FOREIGN KEY (id_remetente) REFERENCES usuario(id_usuario) ON DELETE CASCADE,
	FOREIGN KEY (id_destinatario) REFERENCES usuario(id_usuario) ON DELETE CASCADE
);