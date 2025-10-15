<?php
require_once __DIR__ . '/../config/Conexao.php';

class Notificacao {
    private $conn;

    public function __construct() {
        $this->conn = Conexao::getInstance()->getConexao();
    }

    /**
     * Cria uma nova notificação
     */
    public function criar($id_usuario, $tipo, $mensagem, $id_servico = null) {
        try {
            $sql = "INSERT INTO notificacoes (id_usuario, tipo, mensagem, id_servico, lida, data_criacao)
                    VALUES (?, ?, ?, ?, 0, NOW())";

            $stmt = $this->conn->prepare($sql);
            $id_servico_param = $id_servico ?? null;
            $stmt->bind_param("issi", $id_usuario, $tipo, $mensagem, $id_servico_param);

            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            error_log("Erro ao criar notificação: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Busca notificações de um usuário
     */
    public function buscarPorUsuario($id_usuario, $apenas_nao_lidas = false) {
        try {
            $sql = "SELECT * FROM notificacoes WHERE id_usuario = ?";
            if ($apenas_nao_lidas) {
                $sql .= " AND lida = 0";
            }
            $sql .= " ORDER BY data_criacao DESC LIMIT 50";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id_usuario);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            error_log("Erro ao buscar notificações: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Conta notificações não lidas de um usuário
     */
    public function contarNaoLidas($id_usuario) {
        try {
            $sql = "SELECT COUNT(*) as total FROM notificacoes WHERE id_usuario = ? AND lida = 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id_usuario);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            return $row['total'] ?? 0;
        } catch (mysqli_sql_exception $e) {
            error_log("Erro ao contar notificações: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Marca uma notificação como lida
     */
    public function marcarComoLida($id_notificacao) {
        try {
            $sql = "UPDATE notificacoes SET lida = 1, data_leitura = NOW() WHERE id_notificacao = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id_notificacao);
            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            error_log("Erro ao marcar notificação como lida: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Marca todas notificações de um usuário como lidas
     */
    public function marcarTodasComoLidas($id_usuario) {
        try {
            $sql = "UPDATE notificacoes SET lida = 1, data_leitura = NOW() WHERE id_usuario = ? AND lida = 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id_usuario);
            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            error_log("Erro ao marcar todas notificações como lidas: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Deleta uma notificação
     */
    public function deletar($id_notificacao) {
        try {
            $sql = "DELETE FROM notificacoes WHERE id_notificacao = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id_notificacao);
            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            error_log("Erro ao deletar notificação: " . $e->getMessage());
            return false;
        }
    }
}
?>
