<?php

    // objetivo: criar um cadastro de produtos, exibir o id do produto cadastrado e mostrar quantos registros estão cadastrados no banco

    // incluindo o arquivo de conexão com o banco de dados
    include ("../conexao.php");

    // criando variáveis
    $nome = "";
    $categoria = "";
    $quantidade = 0;
    $preco = 0;
    $erros = [];

    // se o método da requisição for POST (usuário enviou o form)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // capturando as respostas do form 
        $nome = $_POST["nome"];
        $categoria = $_POST["categoria"];
        $quantidade = $_POST["quantidade"];
        $preco = $_POST["preco"];

        // variável para armazenar instrução SQL
        $sql = "INSERT INTO produtos (nome, categoria, quantidade, preco) VALUES (?, ?, ?, ?);";

        // statement preparado para receber dados nos placeholders ?, foi criado a partir da conexão com o banco e do comando SQL.
        $stmt = mysqli_prepare($conexao, $sql);

        // associando os valores das variáveis aos placeholders do statement
        mysqli_stmt_bind_param($stmt, "ssid",$nome, $categoria, $quantidade, $preco);

        // executando o statement e armazenando o resultado (bool)
        $execucao = mysqli_stmt_execute($stmt);

        // se o statement não for executado
        if ($execucao === false) {
            $erros[] = "Erro: ". mysqli_stmt_error($stmt);
        } else {
            // variável para armazenar instrução SQL
            $sql = "SELECT COUNT(*) AS total FROM produtos;";

            // statement criado a partir da conexão e da instrução SQL
            $stmt = mysqli_prepare($conexao, $sql);

            // executando o statement e armazenando o resultado da execução
            $execucao = mysqli_stmt_execute($stmt);

            // se houver erro na execução do select
            if ($execucao === false) {
                $erros[] = "Erro: ". mysqli_stmt_error($stmt);
            } else { // se não houver erro
                // recebendo o conjunto de resultados da execução do select
                $resultadoSelect = mysqli_stmt_get_result($stmt);

                // buscando o registro e guardando-o na variável
                $quantidadeRegistros = mysqli_fetch_assoc($resultadoSelect);

                // mensagem de sucesso. mysqli_insert_id é um comando para mostrar o último id criado no banco de dados
                $mensagem = "Produto cadastrado. Id do produto: ". mysqli_insert_id($conexao) .". Quantidade de registros no banco: ". $quantidadeRegistros["total"];
            };
        };
    };
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de produtos</title>
</head>
<body>
    <header>
        <h1>Cadastre Produtos</h1>

        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (empty($erros)) { // se não houverem erros
                    ?>
                        <p><?= $mensagem ?></p>
                    <?php
                } else { // se houverem erros
                    foreach ($erros as $erro) {
                        ?>
                            <p><?= $erro ?></p>
                        <?php
                    };
                };
            };
        ?>

        <form action="" method="post">
            <!-- nome -->
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="<?= $_SERVER["REQUEST_METHOD"] == "POST" ? $nome : "" ?>">
            <br> <br>

            <!-- categoria -->
            <label for="categoria">Categoria:</label>
            <input type="text" name="categoria" id="categoria" required>
            <br> <br>

            <!-- quantidade -->
            <label for="quantidade">Quantidade:</label>
            <input type="number" name="quantidade" id="quantidade">
            <br> <br>

            <!-- preco -->
            <label for="preco">Preço: R$</label>
            <input type="number" name="preco" id="preco">
            <br> <br>

            <!-- botão -->
            <button type="submit">Cadastrar</button>
            <br> <br>
        </form>
    </header>
</body>
</html>