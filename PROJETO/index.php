<?php
session_start();

if(isset($_SESSION['login'])){
    switch ($_SESSION['usuario']['tipo_perfil']){
        case "solicitante":
            header('location:solicitante/inicialSolicitante.php');
            break;
        case "prestador":
            header('location:prestador/inicialPrestador.php');
            break;
        case "administrador":
            header('location:administrador/inicialAdministrador.php');
            break;
    }
} else {
    header("Location: login.php");
}
?>



