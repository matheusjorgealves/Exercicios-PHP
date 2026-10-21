<?php

    // incluindo a conexão com o banco de dados
    include ("../conexao.php");

    // inicializando variáveis
    $email = "";
    $erros = [];

    // se o método da requisição for post
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // se não existir um email através do método post
        if (!isset($_POST["email"])) {
            $erros[] = "Informe o seu E-mail!";
        } else {
            // se o email informado não possuir formato de email
            if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) === false) {
                $erros[] = "E-mail iformado não possui formato aceitável!";
            } else {
                // recebendo o email do usuário
                $email = $_POST["email"];

                // se o email possuir mais de 100 caracteres
                if (strlen($email) > 100) {
                    $erros[] = "E-mail ultrapassou a quantidade máxima de caracteres!";
                }
            }

            // se não houverem erros 
            if (empty($erros)) {
                // variável que carrega uma instrução sql
                $sql = "SELECT clientes.id, clientes.nome, COUNT(DISTINCT pedidos.id) AS quantidade_pedidos, SUM(itens_pedido.quantidade) AS quantidade_produtos, SUM(itens_pedido.quantidade * itens_pedido.preco_unitario) AS total_gasto
                FROM itens_pedido
                INNER JOIN pedidos
                ON itens_pedido.pedido_id = pedidos.id
                INNER JOIN clientes
                ON pedidos.cliente_id = clientes.id
                WHERE clientes.email = ?
                    AND pedidos.status = 'concluido'
                GROUP BY clientes.id, clientes.nome;";

                // statement preparado para a associação de dados ao parâmetro
                $stmt = mysqli_prepare($conexao, $sql);

                // se a criação do stmt falhar
                if ($stmt === false) {
                    $erros[] = "Não foi possível concluir a consulta!";
                } else {
                    // associando o dado ao parâmetro
                    mysqli_stmt_bind_param($stmt, "s", $email);

                    // executando o stmt
                    $execucao = mysqli_stmt_execute($stmt);

                    // se a execução falhar 
                    if ($execucao === false) {
                        $erros[] = "Não foi possível concluir a consulta!";
                    } else {
                        // recebendo o conjunto de registros retornado pela consulta
                        $resultadoJOIN = mysqli_stmt_get_result($stmt);

                        // fechamento do stmt
                        mysqli_stmt_close($stmt);

                        // recebendo o registro retornado pela consulta
                        $usuario = mysqli_fetch_assoc($resultadoJOIN);

                        // se a consulta for executada e retornar um erro
                        if ($usuario === false) {
                            $erros[] = "Não foi possível concluir a consulta!";
                        } else {
                            if (!empty($usuario)) {
                                // recebendo os dados do usuário
                                $id = $usuario["id"];
                                $nome = $usuario["nome"];
                                $quantPedidos = $usuario["quantidade_pedidos"];
                                $quantProdutos = $usuario["quantidade_produtos"];
                                $total = $usuario["total_gasto"];
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
    <title>Central do cliente</title>
</head>
<body>
    <header>
        <h1>Central do cliente</h1>
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

        <p>Utilize o formulário abaixo para informar seu e-mail e consultar seu histórico na loja</p>

        <form action="" method="post">
            <!-- email -->
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" required value="<?= $_SERVER ["REQUEST_METHOD"] === "POST" ? htmlspecialchars($email, ENT_QUOTES, "UTF-8") : "" ?>">
            <br> <br>

            <!-- button consultar -->
            <button type="submit">Consultar</button>
            <br> <br>
        </form>

        <!-- abrindo o php -->
        <?php
        // se não houverem erros e o método da requisição for post
        if (empty($erros) && $_SERVER["REQUEST_METHOD"] === "POST") {
            // se a consulta retornar um conjunto vazio
            if (empty($usuario)) {
                ?>
                <p>Nenhum resultado encontrado!</p>
                <?php
            } else {
                ?>
                <!-- criação da table -->
                <table>
                    <!-- cabeçalho da table -->
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Pedidos</th>
                            <th>Produtos</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <!-- corpo da table -->
                    <tbody>
                        <tr>
                            <td><?= htmlspecialchars($id, ENT_QUOTES, "UTF-8") ?></td>
                            <td><?= htmlspecialchars($nome, ENT_QUOTES, "UTF-8") ?></td>
                            <td><?= htmlspecialchars($email, ENT_QUOTES, "UTF-8") ?></td>
                            <td><?= htmlspecialchars($quantPedidos, ENT_QUOTES, "UTF-8") ?></td>
                            <td><?= htmlspecialchars($quantProdutos, ENT_QUOTES, "UTF-8") ?></td>
                            <td><?= htmlspecialchars($total, ENT_QUOTES, "UTF-8") ?></td>
                        </tr>
                    </tbody>
                </table>
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