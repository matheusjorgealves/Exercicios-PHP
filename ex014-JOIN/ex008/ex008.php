<?php

    // incluindo a conexão com o banco de dados
    include ("../conexao.php");

    // a página deve receber o id de um cliente e um percentual de aumento (0 a 30), os produtos que ele já comprou devem ter seus preços alterados pelo percentual que o usuário escolher. o preço do produto deve ser alterado apenas uma vez, mesmo que o usuário tenha comprado o mesmo produto várias vezes. deve ser informado ao usuário quantos produtos tiveram seus preços alterados.

    // inicializando variáveis 
    $erros = [];

    // se o método da requisição http for post
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // se não houver id na requisição
        if (!isset($_POST["id"])) {
            $erros[] = "Nenhum id foi informado!";
        } else {
            // recebendo o id
            $id = $_POST["id"];

            // se o id não for um número inteiro
            if (filter_var($id, FILTER_VALIDATE_INT) === FALSE) {
                $erros[] = "Id deve ser um número inteiro!";
            } else {
                // se o id for inferior a 1
                if ($id < 1) {
                    $erros[] = "Id não pode ser inferior a 1!";
                }
            }
        }

        // se não houver um percentual de aumento na requisição
        if (!isset($_POST["aumento"])) {
            $erros[] = "Insira um percentual de aumento!";
        } else {
            // se o aumento não for um número inteiro
            if (filter_var($_POST["aumento"], FILTER_VALIDATE_INT) === false) {
                $erros[] = "O aumento deve ser um valor inteiro!";
            } else {
                // recebendo a resposta do usuário
                $aumento = $_POST["aumento"];

                // se o aumento for inferior a 1 ou superior a 30
                if ($aumento < 1 || $aumento > 30) {
                    $erros[] = "O aumento deve estar entre 0 e 30!";
                } else {
                    // calculando a porcentagem
                    $aumento = $aumento / 100;
                }
            }
        }

        // se não houverem erros
        if (empty($erros)) {
            // variável que armazena uma instrução sql
            $sql = "UPDATE produtos 
                    INNER JOIN itens_pedido
                    ON produtos.id = itens_pedido.produto_id 
                    INNER JOIN pedidos
                    ON itens_pedido.pedido_id = pedidos.id
                    INNER JOIN clientes
                    ON pedidos.cliente_id = clientes.id
                    SET produtos.preco = produtos.preco + produtos.preco * ?
                    WHERE pedidos.status = 'concluido'
                        AND clientes.id = ?;"
            ;

            // statement preparado para a associação de dados aos parâmetros
            $stmt = mysqli_prepare($conexao, $sql);

            // se o stmt não for criado
            if ($stmt === false) {
                $erros[] = "Não foi possível concluir a atualização dos preços dos pedidos!";
            } else {
                // associando os dados aos parâmetros
                mysqli_stmt_bind_param($stmt, "di", $aumento, $id);

                // executando o stmt
                $execucao = mysqli_stmt_execute($stmt);

                // se a execução do stmt falhar
                if ($execucao === false) {
                    $erros[] = "Não foi possível concluir a atualização dos preços dos produtos!";
                } else {
                    // recebendo a quantidade de linhas afetadas
                    $linhasAfetadas = mysqli_stmt_affected_rows($stmt);
                }

                // fechando o stmt
                mysqli_stmt_close($stmt);
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualização de produtos</title>
</head>
<body>
    <header>
        <h1>Atualização de produtos</h1>
    </header>

    <main>
        <!-- abrindo o php -->
        <?php 
        // se houverem erros
        if (!empty($erros)) {
            // percorrendo os erros
            foreach ($erros as $erro) {
                ?>
                <!-- exibindo o erro e escapando a variável antes de exibi-la -->
                <p>Erro: <?= htmlspecialchars($erro, ENT_QUOTES, "UTF-8") ?></p>
                <?php
            }
        }
        ?>

        <p>Os produtos que você já comprou terão seus preços aumentados de acordo com o percentual que você informar!</p>

        <!-- formulário para inserção de id do usuário e valor percentual -->
        <form action="" method="post">
            <!-- id -->
            <label for="id">Seu id:</label>
            <input type="number" name="id" id="id" min="1" required>
            <br> <br>

            <!-- aumento -->
            <label for="aumento">Aumento:</label>
            <input type="number" name="aumento" id="aumento" min="1" max="30" step="1" required>
            <br> <br>

            <!-- button atualizar -->
            <button type="submit">Atualizar</button>
            <br> <br>
        </form>

        <!-- abrindo o php -->
        <?php 
        // se não houverem erros e o método da requisição for post
        if (empty($erros) && $_SERVER["REQUEST_METHOD"] === "POST") {
            // se a quantidade de linhas alteradas foi 0
            if ($linhasAfetadas === 0) {
                ?>
                <p>Nenhum produto foi afetado!</p>
                <?php
            } elseif ($linhasAfetadas === 1) {
                ?>
                <p><?= htmlspecialchars($linhasAfetadas, ENT_QUOTES, "UTF-8") ?> alteração de preço foi realizada!</p>
                <?php
            } else {
                ?>
                <p><?= htmlspecialchars($linhasAfetadas, ENT_QUOTES, "UTF-8") ?> alterações de preço foram realizadas!</p>
                <?php
            }
        }
        ?>
    </main>

    <footer>
        <p>Site feito por <a href="https://GitHub.com/matheusjorgealves/" target="_blank">Matheus Jorge</a></p>
    </footer>
</body>
</html>