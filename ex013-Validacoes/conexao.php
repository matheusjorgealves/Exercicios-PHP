<?php

    // variáveis que indentificam o banco de dados
    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "ex013";
    $porta = 3307;

    // comando para a conexão com o banco de dados
    $conexao = mysqli_connect($servidor, $usuario, $senha, $banco, $porta);

    // se houver erro de conexão com o banco
    if (!$conexao) {
        echo "Erro de conexão com o banco de dados";
        die;
    };

?>