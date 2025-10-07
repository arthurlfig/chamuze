<?php
session_start();
include "../helpers/biblioteca.php";
include "../classes/Servico.php"; // Incluindo a classe Servico

//Verificação de restrição de acesso
verificarSessaoExpirada();
verificarAcesso('solicitante');

// Criando a instância da classe Servico
$servico = new Servico();
$categoriaSelecionada = $_GET['categoria'] ?? null;
$servicos = $servico->buscarPorSolicitante($_SESSION['usuario']['id_usuario']);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChamuZé - Meus Serviços</title>
    <link rel="shortcut icon" href="../assets/img/chamuzeFavicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/estrelas.css">
    <link rel="stylesheet" href="../assets/css/estilo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "../header/header.php"; ?>

    <main class="container flex-grow-1 py-4">
        <?php
        if (isset($_GET['erro'])) {
            switch ($_GET['erro']) {
                case -1:
                    echo "<script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso!',
                                text: 'Prestador avaliado com sucesso!'
                            });
                        </script>";
                    break;
                case 0:
                    echo "<script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso!',
                                text: 'O serviço foi excluído com sucesso!'
                            });
                        </script>";
                    break;
                case 1:
                    echo "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro!',
                                text: 'Ops, algo deu errado. O serviço não foi excluído!'
                            });
                        </script>";
                    break;
            }
        }
        ?>

        <h1 class="text-center mt-4 mb-4">Serviços Disponíveis</h1>
        <?php if (count($servicos) < 1): ?>
            <div class="alert alert-info mt-4" role="alert">
                Você não possui serviços cadastrados no momento!
            </div>
        <?php endif; ?>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
            <?php foreach ($servicos as $row):
                if ($row['status_servico'] == "aceito") {
                    $heaerCard = "card-header bg-warning bg-opacity-75 d-flex justify-content-between";
                    $letraCardAceito = "block";
                    $letraCardConcluido = "none";
                    $stiloPrestadorResponsavel = "block";
                    $visibilidadeBotaoAvaliacaoPrestador = "none";
                } else if ($row['status_servico'] == "concluido") {
                    $heaerCard = "card-header bg-success bg-opacity-75 d-flex justify-content-between";
                    $letraCardAceito = "none";
                    $letraCardConcluido = "block";
                    $visibilidadeBotaoAvaliacaoPrestador = "block";
                    $stiloPrestadorResponsavel = "block";
                } else {
                    $heaerCard = "card-header d-flex";
                    $letraCard = "none";
                    $stiloPrestadorResponsavel = "none";
                    $visibilidadeBotaoAvaliacaoPrestador = "none";
                    $letraCardAceito = "none";
                    $letraCardConcluido = "none";
                }
            ?>
                <div class="col">
                    <div class="card shadow-sm h-100">
                        <!-- Cabeçalho do Card -->
                        <div class="<?= $heaerCard ?>">
                            <h5 class="card-title mb-0"><?= $row['titulo'] ?></h5>
                            <div style="display:<?= $letraCardAceito ?>">
                                <i class="bi bi-check-lg"></i> Serviço Aceito
                            </div>
                            <div style="display:<?= $letraCardConcluido ?>">
                                <i class="bi bi-check-circle"></i> Serviço Concluído
                            </div>
                        </div>

                        <!-- Corpo do Card -->
                        <div class="row-1">
                            <div class="card-body d-flex flex-column flex-md-row">
                                <!-- Imagem -->
                                <div class="flex-shrink-0 me-md-3 mb-3 mb-md-0 text-center">
                                    <img src="<?= $row['img_servico'] ?>" class="img-fluid rounded" alt="Imagem do Serviço"
                                        style="max-width: 150px; max-height: 150px; object-fit: cover;">
                                </div>
                                <!-- Texto -->
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-1 small"><strong>Categoria:</strong> <?= $row['categoria'] ?></p>
                                    <p class="text-muted mb-1 small"><strong>Região:</strong> <?= $row['local_servico'] ?></p>
                                    <p class="card-text small"><?= $row['descricao'] ?></p>
                                    <p class="text-muted mb-2 small"><strong>Disponibilidade Serviço:</strong>
                                        <?= $row['status_servico'] ?></p>
                                        
                                    <p class="fw-bold text-success mb-0" style="font-size: 1.1em;">
                                        <i class="bi bi-currency-dollar"></i> R$: <?= $row['preco'] ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row-2">
                            <form action="../prestador/paginaPrestador.php" method="GET">
                                <?php $prestador = buscarPrestadorNoBancoPeloId($row['id_prestador']) ?>
                                <button class="botao-prestador-responsavel" 
                                        style="display:<?= $stiloPrestadorResponsavel ?>" 
                                        name="id_prestador" 
                                        value="<?= $row['id_prestador'] ?>">
                                    <strong><i class="bi bi-person-video"></i> Prestador responsável:</strong> <?= $prestador['nome'] ?>
                                </button>
                            </form>
                        </div>

                        <!-- Rodapé com Botões -->
                        <div class="card-footer d-flex flex-wrap justify-content-end gap-2">
                            <!-- Botão para abrir modal de avaliação -->
                            <form action="#">
                                <button type="button" class="btn btn-warning" style="display: <?= $visibilidadeBotaoAvaliacaoPrestador ?>" data-bs-toggle="modal" data-bs-target="#avaliarModal<?= $row['id_servico'] ?>">
                                    <i class="bi bi-star-half"></i> Avaliar Prestador
                                </button>
                            </form>

                            <form method="POST" action="updateServico.php" class="d-inline">
                                <input type="hidden" name="id_servico" value="<?= $row['id_servico'] ?>">
                                <button type="submit" name="btn-editar" class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil"></i> Editar
                                </button>
                            </form>
                            <form method="POST" action="../controller/deleteServicoController.php"
                                id="form-excluir-<?= $row['id_servico'] ?>" class="d-inline">
                                <input type="hidden" name="id_servico" value="<?= $row['id_servico'] ?>">
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="confirmarExclusao(<?= $row['id_servico'] ?>)">
                                    <i class="bi bi-trash"></i> Excluir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

        <!-- Modal de avaliação específico para cada serviço -->
        <div class="modal fade" id="avaliarModal<?= $row['id_servico'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="avaliarModalLabel<?= $row['id_servico'] ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="avaliarModalLabel<?= $row['id_servico'] ?>">Avaliação</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>

                    <div class="modal-body">
                        <form action="../controller/avaliarPrestadorController.php" method="POST" enctype="multipart/form-data">
                            <div class="estrelas">
                                <label for="zero_estrela_<?= $row['id_servico'] ?>"><i class="bi bi-star-fill zero_estrela"></i></label>
                                <input type="radio" id="zero_estrela_<?= $row['id_servico'] ?>" name="estrela" value="0" checked>

                                <label for="estrela_um_<?= $row['id_servico'] ?>"><i class="bi bi-star-fill"></i></label>
                                <input type="radio" id="estrela_um_<?= $row['id_servico'] ?>" name="estrela" value="1">

                                <label for="estrela_dois_<?= $row['id_servico'] ?>"><i class="bi bi-star-fill"></i></label>
                                <input type="radio" id="estrela_dois_<?= $row['id_servico'] ?>" name="estrela" value="2">

                                <label for="estrela_tres_<?= $row['id_servico'] ?>"><i class="bi bi-star-fill"></i></label>
                                <input type="radio" id="estrela_tres_<?= $row['id_servico'] ?>" name="estrela" value="3">

                                <label for="estrela_quatro_<?= $row['id_servico'] ?>"><i class="bi bi-star-fill"></i></label>
                                <input type="radio" id="estrela_quatro_<?= $row['id_servico'] ?>" name="estrela" value="4">

                                <label for="estrela_cinco_<?= $row['id_servico'] ?>"><i class="bi bi-star-fill"></i></label>
                                <input type="radio" id="estrela_cinco_<?= $row['id_servico'] ?>" name="estrela" value="5">

                                <input type="hidden" name="id_avaliado" value="<?= $row['id_prestador'] ?>">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-warning" value="avaliar">Avaliar</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
            <?php endforeach; ?>
        </div>
    </main>
    <script>
        function confirmarExclusao(id) {
            Swal.fire({
                title: 'Tem certeza?',
                text: "Você não poderá reverter isso!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-excluir-' + id).submit();
                }
            });
        }
    </script>
    <?php include "../footer.php"; ?>
</body>
</html>
