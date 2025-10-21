<?php
session_start();
include_once "../classes/Login.php";

if (isset($_POST['btn_login'])) {
    $login = new Login($_POST['email'], $_POST['senha']);

    $usuario = $login->buscarNoBanco();
    
    if ($usuario == false) {
        header('Location: ../login.php?erro=1'); 
        exit;
    } else {
        if ($_POST['email'] == $usuario['email'] && password_verify($_POST['senha'], $usuario['senha'])) {

            if ($usuario['tipo_perfil'] == "prestador") {

                require_once __DIR__ . '/../config/Conexao.php';
                $conexao = Conexao::getInstance()->getConexao();
                
                $sql = "SELECT status_avaliacao FROM prestador WHERE id_prestador = ?";
                $stmt = $conexao->prepare($sql);
                $stmt->bind_param("i", $usuario['id_usuario']);
                $stmt->execute();
                $result = $stmt->get_result();
                $prestador = $result->fetch_assoc();
                
                if ($prestador && $prestador['status_avaliacao'] != "aprovado") {
                    header('Location: ../login.php?erro=3'); 
                    exit;
                }
            }
            
            $_SESSION['login'] = true;
            $_SESSION['inicioSessao'] = time();
            $_SESSION['usuario'] = $usuario;

            if (isset($_SESSION['usuario']['tipo_perfil'])) {
                switch ($_SESSION['usuario']['tipo_perfil']) {
                    case "solicitante":
                        header("Location: ../solicitante/inicialSolicitante.php");
                        exit;
                        break;
                    case "prestador":
                        header("Location: ../prestador/inicialPrestador.php");
                        exit;
                        break;
                    case "administrador":
                        header("Location: ../administrador/inicialAdministrador.php");
                        exit;
                        break;
                }
            }
        } else {
            header('Location: ../login.php?erro=2'); // Senha incorreta
            exit;
        }
    }
}
?>