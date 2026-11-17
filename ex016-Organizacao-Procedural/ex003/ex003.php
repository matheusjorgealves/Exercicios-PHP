<?php

    // $conexao é a variável de conexão com o banco de dados
    include ("../conexao.php");

    // function para organizar o relatório
    function montarRelatorio($id, $nome, $status, $produtosDiferentes, $quantidadeUnidades, $total) {
        return "
        Cliente: $nome,
        ID do pedido: $id, 
        Status do pedido: $status, 
        Quantidade de produtos diferentes no pedido: $produtosDiferentes, 
        Quantidade de unidades no pedido: $quantidadeUnidades,
        Total: R$$total
        ";
    }

    // inicializando variáveis
    $erros = [];
    $pedidos = [];

    // se o método da requisição for post
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // validação do id
        if (!isset($_POST["id"])) {
            $erros[] = "Insira o id!";
        } else {
            if (empty($_POST["id"])) {
                $erros[] = "Insira um id válido!";
            } else {
                if (filter_var($_POST["id"], FILTER_VALIDATE_INT) === false) {
                    $erros[] = "O id deve ser um número inteiro!";
                } else {
                    $id = $_POST["id"];

                    if ($id < 1) {
                        $erros[] = "Id deve ser superior ou igual a 1!";
                    }
                }
            }
        }

        // se não houverem erros
        if (empty($erros)) {
            try {
                // SELECT ao banco de dados
                $sql = "SELECT pedidos.id, clientes.nome, pedidos.status, 
                        COUNT(DISTINCT itens_pedido.id_produto) AS produtosDiferentes, SUM(itens_pedido.quantidade) AS quantidadeUnidades, SUM(itens_pedido.quantidade * itens_pedido.preco_unitario) AS total
                        FROM pedidos
                        INNER JOIN clientes
                        ON clientes.id = pedidos.id_cliente
                        INNER JOIN itens_pedido
                        ON itens_pedido.id_pedido = pedidos.id
                        WHERE pedidos.id = ?
                        GROUP BY pedidos.id;";

                $stmt = mysqli_prepare($conexao, $sql);

                mysqli_stmt_bind_param($stmt, "i", $id);

                $execucao = mysqli_stmt_execute($stmt);

                if ($execucao === false) {
                    throw new Exception("Não foi possível gerar o relatório do pedido!");
                } else {
                    $resultadoSelect = mysqli_stmt_get_result($stmt);

                    // enquanto houverem registros
                    while ($pedido = mysqli_fetch_assoc($resultadoSelect)) {
                        $pedidos[] = $pedido;
                    }
                }
            } catch (mysqli_sql_exception $erro) {
                $erros[] = "Não foi possível concluir o relatório!";
            } catch (Exception $erro) {
                $erros[] = $erro->GetMessage();
            }
        }

        if (empty($erros)) {
            // VALIDANDO O RESULTADO DA CONSULTA
            if (empty($pedidos)) {
                $erros[] = "O pedido de id $id não está cadastrado no banco de dados!";
            } else {
                foreach ($pedidos as $pedido) {
                    // recebendo os dados da consulta
                    $nome = $pedido["nome"];
                    $status = $pedido["status"];
                    $produtosDiferentes = $pedido["produtosDiferentes"];
                    $quantidadeUnidades = $pedido["quantidadeUnidades"];
                    $total = $pedido["total"];
                }

                // chamando a function
                $relatorio = montarRelatorio($id, $nome, $status, $produtosDiferentes, $quantidadeUnidades, $total);
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papelaria Horizonte</title>
</head>
<body>
    <header>
        <h1>Papelaria Horizonte</h1>
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
            // se o método for post
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                // se o relatório existir
                if (isset($relatorio)) {
                    ?>
                    <p><?= htmlspecialchars($relatorio, ENT_QUOTES, "UTF-8") ?></p>
                    <?php
                }
            }
        }
        ?>

        <p>Gerar relatório de um pedido registrado</p>

        <form action="" method="post">
            <!-- id -->
            <label for="id">Id:</label>
            <input type="number" name="id" id="id" min="1" required>
            <br> <br>

            <button type="submit">Gerar Relatório</button>
            <br> <br>
        </form>
    </main>

    <footer>
        <p>Site desenvolvido por <a href="https://GitHub.com/matheusjorgealves" target="_blank">Matheus Jorge</a></p>
    </footer>
</body>
</html>