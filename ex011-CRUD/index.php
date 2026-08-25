<?php

    // mysqli_query executa comandos sql. ele devolve a consulta em registros, usei o while comparando o resultado dessa consulta para conseguir receber cada registro de forma separada em um array
    // mysqli_fetch_assoc devolve um array associativo de cada registro ou devolve false para indicar que não há mais registros
    // mysqli_error volta a última mensagem de erro do banco de dados. eu devo usa-lo com o parâmetro $conexao para que ele saiba qual é o banco

    include("conexao.php"); // incluindo esse arquivo no index

    // criando variáveis
    $produtos = [];

    /* READ */
    // variável para armazenar um comando sql 
    $sql = "SELECT * FROM produtos;";

    // comando sql para o banco - parâmetros = banco e comando
    $resultado = mysqli_query($conexao, $sql);

    // validando comando sql
    if ($resultado === false) {
        echo "Erro: ". mysqli_error($conexao);
    } else {
        // enquanto mysqli_fetch_assoc encontrar um próximo registro, ele será armazenado em $produto e adicionado ao array $produtos. Quando não houver mais registros, a função retornará false e o while será encerrado.
        while ($produto = mysqli_fetch_assoc($resultado)) {
            $produtos[] = $produto;
        };
    };

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de produtos</title>
</head>
<body>
    <header>
        <h1>CRUD de produtos</h1>

        <!-- tabela -->
        <table>
            <caption>Produtos Cadastrados</caption> <!-- título da table -->
            <thead> <!-- cabeçalho da tabela -->
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody> <!-- corpo da tabela -->
                <?php
                    // se não houverem erros
                    if ($resultado != false) {
                        // percorrendo os produtos
                        foreach ($produtos as $produto) {
                            ?>
                            <tr> <!-- adiciona linha -->
                                <td><?= $produto["id"] ?></td>
                                <td><?= $produto["nome"] ?></td>
                                <td><?= $produto["categoria"] ?></td>
                                <td><?= $produto["preco"] ?></td>
                                <td><?= $produto["quantidade"] ?></td>
                                <!-- links passando o id para outra página com GET -->
                                <td><a href="editar.php?id=<?= $produto["id"] ?>">Editar</a> | <a href="excluir.php?id=<?= $produto["id"] ?>">Excluir</a></td>
                            </tr>
                            <?php
                        };
                    };
                ?>
            </tbody>
        </table>

        <p><a href="cadastrar.php">Cadastrar produto</a></p>
    </header>
</body>
</html>