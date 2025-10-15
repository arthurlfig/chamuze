<?php

session_start();
require_once "../classes/Servico.php";
require_once "../helpers/biblioteca.php";

//Verificação de restrição de acesso
verificarSessaoExpirada();
verificarAcesso('prestador');


if (!isset($_GET['id_servico'])) {
    header("Location: inicialPrestador.php");
    exit();
}

$id_servico = $_GET['id_servico'];

$servico = new Servico();
$dados = $servico->buscarPorId($id_servico);

if (!$dados) {
    header("Location: inicialPrestador.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Serviço - ChamuZé</title>
    <link rel="shortcut icon" href="../assets/img/chamuzeFavicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/estilo.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "../header/header.php"; ?>

    <main class="container my-5">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h3 class="mb-0"><?= $dados['titulo'] ?></h3>
            </div>

            <div class="card-body row">
                <div class="col-md-4 text-center">
                    <img src="<?= $dados['img_servico'] ?>" alt="Imagem do Serviço" class="img-fluid rounded"
                        style="max-height: 250px; object-fit: cover;">
                </div>

                <div class="col-md-8">
                    <p><strong>Descrição:</strong> <?= $dados['descricao'] ?></p>
                    <p><strong>Categoria:</strong> <?= $dados['categoria'] ?></p>
                    <p><strong>Região:</strong> <?= $dados['local_servico'] ?></p>
                    <p><strong>Status:</strong> <?= $dados['status_servico'] ?></p>
                    <p class="fw-bold text-success" style="font-size: 1.5em;">
                        <i class="bi bi-currency-dollar"></i> R$: <?= $dados['preco'] ?>
                    </p>

                    <div class="service-buttons d-flex justify-content-between mt-4">
                        <form method="POST" action="aceitarServico.php" class="d-inline">
                            <input type="hidden" name="id_servico" value="<?= $dados['id_servico'] ?>">
                            <button type="submit" name="btn-editar" class="btn btn-success btn-lg">
                                <i class="bi bi-check-circle"></i> Aceitar Serviço
                            </button>
                        </form>

                        <form id="form-proposta" method="GET" action="realizarProposta.php" class="d-inline">
                            <input type="hidden" name="id_servico" value="<?= $dados['id_servico'] ?>">
                            <button type="button" id="btn-proposta" class="btn btn-warning btn-lg">
                                <i class="bi bi-credit-card"></i> Realizar Proposta
                            </button>
                        </form>

                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <a href="inicialPrestador.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </main>
    <script>
        document.getElementById("btn-proposta").addEventListener("click", function () {
            Swal.fire({
                title: 'Deseja realizar uma Proposta?',
                text: "Não há garantias que o solicitante aceitará sua proposta",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sim, enviar proposta',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("form-proposta").submit();
                }
            });
        });
</script>

    <?php include "../footer.php"; ?>
</body>

</html>