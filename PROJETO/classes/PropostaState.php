<?php
interface PropostaState {
    public function aceitar(Proposta $proposta);
    public function recusar(Proposta $proposta);
}
?>