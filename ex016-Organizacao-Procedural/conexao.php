<?php

    // credenciais
    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "ex016";
    $porta = 3307;

    // conexão com o banco de dados
    $conexao = mysqli_connect($servidor, $usuario, $senha, $banco, $porta);

    // se a conexão com o banco falhar
    if (!$conexao) {
        echo "Falha na conexão com o banco de dados!";
        die;
    }

?>