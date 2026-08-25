<?php

    // variáveis que armazenam informações do meu banco de dados
    $servidor = "localhost"; // está rodando na mesma máquina
    $usuario = "root"; // usuário administrador padrão do MySQL
    $senha = ""; // senha do root é vazia
    $banco = "cadastro_produtos"; // nome do banco
    $porta = 3307; // porta do MySql

    // desativa o relatório automático de erros
    mysqli_report(MYSQLI_REPORT_OFF);

    // conexão com o banco de dados
    $conexao = mysqli_connect($servidor, $usuario, $senha, $banco, $porta);

    // validação da conexão
    if (!$conexao) {
        // die encerra a execução
        die("Erro ao conectar ao banco de dados!");
    };

?>