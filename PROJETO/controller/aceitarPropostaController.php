<?php
include "../classes/Proposta.php";
$proposta = new Proposta();
var_dump($_POST['id_prestador']);
var_dump($_POST['id_servico']);
if (isset($_POST['id_prestador']) && isset($_POST['id_servico'])){
    $proposta->aceitarProposta($_POST['id_prestador'], $_POST['id_servico']);
    header("Location: ../solicitante/visualizarPropostas.php?erro=-1"); //Erro -1: Proposta aceita com sucesso
} else {
    header("Location: ../solicitante/visualizarPropostas.php?erro=2");// Erro 2: erro ao excluir proposta
}
?>