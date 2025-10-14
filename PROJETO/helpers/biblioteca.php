<?php
require_once __DIR__ . '/../config/Conexao.php';

$conexao = Conexao::getInstance()->getConexao();


function buscarUsuarioPeloId($id_usuario){
    global $conexao;
    $sql = "SELECT * FROM usuario WHERE id_usuario = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('i', $id_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->fetch_assoc();
}

function buscarPrestadorNoBancoPeloId($id){
    global $conexao;
    $sql = "SELECT * FROM usuario LEFT JOIN prestador ON usuario.id_usuario = prestador.id_prestador WHERE id_usuario = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function buscarSolicitanteNoBancoPeloId($id_solicitante){
    global $conexao;
    $sql = "SELECT * FROM usuario LEFT JOIN solicitante ON usuario.id_usuario = solicitante.id_solicitante WHERE id_usuario = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('i', $id_solicitante);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->fetch_assoc();
}

function salvarAvaliacaoNoBanco($nota ,$id_avaliado, $id_avaliador){
    global $conexao;
    $sql = "INSERT INTO avaliacao (nota, id_avaliado, id_avaliador) 
    VALUES (?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("iii",$nota ,$id_avaliado, $id_avaliador);
    $stmt->execute();
}

function recalcularNotaAvaliacao($id_avaliado){
    global $conexao;
    $sql = "SELECT AVG(nota) AS media FROM avaliacao WHERE id_avaliado = (?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('i',$id_avaliado);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $media = 0;
    if($row = $resultado->fetch_assoc()){
        $media = round($row['media'], 2);
    }

    return $media;
}

function atualizarCampoDeNotaRecalculada($novaMedia, $id_avaliado){
    global $conexao;
    $sql = "UPDATE usuario SET nota_reputacao = (?) WHERE id_usuario = (?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('di',$novaMedia, $id_avaliado);
    $stmt->execute();
}

function verificarAcesso($tipoPerfil){
    // Verifica se o usuário está logado
    if (!isset($_SESSION['usuario']['tipo_perfil'])) {
        header("Location: ../sessaoExpirada.php");
        exit();
    }

    // Verifica se o tipo de perfil bate com o permitido
    if ($_SESSION['usuario']['tipo_perfil'] != $tipoPerfil) {
        header("Location: ../index.php");
        exit();
    }
}

function verificarSessaoExpirada(){
    $tempoExpiracao = 432000; // 5 dias em segundos

    $agora = time(); 

    // Verifica se a sessão passou do tempo limite
    if ($agora - $_SESSION['inicioSessao'] > $tempoExpiracao){
        session_unset();     
        session_destroy();   
    }
}


function marcarServicoComoConcluido($id_servico){
    global $conexao;
    $status_concluido = 'concluido';
    $sql = "UPDATE servico SET status_servico = ? WHERE id_servico = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('si',$status_concluido, $id_servico);
    $stmt->execute();
}

function buscarMensagensDoChatNoBanco($id_remetente, $id_destinatario) {
    global $conexao;

    $sql = "SELECT * FROM mensagem
            WHERE (id_remetente = ? AND id_destinatario = ?) 
               OR (id_remetente = ? AND id_destinatario = ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('iiii', $id_remetente, $id_destinatario, $id_destinatario, $id_remetente);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->fetch_all(MYSQLI_ASSOC);
}

function buscarListaDeContatosNoBanco($id_usuario){
    global $conexao;
    $sql = "
        SELECT DISTINCT id_destinatario 
        FROM mensagem 
        WHERE id_remetente = ?
        
        UNION
        
        SELECT DISTINCT id_remetente  
        FROM mensagem 
        WHERE id_destinatario = ?
    ";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('ii', $id_usuario, $id_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->fetch_all(MYSQLI_ASSOC);
}




?>