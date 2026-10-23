<?php

    // inclusão da conexão com o banco de dados
    include("../conexao.php");
    // $conexao é a variável que representa a conexão com o banco de dados

    // essa página deve ser capaz de receber o id de um pedido, verificar se esse pedido está cancelado e remover o registro que contiver a ligação entre o pedido e o produto. após a exclusão, o site deve exibir a quantidade de linhas excluídas

    // inicialização de variáveis
    $idPedido = 0;
    $erros = [];

    // se o método da requisição http for post
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // se não houver um id na requisição http de método post
        if (!isset($_POST["idPedido"])) {
            $erros[] = "Insira o id do pedido!";
        } else {
            // se o id estiver vazio
            if (empty($_POST["idPedido"])) {
                $erros[] = "O id não pode ser nulo!";
            } else {
                // se o id não for um número inteiro
                if (filter_var($_POST["idPedido"], FILTER_VALIDATE_INT) === false) {
                    $erros[] = "O id deve ser um número inteiro!";
                } else {
                    // recebendo o id do pedido
                    $idPedido = $_POST["idPedido"];

                    // se o id for inferior a 1
                    if ($idPedido < 1) {
                        $erros[] = "Valor mínimo para o id é 1!";
                    }
                }
            }
        }

        // se não houverem erros
        if (empty($erros)) {
            // variável para armazenar instrução sql
            $sql = "DELETE itens_pedido 
                    FROM itens_pedido
                    INNER JOIN pedidos
                    ON itens_pedido.pedido_id = pedidos.id
                    WHERE pedidos.id = ? AND pedidos.status = 'cancelado';";

            // statement preparado para a associação de dados
            $stmt = mysqli_prepare($conexao, $sql);

            // se a criação do stmt falhar 
            if ($stmt === false) {
                $erros[] = "Não foi possível concluir a exclusão!";
            } else {
                // associação do dado ao placeholder
                mysqli_stmt_bind_param($stmt, "i", $idPedido);

                // execução do stmt
                $execucao = mysqli_stmt_execute($stmt);

                // se a execução falhar 
                if ($execucao === false) {
                    $erros[] = "Não foi possível concluir a exclusão!";
                } else {
                    // quantidade de linhas afetadas depois da execução da instrução sql
                    $resultado = mysqli_stmt_affected_rows($stmt);
                }

                // fechamento do statement
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
    <title>Exclusão de pedidos</title>
</head>
<body>
    <header>
        <h1>Exclusão de pedidos</h1>
    </header>

    <main>
        <!-- abrindo o php -->
        <?php
        // se houverem erros
        if (!empty($erros)) {
            // percorrendo os erros
            foreach ($erros as $erro) {
                ?>
                <p>Erro: <?= htmlspecialchars($erro, ENT_QUOTES, "UTF-8") ?></p>
                <?php
            }
        }
        ?>

        <p>Insira o id do pedido que você quiser excluír caso este pedido esteja cancelado</p>

        <form action="" method="post">
            <!-- idPedido -->
            <label for="idPedido">Id do pedido:</label>
            <input type="number" name="idPedido" id="idPedido" min="1" required value="<?= $_SERVER["REQUEST_METHOD"] === "POST" ? htmlspecialchars($idPedido, ENT_QUOTES, "UTF-8") : "" ?>">
            <br> <br>

            <!-- button excluir -->
            <button type="submit">Excluir</button>
            <br> <br>
        </form>

        <!-- abrindo o php -->
        <?php
        // se não houverem erros e o método da requisição for post
        if (empty($erros) && $_SERVER["REQUEST_METHOD"] === "POST") {
            // se nenhuma linha do banco de dados for alterada
            if ($resultado < 1) {
                ?>
                <p>O pedido de id <?= htmlspecialchars($idPedido, ENT_QUOTES, "UTF-8") ?> não teve a sua lista de itens removida!</p>
                <?php
            } else {
                ?>
                <p>A quantidade de linhas afetadas foi <?= htmlspecialchars($resultado, ENT_QUOTES, "UTF-8") ?></p>
                <?php
            }
        }
        ?>
    </main>

    <footer>
        <p>Site desenvolvido por <a href="https://GitHub.com/matheusjorgealves" target="_blank">Matheus Jorge</a></p>
    </footer>
</body>
</html>