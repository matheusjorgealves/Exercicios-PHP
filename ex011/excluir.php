<?php

    // incluindo a conexão
    include ("conexao.php");

    // se o usuário acessar com o id do registro
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
    } else {
        echo("Erro!");
        die;
    };

    // variável com comando sql para SELECT
    $sql = "SELECT * FROM produtos WHERE id = ?";

    // preparando o comando sql para receber um dado no ?
    $stmt = mysqli_prepare($conexao, $sql);

    // significado = $stmt recebe $id como dado no lugar de ?, $id é um dado do tipo "i" (integer, ou seja, inteiro)
    mysqli_stmt_bind_param($stmt, "i", $id);

    // executando o statement, ele retorna true ou false
    $resultadoStmt = mysqli_stmt_execute($stmt);

    // validando o resultado do comando SELECT
    if ($resultadoStmt === false) {
        $erro = mysqli_error($conexao);
    } else {
        // buscando o resultado da consulta sql feita com statements e armazenando o resultado
        $resultadoSelect = mysqli_stmt_get_result($stmt);

        // transforma o resultado em um array associativo
        $produto = mysqli_fetch_assoc($resultadoSelect);
    };

    // validando id do banco de dados
    if (!isset($produto["id"])) {
        echo "Produto não encontrado";
        die;
    };

    // caso o usuário clique no botão
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // se o usuário clicar no botão excluir
        if (isset($_POST["buttonExcluir"])) {
            // variável com comando sql para DELETE. ? é um placeholder, significa que ? receberá um dado posteriormente
            $sql = "DELETE FROM produtos WHERE id = ?";

            // prepara o comando da variável sql para ser executada posteriormente, recebendo dados no lugar do ?
            $stmt = mysqli_prepare($conexao, $sql);

            // esse comando associa $id ao parâmetro ? do $stmt. O "i" informa que $id é um inteiro
            mysqli_stmt_bind_param($stmt, "i", $id);

            // mysqli_stmt_execute executa o $stmt, executa o DELETE
            $resultadoDelete = mysqli_stmt_execute($stmt);

            // validando resultado do comando DELETE
            if ($resultadoDelete === false) {
                $erro = mysqli_error($conexao);
                echo "Não foi possível excluir o produto. Tente novamente.";
            } else { // se o DELETE funcionar volta para página inicial
                header("Location: index.php");
            };
        };
    };

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Produtos</title>
</head>
<body>
    <header>
        <h1>Excluir Produtos</h1>
    </header>

    <main>

        <?php
            if (isset($erro)) {
                echo $erro;
                die;
            };
        ?>

        <!-- criação da tabela -->
        <table>
            <caption>Produto:</caption>
            <thead> <!-- cabeçalho --> 
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                </tr>
            </thead>
            <tbody> <!-- corpo da tabela --> 
                <tr>
                    <td><?= $produto["id"] ?></td>
                    <td><?= $produto["nome"] ?></td>
                    <td><?= $produto["categoria"] ?></td>
                    <td><?= $produto["preco"] ?></td>
                    <td><?= $produto["quantidade"] ?></td>
                </tr>
            </tbody>
        </table>

        <!-- formulário para os botões -->
         <!-- onsubmit confirm faz uma pergunta de confirmação, o return retorna verdadeiro ou falso -->
        <form action="" method="post" onsubmit="return confirm('Tem certeza que deseja excluir este produto?')">
            <!-- voltar -->
            <button type="button"><a href="index.php">Voltar</a></button>

            <!-- editar -->
            <button type="button"><a href="editar.php?id=<?= $id ?>">Editar</a></button>

            <!-- excluir -->
            <button type="submit" name="buttonExcluir">Excluir</button>
        </form>

    </main>
</body>
</html>