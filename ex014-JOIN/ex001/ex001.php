<?php

    // incluindo a conexão com o banco de dados
    include ("../conexao.php");

    // preciso exibir uma tabela contendo as informações abaixo:
    // numero do pedido (id do pedido), nome do cliente, data do pedido e status atual do pedido

    // inicializando variáveis
    $erros = [];
    $pedidos = [];

    // variável para armazenar intrução sql
    $sql = "SELECT pedidos.id, pedidos.data_pedido, pedidos.status, clientes.nome FROM pedidos INNER JOIN clientes ON clientes.id = pedidos.cliente_id;";

    // statement preparado
    $stmt = mysqli_prepare($conexao, $sql);

    // executando o statement
    $execucao = mysqli_stmt_execute($stmt);

    // se a execução falhar
    if ($execucao === false) {
        $erros[] = "Não foi possível carregar os dados!";
    } else {
        // recebendo o conjunto de registros
        $resultadoJOIN = mysqli_stmt_get_result($stmt);

        // se a consulta retornar falso
        if ($resultadoJOIN === false) {
            $erros[] = "Houve um erro no retorno da consulta feita ao banco!";
        } else {
            // enquanto existirem registros
            while ($pedido = mysqli_fetch_assoc($resultadoJOIN)) {
                $pedidos[] = $pedido;
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exibindo os dados de pedidos</title>
</head>
<body>
    <header>
        <h1>Exibindo os dados de pedidos</h1>
    </header>

    <main>
        <h2>Tabela com os dados dos pedidos:</h2>
        
        <?php 
            // se houverem erros
            if (!empty($erros)) { 
                // percorrendo os erros
                foreach ($erros as $erro) {
                    ?>
                    <p><?= $erro ?></p>
                    <?php
                }
            }

            // se não houverem pedidos 
            if (empty($pedidos)) {
                ?>
                <p>Não existem pedidos!</p>
                <?php
            } 
            else {
                ?>
                <!-- usei INNER JOIN para buscar a tabela pedidos e clientes e exibir os dados na table -->
                <table>
                    <!-- cabeçalho da table -->
                    <thead>
                        <tr>
                            <th>Id do pedido</th>
                            <th>Nome do cliente</th>
                            <th>Data do pedido</th>
                            <th>Status do pedido</th>
                        </tr>
                    </thead>
                    <!-- corpo da table -->
                    <tbody>
                        <?php
                            // percorrendo os pedidos
                            foreach ($pedidos as $pedido) {
                                // recebendo os dados retornados pela consulta
                                $idPedido = $pedido["id"];
                                $nomeCliente = $pedido["nome"];
                                $dataPedido = $pedido["data_pedido"];
                                $statusPedido = $pedido["status"];
                                
                                // exibindo os dados na table
                                ?>
                                <tr>
                                    <td><?= $idPedido ?></td>
                                    <td><?= $nomeCliente ?></td>
                                    <td><?= $dataPedido ?></td>
                                    <td><?= $statusPedido ?></td>  
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

    <footer>
        <p>Site feito por <a href="https://GitHub.com/matheusjorgealves" target="blank">Matheus Jorge</a></p>
    </footer>
</body>
</html>