<?php

    // incluindo o arquivo de conexão com o banco de dados
    include ("../conexao.php");

    // inicialização de variáveis 
    $erros = [];
    $clientes = [];
    $produtos = [];
    $produtosPorId = [];

    // --- LISTANDO CLIENTES ---

    $sql = "SELECT id, nome FROM clientes
            ORDER BY nome ASC;";

    // executando a instrução sql no banco de dados
    $execucao = mysqli_query($conexao, $sql);

    if ($execucao === false) {
        $erros[] = "Não foi possível listar os clientes cadastrados";
    } else {
        // enquanto houverem registros
        while ($cliente = mysqli_fetch_assoc($execucao)) {
            $clientes[] = $cliente;
        }
    }

    // --- LISTANDO PRODUTOS ---

    $sql = "SELECT id, nome, preco FROM produtos
            ORDER BY preco ASC;";

    // executando a instrução sql no banco de dados
    $execucao = mysqli_query($conexao, $sql);

    if ($execucao === false) {
        $erros[] = "Não foi possível listar os produtos cadastrados";
    } else {
        // enquanto houverem registros
        while ($produto = mysqli_fetch_assoc($execucao)) {
            $produtos[] = $produto;

            // organizando os produtos pelo id para facilitar a consulta posterior
            $produtosPorId[$produto["id"]] = $produto;
        }
    }

    // se o método da requisição for post
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        // recebendo os dados do pedido
        $idCliente = filter_var(
            $_POST["clienteId"] ?? null,
            FILTER_VALIDATE_INT,
            ["options" => ["min_range" => 1]]
        );

        $quantidadesEnviadas = $_POST["quantidades"] ?? null;

        // se o id do cliente for inválido
        if ($idCliente === false) {
            $erros[] = "Selecione um cliente válido!";
        }

        // se as quantidades não forem um array
        if (!is_array($quantidadesEnviadas)) {
            $erros[] = "Os dados dos produtos são inválidos!";
        } else {

            // inicialização de variáveis
            $itensPedido = [];

            // percorrendo as quantidades
            foreach ($quantidadesEnviadas as $idProduto => $valorQuantidade) {

                // se a quantidade estiver vazia ou for igual a 0, o produto não será incluído no pedido
                if ($valorQuantidade === "" || $valorQuantidade === "0") {
                    continue;
                }

                // validando o id do produto
                $idProduto = filter_var(
                    $idProduto,
                    FILTER_VALIDATE_INT,
                    ["options" => ["min_range" => 1]]
                );

                // validando a quantidade
                $quantidade = filter_var(
                    $valorQuantidade,
                    FILTER_VALIDATE_INT
                );

                // se o id ou a quantidade forem inválidos
                if ($idProduto === false || $quantidade === false || $quantidade < 1) {
                    $erros[] = "Existe um produto com identificação ou quantidade inválida!";
                    continue;
                }

                // verificando se o produto existe na lista de produtos consultada no banco de dados
                if (!isset($produtosPorId[$idProduto])) {
                    $erros[] = "Um dos produtos selecionados não existe!";
                    continue;
                }

                // armazenando os dados válidos do produto
                $itensPedido[] = [
                    "idProduto" => $idProduto,
                    "quantidade" => $quantidade,
                    "preco" => $produtosPorId[$idProduto]["preco"]
                ];
            }

            // se não houver nenhum produto válido
            if (empty($itensPedido)) {
                $erros[] = "Selecione pelo menos um produto para registrar o pedido!";
            }
        }

        // se não houverem erros
        if (empty($erros)) {

            // inicialização de variável para controlar o estado da transação
            $transacaoIniciada = false;

            try {

                // inicialização da transação
                mysqli_begin_transaction($conexao);
                $transacaoIniciada = true;

                // --- VERIFICANDO CLIENTE ---

                // consultando o id do cliente
                $sql = "SELECT id FROM clientes WHERE id = ?;";

                // statement preparado
                $stmt = mysqli_prepare($conexao, $sql);

                // associação do id ao parâmetro
                mysqli_stmt_bind_param($stmt, "i", $idCliente);

                // executando o statement
                mysqli_stmt_execute($stmt);

                // recebendo o resultado da consulta
                $resultado = mysqli_stmt_get_result($stmt);

                // recebendo o registro encontrado
                $cliente = mysqli_fetch_assoc($resultado);

                // fechando o statement
                mysqli_stmt_close($stmt);

                // se o cliente não existir
                if (!$cliente) {
                    throw new Exception("O cliente selecionado não existe!");
                }

                // --- INSERINDO PEDIDO ---

                // instrução sql para registrar o pedido
                $sql = "INSERT INTO pedidos (cliente_id, status)
                        VALUES (?, 'pendente');";

                // statement preparado
                $stmt = mysqli_prepare($conexao, $sql);

                // associação do id ao parâmetro
                mysqli_stmt_bind_param($stmt, "i", $idCliente);

                // executando o statement
                mysqli_stmt_execute($stmt);

                // recebendo o id do pedido recém-inserido
                $idPedido = mysqli_insert_id($conexao);

                // fechando o statement
                mysqli_stmt_close($stmt);

                // se não for possível recuperar o id do pedido
                if ($idPedido <= 0) {
                    throw new Exception("Não foi possível recuperar o id do pedido!");
                }

                // --- INSERINDO ITENS DO PEDIDO ---

                $sql = "INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco_unitario)
                        VALUES (?, ?, ?, ?);";

                // statement preparado
                $stmt = mysqli_prepare($conexao, $sql);

                // percorrendo os produtos selecionados
                foreach ($itensPedido as $item) {

                    // recebendo os valores do produto atual
                    $idProduto = $item["idProduto"];
                    $quantidade = $item["quantidade"];
                    $preco = $item["preco"];

                    // associando os dados aos parâmetros
                    mysqli_stmt_bind_param(
                        $stmt,
                        "iiid",
                        $idPedido,
                        $idProduto,
                        $quantidade,
                        $preco
                    );

                    // executando o statement
                    mysqli_stmt_execute($stmt);
                }

                // fechando o statement
                mysqli_stmt_close($stmt);

                // finalizando a transação
                mysqli_commit($conexao);
                $transacaoIniciada = false;

                // mensagem de sucesso
                $msgSucesso = "O pedido foi registrado com sucesso. Id do pedido = " . $idPedido;

            } catch (mysqli_sql_exception $erro) {

                // desfazendo a transação
                if ($transacaoIniciada) {
                    mysqli_rollback($conexao);
                }

                // armazenando a mensagem de erro ao array de erros
                $erros[] = "Ocorreu um erro no banco de dados ao registrar o pedido.";

            } catch (Exception $erro) {

                // desfazendo a transação
                if ($transacaoIniciada) {
                    mysqli_rollback($conexao);
                }

                // armazenando a mensagem de erro ao array de erros
                $erros[] = $erro->getMessage();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar pedidos</title>
</head>
<body>

    <header>
        <h1>Registro de pedidos</h1>
    </header>

    <main>

        <h2>Lista de clientes</h2>

        <?php
        // se houverem erros
        if (!empty($erros)) {
            foreach ($erros as $erro) {
                // exibindo os erros
                ?>
                <p>Erro: <?= htmlspecialchars($erro, ENT_QUOTES, "UTF-8") ?></p>
                <?php
            }
        } else {
            // se o método da requisição for post
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                // se a mensagem de sucesso existir
                if (isset($msgSucesso)) {
                    ?>
                    <p><?= htmlspecialchars($msgSucesso, ENT_QUOTES, "UTF-8") ?></p>
                    <?php
                }
            }
        }
        ?>

        <!-- formulário para enviar o id do cliente, produtos selecionados e suas quantidades -->
        <form action="" method="post">

            <!-- cliente -->
            <?php
                // se não houverem clientes cadastrados
                if (empty($clientes)) {
                    ?>
                    <p>Não existem clientes cadastrados!</p>
                    <?php
                } else {
                    ?>
                    <label for="clienteId">Cliente:</label>

                    <select name="clienteId" id="clienteId" required>
                        <option value="">Selecione um cliente:</option>
                        <?php
                        // percorrendo os clientes cadastrados
                        foreach ($clientes as $cliente) {
                            // recebendo o id e o nome do cliente
                            $idCliente = $cliente["id"];
                            $nomeCliente = $cliente["nome"];
                            ?>
                            <option value="<?= htmlspecialchars($idCliente, ENT_QUOTES, "UTF-8") ?>"><?= htmlspecialchars($nomeCliente, ENT_QUOTES, "UTF-8") ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <br><br>
                    <?php
                }
            ?>

            <!-- produto -->
            <?php
            // se não houverem produtos
            if (empty($produtos)) {
                ?>
                <p>Não existem produtos cadastrados!</p>
                <?php
            } else {
                ?>
                <!-- tabela dos produtos -->
                <table>

                    <!-- cabeçalho da tabela -->
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Preço</th>
                            <th>Quantidade</th>
                        </tr>
                    </thead>

                    <!-- corpo da tabela -->
                    <tbody>
                        <?php
                        // percorrendo os produtos cadastrados
                        foreach ($produtos as $produto) {
                            // recebendo o id, nome e preço dos produtos
                            $idProduto = $produto["id"];
                            $nomeProduto = $produto["nome"];
                            $preco = $produto["preco"];
                            ?>
                            <!-- exibindo linha da tabela -->
                            <tr>
                                <td><?= htmlspecialchars($nomeProduto, ENT_QUOTES, "UTF-8") ?></td>
                                <td>R$ <?= htmlspecialchars($preco, ENT_QUOTES, "UTF-8") ?></td>

                                <td>
                                    <input
                                        type="number"
                                        name="quantidades[<?= htmlspecialchars($idProduto, ENT_QUOTES, "UTF-8") ?>]"
                                        min="0"
                                        step="1"
                                    >
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>

                </table>
                <br>
                <?php
            }
            ?>

            <button type="submit" <?= empty($clientes) || empty($produtos) ? "disabled" : "" ?>>
                Registrar
            </button>

        </form>

    </main>

    <footer>
        <p>Site desenvolvido por <a href="https://github.com/matheusjorgealves" target="_blank">Matheus Jorge</a></p>
    </footer>

</body>
</html>
