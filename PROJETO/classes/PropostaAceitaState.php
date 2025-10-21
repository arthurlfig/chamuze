<?php
require_once 'PropostaState.php';

class PropostaAceitaState implements PropostaState {

    public function aceitar(Proposta $proposta) {
        echo "Proposta já foi aceita.\n";
    }

    public function recusar(Proposta $proposta) {
        echo "Proposta já foi aceita e não pode ser recusada.\n";
    }
}
?>