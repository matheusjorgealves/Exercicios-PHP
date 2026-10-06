<?php

    // variáveis com as credenciais
    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "ex014";
    $porta = 3307;

    // fazendo a conexão com o banco
    $conexao = mysqli_connect($servidor, $usuario, $senha, $banco, $porta);

    // se a conexão falhar
    if (!$conexao) {
        echo "Erro de conexão com o banco!!!";
        die;
    }

?>