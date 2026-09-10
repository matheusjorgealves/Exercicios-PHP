<?php

    include ("../conexao.php");

    // criando variáveis 
    $erros = [];

    // variável para armazenar uma instrução sql
    $sql = "SELECT * FROM produtos;";

    // statement executará a instrução sql no banco de dados
    $stmt = mysqli_prepare($conexao, $sql);

    // executando o stmt
    $execucao = mysqli_stmt_execute($stmt);

    // se a execução não for bem-sucedida
    if ($execucao === false) {
        $erros[] = mysqli_stmt_error($stmt);
    } else {
        // recebendo o resultado da consulta, variável receberá um conjunto de registros
        $resultadoSelect = mysqli_stmt_get_result($stmt);

        // busca o próximo registro do conjunto, ou retorna false
        while ($produto = mysqli_fetch_assoc($resultadoSelect)) {
            $produtos[] = $produto;
        };
    };
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualize produtos</title>
</head>
<body>
    <!-- cabeçalho -->
    <header>
        <h1>Atualize um Produto</h1>
    </header>

    <!-- corpo -->
    <main>
        <p>Clique no produto que você deseja alterar:</p>

        <?php
            // se houverem erros
            if (!empty($erros)) {
                // percorrendo os erros
                foreach ($erros as $erro) {
                    echo "Erro: $erro";
                    die;
                };
            } else { // se não houverem erros 
                ?>
                <!-- tabela -->
                <table>
                    <!-- cabeçalho da tabela -->
                    <thead>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>Ação</th>
                    </thead>
                    <!-- corpo da tabela -->
                    <tbody>
                        <?php
                            // percorrendo os produtos
                           foreach ($produtos as $produto) {
                                ?>
                                    <tr>
                                        <td><?= $produto["id"] ?></td>
                                        <td><?= $produto["nome"] ?></td>
                                        <td><?= $produto["categoria"] ?></td>
                                        <td><?= $produto["quantidade"] ?></td>
                                        <td><?= $produto["preco"] ?></td>
                                        <!-- link para editar registro de id equivalente -->
                                        <td><a href="update001-2.php?id=<?= $produto["id"] ?>">Editar</a></td>
                                    </tr>
                                <?php
                           };
                        ?>
                    </tbody>
                </table>
                <?php
            };
        ?>
    </main>

    <!-- rodapé -->
    <p>Site criado por <a href="https://github.com/matheusjorgealves" target="blanck">Matheus Jorge</a></p>
</body>
</html>