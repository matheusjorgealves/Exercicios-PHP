<?php

    // incluindo a conexão com o banco de dados
    include ("../conexao.php");

    // criando variáveis
    $erros = [];
    $produtos = [];

    // variável para armazenar instrução sql
    $sql = "SELECT * FROM produtos;";

    // statement pronto para ser executado no banco de dados
    $stmt = mysqli_prepare($conexao, $sql);

    // executando o statement no banco de dados
    $execucao = mysqli_stmt_execute($stmt);

    // se a execução do statement falhar
    if ($execucao === false) {
        $erros[] = mysqli_stmt_error($stmt);
    } else {
        // recebendo um conjunto de registros retornados pela consulta
        $resultadoSelect = mysqli_stmt_get_result($stmt);

        // enquanto existirem novos registros dentro do conjunto
        while ($produto = mysqli_fetch_assoc($resultadoSelect)) { 
            $produtos[] = $produto; // recebendo cada registro em um array
        };
    };

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exclusão de Produtos</title>
</head>
<body>
    <header>
        <h1>Exclusão de Produtos</h1>
    </header>

    <main>
        <p>Selecione abaixo o produto que deseja excluir</p>

        <!-- usando php para validar possíveis erros -->
        <?php
            // se houverem erros
            if (!empty($erros)) {
                // percorrendo os erros
                foreach ($erros as $erro) {
                    ?>
                        <p><?= $erro ?></p>
                    <?php
                };
            } else { // sem erros...
                ?>
                    <table> 
                        <!-- cabeçalho da table -->
                        <thead>
                            <throw>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th>Quantidade</th>
                                <th>Preço</th>
                                <th>Exclusão</th>
                            </throw>   
                        </thead> 
                        <!-- fim - cabeçalho da table -->
                        
                        <!-- corpo da table -->
                        <tbody>
                            <?php
                                // percorrendo os produtos
                                foreach ($produtos as $produto) {
                                    ?>
                                        <!-- adicionando uma linha à table -->
                                        <tr>
                                            <td><?= $produto["id"] ?></td>
                                            <td><?= $produto["nome"] ?></td>
                                            <td><?= $produto["categoria"] ?></td>
                                            <td><?= $produto["quantidade"] ?></td>
                                            <td><?= $produto["preco"] ?></td>
                                            <td><a href="delete001-2.php?id=<?= $produto["id"] ?>/">Excluir</a></td>
                                        </tr>
                                    <?php
                                };
                            ?>
                        </tbody> 
                        <!-- fim - corpo da table -->
                    </table>
                <?php
            };      
        ?>
        <!-- fim - php para table -->
    </main>
</body>
</html>