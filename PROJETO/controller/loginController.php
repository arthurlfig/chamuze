<?php
session_start();
include_once "../classes/Login.php";
include_once "../classes/Usuario.php";

if (isset($_POST['btn_login'])) {
    $login = new Login($_POST['email'], $_POST['senha']);
    $usuarioObj = new Usuario();

    $usuario = $login->buscarNoBanco();
    if ($usuario == false) {
        header('Location: ../login.php?erro=1'); // Usuário não existe
        exit;
    } else {
        if ($_POST['email'] == $usuario['email'] && password_verify($_POST['senha'], $usuario['senha'])) {
            if ($usuario['tipo_perfil'] == "prestador") {
                $usuarioPrestador = $usuarioObj->buscarPorId("prestador", $usuario['id_usuario']);
                if ($usuarioPrestador['status_avaliacao'] != "aprovado") {
                    header('Location: ../login.php?erro=3'); // Prestador não aprovado
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
