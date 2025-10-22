<?php
    include "../classes/UsuarioFacade.php";
    $usuario = new UsuarioFacade();

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){  
        $id = $_POST['id_usuario'] ?? null;
        $acao = $_POST['acao'] ?? null;

        if($id && $acao == "aceito"){
            if($usuario->alterar("prestador", $id, "status_avaliacao", "aprovado")){
                header("Location: ../administrador/avaliarPrestadores.php?erro=0");
                exit;
            }
        }
        else if($id && $acao == "recusado"){
            if($usuario->deletarPorID("prestador", $id)){
                header("Location: ../administrador/avaliarPrestadores.php?erro=1");
                exit;
            }
        }
        header("Location: ../administrador/avaliarPrestadores.php?erro=2");
        exit;
    }

?>
