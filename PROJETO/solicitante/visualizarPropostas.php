<?php
include_once "../classes/Proposta.php";
include_once "../classes/Servico.php";
session_start();

include "../helpers/biblioteca.php";

//Verificação de restrição de acesso
verificarSessaoExpirada();
verificarAcesso('solicitante');

$proposta = new Proposta();
$propostas = $proposta->buscarPropostaPorIdSolicitante($_SESSION['usuario']['id_usuario']);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChamuZé - Propostas</title>
    <link rel="shortcut icon" href="../assets/img/chamuzeFavicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/estilo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-light vh-100">
    <?php include "../header/header.php"; ?>

    <main class="container vh-100 flex-grow-1 py-4">
        <h1 class="text-center mt-4 mb-4">Propostas Disponíveis</h1>
        <?php
        if (isset($_GET['erro'])) {
            switch ($_GET['erro']) {
                case 0:
                    echo '<div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                            A proposta foi excluída com sucesso!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                          </div>';
                    break;
                case -1:
                    echo '<div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                            A proposta aceita com sucesso!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                            </div>';
                    break;
                case 1:
                    echo '<div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                            Ops, algo deu errado. A proposta não foi excluída!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                          </div>';
                    break;
                case 2:
                    echo '<div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                            Ops, algo deu errado. A proposta não foi aceita!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                          </div>';
                    break;
            }
        }
        ?>
        <?php
        $propostasDisponiveis = array_filter($propostas, function ($p) use ($proposta) {
            $servico = $proposta->buscarServicoPorId($p['id_servico']);
            return isset($servico['status_servico']) && $servico['status_servico'] === 'disponivel';
        });

        if (count($propostasDisponiveis) > 0) {
            echo "<div class=\"row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3\">";

            foreach ($propostasDisponiveis as $propostaRow) {
                $servico = $proposta->buscarServicoPorId($propostaRow['id_servico']);
                $prestador = $proposta->buscarPrestadorPorId($propostaRow['id_prestador']);
                ?>
                <div class="col">
                    <div class="card shadow-sm h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><?= $servico['titulo'] ?></h5>
                        </div>

                        <div class="card-body d-flex flex-column flex-md-row">
                            <div class="flex-shrink-0 me-md-3 mb-3 mb-md-0 text-center">
                                <img src="<?= $servico['img_servico'] ?>" class="img-fluid rounded" alt="Imagem do Serviço"
                                    style="max-width: 150px; max-height: 150px; object-fit: cover;">
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-danger mb-1"><strong>Preço Antigo: R$
                                        <?= number_format($servico['preco'], 2, ',', '.') ?></strong></p>
                                <p class="text-success mb-1"><strong>Preço Proposto: R$
                                        <?= number_format($propostaRow['valor_proposta'], 2, ',', '.') ?></strong></p>
                                <p class="card-text small"><strong>Prestador:
                                    </strong><?= $prestador['nome'] . " " . $prestador['sobrenome'] ?></p>
                                <p class="card-text small"><strong>Justificativa: </strong><?= $propostaRow['justificativa'] ?>
                                </p>
                            </div>
                        </div>

                        <div class="card-footer bg-transparent d-flex flex-wrap justify-content-end gap-2">
                            <form method="POST" action="../controller/aceitarPropostaController.php" class="d-inline">
                                <input type="hidden" name="id_servico" value="<?= $servico['id_servico'] ?>">
                                <input type="hidden" name="id_prestador" value="<?= $propostaRow['id_prestador'] ?>">
                                <button type="submit" name="btn-editar" class="btn btn-success btn-sm">
                                    <i class="bi bi-check"></i> Aceitar
                                </button>
                            </form>
                            <form method="POST" action="../controller/deletePropostaController.php" class="d-inline">
                                <input type="hidden" name="id_proposta" value="<?= $propostaRow['id_proposta'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Excluir
                                </button>

                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
            echo "</div>"; // fecha a ROW
        } else {
            echo "<div class=\"alert alert-info mt-4\" role=\"alert\">
                    Você não possui nenhuma proposta disponível no momento!
                </div>";
        }
        ?>

    </main>

    <?php include "../footer.php"; ?>
</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.querySelectorAll('form[action="../controller/deletePropostaController.php"]').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // impede o envio padrão
        
        Swal.fire({
            title: 'Tem certeza?',
            text: "Deseja realmente excluir esta proposta?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sim, excluir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // envia o formulário se confirmado
            }
        });
    });
});
</script>


</html>