<?php
session_start();
include "../classes/Cadastro.php";

// Verifica se o botão de envio foi pressionado
if (isset($_POST['btn_enviar'])) {

    // Função para limpar o input (mantém apenas números)
    function limparInput($valor) {
        return preg_replace('/[^0-9]/', '', $valor);
    }

    // Limpeza dos dados
    $_POST['cpf'] = limparInput($_POST['cpf']);
    $_POST['telefone'] = limparInput($_POST['telefone']);

    if (isset($_POST['cep'])) {
        $_POST['cep'] = limparInput($_POST['cep']);
    }

    if ($_POST['tipo_perfil'] === 'prestador') {
        $_POST['cnpj'] = limparInput($_POST['cnpj']);
    }

    // Validação de senha
    $senha = $_POST['senha'];
    $erroSenha = false;

    if (strlen($senha) < 8 ||
        !preg_match('/[A-Z]/', $senha) ||
        !preg_match('/[a-z]/', $senha) ||
        !preg_match('/[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]/', $senha) ||
        !preg_match('/[0-9]/', $senha)) {
        $erroSenha = true;
    }

    if ($erroSenha) {
        if ($_POST['tipo_perfil'] === 'administrador') {
            header('location:../administrador/cadastroAdm.php?erro=7');
        } else {
            header('location:../cadastro.php?erro=7&tipo_perfil=' . $_POST['tipo_perfil']);
        }
        exit();
    }

    // Validação de nome e sobrenome
    $nome = $_POST['nome'];
    $snome = $_POST['snome'];
    $erroNome = false;

    if (empty($nome) || empty($snome) ||
        !preg_match('/^[a-zA-ZÀ-ÿ\s]+$/', $nome) ||
        !preg_match('/^[a-zA-ZÀ-ÿ\s]+$/', $snome) ||
        strlen($nome) < 2 || strlen($snome) < 2) {
        $erroNome = true;
    }

    if ($erroNome) {
        if ($_POST['tipo_perfil'] === 'administrador') {
            header('location:../administrador/cadastroAdm.php?erro=8');
        } else {
            header('location:../cadastro.php?erro=8&tipo_perfil=' . $_POST['tipo_perfil']);
        }
        exit();
    }

    // Confirmação de senha
    if ($_POST['senha'] !== $_POST['senhaConfirmada']) {
        if ($_POST['tipo_perfil'] === 'administrador') {
            header('location:../administrador/cadastroAdm.php?erro=1');
        } else {
            header('location:../cadastro.php?erro=2&tipo_perfil=' . $_POST['tipo_perfil']);
        }
        exit();
    }

    // Criação de objeto Cadastro
    if ($_POST['tipo_perfil'] === 'prestador') {
        $fotoRG = $_FILES['img_rg'];
        $extensao = pathinfo($fotoRG['name'], PATHINFO_EXTENSION);
        $extensoesPermitidas = ['jpg', 'jpeg', 'png'];

        $novoNome = uniqid() . "." . $extensao;
        $caminho = '../uploads/rg/' . $novoNome;

        if (!in_array(strtolower($extensao), $extensoesPermitidas)) {
            header('location:../cadastro.php?erro=3&tipo_perfil=' . $_POST['tipo_perfil']);
            exit();
        }

        if (move_uploaded_file($fotoRG['tmp_name'], $caminho)) {
            $cadastro = new Cadastro(
                $_POST['nome'],
                $_POST['snome'],
                $_POST['email'],
                $_POST['senha'],
                $_POST['cpf'],
                $_POST['telefone'],
                $_POST['datanasc'],
                $_POST['genero'],
                $_POST['tipo_perfil'],
                $_POST['cnpj'],
                $caminho,
                $_POST['chavepix']
            );
        } else {
            header('location:../cadastro.php?erro=4&tipo_perfil=' . $_POST['tipo_perfil']);
            exit();
        }
    } else {
        $cadastro = new Cadastro(
            $_POST['nome'],
            $_POST['snome'],
            $_POST['email'],
            $_POST['senha'],
            $_POST['cpf'],
            $_POST['telefone'],
            $_POST['datanasc'],
            $_POST['genero'],
            $_POST['tipo_perfil']
        );
    }

    // Verificações no banco de dados
    $usuario = $cadastro->buscarNoBanco();
    $cpf = $cadastro->buscarCPF();
    $cnpj = $cadastro->buscarCNPJ();

    if ($usuario) {
        if ($_POST['tipo_perfil'] === 'administrador') {
            header('location:../administrador/cadastroAdm.php?erro=1');
        } else {
            header('location:../cadastro.php?erro=1&tipo_perfil=' . $_POST['tipo_perfil']);
        }
        exit();
    } elseif ($cpf) {
        if ($_POST['tipo_perfil'] === 'administrador') {
            header('location:../administrador/cadastroAdm.php?erro=4');
        } else {
            header('location:../cadastro.php?erro=5&tipo_perfil=' . $_POST['tipo_perfil']);
        }
        exit();
    } elseif ($cnpj) {
        header('location:../cadastro.php?erro=6&tipo_perfil=' . $_POST['tipo_perfil']);
        exit();
    } else {
        // Salvar dados no banco
        $cadastro->salvar();
        $usuario = $cadastro->buscarNoBanco();
        $usuarioid = $usuario['id_usuario'];

        if ($_POST['tipo_perfil'] != 'administrador') {
            $cadastro->salvarEndereco(
                $_POST['estado'],
                $_POST['cidade'],
                $_POST['bairro'],
                $_POST['logradouro'],
                $_POST['numero_casa'],
                $_POST['cep'],
                $usuarioid
            );
        }

        if ($_POST['tipo_perfil'] === 'administrador') {
            header('location:../administrador/cadastroAdm.php?erro=3');
        } else {
            header('location:../login.php?erro=0');
        }
        exit();
    }

} else {
    // Caso o botão não tenha sido pressionado
    if ($_POST['tipo_perfil'] === 'administrador') {
        header("location:../administrador/cadastroAdm.php");
    } else {
        header("location:../cadastro.php");
    }
    exit();
}
?>
