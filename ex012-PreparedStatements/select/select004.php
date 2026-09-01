<?php

    // objetivo: exibir os pordutos da categoria periféricos cujo preço seja maior a 100.00

    // incluindo a conexão com o banco de dados
    include ("../conexao.php");

    // criando variáveis
    $produtos = [];
    $categoria = "Perifericos";
    $preco = 100.00;

    // variável para armazenar a instrução sql
    $sql = "SELECT * FROM produtos WHERE categoria = ? AND preco > ?;";

    // criando statement (estamos criando um statement preparado a partir da instrução SQL e da conexão. executará no banco)
    $stmt = mysqli_prepare($conexao, $sql);

    // associando as variáveis (string e double) aos placeholders ?
    mysqli_stmt_bind_param($stmt, "sd" ,$categoria, $preco);

    // executando o statement e recebendo o resultado (bool)
    $execucao = mysqli_stmt_execute($stmt);

    // se houver erro na execução
    if ($execucao === false) {
        $erro = mysqli_stmt_error($stmt);
        echo "Erro: ". $erro;
    } else { // se não houverem erros
        // obtém os registros retornados pelo stmt
        $resultadoSelect = mysqli_stmt_get_result($stmt);

        // percorrendo os registros e guardando-os
        while ($produto = mysqli_fetch_assoc($resultadoSelect)) {
            $produtos[] = $produto;
        };

        // percorrendo o array que contém todos os registros retornados pelo stmt
        foreach ($produtos as $indice => $produto) {
            $indice++;
            echo "<p>Produto $indice:</p>";
            echo $produto["id"];
            echo $produto["nome"];
            echo $produto["categoria"];
            echo $produto["preco"];
        };
    };
?>