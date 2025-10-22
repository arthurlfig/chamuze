<?php
    include "../classes/UsuarioFacade.php";
    $usuario = new UsuarioFacade();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id_usuario'] ?? null;
        $tipo_usuario = $_POST['acao'] ?? null;
        if ($usuario->deletarPorID($tipo_usuario, $id)) {
            header("Location: ../administrador/gerenciarUsuarios.php?erro=0");
            exit;
        }
        else {
            header("Location: ../administrador/gerenciarUsuarios.php?erro=1");
            exit;
        }
    }
?>