<?php 
session_start();

if(isset($_SESSION['login'])){
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ChamauZé</title>
    <link rel="shortcut icon" href="assets/img/chamuzeFavicon.ico" type="image/x-icon">
    <!-- Link para o Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column" style="height: 100vh;">

    <div class="container-fluid d-flex justify-content-center align-items-center flex-grow-1">
        <div class="row w-100">
            <!-- Imagem (Logo) -->
            <div class="col-12 col-md-6 d-flex justify-content-center align-items-center mb-4 mb-md-0">
                <img src="assets/img/chamuzeLogoSemFundo.png" alt="Logo Chamauze" class="img-fluid" style="max-width: 430px;">
            </div>

            <!-- Formulário de Login -->
            <div class="col-12 col-md-5 bg-white p-5 rounded-5 shadow">
                <h2 class="text-center mb-4">Login</h2>
                <!-- Verificação de erros de login -->
                <?php
                switch (isset($_GET['erro']) ? $_GET['erro'] : null) {
                    case '1':
                        echo "<div class=\"alert alert-danger\">
                                Usuário não cadastrado na base de dados!
                            </div>";
                        break;
                    
                    case '2':
                        echo "<div class=\"alert alert-danger\">
                                E-mail ou senha incorretos!
                            </div>";
                        break;

                        case '3':
                            echo "<div class=\"alert alert-danger\">
                                    Seu cadastro como prestador ainda não foi validado, está em análise!
                                </div>";
                            break;

                    case '0':
                        echo "<div class=\"alert alert-success\">
                                Cadastrado com sucesso!
                            </div>";
                        break;

                    default:
                        // Caso não haja 'erro' ou 'sucesso', não exibe nada
                        break;
                }
                ?>

                <form action="controller/loginController.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail" required>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha" required>
                    </div>
                    <button type="submit" class="btn btn-warning w-100 text-dark" name="btn_login">Entrar</button>
                </form>
                <div class="text-center mt-3">
                    <p class="mb-0">Não possui uma conta? <a href="cadastroEscolha.php">Cadastre-se</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Inclusão do footer padrão -->
    <?php include "footer.php";?>

    <!-- Link para o Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>