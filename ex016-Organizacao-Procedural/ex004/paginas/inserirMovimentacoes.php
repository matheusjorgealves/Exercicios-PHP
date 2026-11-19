<?php

    // $conexao armazena a conexão com o banco de dados
    require ("../../conexao.php");

    // vou usar a "conexão" com esse arquivo para utilizar uma function
    require ("../functions/movimentacoes_estoque.php");

    // inicializando a variável de erros
    $erros = [];

    // se o método da requisição for post
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // validando o id do produto
        if (!isset($_POST["id"])) {
            $erros[] = "Insira o ID do produto!";
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

        // validando a quantidade
        if (!isset($_POST["quantidade"])) {
            $erros[] = "Insira a quantidade!";
        } else {
            if (filter_var($_POST["quantidade"], FILTER_VALIDATE_INT) === false) {
                $erros[] = "A quantidade deve ser um número inteiro!";
            } else {
                $quantidade = $_POST["quantidade"];

                if ($quantidade < 1) {
                    $erros[] = "A quantidade deve ser um número positivo!";
                }
            }
        }

        if (empty($erros)) {
            // chamando uma function para atualizar o estoque
            $linhasAfetadas = atualizarEstoque($id, $quantidade, $conexao);

            // se a movimentação de estoque não for registrada
            if ($linhasAfetadas["sucesso"] === false) {
                foreach ($linhasAfetadas["mensagem"] as $erro) {
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
        <h1>Papelaria Horizonte - Atualizando o estoque</h1>
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
            // se o método da requisição for post
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                ?>
                <p>Atualização de estoque concluida com sucesso!. ID da movimentação de estoque = <?= htmlspecialchars($linhasAfetadas["resultado"], ENT_QUOTES, "UTF-8") ?></p>
                <?php
            }
        }
        ?>

        <h2>Formulário para atualizar o estoque do produto:</h2>
        <form action="" method="post">
            <!-- id -->
            <label for="id">ID do produto: </label>
            <input type="number" name="id" id="id" min="1" required>
            <br> <br>

            <!-- quantidade -->
            <label for="quantidade">Quantidade: </label>
            <input type="number" name="quantidade" id="quantidade" min="1" required>
            <br> <br>

            <button type="submit">Inserir</button>
        </form>

        <p><a href="../index.html">Clique aqui para voltar para a página inicial</a></p>
    </main>

    <footer>
        <p>Site desenvolvido por <a href="https:GitHub.com/matheusjorgealves" target="_blank">Matheus Jorge</a></p>
    </footer>
</body>
</html>