<?php
session_start();
$tipo_perfil = 'administrador';

include "../helpers/biblioteca.php";

verificarAcesso('administrador');
verificarSessaoExpirada();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - ADM</title>
    <link rel="shortcut icon" href="../assets/img/chamuzeFavicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "../header/header.php"; ?>

    <div class="container-fluid d-flex justify-content-center align-items-center flex-grow-1 p-3">
        <div class="row w-100 align-items-center justify-content-center">
            <div class="col-12 col-md-5 bg-white p-5 rounded-5 shadow">
                <h2 class="text-center mb-4">Cadastro</h2>
                <?php
                if (isset($_GET['erro'])) {
                    switch ($_GET['erro']) {
                        case 1:
                            echo "<div class=\"alert alert-danger\">
                            E-mail de usuário já cadastrado no banco de dados
                            </div>";
                            break;
                        case 2:
                            echo "<div class=\"alert alert-danger\">
                            Senhas não coincidem
                            </div>";
                            break;
                        case 3:
                            echo "<div class=\"alert alert-success\">
                            Usuário cadastrado com sucesso
                            </div>";
                            break;
                        case 5:
                            echo "<div class=\"alert alert-danger\">
                            CPF já cadastrado na base de dados
                            </div>";
                            break;
                        case 7:
                            echo "<div class=\"alert alert-danger\">
                            A senha não atende aos requisitos mínimos
                            </div>";
                            break;
                        case 8:
                            echo "<div class=\"alert alert-danger\">
                                Nome ou sobrenome inválidos.
                                </div>";
                            break;
                    }
                }
                ?>
                <form action="../controller/cadastroController.php" method="POST" onsubmit="return validar()"
                    enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail"
                            required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome"
                                required>
                        </div>
                        <div class="col-sm-6">
                            <label for="snome" class="form-label">Sobrenome</label>
                            <input type="text" class="form-control" id="snome" name="snome"
                                placeholder="Digite seu sobrenome" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="datanasc" class="form-label">Data de nascimento</label>
                        <input type="date" class="form-control" id="datanasc" name="datanasc" max="<?= date('Y-m-d') ?>"
                            required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Digite seu CPF"
                                inputmode="numeric" required>
                            <div class="form-text">Apenas números</div>
                        </div>
                        <div class="col-md-6">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="tel" class="form-control" id="telefone" name="telefone"
                                placeholder="Digite seu telefone" required>
                            <div class="form-text">Com DDD, apenas números</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="genero" class="form-label">Gênero</label>
                        <select class="form-select" id="genero" name="genero" required>
                            <option value=0>Selecione...</option>
                            <option value=1>Feminino</option>
                            <option value=2>Masculino</option>
                            <option value=3>Outro</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha"
                            placeholder="Digite sua senha" required>
                        <small id="senhaAjuda" class="form-text text-muted">
                            No mínimo 8 caracteres, incluindo letras minusculas e maisculas, números e um caractere
                            especial.
                        </small>
                    </div>
                    <div class="mb-3">
                        <label for="senhaConfirmada" class="form-label">Confirmar senha</label>
                        <input type="password" class="form-control" id="senhaConfirmada" name="senhaConfirmada"
                            placeholder="Digite sua senha novamente" required>
                    </div>

                    <div id="errorMessages"></div>
                    <input type="hidden" name="tipo_perfil" value="<?= $tipo_perfil ?>">
                    <button type="submit" class="btn btn-warning w-100 text-dark" name="btn_enviar"
                        id="btnEnviar">Enviar</button>
                </form>
                <div class="text-center mt-3">
                    <p class="mb-0">Já possui cadastro? <a href="index.php">Fazer Login</a></p>
                </div>
            </div>
        </div>
    </div>
    <?php include "../footer.php"; ?>
    <script src="../assets/js/validacao.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cpfInput = document.getElementById('cpf');
            if (cpfInput) {
                cpfInput.addEventListener('input', function () {
                    this.value = maskCPF(this.value);
                });
            }

            const cnpjInput = document.getElementById('cnpj');
            if (cnpjInput) {
                cnpjInput.addEventListener('input', function () {
                    this.value = maskCNPJ(this.value);
                });
            }

            const telefoneInput = document.getElementById('telefone');
            if (telefoneInput) {
                telefoneInput.addEventListener('input', function () {
                    this.value = maskTelefone(this.value);
                });
            }
        });

        function validar() {
            document.getElementById('errorMessages').innerHTML = '';

            const senha = document.getElementById('senha');
            const senha2 = document.getElementById('senhaConfirmada');

            if (senha.value !== senha2.value) {
                senha.classList.add('is-invalid');
                senha2.classList.add('is-invalid');
                displayError("Senhas não coincidem. Por favor, verifique e tente novamente.");
                return false;
            }

            if (!validarSenha()) {
                senha.classList.add('is-invalid');
                return false;
            }


            const cpf = document.getElementById('cpf').value.replace(/\D/g, '');
            if (cpf.length !== 11) {
                event.preventDefault();
                const cpfInput = document.getElementById('cpf');
                cpfInput.classList.add('is-invalid');
                displayError("Por favor, digite um CEP válido com 11 dígitos.");
                return false;
            }

            const telefone = document.getElementById('telefone').value.replace(/\D/g, '');
            if (telefone.length < 10 || telefone.length > 11) {
                event.preventDefault();
                const telefoneInput = document.getElementById('telefone');
                telefoneInput.classList.add('is-invalid');
                displayError("Por favor, digite um telefone válido com DDD.");
                return false;
            }

            const nome = document.getElementById('nome').value.trim();
            const snome = document.getElementById('snome').value.trim();
            if (nome.length < 2 || snome.length < 2 || !/^[a-zA-ZÀ-ÿ\s]+$/.test(nome) || !/^[a-zA-ZÀ-ÿ\s]+$/.test(snome)) {
                event.preventDefault();
                const nomeInput = document.getElementById('nome');
                const snomeInput = document.getElementById('snome');
                nomeInput.classList.add('is-invalid');
                snomeInput.classList.add('is-invalid');
                displayError("Nome ou sobrenome inválidos. Por favor, verifique e tente novamente.");
                return false;
            }

            return true;
        }

        function validarSenha() {
            const password = document.getElementById('senha').value.trim();
            let valido = true;
            let erro = '';

            // Check password requirements
            if (password.length < 8) {
                erro += "• Mínimo de 8 caracteres<br>";
                valido = false;
            }
            if (!/[A-Z]/.test(password)) {
                erro += "• Pelo menos uma letra maiúscula<br>";
                valido = false;
            }
            if (!/[a-z]/.test(password)) {
                erro += "• Pelo menos uma letra minúscula<br>";
                valido = false;
            }
            if (!/[0-9]/.test(password)) {
                erro += "• Pelo menos um número<br>";
                valido = false;
            }
            if (!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) {
                erro += "• Pelo menos um caractere especial<br>";
                valido = false;
            }

            if (!valido) {
                displayError("A senha não atende aos requisitos:<br>" + erro);
            }

            return valido;
        }

        const form = document.getElementById('btnEnviar');
        form.addEventListener('submit', function (event) {
            if (!validar()) {
                event.preventDefault();
            }
        });

        const errorMessages = document.getElementById("errorMessages");

        function displayError(msg) {
            errorMessages.innerHTML = `<div class="alert alert-danger">${msg}</div>`;
        }

        //limpa o estilo
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function () {
                this.classList.remove('is-invalid');
            });
        });

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>