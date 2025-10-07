<?php
session_start();
include "../helpers/biblioteca.php";

verificarSessaoExpirada();



if (isset($_GET['id_solicitante'])) {
    $solicitante = buscarSolicitanteNoBancoPeloId($_GET['id_solicitante']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChamuZé - Página solicitante</title>
    <link rel="stylesheet" href="../assets/css/estrelas.css">
    <link rel="shortcut icon" href="../assets/img/chamuzeFavicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/estilo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <?php
    include "../header/header.php";
    ?>

    <main class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
        <div class="col-md-6 shadow-lg p-4 bg-white rounded-4 border">
            <!-- Cabeçalho -->
            <div class="d-flex align-items-center mb-4">
                <h2 class="m-0">Perfil do solicitante</h2>
            </div>
            <p><strong>Id:</strong> <?= $solicitante['id_solicitante'] ?></p>
            <p><strong>Nome:</strong> <?= $solicitante['nome'] ?></p>
            <p><strong>Sobrenome:</strong> <?= $solicitante['sobrenome'] ?></p>
            <p><strong>E-mail:</strong> <?= $solicitante['email'] ?></p>
            <p><strong>Telefone:</strong> <?= $solicitante['telefone'] ?></p>
            <p><strong>Gênero:</strong> <?= $solicitante['genero'] ?></p>
            <p><strong>Data de nascimento:</strong> <?= $solicitante['data_nascimento'] ?></p>
            <p><strong>Avaliação:</strong></p>
            <div>
                <?php
                if ($solicitante['nota_reputacao'] <= 0) {
                    echo "<div> 
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    </div>";
                } else if ($solicitante['nota_reputacao'] <= 1.5) {
                    echo "<div> 
                    <i class='bi bi-star-fill estrela-avaliacao-preenchida'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    </div>";
                } else if ($solicitante['nota_reputacao'] <= 2.5) {
                    echo "<div> 
                    <i class='bi bi-star-fill estrela-avaliacao-preenchida'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-preenchida'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    </div>";
                } else if ($solicitante['nota_reputacao'] <= 3.5) {
                    echo "<div> 
                    <i class='bi bi-star-fill estrela-avaliacao-preenchida'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-preenchida'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-preenchida'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    </div>";
                } else if ($solicitante['nota_reputacao'] <= 4.5) {
                    echo "<div> 
                    <i class='bi bi-star-fill estrela-avaliacao-preenchida'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-preenchida'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-preenchida'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-preenchida'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    </div>";
                } else {
                    echo "<div> 
                    <i class='bi bi-star-fill estrela-avaliacao-preenchida'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-preenchida'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-preenchida'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-preenchida'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-preenchida'></i>
                    </div>";
                }
                ?>
            </div>

            <!-- Botão de conversa -->
            <form action="../config/chat.php" class="mt-4 text-end" method="GET">
                <button class="btn btn-primary rounded-pill p-3">
                    <input type="hidden" value="<?= $solicitante['id_solicitante'] ?>" name="id_destinatario">
                    <i class="bi bi-chat-dots"></i> Conversar
                </button>
            </form>
        </div>
        </div>
    </main>


    <?php include "../footer.php"; ?>

</body>

</html>