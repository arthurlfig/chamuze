<?php
require_once __DIR__ . '/../config/Conexao.php';

class Usuario
{
    private $conexao;

    public function __construct()
    {
        // Conexão via Singleton
        $this->conexao = Conexao::getInstance()->getConexao();
    }

    /**
     * Buscar todos os usuários ou apenas prestadores
     */
    public function buscarTodos(string $tipoUsuario = null): array
    {
        if ($tipoUsuario === "prestador") {
            $sql = "SELECT 
                        u.id_usuario, u.nome, u.sobrenome, u.email, u.cpf, u.telefone,
                        u.nacionalidade, u.data_nascimento, u.nota_reputacao, u.genero,
                        p.cnpj, p.img_rg, p.chave_pix, p.status_avaliacao,
                        e.estado, e.cidade, e.bairro, e.logradouro, e.numero_casa, e.cep
                    FROM usuario u
                    LEFT JOIN prestador p ON u.id_usuario = p.id_prestador
                    LEFT JOIN endereco e ON u.id_usuario = e.id_usuario
                    WHERE u.tipo_perfil = ?";

            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param("s", $tipoUsuario);
        } else {
            $sql = "SELECT * FROM usuario";
            $stmt = $this->conexao->prepare($sql);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Buscar usuário por ID
     */
    public function buscarPorId(string $tipoUsuario, int $id): ?array
    {
        if ($tipoUsuario === "prestador") {
            $sql = "SELECT * 
                    FROM usuario u 
                    LEFT JOIN prestador p ON u.id_usuario = p.id_prestador 
                    WHERE u.tipo_perfil = ? AND u.id_usuario = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param("si", $tipoUsuario, $id);
        } else {
            $sql = "SELECT * FROM usuario WHERE id_usuario = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param("i", $id);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    /**
     * Deletar usuário e dados relacionados
     */
    public function deletarPorID(string $tipoUsuario, int $id): bool
    {
        $resultEndereco = $this->executarQuery("DELETE FROM endereco WHERE id_usuario = ?", "i", [$id]);

        if ($tipoUsuario === "prestador") {
            $resultPrestador = $this->executarQuery("DELETE FROM prestador WHERE id_prestador = ?", "i", [$id]);
        } else {
            $resultPrestador = $this->executarQuery("DELETE FROM solicitante WHERE id_solicitante = ?", "i", [$id]);
        }

        $resultUsuario = $this->executarQuery("DELETE FROM usuario WHERE id_usuario = ?", "i", [$id]);

        return $resultEndereco && $resultPrestador && $resultUsuario;
    }

    /**
     * Atualizar coluna específica de usuário ou prestador
     */
    public function alterar(string $tipoUsuario, int $id, string $nomeColuna, $novoValor): bool
    {
        $colunasPermitidasPrestador = ['cnpj', 'img_rg', 'chave_pix', 'status_avaliacao'];
        $colunasPermitidasUsuario = ['nome', 'sobrenome', 'email', 'senha', 'cpf', 'telefone', 'nacionalidade', 'data_nascimento', 'nota_reputacao', 'genero', 'tipo_perfil'];

        if ($tipoUsuario === "prestador") {
            if (!in_array($nomeColuna, $colunasPermitidasPrestador)) {
                throw new Exception("Coluna inválida para prestador.");
            }
            $sql = "UPDATE prestador SET $nomeColuna = ? WHERE id_prestador = ?";
        } else {
            if (!in_array($nomeColuna, $colunasPermitidasUsuario)) {
                throw new Exception("Coluna inválida para usuário.");
            }
            $sql = "UPDATE usuario SET $nomeColuna = ? WHERE id_usuario = ?";
        }

        return $this->executarQuery($sql, "si", [$novoValor, $id]);
    }

    /**
     * Enviar mensagem
     */
    public function enviarMensagem(int $idRemetente, int $idDestinatario, string $mensagem): bool
    {
        $sql = "INSERT INTO mensagem (id_remetente, id_destinatario, mensagem) VALUES (?, ?, ?)";
        return $this->executarQuery($sql, "iis", [$idRemetente, $idDestinatario, $mensagem]);
    }

    /**
     * Buscar usuário por e-mail
     */
    public function buscarPorEmail(string $email): ?array
    {
        $sql = "SELECT * FROM usuario WHERE email = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if (!$user) return null;

        if ($user['tipo_perfil'] === 'prestador') {
            $sqlPrestador = "SELECT * FROM prestador WHERE id_prestador = ?";
            $stmtPrestador = $this->conexao->prepare($sqlPrestador);
            $stmtPrestador->bind_param("i", $user['id_usuario']);
            $stmtPrestador->execute();
            $prestador = $stmtPrestador->get_result()->fetch_assoc() ?: [];

            if (isset($prestador['status_avaliacao']) && $prestador['status_avaliacao'] === 'naoverificado') {
                return null;
            }

            return array_merge($user, $prestador);
        }

        if ($user['tipo_perfil'] === 'administrador') return null;

        return $user;
    }

    /**
     * Método auxiliar para executar queries com bind
     */
    private function executarQuery(string $sql, string $tipos, array $params): bool
    {
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param($tipos, ...$params);
        return $stmt->execute();
    }
}
?>
