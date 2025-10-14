<?php
// Inclui a conexão apenas uma vez no topo do arquivo
require_once __DIR__ . '/../config/Conexao.php';

class Login {
    private $emailUsuario;
    private $senhaUsuario;
    private $conexao;

    // Construtor recebe os dados do login
    public function __construct($emailUsuario, $senhaUsuario){
        $this->emailUsuario = $emailUsuario;
        $this->senhaUsuario = $senhaUsuario;
        // Pega a conexão do Singleton
        $this->conexao = Conexao::getInstance()->getConexao();
    }

    // Busca usuário no banco pelo email
    public function buscarNoBanco(){
        $sql = "SELECT * FROM usuario WHERE email = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("s", $this->emailUsuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0){
            return $resultado->fetch_assoc(); // retorna array associativo
        } else{
            return false;
        }
    }

    // Realiza logout do usuário
    public function realizarLogout(){
        if(isset($_SESSION['id'])){
            session_destroy();
            header('Location: ../index.php');
            exit; // garante que nada mais seja executado após o redirect
        }
    }
}
?>
