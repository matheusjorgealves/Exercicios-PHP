<?php

    // incluindo a conexão com o banco de dados
    include ("../conexao.php");

    // exibir o nome do cliente, a quantidade de pedidos e o valor total gasto dos clientes com 2 ou mais pedidos feitos. organizar o relatório do maior para o menor valor gasto. se não existir nenhum cliente com esses requisitos eu devo exibir uma mensagem e não gerar a tabela 

    // inicializando variáveis
    $erros = [];
    $clientes = [];

    // variável para armazenar instrução sql
    $sql = "SELECT clientes.nome, COUNT(DISTINCT pedidos.id) AS quant_pedidos, SUM(itens_pedido.quantidade * itens_pedido.preco_unitario) AS total_gasto
    FROM itens_pedido INNER JOIN pedidos
    ON itens_pedido.pedido_id = pedidos.id
    INNER JOIN clientes
    ON pedidos.cliente_id = clientes.id
    GROUP BY clientes.id
    HAVING quant_pedidos >= 2
    ORDER BY total_gasto DESC;";

    // statement preparado para executar no banco de dados
    $stmt = mysqli_prepare($conexao, $sql);

    // se a criação do stmt falhar
    if ($stmt === false) {
        $erros[] = "Não foi possível concluir a consulta!";
    } else {
        // executando o stmt
        $execucao = mysqli_stmt_execute($stmt);

        // se a execução do stmt falhar
        if ($execucao === false) {
            $erros[] = "Não foi possível concluir a consulta!";
        } else {
            // recebendo o conjunto de registros retornados pela consulta 
            $resultadoJOIN = mysqli_stmt_get_result($stmt);
        
            // se o resultado for um erro
            if ($resultadoJOIN === false) {
                $erros[] = "Não foi possível concluir a consulta!";
            } else {
                // enquanto houverem registros
                while ($cliente = mysqli_fetch_assoc($resultadoJOIN)) {
                    $clientes[] = $cliente;
                }
            }
        }

        // fechando o statement
        mysqli_stmt_close($stmt);
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
</head>
<body>
    <header>
        <h1>Clientes</h1>
    </header>

    <main>
        <!-- abrindo php -->
        <?php
            // se houverem erros
            if (!empty($erros)) {
                // percorrendo os erros
                foreach ($erros as $erro) {
                    ?>
                    <p>Erro: <?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></p>
                    <?php
                }
                die;
            }

            // se não houverem clientes que atendam aos requisitos
            if (empty($clientes)) {
                ?>
                <h2>Nenhum cliente registrado realizou dois ou mais pedidos</h2>
                <?php
            } else { // se houverem clientes que atendam aos requisitos
                ?>
                <h2>Clientes com dois ou mais pedidos feitos:</h2>

                <table>
                    <!-- cabeçalho da table -->
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Pedidos</th>
                            <th>Total Gasto</th>
                        </tr>
                    </thead>

                    <!-- corpo da table -->
                    <tbody>
                        <?php
                            // percorrendo os clientes
                            foreach ($clientes as $cliente) {
                                // recebendo os dados dos clientes
                                $nome = $cliente["nome"];
                                $quantPedidos = $cliente["quant_pedidos"];
                                $total = $cliente["total_gasto"];

                                ?>
                                <!-- criando linha de dados na table -->
                                <tr>
                                    <td><?= htmlspecialchars($nome, ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><?= htmlspecialchars($quantPedidos, ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><?= htmlspecialchars($total, ENT_QUOTES, 'UTF-8') ?></td>
                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
                <?php
            }
        ?>
    </main>
</body>
</html>