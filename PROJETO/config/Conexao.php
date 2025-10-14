<?php
class Conexao{
    private static $instancia;
    private $conexao;

    private function __construct()
    {
        $host = 'localhost';
        $user = 'root';
        $senha = '';
        $db = 'chamuze';

        $this->conexao = new mysqli($host, $user, $senha, $db);

        if($this->conexao->connect_error){
            die("Erro na conexão: " . $this->conexao->connect_error);
        }
    }

    public static function getInstance(){
        if(self::$instancia == null){
            self::$instancia = new Conexao();
        }

        return self::$instancia;
    }

    public function getConexao(){
        return $this->conexao;
    }

}
?>
