<?php
session_start();
include "../classes/Servico.php";

// Verifica se o formulário foi submetido
if (isset($_POST['btn_solicitar'])) {

    // Processa a imagem
    $fotoServico = $_FILES['img_servico'];
    $extensao = pathinfo($fotoServico['name'], PATHINFO_EXTENSION); // Obtém a extensão do arquivo
    $extensoesPermitidas = ['jpg', 'jpeg', 'png'];

    // Gera um nome único para a imagem
    $novoNome = uniqid() . "." . $extensao;
    $caminho = '../uploads/servicos/' . $novoNome;

     // Verifica se a extensão é permitida
     if (!in_array(strtolower($extensao), $extensoesPermitidas)) {
        header("Location: ../solicitante/solicitarServico.php?erro=1"); //Erro 1: Arquivo no formato não permitido
     } else {

        //Cria a instancia servico
        $servico = new Servico();

        // Move o arquivo para o diretório de uploads e salva os dados no banco
        if (move_uploaded_file($fotoServico['tmp_name'], $caminho)) {

            // Salva os dados no banco
            $servico->salvar($_POST['titulo'], $_POST['descricao'], $_POST['categoria'], $_POST['regiao'], $caminho, $_POST['preco'], $_POST['id_solicitante']);

            // Redireciona para a página de visualização dos serviços
            header("Location: ../solicitante/visualizarServicos.php");
            exit();

        } else {
            header("Location: ../solicitante/solicitarServico.php?erro=2");//Erro 2: Erro ao salvar no Banco
        }
    }
}
?>