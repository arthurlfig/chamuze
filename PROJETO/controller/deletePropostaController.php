<?php
include "../classes/Proposta.php";  // Incluindo a classe Servico

// Criando uma instância da classe Proposta
$proposta = new Proposta();

// Verificando se o ID do proposta foi passado
if (isset($_POST['id_proposta'])) {
    $id_proposta = $_POST['id_proposta'];

    // Excluindo o serviço
    if ($proposta->excluir($id_proposta)) {
        // Redirecionando de volta para a página de visualização com status de sucesso
        header("Location: ../solicitante/visualizarPropostas.php?erro=0"); // Erro 0: a exclusão deu certo
        exit;
    } else {
        // Caso não consiga excluir, redireciona com um erro
        header("Location: ../solicitante/visualizarPropostas.php?erro=1"); //Erro 1: algo deu errado
        exit;
    }
} else {
    // Se não passar o ID do serviço, redireciona com erro
    header("Location: ../solicitante/visualizarPropostas.php?erro=1"); //Erro 1: algo deu errado
    exit;
}
?>