<?php
session_start();

include "../helpers/biblioteca.php";

//Lógica extra para verificar acesso


if(isset($_GET['id_destinatario'])){
    $id_destinatario = $_GET['id_destinatario'];
}

$id_remetente = $_SESSION['usuario']['id_usuario'];

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Bate-papo - ChamuZé</title>
    <link rel="stylesheet" href="../assets/css/estrelas.css">
    <link rel="shortcut icon" href="../assets/img/chamuzeFavicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/estilo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .card-text {
            word-wrap: break-word;
            overflow-wrap: break-word;
            max-height: 100px;
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-light  vh-100">
    <?php include "../header/header.php"; ?>
    <main class="container min-vh-100">
        <h2 class="my-4 text-center">Suas conversas</h2>
        <?php 
            $idDosContatos = buscarListaDeContatosNoBanco($id_remetente);
            if (count($idDosContatos) <= 0){
                echo '<div class = "alert alert-info mt-4" role="alert"">
                        Você ainda não possui conversas!
                    </div>';
            } else {
                for($i = 0; $i < count($idDosContatos); $i++){
                    $usuario = buscarUsuarioPeloId($idDosContatos[$i]["id_destinatario"]);
                ?>
                <div class="card mb-3" style="cursor: pointer;" onclick="window.location.href='../config/chat.php?id_destinatario=<?= $usuario['id_usuario'] ?>'">
                    <div class="card-body bg-warning bg-opacity-75">
                        <h5 class="card-title mb-1"><?= $usuario["nome"]?> <?= $usuario["sobrenome"] ?></h5>
                        <p class="card-text text-muted mb-0"><?= $usuario["email"] ?></p>
                    </div>
                </div>

            <?php }
                    }?>
    </main>


    <?php include "../footer.php"; ?>
</body>

</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
