<?php
session_start();
include "../helpers/biblioteca.php";

//Verificação de restrição de acesso
verificarSessaoExpirada();
$prestador = buscarPrestadorNoBancoPeloId($_GET['id_prestador'] ?? null);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChamuZé - Página Prestador</title>
    <link rel="stylesheet" href="../assets/css/estrelas.css">
    <link rel="shortcut icon" href="../assets/img/chamuzeFavicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/estilo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-light  vh-100">
    <?php
    include "../header/header.php";

    ?>

    <main class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
        <div class="col-md-6 shadow-lg p-4 bg-white rounded-4 border">
            <!-- Cabeçalho -->
            <div class="d-flex align-items-center mb-4">
                <h2 class="m-0">Perfil do Prestador</h2>
            </div>
            <p><strong>Id:</strong> <?= $prestador['id_prestador'] ?></p>
            <p><strong>Nome:</strong> <?= $prestador['nome'] ?></p>
            <p><strong>Sobrenome:</strong> <?= $prestador['sobrenome'] ?></p>
            <p><strong>E-mail:</strong> <?= $prestador['email'] ?></p>
            <p><strong>Telefone:</strong> <?= $prestador['telefone'] ?></p>
            <p><strong>Gênero:</strong> <?= $prestador['genero'] ?></p>
            <p><strong>Data de nascimento:</strong> <?= $prestador['data_nascimento'] ?></p>
            <p><strong>Avaliação:</strong></p>
            <div>
                <?php
                if ($prestador['nota_reputacao'] <= 0) {
                    echo "<div> 
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    </div>";
                } else if ($prestador['nota_reputacao'] <= 1.5) {
                    echo "<div> 
                    <i class='bi bi-star-fill estrela-avaliacao-preenchida'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    </div>";
                } else if ($prestador['nota_reputacao'] <= 2.5) {
                    echo "<div> 
                    <i class='bi bi-star-fill estrela-avaliacao-preenchida'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-preenchida'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    </div>";
                } else if ($prestador['nota_reputacao'] <= 3.5) {
                    echo "<div> 
                    <i class='bi bi-star-fill estrela-avaliacao-preenchida'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-preenchida'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-preenchida'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    <i class='bi bi-star-fill estrela-avaliacao-vazia'></i>
                    </div>";
                } else if ($prestador['nota_reputacao'] <= 4.5) {
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
                <input type="hidden" value="<?= $prestador['id_prestador'] ?>" name="id_destinatario">
                <button class="btn btn-primary rounded-pill p-3">
                    <i class="bi bi-chat-dots"></i> Conversar
                </button>
            </form>
        </div>
        </div>
    </main>


    <?php include "../footer.php"; ?>

</body>

</html>