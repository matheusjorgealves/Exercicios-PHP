<?php

    // inclusão da conexão com o banco de dados. $conexao é a variável de conexão com o bd
    include ("../conexao.php");

    // o objetivo dessa página é inserir os clientes que já realizaram uma compra, na tabela de clientes ativos. esses clientes não devem ser registrados na tabela de ativos mais de uma vez.

    // incialização de variáveis
    $erros = [];
    $clientesAtivos = [];

    // se o método da requisição for post
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // variável que armazena uma instrução sql
        $sql = "INSERT INTO clientes_ativos (cliente_id)
                SELECT DISTINCT clientes.id 
                FROM clientes
                INNER JOIN pedidos
                ON clientes.id = pedidos.cliente_id
                WHERE pedidos.status = 'concluido' 
                    AND NOT EXISTS (
                    SELECT 1
                    FROM clientes_ativos
                    WHERE clientes_ativos.cliente_id = clientes.id
                    );";

        // statement preparado para a execução no bd
        $stmt = mysqli_prepare($conexao, $sql);

        // se a criação do stmt falhar 
        if ($stmt === false) {
            $erros[] = "Não foi possível atualizar a tabela de clientes ativos!";
        } else {
            // execução do stmt
            $execucao = mysqli_stmt_execute($stmt);

            // se a execução falhar
            if ($execucao === false) {
                $erros[] = "Não foi possível atualizar a tabela de clientes ativos!";
            } else {
                // recebendo a quantidade de linhas afetadas
                $resultadoInsert = mysqli_stmt_affected_rows($stmt);
            }

            // fechando o stmt
            mysqli_stmt_close($stmt);
        }
    }

    // variável que contém uma instrução sql
    $sql = "SELECT clientes_ativos.id AS id_clientes_ativos, clientes.id AS id_cliente, 
            clientes.nome, clientes.email, clientes_ativos.data_registro 
            FROM clientes_ativos 
            INNER JOIN clientes
            ON clientes_ativos.cliente_id = clientes.id;";

    // statement preparado para a execução no bd
    $stmt = mysqli_prepare($conexao, $sql);

    // se a criação do stmt falhar
    if ($stmt === false) {
        $erros[] = "Não foi possível concluir a consulta da tabela de clientes ativos!";
    } else {
        // execução do stmt
        $execucao = mysqli_stmt_execute($stmt);

        // se a execução falhar 
        if ($execucao === false) {
            $erros[] = "Não foi possível concluir a consulta da tabela de clientes ativos!";
        } else {
            // recebendo o conjunto de registros retornados pela consulta
            $resultadoSelect = mysqli_stmt_get_result($stmt);

            // se houver erro
            if ($resultadoSelect === false) {
                $erros[] = "Não foi possível concluir a consulta da tabela de clientes ativos!";
            } else {
                // enquanto houverem registros
                while ($clienteAtivo = mysqli_fetch_assoc($resultadoSelect)) {
                    $clientesAtivos[] = $clienteAtivo;
                }
            }
        }

        // fechando o stmt 
        mysqli_stmt_close($stmt);
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de clientes ativos</title>
</head>
<body>
    <header>
        <h1>Gerenciamento de clientes ativos</h1>
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

        <p>Atualize, clicando no botão abaixo, a tabela de clientes ativos.</p>

        <form action="" method="post">
            <!-- button atualizar -->
            <button type="submit">Atualizar</button>
            <br> <br>
        </form>

        <?php
        // se não houverem erros
        if (empty($erros)) {
            // se o método da requisição http for post
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                // se a atualização não inseriu nenhuma linha na tabela de clientes ativos
                if ($resultadoInsert < 1) {
                    ?>
                    <p>Nenhum novo cliente foi adicionado na tabela de clientes ativos</p>
                    <?php
                } elseif ($resultadoInsert === 1) {
                    ?>
                    <p><?= htmlspecialchars($resultadoInsert, ENT_QUOTES, "UTF-8") ?> novo cliente foi registrado na tabela de clientes ativos</p>
                    <?php
                } else {
                    ?>
                    <p><?= htmlspecialchars($resultadoInsert, ENT_QUOTES, "UTF-8") ?> novos clientes foram registrados na tabela de clientes ativos</p>
                    <?php
                }
            }

            // se a tabela dos clientes ativos estiver vazia
            if (empty($clientesAtivos)) {
                ?>
                <p>A tabela de clientes ativos está vazia!</p>
                <?php
            } else {
                ?>
                <h2>Tabela com os dados dos clientes ativos</h2>

                <!-- criação da table -->
                <table>
                    <!-- cabeçalho da table -->
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Id do cliente</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Data Registro</th>
                        </tr>
                    </thead>

                    <!-- corpo da table -->
                    <tbody>
                        <?php
                        // percorrendo os clientes ativos
                        foreach ($clientesAtivos as $clienteAtivo) {
                            // recebendo os dados dos clientes
                            $idClientesAtivos = $clienteAtivo["id_clientes_ativos"];
                            $idCliente = $clienteAtivo["id_cliente"];
                            $nome = $clienteAtivo["nome"];
                            $email = $clienteAtivo["email"];
                            $dataRegistro = $clienteAtivo["data_registro"];

                            ?>
                            <tr>
                                <td><?= htmlspecialchars($idClientesAtivos, ENT_QUOTES, "UTF-8") ?></td>
                                <td><?= htmlspecialchars($idCliente, ENT_QUOTES, "UTF-8") ?></td>
                                <td><?= htmlspecialchars($nome, ENT_QUOTES, "UTF-8") ?></td>
                                <td><?= htmlspecialchars($email, ENT_QUOTES, "UTF-8") ?></td>
                                <td><?= htmlspecialchars($dataRegistro, ENT_QUOTES, "UTF-8") ?></td>
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
</body>
</html>