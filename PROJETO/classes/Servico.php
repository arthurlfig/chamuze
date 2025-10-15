<?php
class Servico{
    private $conexao;
    private $status = "disponivel";
    private $conn;

    public function __construct(){
        
        include __DIR__ . '/../config/conexao.php'; // Usando __DIR__ para garantir o caminho correto
        $this->conexao = conectaDB();
    }

    // Salvar serviço no banco
    public function salvar($titulo, $descricao, $categoria, $regiao, $caminhoImgServico, $preco, $idSolicitante)
    {
        $sql = "INSERT INTO servico (titulo, descricao, categoria, local_servico, img_servico, preco, id_solicitante) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("sssssdi", $titulo, $descricao, $categoria, $regiao, $caminhoImgServico, $preco, $idSolicitante);
        return $stmt->execute();
    }

    // Excluir serviço pelo ID
    public function excluir($id)
    {
        $sql = "DELETE FROM servico WHERE id_servico = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Atualizar serviço pelo ID
    public function atualizar($id, $titulo, $descricao, $categoria, $regiao, $caminhoImgServico, $preco)
    {
        $sql = "UPDATE servico SET titulo = ?, descricao = ?, categoria = ?, local_servico = ?, img_servico = ?, preco = ? WHERE id_servico = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("sssssdi", $titulo, $descricao, $categoria, $regiao, $caminhoImgServico, $preco, $id);
        return $stmt->execute();
    }

    // Buscar todos os serviços
    public function buscarTodos()
    {
        $sql = "SELECT * FROM servico";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Buscar todos os serviços disponiveis
    public function buscarTodosDisponiveis()
    {
        $status_servico = "disponivel";
        $sql = "SELECT * FROM servico WHERE status_servico = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("s", $status_servico);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Buscar serviço por ID
    public function buscarPorId($id_servico)
    {
        $sql = "SELECT * FROM servico WHERE id_servico = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $id_servico); // "i" para inteiro
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Retorna uma linha associativa
    }

    public function buscarPorSolicitante($id_usuario)
    {
        $sql = "SELECT * FROM servico 
                WHERE id_solicitante = ? 
                ORDER BY 
                    CASE 
                        WHEN status_servico = 'disponivel' THEN 1
                        WHEN status_servico = 'aceito' THEN 2
                        WHEN status_servico = 'concluido' THEN 3
                        ELSE 4
                    END";
        
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function aceitarServico($id_servico, $id_prestador)
    {
        $sql = "UPDATE servico SET id_prestador = ?, status_servico = 'aceito' WHERE id_servico = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("ii", $id_prestador, $id_servico);
        return $stmt->execute();
    }

    public function buscarServicosPorPrestador($id_prestador)
    {
        $sql = "SELECT * FROM servico 
                WHERE id_prestador = ? 
                ORDER BY 
                    CASE 
                        WHEN status_servico = 'disponivel' THEN 1
                        WHEN status_servico = 'aceito' THEN 2
                        WHEN status_servico = 'concluido' THEN 3
                        ELSE 4
                    END";
        
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $id_prestador);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function buscarPorCategoria($categoria)
    {
        $status_servico = "disponivel";
        $sql = "SELECT * FROM servico WHERE status_servico = ? AND categoria = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("ss", $status_servico, $categoria);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function buscarPorRegiao($regiao)
    {
        $status_servico = "disponivel";
        $sql = "SELECT * FROM servico WHERE status_servico = ? AND local_servico = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("ss", $status_servico, $regiao);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function buscarPorCategoriaeRegiao($regiao, $categoria)
    {
        $status_servico = "disponivel";
        $sql = "SELECT * FROM servico WHERE status_servico = ? AND local_servico = ? AND categoria = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("sss", $status_servico, $regiao, $categoria);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function buscarRegioes()
    {
        $sql = "SELECT DISTINCT local_servico FROM servico";
        $stmt = $this->conexao->prepare($sql);

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function buscarComFiltros($categoria = null, $regiao = null, $id_usuario = null)
    {
        $sql = "SELECT * FROM servico WHERE 1";
        $params = [];
        $types = '';

        if ($categoria) {
            $sql .= " AND categoria = ?";
            $params[] = $categoria;
            $types .= 's';
        }

        if ($regiao) {
            $sql .= " AND local_servico = ?";
            $params[] = $regiao;
            $types .= 's';
        }

        if ($id_usuario) {
            $sql .= " AND id_solicitante = ?";
            $params[] = $id_usuario;
            $types .= 's';
        }

        $stmt = $this->conexao->prepare($sql);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function inserirProposta($id_servico, $id_prestador, $novo_preco, $mensagem)
    {
        $sql = "INSERT INTO proposta (id_servico, id_prestador, novo_preco, mensagem, data_envio)
                VALUES (?, ?, ?, ?, NOW())";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("iids", $id_servico, $id_prestador, $novo_preco, $mensagem);
        return $stmt->execute();
    }
    public function atualizarStatus($id_servico, $novoStatus, $id_prestador)
    {
        $sql = "UPDATE servico 
                SET status_servico = ?, id_prestador = ? 
                WHERE id_servico = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("sii", $novoStatus, $id_prestador, $id_servico);
        return $stmt->execute();
    }


}

?>