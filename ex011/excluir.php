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
    $sql = "SELECT * FROM produtos WHERE id = $id";

    // executando o comando sql e armazenando o resultado
    $resultadoSelect = mysqli_query($conexao, $sql);

    // validando o resultado do comando SELECT
    if ($resultadoSelect === false) {
        $erro = mysqli_error($conexao);
    } else {
        $produto = mysqli_fetch_assoc($resultadoSelect);
    };

    // validando id do banco de dados
    if (!isset($produto["id"])) {
        echo "Erro de id!";
        die;
    };

    // caso o usuário clique no botão
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // se o usuário clicar no botão excluir
        if (isset($_POST["buttonExcluir"])) {
            // variável com comando sql para DELETE
            $sql = "DELETE FROM produtos WHERE id = $id";

            // executando comando DELETE
            $resultadoDelete = mysqli_query($conexao, $sql);

            // validando resultado do comando DELETE
            if ($resultadoDelete === false) {
                $erro = mysqli_error($resultadoDelete);
                echo $erro;
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