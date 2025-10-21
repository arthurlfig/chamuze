<?php
session_start();

require_once __DIR__ . '/../classes/UsuarioFactoryProvider.php';
require_once __DIR__ . '/../classes/DadosUsuario.php';
require_once __DIR__ . '/../classes/Cadastro.php'; 

if (!isset($_POST['btn_enviar'])) {
    header("location:../cadastro.php");
    exit();
}

try {
    
    function limparInput($valor) {
        return preg_replace('/[^0-9]/', '', $valor);
    }

    $_POST['cpf'] = limparInput($_POST['cpf']);
    $_POST['telefone'] = limparInput($_POST['telefone']);
    
    if (isset($_POST['cep'])) {
        $_POST['cep'] = limparInput($_POST['cep']);
    }

    if ($_POST['tipo_perfil'] === 'prestador' && isset($_POST['cnpj'])) {
        $_POST['cnpj'] = limparInput($_POST['cnpj']);
    }
    
    $senha = $_POST['senha'];
    $senhaConfirmada = $_POST['senhaConfirmada'];

    if ($senha !== $senhaConfirmada) {
        if ($_POST['tipo_perfil'] === 'administrador') {
            header('location:../administrador/cadastroAdm.php?erro=1');
        } else {
            header('location:../cadastro.php?erro=2&tipo_perfil=' . $_POST['tipo_perfil']);
        }
        exit();
    }

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
    
    $nome = trim($_POST['nome']);
    $snome = trim($_POST['snome']);

    if (empty($nome) || empty($snome) ||
        !preg_match('/^[a-zA-ZÀ-ÿ\s]+$/', $nome) ||
        !preg_match('/^[a-zA-ZÀ-ÿ\s]+$/', $snome) ||
        strlen($nome) < 2 || strlen($snome) < 2) {
        
        if ($_POST['tipo_perfil'] === 'administrador') {
            header('location:../administrador/cadastroAdm.php?erro=8');
        } else {
            header('location:../cadastro.php?erro=8&tipo_perfil=' . $_POST['tipo_perfil']);
        }
        exit();
    }

    $cadastroTemp = new Cadastro(
        $nome,
        $snome,
        $_POST['email'],
        $senha,
        $_POST['cpf'],
        $_POST['telefone'],
        $_POST['datanasc'],
        $_POST['genero'],
        $_POST['tipo_perfil']
    );

    if ($cadastroTemp->buscarNoBanco()) {
        if ($_POST['tipo_perfil'] === 'administrador') {
            header('location:../administrador/cadastroAdm.php?erro=1');
        } else {
            header('location:../cadastro.php?erro=1&tipo_perfil=' . $_POST['tipo_perfil']);
        }
        exit();
    }

    if ($cadastroTemp->buscarCPF()) {
        if ($_POST['tipo_perfil'] === 'administrador') {
            header('location:../administrador/cadastroAdm.php?erro=4');
        } else {
            header('location:../cadastro.php?erro=5&tipo_perfil=' . $_POST['tipo_perfil']);
        }
        exit();
    }
    
    $caminhoImgRg = null;
    $chavePix = null;
    $cnpj = null;

    if ($_POST['tipo_perfil'] === 'prestador') {

        $cadastroTempPrest = new Cadastro(
            $nome,
            $snome,
            $_POST['email'],
            $senha,
            $_POST['cpf'],
            $_POST['telefone'],
            $_POST['datanasc'],
            $_POST['genero'],
            $_POST['tipo_perfil'],
            $_POST['cnpj']
        );

        if ($cadastroTempPrest->buscarCNPJ()) {
            header('location:../cadastro.php?erro=6&tipo_perfil=' . $_POST['tipo_perfil']);
            exit();
        }

        if (!isset($_FILES['img_rg']) || $_FILES['img_rg']['error'] !== UPLOAD_ERR_OK) {
            header('location:../cadastro.php?erro=4&tipo_perfil=' . $_POST['tipo_perfil']);
            exit();
        }

        $fotoRG = $_FILES['img_rg'];
        $extensao = strtolower(pathinfo($fotoRG['name'], PATHINFO_EXTENSION));
        $extensoesPermitidas = ['jpg', 'jpeg', 'png'];

        if (!in_array($extensao, $extensoesPermitidas)) {
            header('location:../cadastro.php?erro=3&tipo_perfil=' . $_POST['tipo_perfil']);
            exit();
        }

        $novoNome = uniqid() . "." . $extensao;
        $caminho = '../uploads/rg/' . $novoNome;

        if (!is_dir('../uploads/rg/')) {
            mkdir('../uploads/rg/', 0755, true);
        }

        if (!move_uploaded_file($fotoRG['tmp_name'], $caminho)) {
            header('location:../cadastro.php?erro=4&tipo_perfil=' . $_POST['tipo_perfil']);
            exit();
        }

        $caminhoImgRg = $caminho;
        $chavePix = $_POST['chavepix'];
        $cnpj = $_POST['cnpj'];
    }
    
    $tipoPerfil = $_POST['tipo_perfil'];

    if ($tipoPerfil === 'administrador') {
        $cadastro = new Cadastro(
            $nome,
            $snome,
            $_POST['email'],
            $senha,
            $_POST['cpf'],
            $_POST['telefone'],
            $_POST['datanasc'],
            $_POST['genero'],
            $tipoPerfil
        );
        
        $cadastro->salvar();
        header('location:../administrador/cadastroAdm.php?erro=3');
        exit();
    }

    if ($tipoPerfil === 'solicitante') {
        $dados = DadosUsuario::paraSolicitante(
            $nome,
            $snome,
            $_POST['email'],
            $_POST['telefone'],
            $senha,
            $_POST['cpf'],
            $_POST['datanasc'],
            $_POST['genero'],
            $_POST['logradouro'] ?? null,
            $_POST['numero_casa'] ?? null,
            $_POST['bairro'] ?? null,
            $_POST['cidade'] ?? null,
            $_POST['estado'] ?? null,
            $_POST['cep'] ?? null
        );
    } else { // prestador
        $dados = DadosUsuario::paraPrestador(
            $nome,
            $snome,
            $_POST['email'],
            $_POST['telefone'],
            $senha,
            $_POST['cpf'],
            $_POST['datanasc'],
            $_POST['genero'],
            $cnpj,
            $caminhoImgRg,
            $chavePix,
            $_POST['logradouro'],
            $_POST['numero_casa'],
            $_POST['bairro'],
            $_POST['cidade'],
            $_POST['estado'],
            $_POST['cep']
        );
    }

    $factory = UsuarioFactoryProvider::getFactory($tipoPerfil);
    $idUsuario = $factory->criarERegistrar($dados);

    header('location:../login.php?erro=0');
    exit();

} catch (Exception $e) {

    error_log("Erro no cadastro: " . $e->getMessage());
    
    if (isset($_POST['tipo_perfil']) && $_POST['tipo_perfil'] === 'administrador') {
        header('location:../administrador/cadastroAdm.php?erro=9');
    } else {
        $tipo = $_POST['tipo_perfil'] ?? 'solicitante';
        header('location:../cadastro.php?erro=9&tipo_perfil=' . $tipo);
    }
    exit();
}
?>