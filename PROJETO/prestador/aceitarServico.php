<?php
session_start();

include "../helpers/biblioteca.php";

//Verificação de restrição de acesso
verificarSessaoExpirada();
verificarAcesso('prestador');

include_once "../classes/Servico.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_servico'])) {
    $id_servico = intval($_POST['id_servico']);
    $id_prestador = $_SESSION['usuario']['id_usuario']; // ID do prestador logado

    $servico = new Servico();
    if ($servico->aceitarServico($id_servico, $id_prestador)) {
        header("Location: meusServicos.php?sucesso=1");
        exit();
    } else {
        header("Location: visualizarServico.php?id_servico=$id_servico&erro=1");
        exit();
    }
} else {
    header("Location: inicialPrestador.php");
    exit();
}
