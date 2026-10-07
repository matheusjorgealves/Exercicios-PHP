<?php

    // incluindo a conexão com o banco de dados
    include ("../conexao.php");

    // inicializando variáveis
    $id = 0;
    $erros = [];
    $pedidos = [];

    // se o método da requisição for post
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // validações 
        // se o id não existir em post
        if (!isset($_POST["id"])) {
            $erros[] = "Insira o id novamente!";
        } else {
            // recebendo a resposta do form
            $respostaID = $_POST["id"];
            
            // se o id for string
            if (is_string($respostaID) === true) {
                // transforma o id em int
                $id = (int) $respostaID;
            } else {
                $id = $respostaID;
            }

            // se o id estiver vazio
            if (empty($id)) {
                $erros[] = "Id vazio!";
            }

            // se o id for menor do que 1
            if ($id < 1) {
                $erros[] = "Valor mínimo do id é 1";
            }
        }

        // se não houverem erros nas validações
        if (empty($erros)) {
            // variável para armazenar instrução sql
            $sql = "SELECT pedidos.id, clientes.nome, pedidos.data_pedido, pedidos.status FROM pedidos INNER JOIN clientes ON pedidos.cliente_id = clientes.id WHERE pedidos.cliente_id = ?;";

            // statement preparado para a associação do id no placeholder
            $stmt = mysqli_prepare($conexao, $sql);

            // associando o id ao placeholder
            mysqli_stmt_bind_param($stmt, "i", $id);

            // executando o statement
            $execucao = mysqli_stmt_execute($stmt);

            // se houver erro na execução
            if ($execucao === false) {
                $erros[] = "Não foi possível carregar os dados!";
            } else {
                // recebendo o conjunto de registros retornados pela consulta
                $resultadoJOIN = mysqli_stmt_get_result($stmt);

                // enquanto houverem registros
                while ($pedido = mysqli_fetch_assoc($resultadoJOIN)) {
                    $pedidos[] = $pedido;
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
    <title>Consulte os seus pedidos</title>
</head>
<body>
    <header>
        <h1>Consulte os seus pedidos</h1>
    </header>

    <main>
        <h2>Insira o seu id</h2>

        <!-- formulário id -->
        <form action="" method="post">
            <!-- id -->
            <label for="id">Id:</label>
            <input type="number" name="id" id="id" min="1" step="1" required>
            <br> <br>

            <!-- button consultar -->
            <button type="submit">Consultar</button>
            <br> <br>
        </form>

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
            } else {
                // se não houverem pedidos
                if (empty($pedidos)) {
                    ?>
                    <p>Não existem pedidos cadastrados pertencentes ao cliente de id <?= $id ?></p>
                    <?php
                } else {
                    ?>
                    <!-- criando a tabela -->
                    <table>
                        <!-- cabeçalho da table -->
                        <thead>
                            <tr>
                                <th>Id do pedido</th>
                                <th>Nome</th>
                                <th>Data</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <!-- corpo da table -->
                        <tbody>
                            <?php
                            // percorrendo os pedidos
                            foreach ($pedidos as $pedido) {
                                // recebendo os dados do pedido
                                $idPedido = $pedido["id"];
                                $nomeCliente = $pedido["nome"];
                                $dataPedido = $pedido["data_pedido"];
                                $statusPedido = $pedido["status"];
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
            }
        ?>
    </main>

    <footer>
        <p>Site desenvolvido por <a href="https://GitHub.com/matheusjorgealves" target="blank">Matheus Jorge</a></p>
    </footer>
</body>
</html>