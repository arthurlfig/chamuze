<?php
require_once __DIR__ . '/../config/Conexao.php';

class Proposta{
    private $id_proposta;
    private $id_servico; 
    private $id_prestador;
    private $id_solicitante;
    private $valor_proposta;
    private $justificativa;
    private $statusServico = "aceito";
    private $conexao; 

    public function __construct(){
        $this->conexao = Conexao::getInstance()->getConexao();

    }

    public function enviarProposta($id_servico, $id_prestador, $id_solicitante, $valor_proposta, $justificativa) {
        $sql = "INSERT INTO proposta (id_servico, id_prestador, id_solicitante, valor_proposta, justificativa)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("iiids", $id_servico, $id_prestador, $id_solicitante, $valor_proposta, $justificativa);
        return $stmt->execute();
    }
    

    public function buscarPropostaPorIdSolicitante($idSolicitante){
        $sql = "SELECT * FROM proposta WHERE id_solicitante = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $idSolicitante); // Corrigido
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //Buscar prestador pelo ID
    public function buscarPrestadorPorId($idPrestador){
        $sql = "SELECT * FROM usuario WHERE id_usuario = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $idPrestador); 
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Buscar serviço por ID
    public function buscarServicoPorId($id_servico){
        $sql = "SELECT * FROM servico WHERE id_servico = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $id_servico); // "i" para inteiro
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Retorna uma linha associativa
    }

    // Excluir serviço pelo ID
    public function excluir($id){
        $sql = "DELETE FROM proposta WHERE id_proposta = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function aceitarProposta($idPrestador, $idServico){

        //Atualizando o status e vinculando um prestador a um serviço
        $sql = "UPDATE servico SET status_servico = ?, id_prestador = ? WHERE id_servico = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("sis",$this->statusServico, $idPrestador, $idServico);
        $stmt->execute();

    }

    

}
?>