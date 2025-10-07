<?php
class Login{
    private $emailUsuario;
    private $senhaUsuario;
    private $conexao;

    public function __construct($emailUsuario, $senhaUsuario){
        $this->emailUsuario = $emailUsuario;
        $this->senhaUsuario = $senhaUsuario;
        include "../config/conexao.php";  // Conectando ao banco de dados
        $this->conexao = conectaDB(); // Estabelecendo a conexão com o banco
    }

    public function buscarNoBanco(){
        // Prepara a consulta SQL para buscar o e-mail e a senha do usuário
        $sql = "SELECT * FROM usuario WHERE email = ?";
        $stmt = $this->conexao->prepare($sql); 
    
        // Associa o parâmetro (e-mail) à consulta preparada para evitar SQL Injection
        $stmt->bind_param("s", $this->emailUsuario); 
    
        // Executa a consulta preparada
        $stmt->execute();
    
        // Obtém o resultado da execução da consulta
        $resultado = $stmt->get_result(); 
    
        if ($resultado->num_rows > 0){
            // Retorna o primeiro resultado encontrado como um array associativo
            return $resultado->fetch_assoc();
        } else{
            return false;
        }
    }

    public function realizarLogout(){
        if(isset($_SESSION['id'])){
            session_destroy();
            header('location:../index.php');
        }
    }
}


?>