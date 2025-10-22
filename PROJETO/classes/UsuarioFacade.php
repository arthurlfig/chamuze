<?php
require_once __DIR__ . '/../config/Conexao.php';
require_once __DIR__ . '/Notificacao.php';

class UsuarioFacade {
    private $conn;
    private $notificacao;

    public function __construct() {

        // Singleton - Conexao
        $this->conn = Conexao::getInstance()->getConexao();
        
        // Observer - Notificacao
        $this->notificacao = new Notificacao();
    }

    // ==================== MÉTODOS DE CONSULTA ====================

    /**
     * Busca todos os usuários de um tipo específico
     * Delega para queries diretas (subsistema de persistência)
     */

    public function buscarTodos($tipoUsuario) {
        try {
            $sql = "SELECT u.*, ";
            
            if ($tipoUsuario === 'prestador') {
                $sql .= "p.cnpj, p.img_rg, p.chave_pix, p.status_avaliacao 
                        FROM usuario u 
                        INNER JOIN prestador p ON u.id_usuario = p.id_prestador 
                        WHERE u.tipo_perfil = 'prestador'";
            } else {
                $sql .= "s.id_solicitante 
                        FROM usuario u 
                        INNER JOIN solicitante s ON u.id_usuario = s.id_solicitante 
                        WHERE u.tipo_perfil = 'solicitante'";
            }

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log("Erro ao buscar usuários: " . $e->getMessage());
            return [];
        }
    }

