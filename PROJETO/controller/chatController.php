<?php
session_start();

include '../classes/Usuario.php';

$usuario = new Usuario();
if(isset($_POST['envio_mensagem'])){
    $usuario->enviarMensagem($_SESSION['usuario']['id_usuario'], $_POST['id_destinatario'], $_POST['mensagem']);

    header("Location: ../config/chat.php?id_destinatario=" . $_POST['id_destinatario']);
} else {
    echo "Erro no POST";
}
?>