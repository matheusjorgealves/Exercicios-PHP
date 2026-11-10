<?php

    // incluindo o arquivo de conexão com o banco de dados
    include ("../conexao.php");

    // inicializando variáveis
    $erros = [];
    $itensPedidos = [];

    // se o método da requisição for post
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // validando o id
        if (!isset($_POST["idPedido"]) || empty($_POST["idPedido"])) {
            $erros[] = "Insira o id do pedido!";
        } elseif (filter_var($_POST["idPedido"], FILTER_VALIDATE_INT) === false) {
            $erros[] = "O id deve ser um número inteiro!";
        } else {
            $idPedido = (int) $_POST["idPedido"];
            
            // se o id for inferior a 1
            if ($idPedido < 1) {
                $erros[] = "O id deve ser um número positivo!";
            }
        }

        // se não houverem erros
        if (empty($erros)) {
            // consultando o id do pedido
            $sql = "SELECT id, status FROM pedidos WHERE id = ?;";

            // statement preparado
            $stmt = mysqli_prepare($conexao, $sql);

            if ($stmt === false) {
                $erros[] = "Não foi possível consultar o pedido!";
            } else {
                // associando o id do pedido ao parâmetro
                mysqli_stmt_bind_param($stmt, "i", $idPedido);

                // executando o stmt
                $execucao = mysqli_stmt_execute($stmt);

                if ($execucao === false) {
                    $erros[] = "Não foi possível consultar o pedido!";
                } else {
                    $resultadoSelect = mysqli_stmt_get_result($stmt);

                    if ($resultadoSelect === false) {
                        $erros[] = "Não foi possível consultar o pedido!";
                    } else {
                        // recebendo o conjunto de registros retornados pela consulta
                        $pedido = mysqli_fetch_assoc($resultadoSelect);

                        // se o pedido não existir 
                        if (empty($pedido)) {
                            $erros[] = "O pedido de id ". htmlspecialchars($idPedido, ENT_QUOTES, "UTF-8") ." não está registrado no banco de dados!";
                        } else {
                            // recebendo o status do pedido
                            $status = $pedido["status"];

                            // se o status do pedido for diferente de pendente
                            if ($status !== 'pendente') {
                                $erros[] = "O status do pedido deve ser pendente! Ele está com status de ". htmlspecialchars($status, ENT_QUOTES, "UTF-8");
                            }
                        }
                    }
                }

                // fechando o statement
                mysqli_stmt_close($stmt);
            }
        }

        // se não houverem erros
        if (empty($erros)) {
            try {
                // inicializando a transação
                mysqli_begin_transaction($conexao);

                // ATUALIZANDO O STATUS DOS PEDIDOS
                $sql = "UPDATE pedidos
                        SET status = 'cancelado'
                        WHERE id = ? AND status = 'pendente';";

                $stmt = mysqli_prepare($conexao, $sql);

                mysqli_stmt_bind_param($stmt, "i", $idPedido);

                mysqli_stmt_execute($stmt);

                // recebendo a quantidade de linhas afetadas
                $resultadoUpdate = mysqli_affected_rows($conexao);

                // fechando o statement
                mysqli_stmt_close($stmt);

                if ($resultadoUpdate < 1) {
                    throw new Exception("Não foi possível cancelar o pedido!");
                }

                // CONSULTANDO OS ITENS DO PEDIDO
                $sql = "SELECT produto_id, quantidade FROM itens_pedido
                        INNER JOIN produtos 
                        ON produto_id = produtos.id
                        WHERE pedido_id = ?;";

                $stmt = mysqli_prepare($conexao, $sql);

                mysqli_stmt_bind_param($stmt, "i", $idPedido);

                mysqli_stmt_execute($stmt);

                $resultadoSelect = mysqli_stmt_get_result($stmt);

                // fechando o statement
                mysqli_stmt_close($stmt);

                // enquanto houverem registros
                while ($itemPedido = mysqli_fetch_assoc($resultadoSelect)) {
                    $itensPedidos[] = $itemPedido;
                }

                // se não houverem itens do pedido
                if (empty($itensPedidos)) {
                    throw new Exception("Não foi possível consultar os itens que estavam registrados no seu pedido!");
                }

                // ATUALIZANDO O ESTOQUE DE PRODUTOS
                $sql = "UPDATE produtos 
                        SET estoque = estoque + ?
                        WHERE id = ?;";

                $stmt = mysqli_prepare($conexao, $sql);

                // percorrendo os itens do pedido
                foreach ($itensPedidos as $itemPedido) {
                    // vou associar e executar as intruções sql de acordo com a quantidade de itens do pedido

                    // recebendo os dados do item do pedido
                    $produtoId = $itemPedido["produto_id"];
                    $quantidade = $itemPedido["quantidade"];
                    
                    mysqli_stmt_bind_param($stmt, "ii", $quantidade, $produtoId);

                    mysqli_stmt_execute($stmt);

                    $resultadoUpdate = mysqli_affected_rows($conexao);

                    // se a quantidade de linhas afetadas for inferior a 1
                    if ($resultadoUpdate < 1) {
                        throw new Exception("Não foi possível devolver os itens que você comprou ao estoque!");
                    }

                    // INSERINDO A MOVIMENTAÇÃO DE ESTOQUE 
                    $sql = "INSERT INTO movimentacoes_estoque (pedido_id, produto_id, tipo,
                            quantidade, descricao)
                            VALUES (?, ?, 'entrada', ?, 'Devolução de mercadorias');";

                    $stmtInsert = mysqli_prepare($conexao, $sql);

                    mysqli_stmt_bind_param($stmtInsert, "iii", $idPedido, $produtoId, $quantidade);

                    mysqli_stmt_execute($stmtInsert);

                    $resultadoInsert = mysqli_affected_rows($conexao);

                    // fechando o statement do insert
                    mysqli_stmt_close($stmtInsert);

                    // se a inserção do registro de movimentações de estoque não acontecer
                    if ($resultadoInsert < 1) {
                        throw new Exception("Não foi possível concluir a inserção do registro de movimentação do estoque!");                        
                    }
                }

                // fechando o statement
                mysqli_stmt_close($stmt);

                // confirmando a transação
                mysqli_commit($conexao);

                $mensagem = "O pedido de id ". htmlspecialchars($idPedido, ENT_QUOTES, "UTF-8") ." foi cancelado com sucesso!";

            } catch (mysqli_sql_exception $erro) {
                // desfazendo a transação
                mysqli_rollback($conexao);

                $erros[] = $erro->getMessage();
            } catch (Exception $erro) {
                // desafazendo a transação
                mysqli_rollback($conexao);

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
    <title>Cancelamento de pedidos</title>
</head>
<body>
    <header>
        <h1>Cancelamento de pedidos</h1>
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
            // se a mensagem existir
            if (isset($mensagem)) {
                ?>
                <p><?= htmlspecialchars($mensagem, ENT_QUOTES, "UTF-8") ?></p>
                <?php
            }
        }
        ?>

        <h2>Insira o id do pedido que deseja cancelar</h2>
        <form action="" method="post">
            <!-- idPedido -->
            <label for="idPedido">Id:</label>
            <input type="number" name="idPedido" id="idPedido" min="1" required>
            <br> <br>

            <!-- button cancelar -->
            <button type="submit">Cancelar</button>
            <br> <br>
        </form>
    </main>

    <footer>
        <p>Site desenvolvido por <a href="https://GitHub.com/matheusjorgealves/" target="_blank">Matheus Jorge</a></p>
    </footer>
</body>
</html>