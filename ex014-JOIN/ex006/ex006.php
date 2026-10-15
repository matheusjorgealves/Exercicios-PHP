<?php

    // incluindo a conexão com o banco de dados
    include ("../conexao.php");

    // exibir todos os clientes cadastrados (se não tiver pedido cadastrado exibir 0, usando COALESCE), nome do cliente, quantidade de pedidos realizados, quantidade de produtos comprados e total de gastos. Organizar isso tudo por ordem alfabética

    // inicializando variáveis
    $erros = [];
    $clientes = [];

    // variável para armazenar uma instrução sql
    $sql = "SELECT clientes.id, clientes.nome, COUNT(DISTINCT pedidos.id) AS quantidade_pedidos, COALESCE(SUM(itens_pedido.quantidade), 0) AS quantidade_produtos, COALESCE(SUM(quantidade * itens_pedido.preco_unitario), 0) AS total_gastos 
    FROM clientes
    LEFT JOIN pedidos
    ON clientes.id = pedidos.cliente_id
    LEFT JOIN itens_pedido
    ON pedidos.id = itens_pedido.pedido_id
    GROUP BY clientes.id, clientes.nome
    ORDER BY clientes.nome ASC;";

    // statement preparado para a execução no banco de dados
    $stmt = mysqli_prepare($conexao, $sql);

    // se houver erro na criação do statement
    if ($stmt === false) {
        $erros[] = "Não foi possível carregar os dados!";
    } else {
        // executando o stmt
        $execucao = mysqli_stmt_execute($stmt);

        // se a execução do stmt falhar
        if ($execucao === false) {
            $erros[] = "Não foi possível carregar os dados!";
        } else {
            // recebe o conjunto de registros retornado pela consulta
            $resultadoJOIN = mysqli_stmt_get_result($stmt);

            // fechamento do stmt
            mysqli_stmt_close($stmt);

            // se o conjunto não for passado corretamente
            if ($resultadoJOIN === false) {
                $erros[] = "Não foi possível carregar os dados!";
            } else {
                // enquanto houverem registros
                while ($cliente = mysqli_fetch_assoc($resultadoJOIN)) {
                    $clientes[] = $cliente;
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
    <title>Clientes cadastrados</title>
</head>
<body>
    <header>
        <h1>Clientes cadastrados</h1>
    </header>

    <main>
        <!-- abrindo o php -->
        <?php
            // se houverem erros
            if (!empty($erros)) {
                // percorrendo os erros
                foreach ($erros as $erro) {
                    ?>
                    <p>Erro: <?= $erro ?></p>
                    <?php
                }
                // parando a execução
                die;
            }
        ?>
        <table>
            <!-- cabeçalho da table -->
            <thead>
                <tr>
                    <th>Id do cliente</th>
                    <th>Nome do cliente</th>
                    <th>Quantidade de pedidos realizados</th>
                    <th>Quantidade de produtos comprados</th>
                    <th>Total de gastos</th>
                </tr>
            </thead>

            <!-- corpo da table -->
            <tbody>
                <?php
                    // percorrendo os clientes
                    foreach ($clientes as $cliente) {
                        $id = $cliente["id"];
                        $nome = $cliente["nome"];
                        $quantidadePedidos = $cliente["quantidade_pedidos"];
                        $quantidadeProdutos = $cliente["quantidade_produtos"];
                        $totalGastos = $cliente["total_gastos"];
                        ?>
                        <tr>
                            <td><?= $id ?></td>
                            <td><?= $nome ?></td>
                            <td><?= $quantidadePedidos ?></td>
                            <td><?= $quantidadeProdutos ?></td>
                            <td><?= $totalGastos ?></td>
                        </tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>Site desenvolvido pro <a href="https://GitHub.com/matheusjorgealves" target="_blank">Matheus Jorge</a></p>
    </footer>
</body>
</html>