<?php

class DadosUsuario {
    private $nome;
    private $sobrenome;
    private $email;
    private $telefone;
    private $senha;
    private $cpf;
    private $cnpj;
    private $dataNascimento;
    private $genero;
    private $tipoPerfil;
    
    private $rua;
    private $numero;
    private $bairro;
    private $cidade;
    private $estado;
    private $cep;
    
    private $imgRg;
    private $chavePix;
    
    private function __construct() {
    }
    
    public static function paraSolicitante(
        $nome, 
        $sobrenome, 
        $email, 
        $telefone, 
        $senha,
        $cpf, 
        $dataNascimento, 
        $genero,
        $rua = null, 
        $numero = null, 
        $bairro = null,
        $cidade = null, 
        $estado = null, 
        $cep = null
    ) {
        $dados = new self();
        $dados->nome = $nome;
        $dados->sobrenome = $sobrenome;
        $dados->email = $email;
        $dados->telefone = $telefone;
        $dados->senha = $senha;
        $dados->cpf = $cpf;
        $dados->dataNascimento = $dataNascimento;
        $dados->genero = $genero;
        $dados->tipoPerfil = 'solicitante';
        
        $dados->rua = $rua;
        $dados->numero = $numero;
        $dados->bairro = $bairro;
        $dados->cidade = $cidade;
        $dados->estado = $estado;
        $dados->cep = $cep;
        
        $dados->cnpj = null;
        $dados->imgRg = null;
        $dados->chavePix = null;
        
        return $dados;
    }
    
    public static function paraPrestador(
        $nome, 
        $sobrenome, 
        $email, 
        $telefone, 
        $senha,
        $cpf,
        $dataNascimento, 
        $genero,
        $cnpj,
        $imgRg,
        $chavePix,
        $rua, 
        $numero, 
        $bairro,
        $cidade, 
        $estado, 
        $cep
    ) {
        $dados = new self();
        $dados->nome = $nome;
        $dados->sobrenome = $sobrenome;
        $dados->email = $email;
        $dados->telefone = $telefone;
        $dados->senha = $senha;
        $dados->cpf = $cpf;
        $dados->dataNascimento = $dataNascimento;
        $dados->genero = $genero;
        $dados->tipoPerfil = 'prestador';
        
        $dados->cnpj = $cnpj;
        $dados->imgRg = $imgRg;
        $dados->chavePix = $chavePix;
        
        $dados->rua = $rua;
        $dados->numero = $numero;
        $dados->bairro = $bairro;
        $dados->cidade = $cidade;
        $dados->estado = $estado;
        $dados->cep = $cep;
        
        return $dados;
    }
    
    // Getters
    public function getNome() { return $this->nome; }
    public function getSobrenome() { return $this->sobrenome; }
    public function getEmail() { return $this->email; }
    public function getTelefone() { return $this->telefone; }
    public function getSenha() { return $this->senha; }
    public function getCpf() { return $this->cpf; }
    public function getCnpj() { return $this->cnpj; }
    public function getDataNascimento() { return $this->dataNascimento; }
    public function getGenero() { return $this->genero; }
    public function getTipoPerfil() { return $this->tipoPerfil; }
    
    public function getRua() { return $this->rua; }
    public function getNumero() { return $this->numero; }
    public function getBairro() { return $this->bairro; }
    public function getCidade() { return $this->cidade; }
    public function getEstado() { return $this->estado; }
    public function getCep() { return $this->cep; }
    
    public function getImgRg() { return $this->imgRg; }
    public function getChavePix() { return $this->chavePix; }
    
    // Métodos Helper
    public function temCpf() {
        return $this->cpf !== null && trim($this->cpf) !== '';
    }
    
    public function temCnpj() {
        return $this->cnpj !== null && trim($this->cnpj) !== '';
    }
    
    public function temEndereco() {
        return $this->rua !== null && 
               $this->numero !== null && 
               $this->bairro !== null &&
               $this->cidade !== null && 
               $this->estado !== null && 
               $this->cep !== null;
    }
}
?>