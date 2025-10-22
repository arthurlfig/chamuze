<?php
session_start();

include "../helpers/biblioteca.php";
include "../classes/UsuarioFacade.php";

// Verificar se usuário está logado
if (!isset($_SESSION['usuario']['id_usuario'])) {
    header("Location: ../index.php");
    exit;
}

// Validar destinatário
if (!isset($_GET['id_destinatario'])) {
    header("Location: ../config/meusServicos.php");
    exit;
}

$id_destinatario = (int)$_GET['id_destinatario'];
$id_remetente = $_SESSION['usuario']['id_usuario'];

$usuario = new UsuarioFacade();
$mensagens = $usuario->buscarMensagens($id_remetente, $id_destinatario);

// Busca o destinatário (tenta prestador primeiro, depois solicitante)
$destinatario = $usuario->buscarPorId('prestador', $id_destinatario);
if (!$destinatario) {
    $destinatario = $usuario->buscarPorId('solicitante', $id_destinatario);
}

if (!$destinatario) {
    echo "Usuário não encontrado";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Chat - ChamuZé</title>
    <link rel="stylesheet" href="../assets/css/estrelas.css">
    <link rel="shortcut icon" href="../assets/img/chamuzeFavicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/estilo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        .card-text {
            word-wrap: break-word;
            overflow-wrap: break-word;
            max-height: 100px;
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-light vh-100">
    <?php include "../header/headerPrestador.php"; ?>
    
    <main class="container min-vh-100">
        <h2 class="my-4">Bate-papo</h2>

        <div class="card shadow mb-4">
            <div class="card-header">
                Chat com <?= htmlspecialchars($destinatario['nome'] . " " . $destinatario['sobrenome']) ?>
            </div>

            <div class="card-body" id="mensagens" style="height: 300px; overflow-y: auto; background-color: #f9f9f9;">
                <?php foreach ($mensagens as $mensagem): ?>
                    <?php if ($mensagem['id_remetente'] == $id_remetente): ?>

                        <!-- Mensagem do Remetente (usuário logado) -->

                        <div class="d-flex justify-content-end mb-2">
                            <div class="p-2 bg-primary text-white rounded shadow-sm" style="max-width: 75%;">
                                <p class="mb-1"><?= htmlspecialchars($mensagem['mensagem']) ?></p>
                                <small class="text-light"><?= htmlspecialchars($mensagem['data_envio']) ?></small>
                            </div>
                        </div>
                    <?php else: ?>
                        
                        <!-- Mensagem do Destinatário -->

                        <div class="d-flex justify-content-start mb-2">
                            <div class="p-2 bg-secondary bg-opacity-75 text-white rounded shadow-sm" style="max-width: 75%;">
                                <p class="mb-1"><?= htmlspecialchars($mensagem['mensagem']) ?></p>
                                <small class="text-light"><?= htmlspecialchars($mensagem['data_envio']) ?></small>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <form id="formChat" class="input-group" action="../controller/chatController.php" method="POST">
            <input type="hidden" name="id_destinatario" value="<?= $id_destinatario ?>"> 
            <input type="text" name="mensagem" class="form-control" placeholder="Digite sua mensagem..." required>
            <button class="btn btn-primary" type="submit" name="envio_mensagem">
                <i class="bi bi-send"></i> Enviar
            </button>
        </form>
    </main>

    <?php include "../footer.php"; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>