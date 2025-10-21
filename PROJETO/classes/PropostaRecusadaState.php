<?php
require_once 'PropostaState.php';

class PropostaRecusadaState implements PropostaState {

    public function aceitar(Proposta $proposta) {
        echo "Proposta recusada.\n";
    }

    public function recusar(Proposta $proposta) {
        echo "Proposta já está recusada.\n";
    }
}
?>
