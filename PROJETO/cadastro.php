<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Chamauze</title>
    <link rel="shortcut icon" href="assets/img/chamuzeFavicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <style>
        .cep-loading {
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="%236c757d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10" fill="none"/></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 15px 15px;
        }

        .endereco-sucesso {
            border: 2px solid #198754;
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
        }

        .endereco-falha {
            border: 2px solid #dc3545;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        }
    </style>
</head>

<body class="bg-light d-flex flex-column" style="height: 100vh;">

    <div class="container-fluid d-flex justify-content-center align-items-center flex-grow-1 p-3">
        <div class="row w-100">
            <div class="col-12 col-md-6 d-flex justify-content-center align-items-center mb-4 mb-md-0">
                <img src="assets/img/chamuzeLogoSemFundo.png" alt="Logo Chamauze" class="img-fluid"
                    style="max-width: 430px;">
            </div>

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
                            echo "<div class=\"alert alert-danger\">
                            Arquivo não permitido (Apenas JPEG,JPG ou PNG)
                            </div>";
                            break;
                        case 4:
                            echo "<div class=\"alert alert-danger\">
                            Imagem não carregada...
                            </div>";
                            break;
                        case 5:
                            echo "<div class=\"alert alert-danger\">
                            CPF já cadastrado na base de dados
                            </div>";
                            break;
                        case 6:
                            echo "<div class=\"alert alert-danger\">
                            CNPJ já cadastrado na base de dados
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
                <form action="controller/cadastroController.php" method="POST" onsubmit="return validar()"
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
                            <small id="nomeAjuda" class="form-text text-muted">
                                No mínimo 2 caracteres, apenas letras.
                            </small>
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
                        <!-- Prestador -->
                        <?php
                        $tipo_perfil = $_GET['tipo_perfil'] ?? '';
                        if ($tipo_perfil == 'prestador'): ?>
                            <div class="col-md-6">
                                <label for="cnpj" class="form-label">CNPJ</label>
                                <input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="Digite seu CNPJ"
                                    required>
                                <div class="form-text">Apenas números</div>
                            </div>
                        <?php endif; ?>
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

                    <div class="mb-3">
                        <h5 class="mb-3">Endereço</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="cep" class="form-label">CEP</label>
                                <input type="text" class="form-control" id="cep" name="cep" placeholder="00000-000"
                                    inputmode="numeric" required>
                                <div class="form-text">Digite apenas números</div>
                            </div>

                            <div class="col-md-8">
                                <label for="logradouro" class="form-label">Logradouro</label>
                                <input type="text" class="form-control" id="logradouro" name="logradouro"
                                    placeholder="Rua/Avenida" required>
                            </div>

                            <div class="col-md-6">
                                <label for="bairro" class="form-label">Bairro</label>
                                <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro"
                                    required>
                            </div>

                            <div class="col-md-4">
                                <label for="cidade" class="form-label">Cidade</label>
                                <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade"
                                    required>
                            </div>

                            <div class="col-md-2">
                                <label for="numero_casa" class="form-label">Número</label>
                                <input type="number" class="form-control" id="numero_casa" name="numero_casa"
                                    placeholder="Nº" min="1" required>
                            </div>

                            <div class="col-md-12">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="">Selecione...</option>
                                    <option value="AC">Acre</option>
                                    <option value="AL">Alagoas</option>
                                    <option value="AP">Amapá</option>
                                    <option value="AM">Amazonas</option>
                                    <option value="BA">Bahia</option>
                                    <option value="CE">Ceará</option>
                                    <option value="DF">Distrito Federal</option>
                                    <option value="ES">Espírito Santo</option>
                                    <option value="GO">Goiás</option>
                                    <option value="MA">Maranhão</option>
                                    <option value="MT">Mato Grosso</option>
                                    <option value="MS">Mato Grosso do Sul</option>
                                    <option value="MG">Minas Gerais</option>
                                    <option value="PA">Pará</option>
                                    <option value="PB">Paraíba</option>
                                    <option value="PR">Paraná</option>
                                    <option value="PE">Pernambuco</option>
                                    <option value="PI">Piauí</option>
                                    <option value="RJ">Rio de Janeiro</option>
                                    <option value="RN">Rio Grande do Norte</option>
                                    <option value="RS">Rio Grande do Sul</option>
                                    <option value="RO">Rondônia</option>
                                    <option value="RR">Roraima</option>
                                    <option value="SC">Santa Catarina</option>
                                    <option value="SP">São Paulo</option>
                                    <option value="SE">Sergipe</option>
                                    <option value="TO">Tocantins</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Prestador -->
                    <?php if ($tipo_perfil === 'prestador'): ?>
                        <div class="mb-3">
                            <label for="img_rg" class="form-label">Imagem do RG</label>
                            <input type="file" class="form-control" name="img_rg" id="img_rg" required>
                        </div>

                        <div class="mb-3">
                            <label for="chavepix" class="form-label">Chave Pix</label>
                            <input type="text" class="form-control" id="chavepix" name="chavepix"
                                placeholder="Digite sua chave Pix (CPF, e-mail, telefone ou chave aleatória)" required>
                        </div>
                    <?php endif; ?>
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
    <?php include "footer.php"; ?>
    <script src="assets/js/validacao.js"></script>

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

        function buscarCEP() {
            const cep = document.getElementById('cep').value.replace(/\D/g, '');


            if (cep.length !== 8) {
                return;
            }

            const cepInput = document.getElementById('cep');
            cepInput.classList.add('cep-loading');

            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json())
                .then(data => {
                    if (!data.erro) {
                        document.getElementById('logradouro').value = data.logradouro;
                        document.getElementById('bairro').value = data.bairro;
                        document.getElementById('cidade').value = data.localidade;
                        document.getElementById('estado').value = data.uf;

                        cepInput.classList.remove('cep-loading');
                        cepInput.classList.add('endereco-sucesso');

                        document.getElementById('numero_casa').focus();
                    } else {
                        cepInput.classList.remove('cep-loading');
                        cepInput.classList.add('endereco-falha');
                        setTimeout(() => {
                            cepInput.classList.remove('endereco-falha');
                        }, 3000);
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar CEP:', error);
                    cepInput.classList.remove('cep-loading');
                    cepInput.classList.add('endereco-falha');
                    setTimeout(() => {
                        cepInput.classList.remove('endereco-falha');
                    }, 3000);
                });
        }

        const cepInput = document.getElementById('cep');
        if (cepInput) {
            cepInput.addEventListener('input', function () {
                this.value = maskCEP(this.value);
            });

            cepInput.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    buscarCEP();
                }
            });

            cepInput.addEventListener('blur', function () {

                if (this.value.replace(/\D/g, '').length === 8) {
                    buscarCEP();
                }
            });
        }

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

            const cep = document.getElementById('cep').value.replace(/\D/g, '');
            if (cep.length !== 8) {
                event.preventDefault();
                const cepInput = document.getElementById('cep');
                cepInput.classList.add('is-invalid');
                displayError("Por favor, digite um CEP válido com 8 dígitos.");
                return false;
            }

            const cpf = document.getElementById('cpf').value.replace(/\D/g, '');
            if (cpf.length !== 11) {
                event.preventDefault();
                const cpfInput = document.getElementById('cpf');
                cpfInput.classList.add('is-invalid');
                displayError("Por favor, digite um CPF válido com 11 dígitos.");
                return false;
            }

            const cnpj = document.getElementById('cnpj').value.replace(/\D/g, '');
            if (cnpj.length !== 14) {
                event.preventDefault();
                const cnpjInput = document.getElementById('cnpj');
                cnpjInput.classList.add('is-invalid');
                displayError("Por favor, digite um CNPJ válido com 14 dígitos.");
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
                this.classList.remove('endereco-falha');
                this.classList.remove('endereco-sucesso');
            });
        });

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>