<?php
include "../classes/Servico.php";  // Incluindo a classe Servico

// Criando uma instância da classe Servico
$servico = new Servico();

// Verificando se o ID do serviço foi passado
if (isset($_POST['id_servico'])) {
    $id_servico = $_POST['id_servico'];

    // Excluindo o serviço
    if ($servico->excluir($id_servico)) {
        // Redirecionando de volta para a página de visualização com status de sucesso
        header("Location: ../solicitante/visualizarServicos.php?erro=0"); // Erro 0: a exclusão deu certo
        exit;
    } else {
        // Caso não consiga excluir, redireciona com um erro
        header("Location: ../solicitante/visualizarServicos.php?erro=1"); //Erro 1: algo deu errado
        exit;
    }
} else {
    // Se não passar o ID do serviço, redireciona com erro
    header("Location: ../solicitante/visualizarServicos.php?erro=1"); //Erro 1: algo deu errado
    exit;
}
?>
