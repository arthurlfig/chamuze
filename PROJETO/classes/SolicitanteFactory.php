<?php
require_once 'UsuarioFactory.php';
require_once 'DadosUsuario.php';

class SolicitanteFactory extends UsuarioFactory {
    
    protected function salvarTipoUsuario($idUsuario, DadosUsuario $dados) {
        $conexao = Conexao::getInstance()->getConexao();
        
        $sql = "INSERT INTO solicitante (id_solicitante) VALUES (?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $idUsuario);
        
        if (!$stmt->execute()) {
            throw new Exception("Erro ao salvar solicitante: " . $stmt->error);
        }
    }
    
    protected function registrarObservador($idUsuario) {
        try {

            require_once __DIR__ . '/Notificacao.php';
            $notificacao = new Notificacao();
            
            $notificacao->criar(
                $idUsuario,
                'cadastro_solicitante',
                'Bem-vindo ao ChamauZé! Você já pode começar a criar solicitações de serviços e receber propostas de prestadores.',
                null
            );
            
        } catch (Exception $e) {

            error_log("Erro ao criar notificação de boas-vindas: " . $e->getMessage());
        }
    }
}
?>