<?php session_start();
if (isset($_SESSION['login'])) {
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ChamauZé</title>
    <link rel="shortcut icon" href="../assets/img/chamuzeFavicon.ico" type="image/x-icon">
    <!-- Link para o Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex flex-column" style="height: 100vh;">

    <div class="container-fluid d-flex justify-content-center align-items-center flex-grow-1">

        <img src="../assets/img/chamuzeLogoSemFundo.png" alt="Logo Chamauze" class="img-fluid"
            style="max-width: 430px;">
        <div class="alert alert-danger">
            Erro: Banco de dados não encontrado
            <a class="btn btn-primary" href="../login.php" role="button">Retornar ao Login</a>
        </div>


    </div>
    </div>

    <!-- Inclusão do footer padrão -->
    <?php include "../footer.php"; ?>

    <!-- Link para o Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>