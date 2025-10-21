<?php
require_once 'UsuarioFactory.php';
require_once 'DadosUsuario.php';

class PrestadorFactory extends UsuarioFactory {
    
    protected function salvarTipoUsuario($idUsuario, DadosUsuario $dados) {
        $conexao = Conexao::getInstance()->getConexao();
        
        $sql = "INSERT INTO prestador (
            id_prestador, 
            cnpj, 
            img_rg, 
            chave_pix, 
            status_avaliacao
        ) VALUES (?, ?, ?, ?, 'naoverificado')";
        
        $stmt = $conexao->prepare($sql);
        
        $cnpj = $dados->getCnpj();
        $imgRg = $dados->getImgRg();
        $chavePix = $dados->getChavePix();
        
        $stmt->bind_param(
            "isss",
            $idUsuario,
            $cnpj,
            $imgRg,
            $chavePix
        );
        
        if (!$stmt->execute()) {
            throw new Exception("Erro ao salvar prestador: " . $stmt->error);
        }
    }
    
    protected function registrarObservador($idUsuario) {
        try {

            require_once __DIR__ . '/Notificacao.php';
            $notificacao = new Notificacao();
            
            $notificacao->criar(
                $idUsuario,
                'cadastro_prestador',
                'Bem-vindo ao ChamauZé! Seu cadastro como prestador está em análise e será aprovado em breve. Você será notificado assim que for aprovado.',
                null
            );
            
        } catch (Exception $e) {

            error_log("Erro ao criar notificação de boas-vindas: " . $e->getMessage());
        }
    }
}
?>