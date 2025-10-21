<?php
require_once 'PropostaState.php';
require_once 'PropostaAceitaState.php';
require_once 'PropostaRecusadaState.php';

class PropostaEnviadaState implements PropostaState {

    public function aceitar(Proposta $proposta) {
        echo "Proposta aceita!\n";
        $proposta->setEstado(new PropostaAceitaState());
        $proposta->atualizarPrecoServico();
    }

    public function recusar(Proposta $proposta) {
        echo "Proposta recusada!\n";
        $proposta->setEstado(new PropostaRecusadaState());
    }
}
?>
