<?php

    // variáveis indentificadoras do banco
    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "ex012";
    $porta = 3307;

    // conexão com o banco
    $conexao = mysqli_connect($servidor, $usuario, $senha, $banco, $porta);

    // se a conexão falhar
    if (!$conexao) {
        echo "Erro!!!";
        die;
    };

?>