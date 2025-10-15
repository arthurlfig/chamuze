<?php
session_start();
include "../helpers/biblioteca.php";
include "../classes/Notificacao.php";

verificarSessaoExpirada();
verificarAcesso('solicitante'); // garante que só solicitantes vejam aqui

$id_usuario = $_SESSION['usuario']['id_usuario'];

$notificacao = new Notificacao();
$notificacoes = $notificacao->buscarPorUsuario($id_usuario);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Notificações - ChamuZé</title>
    <link rel="shortcut icon" href="../assets/img/chamuzeFavicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/estilo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <?php include "../header/header.php"; ?>

    <main class="container my-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="bi bi-bell"></i> Minhas Notificações</h3>
            </div>

            <div class="card-body">
                <?php if (empty($notificacoes)): ?>
                    <p class="text-center text-muted">Você ainda não tem notificações.</p>
                <?php else: ?>
                    <div class="list-group">
                        <?php foreach ($notificacoes as $n): ?>
                            <a href="visualizarMeuServico.php?id_servico=<?= $n['id_servico'] ?>" 
                               class="list-group-item list-group-item-action <?= $n['lida'] ? '' : 'fw-bold bg-light' ?>">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>
                                        <i class="bi <?= $n['lida'] ? 'bi-bell' : 'bi-bell-fill text-warning' ?>"></i>
                                        <?= htmlspecialchars($n['mensagem']) ?>
                                    </span>
                                    <small class="text-muted"><?= date('d/m/Y H:i', strtotime($n['data_criacao'])) ?></small>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="card-footer text-end">
                <a href="inicialSolicitante.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </main>

    <?php include "../footer.php"; ?>
</body>
</html>
