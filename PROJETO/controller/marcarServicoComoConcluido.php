<?php
session_start();

include '../helpers/biblioteca.php';

    if(isset($_POST['id_servico'])){
        marcarServicoComoConcluido($_POST['id_servico']);
        header("Location: ../prestador/meusServicos.php?erro=0");
        exit();
    } else {
        header("Location: ../prestador/meusServicos.php?erro=1");
        exit();
    }
?>