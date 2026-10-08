<?php

    // incluindo a conexão com o banco de dados
    include ("../conexao.php");

    // exibir o id do cliente, id do pedido, nome do cliente, nome do produto, quantidade de produtos no pedido, data do pedido, status do pedido, preço unitário registrado no pedido

    // inicializando variáveis
    $erros = [];
    $itensPedido = [];

    // se não existir um id na url
    if (!isset($_GET["id"])) {
        $erros[] = "Página acessada sem o id do cliente na URL!";
    } else {
        // se o id digitado não for um número inteiro
        if (filter_var($_GET["id"], FILTER_VALIDATE_INT) === false) {
            $erros[] = "Id deve ser um número inteiro!";
        } else {
            // recebendo o id da url
            $id = $_GET["id"];

            // validando o id 
            // se o id for inferior a 1 ou null
            if ($id < 1) {
                $erros[] = "Id inválido!";
            } else {
                // consulta dos pedidos do cliente desse id no banco de dados

                // variável que armazena instrução sql
                $sql = "SELECT pedidos.id AS id_pedido, clientes.nome AS nome_cliente, pedidos.data_pedido, pedidos.status, produtos.id AS id_produto, produtos.nome AS nome_produto, itens_pedido.quantidade, itens_pedido.preco_unitario FROM itens_pedido INNER JOIN pedidos
                ON itens_pedido.pedido_id = pedidos.id
                INNER JOIN clientes
                ON pedidos.cliente_id = clientes.id
                INNER JOIN produtos
                ON itens_pedido.produto_id = produtos.id
                WHERE cliente_id = ?;";

                // statement preparado para a associação do id ao placeholder
                $stmt = mysqli_prepare($conexao, $sql);

                // se a criação do stmt falhar
                if ($stmt === false) {
                    $erros[] = "A consulta não pôde ser concluída!";
                } else {
                    // associando o parâmetro ao placeholder
                    mysqli_stmt_bind_param($stmt, "i", $id);

                    // executando o statement
                    $execucao = mysqli_stmt_execute($stmt);
                    
                    // se houverem falhas na execução do statement
                    if ($execucao === false) {
                        $erros[] = "Não foi possível carregar os dados!";
                    } else {
                        // recebendo o conjunto de registros retornados pela consulta
                        $resultadoJOIN = mysqli_stmt_get_result($stmt);

                        // fechando o statement
                        mysqli_stmt_close($stmt);

                        // se houver falha no resultado da consulta
                        if ($resultadoJOIN === false) {
                            $erros[] = "Resultado inesperado da consulta ao banco de dados!";
                        } else {
                            // enquanto houverem registros
                            while ($itemPedido = mysqli_fetch_assoc($resultadoJOIN)) {
                                // recebendo o nome do cliente 
                                $nomeCliente = $itemPedido["nome_cliente"];

                                // armazenando os itens do pedido de id correspondente
                                $itensPedido[] = $itemPedido;
                            }
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
    <title>Pedidos realizados</title>
</head>
<body>
    <header>
        <h1>Pedidos realizados</h1>
    </header>

    <main>
        <?php
            // se houverem erros
            if (!empty($erros)) {
                // percorrendo os erros 
                foreach ($erros as $erro) {
                    ?>
                    <p>Erro: <?= $erro ?> Corrija na URL!</p>
                    <?php
                }
                die;
            } else {
                // se o cliente de id correspondente não tiver pedidos cadastrados
                if (empty($itensPedido)) {
                    ?>
                    <p>O cliente de id <?= $id ?> não possui pedidos cadastrados!</p>
                    <?php
                } else {
                    // abrindo o html e criando um subtítulo e uma table 
                    ?>
                    <h2>Informações dos seus pedidos, <?= $nomeCliente ?></h2>
                    <table>
                        <!-- cabeçalho da table -->
                        <thead>
                            <tr>
                                <th>Id do cliente</th>
                                <th>Id do pedido</th>
                                <th>Cliente</th>
                                <th>Produto</th>
                                <th>Quantidade do produto</th>
                                <th>Data do pedido</th>
                                <th>Status do pedido</th>
                                <th>Preço</th>
                            </tr>
                        </thead>

                        <!-- corpo da table -->
                        <tbody>
                            <!-- abrindo o php -->
                            <?php
                                // percorredo o array dos itens do pedido
                                foreach ($itensPedido as $itemPedido) {
                                    // recebendo os dados do pedido
                                    $idPedido = $itemPedido["id_pedido"];
                                    $nomeProduto = $itemPedido["nome_produto"];
                                    $quantidade = $itemPedido["quantidade"];
                                    $dataPedido = $itemPedido["data_pedido"];
                                    $statusPedido = $itemPedido["status"];
                                    $precoUnitario = $itemPedido["preco_unitario"];
                                    ?>
                                    <!-- linha na table -->
                                    <tr>
                                        <td><?= $id ?></td>
                                        <td><?= $idPedido ?></td>
                                        <td><?= $nomeCliente ?></td>
                                        <td><?= $nomeProduto ?></td>
                                        <td><?= $quantidade ?></td>
                                        <td><?= $dataPedido ?></td>
                                        <td><?= $statusPedido ?></td>
                                        <td><?= $precoUnitario ?></td>
                                    </tr>
                                    <?php
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php
                }
            }
        ?>
    </main>

    <footer>
        <p>Site feito por <a href="https://GitHub.com/matheusjorgealves" target="blank">Matheus Jorge</a></p>
    </footer>
</body>
</html>