    public function buscarPorId($tipoUsuario, $id) {
        try {
            $sql = "SELECT u.*, ";
            
            if ($tipoUsuario === 'prestador') {
                $sql .= "p.cnpj, p.img_rg, p.chave_pix, p.status_avaliacao 
                        FROM usuario u 
                        INNER JOIN prestador p ON u.id_usuario = p.id_prestador 
                        WHERE u.id_usuario = ?";
            } else {
                $sql .= "s.id_solicitante 
                        FROM usuario u 
                        INNER JOIN solicitante s ON u.id_usuario = s.id_solicitante 
                        WHERE u.id_usuario = ?";
            }

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (Exception $e) {
            error_log("Erro ao buscar usuário por ID: " . $e->getMessage());
            return null;
        }
    }

    public function buscarPorEmail($email) {
        try {
            $sql = "SELECT u.* FROM usuario u WHERE u.email = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $usuario = $result->fetch_assoc();

            if (!$usuario) {
                return null;
            }

            if ($usuario['tipo_perfil'] === 'prestador') {
                $sqlPrest = "SELECT cnpj, img_rg, chave_pix, status_avaliacao 
                            FROM prestador WHERE id_prestador = ?";
                $stmtPrest = $this->conn->prepare($sqlPrest);
                $stmtPrest->bind_param("i", $usuario['id_usuario']);
                $stmtPrest->execute();
                $prestador = $stmtPrest->get_result()->fetch_assoc();
                
                if ($prestador) {
                    $usuario = array_merge($usuario, $prestador);
                }
            }

            return $usuario;
        } catch (Exception $e) {
            error_log("Erro ao buscar usuário por email: " . $e->getMessage());
            return null;
        }
    }

    // ==================== MÉTODOS DE ALTERAÇÃO ====================

    /**
     * Altera um campo específico de um usuário
     * Facade simplifica a alteração de dados
     */

    public function alterar($tabela, $id, $campo, $valor) {
        try {
            $camposPermitidos = [
                'usuario' => ['nome', 'sobrenome', 'email', 'telefone', 'genero', 'data_nascimento'],
                'prestador' => ['status_avaliacao', 'cnpj', 'chave_pix', 'img_rg'],
                'solicitante' => []
            ];

            if (!isset($camposPermitidos[$tabela]) || !in_array($campo, $camposPermitidos[$tabela])) {
                throw new Exception("Campo não permitido para alteração");
            }

            $colunaId = ($tabela === 'prestador') ? 'id_prestador' : 
                       (($tabela === 'solicitante') ? 'id_solicitante' : 'id_usuario');

            $sql = "UPDATE {$tabela} SET {$campo} = ? WHERE {$colunaId} = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("si", $valor, $id);
            
            $success = $stmt->execute();
            
            if ($success && $tabela === 'prestador' && $campo === 'status_avaliacao') {
                $this->notificarMudancaStatus($id, $valor);
            }
            
            return $success;
        } catch (Exception $e) {
            error_log("Erro ao alterar usuário: " . $e->getMessage());
            return false;
        }
    }

    private function notificarMudancaStatus($id_usuario, $novoStatus) {
        try {
            if ($novoStatus === 'aprovado') {
                $this->notificacao->criar(
                    $id_usuario,
                    'aprovacao_prestador',
                    'Parabéns! Seu cadastro como prestador foi aprovado. Agora você pode aceitar serviços.',
                    null
                );
            } elseif ($novoStatus === 'rejeitado') {
                $this->notificacao->criar(
                    $id_usuario,
                    'rejeicao_prestador',
                    'Seu cadastro como prestador foi rejeitado. Entre em contato para mais informações.',
                    null
                );
            }
        } catch (Exception $e) {
            error_log("Erro ao notificar mudança de status: " . $e->getMessage());
        }
    }

    // ==================== MÉTODOS DE EXCLUSÃO ====================

    public function deletarPorID($tipoUsuario, $id) {
        try {
            $this->conn->begin_transaction();

            // Deleta relacionamentos baseando-se no tipo
            if ($tipoUsuario === 'solicitante') {
                $this->deletarRelacionamentosSolicitante($id);
            } else {
                $this->deletarRelacionamentosPrestador($id);
            }

            // Deleta de uma tabela específica
            $this->deletarTipoUsuario($tipoUsuario, $id);

            // Deleta os dados comuns
            $this->deletarDadosComuns($id);

            // Deleta da tabela usuario
            $sqlUsuario = "DELETE FROM usuario WHERE id_usuario = ?";
            $stmtUsuario = $this->conn->prepare($sqlUsuario);
            $stmtUsuario->bind_param("i", $id);
            $stmtUsuario->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            error_log("Erro ao deletar usuário: " . $e->getMessage());
            return false;
        }
    }

    private function deletarRelacionamentosSolicitante($id) {

        // Deleta os serviços criados
        $sql = "DELETE FROM servico WHERE id_solicitante = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Deleta as propostas recebidas
        $sql = "DELETE FROM proposta WHERE id_solicitante = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    private function deletarRelacionamentosPrestador($id) {

        // Deleta as propostas enviadas
        $sql = "DELETE FROM proposta WHERE id_prestador = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Remove o vínculo de serviços aceitos
        $sql = "UPDATE servico SET id_prestador = NULL, status_servico = 'disponivel' 
                WHERE id_prestador = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    private function deletarTipoUsuario($tipoUsuario, $id) {
        $tabela = ($tipoUsuario === 'prestador') ? 'prestador' : 'solicitante';
        $coluna = ($tipoUsuario === 'prestador') ? 'id_prestador' : 'id_solicitante';
        
        $sql = "DELETE FROM {$tabela} WHERE {$coluna} = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    private function deletarDadosComuns($id) {

        $sql = "DELETE FROM endereco WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $sql = "DELETE FROM notificacoes WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $sql = "DELETE FROM mensagens WHERE id_remetente = ? OR id_destinatario = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $id, $id);
        $stmt->execute();
    }

    // ==================== MÉTODOS DE CHAT ====================

    public function enviarMensagem($id_remetente, $id_destinatario, $mensagem) {
        try {
            $sql = "INSERT INTO mensagens (id_remetente, id_destinatario, mensagem, data_envio) 
                    VALUES (?, ?, ?, NOW())";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iis", $id_remetente, $id_destinatario, $mensagem);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Erro ao enviar mensagem: " . $e->getMessage());
            return false;
        }
    }

    public function buscarMensagens($id_usuario1, $id_usuario2) {
        try {
            $sql = "SELECT * FROM mensagens 
                    WHERE (id_remetente = ? AND id_destinatario = ?) 
                       OR (id_remetente = ? AND id_destinatario = ?)
                    ORDER BY data_envio ASC";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iiii", $id_usuario1, $id_usuario2, $id_usuario2, $id_usuario1);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log("Erro ao buscar mensagens: " . $e->getMessage());
            return [];
        }
    }
}
?>