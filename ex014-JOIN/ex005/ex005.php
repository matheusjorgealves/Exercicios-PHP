<?php

    // incluindo a conexão com o banco de dados
    include ("../conexao.php");

    // exibir nome do cliente, quantos pedidos ele fez, quantos produtos ele comprou e quanto ele gastou

    // inicializando variáveis
    $erros = [];
    $dadosClientes = [];

    // se o método da requisição for post
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // se o id não for passado pelo método post
        if (!isset($_POST["id"])) {
            $erros[] = "Id inexistente!";
        } else {
            // se o id não for número inteiro
            if (filter_var($_POST["id"], FILTER_VALIDATE_INT) === false) {
                $erros[] = "Id deve ser número inteiro!";
            } else {
                // recebendo o id
                $id = $_POST["id"];

                // validações do id
                // se o id for inferior a 1
                if ($id < 1) {
                    $erros[] = "Id não pode ser inferior a 1!";
                }
            }
        }

        // se não houverem erros
        if (empty($erros)) {
            // variável para armazenar instrução sql
            $sql = "SELECT clientes.nome, COUNT(DISTINCT pedidos.id) AS total_pedidos, SUM(itens_pedido.quantidade) AS total_produtos, SUM(itens_pedido.quantidade * itens_pedido.preco_unitario) AS preco_total FROM itens_pedido 
            INNER JOIN pedidos
            ON itens_pedido.pedido_id = pedidos.id
            INNER JOIN clientes
            ON pedidos.cliente_id = clientes.id
            INNER JOIN produtos
            ON itens_pedido.produto_id = produtos.id
            WHERE clientes.id = ?
            GROUP BY clientes.id;";

            // statement preparado para a associação do id ao placeholder
            $stmt = mysqli_prepare($conexao, $sql);

            // se a criação do stmt falhar
            if ($stmt === false) {
                $erros[] = "A consulta não pôde ser concluída!";
            } else {
                // associando o id ao placeholder
                mysqli_stmt_bind_param($stmt, "i", $id);

                // executando o stmt
                $execucao = mysqli_stmt_execute($stmt);

                // se a exeução do statement falhar
                if ($execucao === false) {
                    $erros[] = "Não foi possível carregar os dados!";
                } else {
                    // recebendo o conjunto de registros retornados pela consulta
                    $resultadoJOIN = mysqli_stmt_get_result($stmt);

                    // encerrando o stmt
                    mysqli_stmt_close($stmt);

                    // se houverem erros na busca do conjunto de registros
                    if ($resultadoJOIN === false) {
                        $erros[] = "Não foi possível carregar os dados por problemas tecnicos!";
                    } else {
                        // enquanto houverem registros
                        while ($dadosCliente = mysqli_fetch_assoc($resultadoJOIN)) {
                            $dadosClientes[] = $dadosCliente;
                        }
                    }
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
    <title>Consulte suas informações</title>
</head>
<body>
    <header>
        <h1>Consulte suas informações</h1>
    </header>

    <main>
        <!-- abrindo php -->
        <?php
            // se houverem erros
            if (!empty($erros)) {
                // percorrendo os erros
                foreach ($erros as $erro) {
                    ?>
                    <p>Erro: <?= $erro ?></p>
                    <?php
                }
            }
        ?>

        <form action="" method="post">
            <!-- id -->
            <label for="id">Id do usuário:</label>
            <input type="number" name="id" id="id" step="1" min="1" required>
            <br> <br>

            <!-- button consultar -->
            <button type="submit">Consultar</button>
            <br> <br>
        </form>

        <?php
            // se não houverem erros
            if (empty($erros)) {
                // se o metodo da requisição for post
                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    // se o usuário não existir ou não possuir pedidos cadastrados
                    if (empty($dadosClientes)) {
                        ?>
                        <p>Dados inexistentes!</p>
                        <?php
                    } else {
                        // criando uma table

                        ?>
                        <table>
                            <!-- cabeçalho da table -->
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Pedidos realizados</th>
                                    <th>Produtos comprados</th>
                                    <th>Total</th>
                                </tr>
                            </thead>

                            <!-- corpo da table -->
                            <tbody>
                                <tr>
                                    <?php
                                        // percorrendo os registros
                                        foreach ($dadosClientes as $dadosCliente) {
                                            // recebendo os dados do cliente
                                            $nome = $dadosCliente["nome"];
                                            $totalPedidos = $dadosCliente["total_pedidos"];
                                            $totalProdutos = $dadosCliente["total_produtos"];
                                            $precoTotal = $dadosCliente["preco_total"];
                                            ?>
                                            <td><?= $nome ?></td>
                                            <td><?= $totalPedidos ?></td>
                                            <td><?= $totalProdutos ?></td>
                                            <td><?= $precoTotal ?></td>
                                            <?php
                                        }
                                    ?>
                                </tr>
                            </tbody>
                        </table>
                        <?php
                    }
                }
            }
        ?>
    </main>

    <footer>
        <p>Site feito por <a href="https://GitHub.com/matheusjorgealves" target="blank">Matheus Jorge</a></p>
    </footer>
</body>
</html>