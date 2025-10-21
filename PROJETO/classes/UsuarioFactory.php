<?php
require_once __DIR__ . '/../config/Conexao.php';

abstract class UsuarioFactory {
    
    public final function criarERegistrar(DadosUsuario $dados) {
        try {
            $conexao = Conexao::getInstance()->getConexao();
            $conexao->begin_transaction();
            
            $idUsuario = $this->criarUsuario($dados);
            
            $this->salvarTipoUsuario($idUsuario, $dados);
            
            if ($dados->temEndereco()) {
                $this->salvarEndereco($idUsuario, $dados);
            }
            
            $this->registrarObservador($idUsuario);
            
            $conexao->commit();
            
            return $idUsuario;
            
        } catch (Exception $e) {
            $conexao->rollback();
            throw new Exception("Erro ao criar usuário: " . $e->getMessage());
        }
    }
    
    protected function criarUsuario(DadosUsuario $dados) {
        $conexao = Conexao::getInstance()->getConexao();
        
        $sql = "INSERT INTO usuario (
            nome, 
            sobrenome, 
            email, 
            senha, 
            cpf, 
            telefone, 
            nacionalidade, 
            data_nascimento, 
            genero, 
            tipo_perfil
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conexao->prepare($sql);
        
        $senhaHash = password_hash($dados->getSenha(), PASSWORD_DEFAULT);
        $nacionalidade = 'Brasileiro';
        
        $nome = $dados->getNome();
        $sobrenome = $dados->getSobrenome();
        $email = $dados->getEmail();
        $cpf = $dados->getCpf();
        $telefone = $dados->getTelefone();
        $dataNascimento = $dados->getDataNascimento();
        $genero = $dados->getGenero();
        $tipoPerfil = $dados->getTipoPerfil();
        
        $stmt->bind_param(
            "ssssssssss",
            $nome,
            $sobrenome,
            $email,
            $senhaHash,
            $cpf,
            $telefone,
            $nacionalidade,
            $dataNascimento,
            $genero,
            $tipoPerfil
        );
        
        if (!$stmt->execute()) {
            throw new Exception("Erro ao salvar usuário: " . $stmt->error);
        }
        
        return $conexao->insert_id;
    }
    
    protected function salvarEndereco($idUsuario, DadosUsuario $dados) {
        $conexao = Conexao::getInstance()->getConexao();
        
        $sql = "INSERT INTO endereco (
            estado, 
            cidade, 
            bairro, 
            logradouro, 
            numero_casa, 
            cep, 
            id_usuario
        ) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conexao->prepare($sql);
        
        // Armazenar em variáveis para passar por referência
        $estado = $dados->getEstado();
        $cidade = $dados->getCidade();
        $bairro = $dados->getBairro();
        $rua = $dados->getRua();
        $numero = $dados->getNumero();
        $cep = $dados->getCep();
        
        $stmt->bind_param(
            "ssssssi",
            $estado,
            $cidade,
            $bairro,
            $rua,
            $numero,
            $cep,
            $idUsuario
        );
        
        if (!$stmt->execute()) {
            throw new Exception("Erro ao salvar endereço: " . $stmt->error);
        }
    }
    
    abstract protected function salvarTipoUsuario($idUsuario, DadosUsuario $dados);
    
    protected function registrarObservador($idUsuario) {

    }
}
?>