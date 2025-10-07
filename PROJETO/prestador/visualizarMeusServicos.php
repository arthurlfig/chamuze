<?php
session_start();

include "../helpers/biblioteca.php";

//Verificação de restrição de acesso
verificarSessaoExpirada();
verificarAcesso('prestador');

include "../classes/Servico.php";

if (!isset($_GET['id_servico'])) {
    header("Location: meusServicos.php");
    exit();
}

$id_servico = intval($_GET['id_servico']);
$servico = new Servico();
$dadosServico = $servico->buscarPorId($id_servico);

// Verificar se o serviço pertence ao prestador logado
if (!$dadosServico || $dadosServico['id_prestador'] != $_SESSION['usuario']['id_usuario']) {
    header("Location: meusServicos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Serviço Aceito - ChamuZé</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="estiloPrestador2.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include "../header/headerPrestador.php"; ?>

<main class="container mt-4">
    <h1 class="text-center mb-4">Detalhes do Serviço Aceito</h1>

    <div class="card mb-4 shadow-sm">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="<?= $dadosServico['img_servico'] ?>" class="img-fluid rounded-start" alt="Imagem do Serviço" style="height: 100%; object-fit: cover;">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h4 class="card-title"><?= $dadosServico['titulo'] ?></h4>
                    <p class="text-muted"><strong>Categoria:</strong> <?= $dadosServico['categoria'] ?></p>
                    <p class="text-muted"><strong>Região:</strong> <?= $dadosServico['regiao'] ?? 'Não informada' ?></p>
                    <p><strong>Descrição:</strong></p>
                    <p style="white-space: pre-wrap;"><?= $dadosServico['descricao'] ?></p>
                    <p class="fw-bold text-success fs-5 mt-3">
                        <strong>Preço:</strong> R$ <?= number_format($dadosServico['preco'], 2, ',', '.') ?>
                    </p>
                    <p class="text-muted"><strong>Status:</strong> <?= ucfirst($dadosServico['status_servico']) ?></p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include "../footer.php"; ?>
</body>
</html>
