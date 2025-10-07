<?php
session_start();
include "../helpers/biblioteca.php";
if (isset($_POST['estrela'])){
    //Salvar na tabela avaliação
    salvarAvaliacaoNoBanco($_POST['estrela'] ,$_POST['id_avaliado'], $_SESSION['usuario']['id_usuario']);
    //Salvar nota recalculada na tabela usuário
    $novaNota = recalcularNotaAvaliacao($_POST['id_avaliado']);
    atualizarCampoDeNotaRecalculada($novaNota, $_POST['id_avaliado']);

    switch ($_SESSION['usuario']['tipo_perfil']){
        case 'prestador':
            header("Location: ../prestador/meusServicos.php?erro=-1");
            break;
        case 'solicitante':
            header("Location: ../solicitante/visualizarServicos.php?erro=-1");
            break;
    }
}

?>