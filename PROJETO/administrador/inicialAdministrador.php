<?php
session_start();

include "../helpers/biblioteca.php";

verificarAcesso('administrador');
verificarSessaoExpirada();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início do Administrador - Chamauze</title>
    <link rel="shortcut icon" href="../assets/img/chamuzeFavicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "../header/header.php"; ?>

    <main class="flex-grow-1 d-flex justify-content-center align-items-center">
        <div class="text-center">
            <h1 class="mb-3">Painel Administrativo</h1>
            <p class="lead">Bem-vindo, <?= htmlspecialchars($_SESSION['usuario']['nome']) ?>!</p>
            <p class="text-muted">Utilize o menu acima para gerenciar usuários, prestadores e serviços da plataforma Chamauze.</p>
        </div>
    </main>

    <?php include "../footer.php"; ?>
</body>

</html>
