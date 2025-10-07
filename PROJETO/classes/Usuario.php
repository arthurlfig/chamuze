<?php
class Usuario
{
    private $connection;
    public function __construct()
    {
        include __DIR__ . '/../config/conexao.php';
        $this->connection = conectaDB();
    }
    public function buscarTodos($tipoUsuario)
    {
        if ($tipoUsuario == "prestador") {
            $sql = "SELECT 
                            usuario.id_usuario, usuario.nome, usuario.sobrenome, usuario.email, usuario.cpf, usuario.telefone,
                            usuario.nacionalidade, usuario.data_nascimento, usuario.nota_reputacao, usuario.genero,
                            prestador.cnpj, prestador.img_rg, prestador.chave_pix, prestador.status_avaliacao,
                            endereco.estado, endereco.cidade, endereco.bairro, endereco.logradouro, endereco.numero_casa, endereco.cep
                        FROM usuario
                        LEFT JOIN prestador ON usuario.id_usuario = prestador.id_prestador
                        LEFT JOIN endereco ON usuario.id_usuario = endereco.id_usuario
                        WHERE usuario.tipo_perfil = ?";

            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("s", $tipoUsuario);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $sql = "SELECT * FROM usuario";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }
    public function buscarPorId($tipoUsuario, $id)
    {
        if ($tipoUsuario == "prestador") {
            $sql = "SELECT * FROM usuario LEFT JOIN prestador ON usuario.id_usuario = prestador.id_prestador WHERE tipo_perfil = ? AND id_usuario = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("si", $tipoUsuario, $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } else {
            $sql = "SELECT * FROM usuario WHERE id_usuario = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
    }
    public function deletarPorID($tipoUsuario, $id)
    {

        $sqlEndereco = "DELETE FROM endereco WHERE id_usuario = ?";
        $stmtEndereco = $this->connection->prepare($sqlEndereco);
        $stmtEndereco->bind_param("i", $id);
        $resultEndereco = $stmtEndereco->execute();
        if ($tipoUsuario == "prestador") {

            $sql1 = "DELETE FROM prestador WHERE id_prestador = ?";
            $stmt1 = $this->connection->prepare($sql1);
            $stmt1->bind_param("i", $id);
            $result1 = $stmt1->execute();


            $sql2 = "DELETE FROM usuario WHERE id_usuario = ?";
            $stmt2 = $this->connection->prepare($sql2);
            $stmt2->bind_param("i", $id);
            $result2 = $stmt2->execute();

        } else if ($tipoUsuario == "solicitante") {

            $sql1 = "DELETE FROM solicitante WHERE id_solicitante = ?";
            $stmt1 = $this->connection->prepare($sql1);
            $stmt1->bind_param("i", $id);
            $result1 = $stmt1->execute();

            $sql2 = "DELETE FROM usuario WHERE id_usuario = ?";
            $stmt2 = $this->connection->prepare($sql2);
            $stmt2->bind_param("i", $id);
            $result2 = $stmt2->execute();
        }

        return $result1 && $result2 && $resultEndereco;
    }


    public function alterar($tipoUsuario, $id, $nomeColuna, $novoValor)
    {
        if ($tipoUsuario == "prestador") {
            $colunasPermitidas = ['cnpj', 'img_rg', 'chave_pix', 'status_avaliacao'];
            if (!in_array($nomeColuna, $colunasPermitidas)) {
                throw new Exception("Coluna inválida.");
            }
            $sql = "UPDATE prestador SET $nomeColuna = ? WHERE id_prestador = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("si", $novoValor, $id);
            return $stmt->execute();
        } else {
            $colunasPermitidas = ['nome', 'sobrenome', 'email', 'senha', 'cpf', 'telefone', 'nacionalidade', 'data_nascimento', 'nota_reputacao', 'genero', 'tipo_perfil'];
            if (!in_array($nomeColuna, $colunasPermitidas)) {
                throw new Exception("Coluna inválida.");
            }
            $sql = "UPDATE usuario SET $nomeColuna = ? WHERE id_usuario = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("si", $novoValor, $id);
            return $stmt->execute();
        }
    }

    public function enviarMensagem($id_remetende, $id_destinatario, $mensagem)
    {
        $sql = "INSERT INTO mensagem (id_remetente, id_destinatario, mensagem) VALUES (?,?,?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param('iis', $id_remetende, $id_destinatario, $mensagem);
        return $stmt->execute();
    }

    public function buscarPorEmail($email)
    {
        $sql1 = "SELECT * FROM usuario WHERE email = ?";
        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("s", $email);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        if ($result1->num_rows == 0) {
            return null;
        }
        $user = $result1->fetch_assoc();
        if ($user['tipo_perfil'] == 'prestador') {
            $sql2 = "SELECT * FROM prestador WHERE id_prestador = ?";
            $stmt2 = $this->connection->prepare($sql2);
            $stmt2->bind_param("i", $user['id_usuario']);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            if ($result2->num_rows == 0) {
                $userPrestador['cnpj'] = null;
                $userPrestador['img_rg'] = null;
                $userPrestador['chave_pix'] = null;
                $userPrestador['status_avaliacao'] = null;

                return $user = array_merge($user, $userPrestador);
            }
            $userPrestador = $result2->fetch_assoc();
            if ($userPrestador['status_avaliacao'] == 'naoverificado') {
                return null;
            } else {
                return $user = array_merge($user, $userPrestador);
            }
        } else if ($user['tipo_perfil'] == 'administrador') {
            return null;
        } else {
            return $user;
        }
    }
}


?>