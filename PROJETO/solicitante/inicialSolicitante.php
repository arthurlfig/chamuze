<?php
session_start();

include "../helpers/biblioteca.php";

verificarSessaoExpirada();
verificarAcesso("solicitante");

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChamuZé</title>
    <link rel="shortcut icon" href="../assets/img/chamuzeFavicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include "../header/header.php"; ?>
    <main class="d-flex flex-column justify-content-center align-items-center vh-100 bg-light text-center">
        <h3 class="display-3 mb-4">Seu serviço doméstico a um clique de distância.</h3>
        <h3 class="mb-4">Chama o Zé!</h3>
        <a href="solicitarServico.php" class="btn btn-warning" style="padding: 5px 10px; font-size: 1.2rem;">Solicitar Serviço</a>
    </main>

    <?php include "../footer.php"; ?>
</body>

</html>