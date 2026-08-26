<?php

    // incluindo o arquivo de conexão
    include ("../conexao.php");

    // desafio: Buscar todos os produtos que pertencem à categoria "Periféricos usando prepared statements

    $categoria = "Periféricos";

    // variável para armazenar uma instrução sql
    $sql = "SELECT * FROM produtos WHERE categoria = ?;";

    // criando um statement preparado a partir da conexão e da instrução sql preparada para receber um dado no placeholder ?
    $stmt = mysqli_prepare($conexao, $sql);

    // associa o dado $categoria, do tipo string, ao placeholder ?
    mysqli_stmt_bind_param($stmt, "s", $categoria);

    // recebe o resultado (booleano) da execução do stmt
    $execucaoStmt = mysqli_stmt_execute($stmt);

    // caso houverem erros
    if ($execucaoStmt === false) {
        // recebe o erro que ocorreu no statement (ele armazena erros também)
        $erro = mysqli_stmt_error($stmt);

        echo "Erro:". $erro;
    } else {
        // recebe o resultado da execução do $stmt
        $resultadoSelect = mysqli_stmt_get_result($stmt);

        // $produto armazena o próximo registro ou false (encerra o laço)
        while ($produto = mysqli_fetch_assoc($resultadoSelect)) {
            // array $produtos armazenará cada um dos registros
            $produtos[] = $produto;
        };

        // percorre os arrays dentro de $produtos
        foreach ($produtos as $produto) {
            echo "<h2>Produto:</h2>";
            // acessando os registros sem um segundo laço
            echo "ID: ". $produto["id"] ."<br>"; 
            echo "Nome: ". $produto["nome"] ."<br>";
            echo "Categoria: ". $produto["categoria"] ."<br>";
        };
    };
?>