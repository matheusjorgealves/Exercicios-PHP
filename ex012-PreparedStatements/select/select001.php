<?php

    // desafio do exercício: buscar no banco o registro de id 3 usando prepared statements

    // incluindo o arquivo de conexão com o banco de dados
    include ("../conexao.php");

    $id = 3;

    // variável para armazenar comando sql
    $sql = "SELECT * FROM produtos WHERE id = ?;";

    // variável para receber a conexão e o comando sql já preparado para receber um dado no lugar de "?" (placeholder)
    $stmt = mysqli_prepare($conexao, $sql);

    // inserindo o $id como dado do tipo integer "i" ao ?
    mysqli_stmt_bind_param($stmt, "i", $id);

    // executando a consulta
    $executouStmt = mysqli_stmt_execute($stmt);

    // se houverem erros
    if ($executouStmt === false) {
        $erro = mysqli_stmt_error($stmt); 
        echo "Erro: ". $erro;
    } else { 
        // obtém o conjunto de resultados gerado pelo SELECT executado no $stmt
        $resultadoSelect = mysqli_stmt_get_result($stmt);

        // $produto recebe o próximo array associativo (no caso 1 só)
        $produto = mysqli_fetch_assoc($resultadoSelect);

        echo $produto["id"] ."<br>";
        echo $produto["nome"] ."<br>";
        echo $produto["categoria"] ."<br>";
        echo $produto["quantidade"] ."<br>";
        echo $produto["preco"] ."<br>";
    };
?>