<?php
session_start();

include "../helpers/biblioteca.php";

verificarAcesso('administrador');
verificarSessaoExpirada();


include "../classes/Usuario.php";
$usuario = new Usuario();
$usuarios = $usuario->buscarTodos("prestador");
$naoVerificados = array_filter($usuarios, fn($u) => $u['status_avaliacao'] == 'naoverificado');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Avaliar Prestador - ChamuZé</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php include "../header/header.php"; ?>
    <main class="container py-4">
        <h1 class="text-center mt-4 mb-4">Avaliar Prestadores</h1>

        <?php if (isset($_GET['erro'])): ?>
            <?php
                switch ($_GET['erro']) {
                    case 0:
                        echo '<div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                                O Prestador foi Cadastrado na base de dados!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                              </div>';
                        break;
                    case 1:
                        echo '<div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                                O Prestador foi Rejeitado com sucesso e removido da base de dados!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                              </div>';
                        break;
                    case 2:
                        echo '<div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                                Ops, algo deu errado! Os dados não foram enviados por POST.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                              </div>';
                        break;
                }
            ?>
        <?php endif; ?>

        <?php if (count($naoVerificados) < 1): ?>
            <div class="alert alert-primary">Nenhum prestador para avaliar.</div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($naoVerificados as $row): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card shadow-lg border-0 h-100">
                            <div class="card-body">
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item"><strong>Nome:</strong> <?= $row['nome'] ?></li> 
                                    <li class="list-group-item"><strong>Sobrenome:</strong> <?= $row['sobrenome'] ?></li> 
                                    <li class="list-group-item"><strong>E-mail:</strong> <?= $row['email'] ?></li> 
                                    <li class="list-group-item"><strong>Telefone:</strong> <?= $row['telefone'] ?></li>
                                    <li class="list-group-item"><strong>Data de Nascimento:</strong> <?= date("d/m/Y", strtotime($row['data_nascimento'])) ?></li>
                                    <li class="list-group-item"><strong>Gênero:</strong> <?= ucfirst($row['genero']) ?></li>
                                    <li class="list-group-item"><strong>Nacionalidade:</strong> <?= $row['nacionalidade'] ?></li>
                                    <li class="list-group-item"><strong>CPF:</strong> <?= $row['cpf'] ?></li>
                                    <li class="list-group-item"><strong>CNPJ:</strong> <?= $row['cnpj'] ?></li>
                                    <li class="list-group-item"><strong>Chave Pix:</strong> <?= $row['chave_pix'] ?></li>
                                </ul>

                                <div class="mb-3 text-center">
                                    <strong>Documento (RG):</strong><br>
                                    <img src="<?= $row['img_rg'] ?>" class="img-thumbnail mt-2" alt="Imagem do RG"
                                        style="max-height: 250px; object-fit: cover;">
                                </div>

                                <form method="POST" action="../controller/admDecisaoSobPrestador.php" class="form-avaliacao">
                                    <input type="hidden" name="id_usuario" value="<?= $row['id_usuario'] ?>">
                                    <div class="d-flex justify-content-center gap-3">
                                        <button class="btn btn-success px-4" type="submit" name="acao" value="aceito">Aceitar</button>
                                        <button class="btn btn-danger px-4 btn-recusar" type="button" data-id="<?= $row['id_usuario'] ?>">Recusar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <?php include "../footer.php"; ?>

    <script>
    document.querySelectorAll('.btn-recusar').forEach(botao => {
        botao.addEventListener('click', function () {
            const form = this.closest('form');
            const id = this.dataset.id;

            Swal.fire({
                title: 'Tem certeza?',
                text: "Essa ação irá recusar e remover o prestador da base de dados!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, recusar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Criar input hidden para acao = recusado
                    const inputAcao = document.createElement('input');
                    inputAcao.type = 'hidden';
                    inputAcao.name = 'acao';
                    inputAcao.value = 'recusado';
                    form.appendChild(inputAcao);
                    form.submit();
                }
            });
        });
    });
    </script>
</body>
</html>
