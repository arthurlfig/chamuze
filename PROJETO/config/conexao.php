<?php

if (!function_exists('conectaDB')) {
    function conectaDB()
    {
        static $conexao = null;

        if ($conexao === null) {
            $host = 'localhost:3306';
            $db_name = 'bd_chamuze_fisico';
            $user_name = 'root';
            $password = '';


            try {
                $conexao = new mysqli($host, $user_name, $password, $db_name);
            } catch (mysqli_sql_exception $e) {
                $erro = "../config/erro_db.php";

                if (!headers_sent()) {
                    header("Location: $erro");
                    $_POST['erro'] = $conexao->connect_error;
                    exit;
                } else {
                    echo "<script>window.location.href='$erro';</script>";
                    $_POST['erro'] = $conexao->connect_error;
                    exit;
                }
            }
        }

        return $conexao;
    }
}
