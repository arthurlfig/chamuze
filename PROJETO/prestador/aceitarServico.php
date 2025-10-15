<?php
session_start();

require_once "../classes/Servico.php";
require_once "../classes/Notificacao.php";
require_once "../helpers/biblioteca.php";

// Verificação de acesso
verificarSessaoExpirada();
verificarAcesso('prestador');

if (!isset($_POST['id_servico'])) {
    header("Location: inicialPrestador.php");
    exit();
}

$id_servico = $_POST['id_servico'];
$id_prestador = $_SESSION['usuario']['id_usuario']; // ID do prestador logado

$servico = new Servico();
$dadosServico = $servico->buscarPorId($id_servico);

if (!$dadosServico) {
    header("Location: inicialPrestador.php");
    exit();
}

// Atualiza status do serviço no banco
$atualizado = $servico->atualizarStatus($id_servico, 'Aceito', $id_prestador);

if ($atualizado) {
    // Cria uma notificação para o solicitante
    $notificacao = new Notificacao();

    $id_solicitante = $dadosServico['id_solicitante']; // esse campo deve existir na tabela servico
    $mensagem = "Seu serviço \"{$dadosServico['titulo']}\" foi aceito por um prestador!";

    $notificacao->criar(
        $id_solicitante,
        'servico_aceito',
        $mensagem,
        $id_servico
    );

    // Redireciona com sucesso
    $_SESSION['msg_sucesso'] = "Serviço aceito com sucesso! O solicitante foi notificado.";
    header("Location: inicialPrestador.php");
    exit();
} else {
    $_SESSION['msg_erro'] = "Erro ao aceitar o serviço. Tente novamente.";
    header("Location: verServico.php?id_servico=$id_servico");
    exit();
}
?>
