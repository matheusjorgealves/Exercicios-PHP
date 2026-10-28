<?php

    // inclusão do arquivo de conexão com o banco de dados. $conexao é a variável de conexão com o bd
    include ("../conexao.php");

    // inicializando variáveis
    $erros = [];

    // se o método da requisição for post
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // validando o id do produto que o usuário informar
        if (filter_var($_POST["idProduto"] ?? null, FILTER_VALIDATE_INT) === false) {
            $erros[] = "Id do produto deve ser inteiro!";
        } else {
            // recebendo o id do produto
            $idProduto = $_POST["idProduto"];

            // se o id do produto for menor do que 1
            if ($idProduto < 1) {
                $erros[] = "Id do produto deve ser, no mínimo, 1!";
            }
        }

        // validando a quantidade de novas mercadorias
        if (filter_var($_POST["quantidadeChegou"] ?? null, FILTER_VALIDATE_INT) === false) {
            $erros[] = "Quantidade de produtos recebidos deve ser um número inteiro!";
        } else {
            // recebendo a quantidade de produtos recebidos
            $quantidadeChegou = $_POST["quantidadeChegou"];

            // se a quantidade de produtos recebidos for menor do que 1
            if ($quantidadeChegou < 1) {
                $erros[] = "Quantidade de produtos recebidos deve ser, no mínimo, 1!";
            }
        }

        // se não houverem erros
        if (empty($erros)) {
            try {
                // inicializando a transação
                mysqli_begin_transaction($conexao);

                // ------ ATUALIZANDO O ESTOQUE DO PRODUTO ------
                $sql = "UPDATE produtos 
                        SET estoque = estoque + ?
                        WHERE id = ?;";

                // statement preparado para a associação de dados aos parâmetros 
                $stmt = mysqli_prepare($conexao, $sql);

                // associação de dados aos parâmetros
                mysqli_stmt_bind_param($stmt, "ii", $quantidadeChegou, $idProduto);

                // execução do stmt
                $execucao = mysqli_stmt_execute($stmt);

                // buscando a quantidade de linhas afetadas pelo update
                $resultadoUpdate = mysqli_affected_rows($conexao);

                // fechando o stmt
                mysqli_stmt_close($stmt);

                // se nenhum produto tiver seu estoque atualizado
                if ($resultadoUpdate === 0) { 
                    // lançando uma exceção
                    throw new Exception("O produto de id $idProduto não existe!");
                }

                // ------ INSERINDO UM NOVO REGISTRO NO HISTÓRICO DE MOVIMENTAÇÕES ------
                $sql = "INSERT INTO movimentacoes_estoque 
                        (produto_id, tipo, quantidade, descricao)
                        VALUES (?, 'entrada', ?, 'Entrada de mercadorias');";

                // statement preparado para a associação de dados aos parâmetros
                $stmt = mysqli_prepare($conexao, $sql);

                // associação dos dados aos parâmetros
                mysqli_stmt_bind_param($stmt, "ii", $idProduto, $quantidadeChegou);

                // execução do stmt
                $execucao = mysqli_stmt_execute($stmt);

                // fechando o stmt
                mysqli_stmt_close($stmt);

                // executando a transação
                mysqli_commit($conexao);

                // mensagem de sucesso
                $mensagemSucesso = "A transação foi concluida com sucesso!";
            } catch (mysqli_sql_exception $erro) { // se houver uma exceção mysqli
                $erros[] = "Não foi possível atualizar o banco de dados!";

                // desfazendo a transação
                mysqli_rollback($conexao);
            } catch (Exception $erro) { // se houver uma exceção
                $erros[] = $erro->getMessage();

                // desfazendo a transação
                mysqli_rollback($conexao);
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recebimento de mercadorias</title>
</head>
<body>
    <header>
        <h1>Recebimento de mercadorias</h1>
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

        <p>Preencha o formulário abaixo para registrar a chegada de mercadorias</p>

        <form action="" method="post">
            <!-- idProduto -->
            <label for="idProduto">Id do Produto:</label>
            <input type="number" name="idProduto" id="idProduto" min="1" step="1" required>
            <br> <br>

            <!-- quantidadeChegou -->
            <label for="quantidadeChegou">Quantidade de Produtos Recebidos:</label>
            <input type="number" name="quantidadeChegou" id="quantidadeChegou" min="1" step="1" required>
            <br> <br>

            <!-- button registrar -->
            <button type="submit">Registrar</button>
            <br> <br>
        </form>

        <!-- abrindo o php -->
        <?php
        // se não houverem erros e o método da requisição for post
        if (empty($erros) && $_SERVER["REQUEST_METHOD"] === "POST") {
            // se a mensagem de sucesso exitir
            if (isset($mensagemSucesso)) {
                ?>
                <p><?= htmlspecialchars($mensagemSucesso, ENT_QUOTES, "UTF-8") ?></p>
                <?php
            }

            // se a variável de linhas afetadas existir
            if (isset($resultadoUpdate)) {
                // se o estoque de nenhum produto for alterado
                if ($resultadoUpdate >= 1) {
                    // exibindo a quantidade de linhas afetadas pela atualização do estoque
                    ?>
                    <p><?= htmlspecialchars($resultadoUpdate, ENT_QUOTES, "UTF-8") ?> produto teve seu estoque alterado</p>
                    <?php
                }
            }
        }
        ?>
    </main>

    <footer>
        <p>Site desenvolvido por <a href="https://GitHub.com/matheusjorgealves" target="_blank">Matheus Jorge</a></p>
    </footer>
</body>
</html>