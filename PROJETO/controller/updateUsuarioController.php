<?php
session_start();
include '../classes/UsuarioFacade.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['usuario'])) {
    $usuario = new UsuarioFacade();
    $id = $_SESSION['usuario']['id_usuario'];


    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];


    $usuario->alterar('usuario', $id, 'nome', $nome);
    $usuario->alterar('usuario', $id, 'sobrenome', $sobrenome);
    $usuario->alterar('usuario', $id, 'email', $email);
    $usuario->alterar('usuario', $id, 'telefone', $telefone);


    $_SESSION['usuario']['nome'] = $nome;
    $_SESSION['usuario']['sobrenome'] = $sobrenome;
    $_SESSION['usuario']['email'] = $email;
    $_SESSION['usuario']['telefone'] = $telefone;

    header('Location: ../config/perfilUsuario.php?sucesso=1');
    exit;
}
header('Location: ../config/perfilUsuario.php?erro=1');
exit;