<?php
session_start();

include "../helpers/biblioteca.php";
verificarSessaoExpirada();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="shortcut icon" href="../assets/img/chamuzeFavicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/estiloperfilusuario.css">
    <style>
        .edit-icon {
            cursor: pointer;
            margin-left: 10px;
            font-size: 0.8em;
            color: #6c757d;
        }

        .edit-icon:hover {
            color: #0d6efd;
        }

        .form-control {
            max-width: 300px;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "../header/header.php"; ?>

    <div class="container mt-5 d-flex justify-content-center align-items-center">
        <div class="perfil-container w-75">
            <h2 class="text-center mb-4">Perfil do Usuário</h2>

            <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == '1'): ?>
                <div class="alert alert-success">Perfil atualizado com sucesso!</div>
            <?php endif; ?>
            <?php
            if (isset($_GET['erro'])) {
                switch ($_GET['erro']) {
                    case 1:
                        echo "<div class=\"alert alert-danger\">
                            E-mail de usuário já cadastrado no banco de dados
                            </div>";
                        break;
                }
            }
            ?>

            <?php if (isset($_SESSION['usuario'])): ?>
                <?php
                // Pegando os dados da sessão
                $usuario = $_SESSION['usuario'];
                ?>

                <form method="POST" action="../controller/updateUsuarioController.php">
                    <table class="table perfil-table">
                        <tbody>
                            <tr>
                                <th>Nome:</th>
                                <td>
                                    <span class="display-mode"><?= $usuario['nome']; ?></span>
                                    <input type="text" name="nome" value="<?= $usuario['nome']; ?>"
                                        class="form-control edit-mode d-none">
                                    <span class="edit-icon display-mode"><i class="bi bi-pencil"></i></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Sobrenome:</th>
                                <td>
                                    <span class="display-mode"><?= $usuario['sobrenome']; ?></span>
                                    <input type="text" name="sobrenome" value="<?= $usuario['sobrenome']; ?>"
                                        class="form-control edit-mode d-none">
                                    <span class="edit-icon display-mode"><i class="bi bi-pencil"></i></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>
                                    <span class="display-mode"><?= $usuario['email']; ?></span>
                                    <input type="email" name="email" value="<?= $usuario['email']; ?>"
                                        class="form-control edit-mode d-none">
                                    <span class="edit-icon display-mode"><i class="bi bi-pencil"></i></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Telefone:</th>
                                <td>
                                    <span class="display-mode"><?= $usuario['telefone']; ?></span>
                                    <input type="text" name="telefone" value="<?= $usuario['telefone']; ?>"
                                        class="form-control edit-mode d-none">
                                    <span class="edit-icon display-mode"><i class="bi bi-pencil"></i></span>
                                </td>
                            </tr>

                            <tr>
                                <th>CPF:</th>
                                <td><?= $usuario['cpf']; ?></td>
                            </tr>
                            <tr>
                                <th>Nacionalidade:</th>
                                <td><?= $usuario['nacionalidade']; ?></td>
                            </tr>
                            <tr>
                                <th>Data de Nascimento:</th>
                                <td><?= date('d/m/Y', strtotime($usuario['data_nascimento'])); ?></td>
                            </tr>
                            <tr>
                                <th>Nota de Reputação:</th>
                                <td><?= $usuario['nota_reputacao']; ?></td>
                            </tr>
                            <tr>
                                <th>Gênero:</th>
                                <td><?= $usuario['genero'] == 'F' ? 'Feminino' : ($usuario['genero'] == 'M' ? 'Masculino' : 'Outro'); ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Tipo de Perfil:</th>
                                <td><?= ucfirst($usuario['tipo_perfil']); ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="edit-buttons edit-mode d-none mt-3 mb-3">
                        <button type="submit" class="btn btn-success me-2">Salvar Alterações</button>
                        <button type="button" class="btn btn-secondary" id="cancel-edit">Cancelar</button>
                    </div>
                </form>


                <form method="POST" action="../controller/logOutController.php">
                    <input type="submit" value="Sair" class="btn btn-danger btn-logout">
                </form>

            <?php else: ?>
                <p class="text-center">Você não está logado!</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include "../footer.php"; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editIcons = document.querySelectorAll('.edit-icon');
            const editModeElements = document.querySelectorAll('.edit-mode');
            const displayModeElements = document.querySelectorAll('.display-mode');

            // Enter edit mode
            editIcons.forEach(icon => {
                icon.addEventListener('click', () => {
                    editModeElements.forEach(el => el.classList.remove('d-none'));
                    displayModeElements.forEach(el => el.classList.add('d-none'));
                });
            });

            // Cancel edit mode
            document.getElementById('cancel-edit')?.addEventListener('click', () => {
                editModeElements.forEach(el => el.classList.add('d-none'));
                displayModeElements.forEach(el => el.classList.remove('d-none'));
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>