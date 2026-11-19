<?php

    // $conexao é a variável de conexão com o banco de dados
    require ("../../conexao.php");

    require ("../functions/produtos.php");
    
    // inicializando variável de erros
    $erros = [];

    // se o método da requisição for post
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // validando o id
        if (!isset($_POST["id"])) {
            $erros[] = "Insira o ID!";
        } else {
            if (filter_var($_POST["id"], FILTER_VALIDATE_INT) === false) {
                $erros[] = "O ID deve ser um número inteiro!";
            } else {
                $id = $_POST["id"];

                if ($id < 1) {
                    $erros[] = "O ID deve ser um número positivo!";
                }
            }
        }

        if (empty($erros)) {
            // chamando a function para consultar o banco de dados
            $produto = consultarProduto($id, $conexao);

            // se a consulta não funcionar
            if ($produto["sucesso"] === false) {
                foreach ($produto["mensagem"] as $erro) {
                    $erros[] = $erro;
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papelaria Horizonte</title>
</head>
<body>
    <header>
        <h1>Papelaria Horizonte - Consulta de produtos</h1>
    </header>

    <main>
        <?php
        // se houverem erros
        if (!empty($erros)) {
            foreach ($erros as $erro) {
                ?>
                <p>Erro: <?= htmlspecialchars($erro, ENT_QUOTES, "UTF-8") ?></p>
                <?php
            }
        } else {
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                ?>
                <table>
                    <!-- cabeçalho da table -->
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Preço</th>
                            <th>Quantidade</th>
                        </tr>
                    </thead>

                    <!-- corpo da table -->
                    <tbody>
                        <tr>
                            <?php
                            // percorrendo o produto
                            foreach ($produto["resultado"] as $itens) {
                                ?>
                                <td><?= htmlspecialchars($itens, ENT_QUOTES, "UTF-8") ?></td>
                                <?php
                            }
                            ?>
                        </tr>
                    </tbody>
                </table>
                <?php
            }
        }
        ?>

        <h2>Informe o ID do produto que deseja consultar</h2>

        <form action="" method="post">
            <!-- id -->
            <label for="id">ID: </label>
            <input type="number" name="id" id="id" min="1" required>
            <br> <br>

            <button type="submit">Consultar</button>
            <br> <br>
        </form>
        <p><a href="../index.html">Clique aqui para voltar para a página inicial</a></p>
    </main>

    <footer>
        <p>Site desenvolvido por <a href="https://GitHub.com/matheusjorgealves" target="_blank">Matheus Jorge</a></p>
    </footer>
</body>
</html>