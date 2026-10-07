<?php

    // incluindo a conexão com o banco de dados
    include ("../conexao.php");

    // id do pedido, nome do cliente, nome do produto, quantidade comprada e o preço

    // inicializando variável
    $erros = [];
    $pedidos = [];

    // variável que armazena uma instrução sql
    $sql = "SELECT pedidos.id, clientes.nome AS nome_cliente, produtos.nome AS nome_produto, itens_pedido.quantidade, itens_pedido.preco_unitario 
    FROM itens_pedido INNER JOIN pedidos 
    ON itens_pedido.pedido_id = pedidos.id
    INNER JOIN clientes 
    ON pedidos.cliente_id = clientes.id
    INNER JOIN produtos
    ON itens_pedido.produto_id = produtos.id;";

    // statement preparado para executar no banco de dados
    $stmt = mysqli_prepare($conexao, $sql);

    // executando o stmt
    $execucao = mysqli_stmt_execute($stmt);

    // se a execução falhar
    if ($execucao === false) {
        $erros[] = "Não foi possível carregar os dados!";
    } else {
        // recebendo o conjunto retornado pela consulta
        $resultadoJOIN = mysqli_stmt_get_result($stmt);

        // enquanto houverem registros
        while ($pedido = mysqli_fetch_assoc($resultadoJOIN)) {
            $pedidos[] = $pedido;
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
</head>
<body>
    <header>
        <h1>Veja todos os pedidos e seus dados mais relevantes!</h1>
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
            } else {
                // se a consulta não retornar nada
                if (empty($pedidos)) {
                    ?>
                    <p>Nenhum pedido cadastrado!</p>
                    <?php
                } else{
                    ?>
                    <table>
                        <!-- cabeçalho da tabela -->
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nome do cliente</th>
                                <th>Nome do produto</th>
                                <th>Quantidade</th>
                                <th>Preço</th>
                            </tr>
                        </thead>

                        <!-- corpo da tabela -->
                        <tbody>
                            <?php
                                // percorrendo os pedidos
                                foreach ($pedidos as $pedido) {
                                    // recebendo os dados dos pedidos
                                    $id = $pedido["id"];
                                    $nomeCliente = $pedido["nome_cliente"];
                                    $nomeProduto = $pedido["nome_produto"];
                                    $quantidade = $pedido["quantidade"];
                                    $preco = $pedido["preco_unitario"];

                                    ?>
                                    <tr>
                                        <td><?= $id ?></td>
                                        <td><?= $nomeCliente ?></td>
                                        <td><?= $nomeProduto ?></td>
                                        <td><?= $quantidade ?></td>
                                        <td><?= $preco ?></td>
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
        <p>Site desenvolvido por <a href="https://GitHub.com/matheusjorgealves" target="blank">Matheus Jorge</a></p>
    </footer>
</body>
</html>