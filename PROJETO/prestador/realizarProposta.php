<?php
session_start();
include "../classes/Proposta.php";
include "../classes/Servico.php";

include "../helpers/biblioteca.php";

//Verificação de restrição de acesso
verificarSessaoExpirada();
verificarAcesso('prestador');

$id_servico = $_GET['id_servico'];
$id_prestador = $_SESSION['usuario']['id_usuario'];

$servico = new Servico();
$dadosServico = $servico->buscarPorId($id_servico);

if (!$dadosServico) {
    echo "Serviço não encontrado.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $novoPreco = $_POST['valor_proposta'];
    $justificativa = $_POST['justificativa'];
    $id_solicitante = $dadosServico['id_solicitante'];

    $proposta = new Proposta();
    $sucesso = $proposta->enviarProposta($id_servico, $id_prestador, $id_solicitante, $novoPreco, $justificativa);

    if ($sucesso) {
        header("Location: meusServicos.php?proposta=enviada");
        exit();
    } else {
        $erro = "Erro ao enviar proposta.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Realizar Proposta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1 class="mb-4">Realizar Proposta</h1>

    <?php if (isset($erro)): ?>
        <div class="alert alert-danger"><?= $erro ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label"><strong>Preço Original:</strong></label>
            <p class="form-control-plaintext">R$ <?= number_format($dadosServico['preco'], 2, ',', '.') ?></p>
        </div>

        <div class="mb-3">
            <label for="valor_proposta" class="form-label">Novo Preço</label>
            <input type="number" step="0.01" class="form-control" id="valor_proposta" name="valor_proposta" required>
        </div>

        <div class="mb-3">
            <label for="justificativa" class="form-label">Justificativa</label>
            <textarea class="form-control" id="justificativa" name="justificativa" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Enviar Proposta</button>
        <a href="verServico.php?id_servico=<?= $id_servico ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
