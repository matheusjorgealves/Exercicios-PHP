<?php

    // credenciais
    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "ex015";
    $porta = 3307;

    // comando mysqli de conexão com o banco de dados
    $conexao = mysqli_connect($servidor, $usuario, $senha, $banco, $porta);

    // se a conexão com o banco de dados falhar
    if (!$conexao) {
        echo "Erro na conexão com o banco de dados!";
        die;
    }

?>