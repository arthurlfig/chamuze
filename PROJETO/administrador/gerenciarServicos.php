<?php
session_start();
include "../classes/Servico.php";
include "../classes/Usuario.php";

include "../helpers/biblioteca.php";

verificarAcesso('administrador');
verificarSessaoExpirada();

$servico = new Servico();
    $servicos = $servico->buscarTodos(); // Ajuste conforme necessário
    $usuarioObj = new Usuario();

$servico = new Servico();
if (isset($_POST['id_servico'])) {
    $id_servico = $_POST['id_servico'];


    


    if ($servico->excluir($id_servico)) {

        header("Location: gerenciarServicos.php?erro=0"); // 0 é para sucesso
        exit; // Após header, a execução deve parar
    } else {

        header("Location: gerenciarServicos.php?erro=1"); // 1 é para erro
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Serviços</title>
    <link rel="shortcut icon" href="../assets/img/chamuzeFavicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/estilo.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "../header/header.php"; ?>

    <div class="container ">
        <h1 class="mt-4 mb-4">Gerenciar Serviços</h1>

        <?php
        if (isset($_GET['erro'])) {
            switch ($_GET['erro']) {
                case 0:
                    echo '<div class="alert alert-success">Serviço excluído com sucesso!</div>';
                    break;
                case 1:
                    echo '<div class="alert alert-danger">Erro ao excluir o serviço.</div>';
                    break;
            }
        }
        ?>



        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
            <?php
            foreach ($servicos as $servico):
                $usuario = $usuarioObj->buscarPorId("solicitante", $servico['id_solicitante']);
                ?>
                <div class="col">
                    <div class="card shadow-sm h-100">
                        <div class="card-header d-flex justify-content-between">
                            <h5 class="card-title mb-0"><?= $servico['titulo'] ?></h5>
                        </div>
                        <div class="card-body d-flex">
                            <div class="flex-shrink-0 me-3">
                                <img src="<?= $servico['img_servico'] ?>" class="img-fluid rounded" alt="Imagem do Serviço"
                                    style="max-width: 150px; max-height: 150px; object-fit: cover;">
                            </div>
                            <div class="flex-grow-1">
                                <p><strong>Solicitante:</strong> <?= ($usuario['nome']) ?></p>
                                <p><strong>Categoria:</strong> <?= $servico['categoria'] ?></p>
                                <p><strong>Região:</strong> <?= $servico['local_servico'] ?></p>
                                <p><strong>Preço:</strong> R$: <?= number_format($servico['preco'], 2, ',', '.') ?></p>
                                <p><strong>Status:</strong> <?= $servico['status_servico'] ?></p>
                            </div>
                        </div>
                        <div class="card-footer d-flex flex-wrap justify-content-end gap-2">
                            <form method="POST" action="gerenciarServicos.php" class="d-inline excluir-form">
                                <input type="hidden" name="id_servico" value="<?= $servico['id_servico'] ?>">
                                <button type="button" class="btn btn-danger btn-confirmar-exclusao">Excluir</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php include "../footer.php"?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script SweetAlert de confirmação -->
    <script>
        document.querySelectorAll('.btn-confirmar-exclusao').forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('.excluir-form');
                Swal.fire({
                    title: 'Tem certeza?',
                    text: "Uma vez excluído, o serviço não pode ser recuperado",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Excluir!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
</body>

</html>