<?php

    // inclui o arquivo de conexão com o banco de dados
    include ("../conexao.php");

    // se o método da requisição for post
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // criando variáveis para receber as respostas do form enviadas pelo método post
        $nome = $_POST["nome"];
        $categoria = $_POST["categoria"];
        $quantidade = $_POST["quantidade"];
        $preco = $_POST["preco"];

        // variável para armazenar uma instrução sql
        $sql = "INSERT INTO produtos (nome, categoria, quantidade, preco) VALUES (?, ?, ?, ?)";

        // criando statement preparado a partir da conexão com o banco de dados e da instrução sql. Executarei no banco
        $stmt = mysqli_prepare($conexao, $sql);

        // associando as variáveis aos placeholders do statement
        mysqli_stmt_bind_param($stmt, "ssid" ,$nome, $categoria, $quantidade, $preco);

        //executando o statement e verificando se o statement foi executado (bool)
        $execucao = mysqli_stmt_execute($stmt);

        // se houver erro de execução
        if ($execucao === false) {
            echo mysqli_stmt_error($stmt);
        } else {
            // id do último produto inserido no banco de dados
            $idProduto = mysqli_insert_id($conexao);

            echo "Produto cadastrado. Id do produto: $idProduto";
        };
    };

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos</title>
</head>
<body>
    <header>
        <h1>Cadastre produtos</h1>
    </header>
    <main>
        <p>Cadastre um produto no formulário abaixo</p>

        <form action="" method="post">
            <!-- nome -->
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome">
            <br> <br>

            <!-- categoria -->
            <label for="categoria">Categoria:</label>
            <input type="text" name="categoria" id="categoria">
            <br> <br>

            <!-- quantidade -->
            <label for="quantidade">Quantidade:</label>
            <input type="number" name="quantidade" id="quantidade">
            <br> <br>

            <!-- preco -->
            <label for="preco">Preço: R$</label>
            <input type="number" name="preco" id="preco">
            <br> <br>

            <!-- botão cadastrar -->
            <button type="submit">Cadastrar</button>
        </form>
    </main>
</body>
</html>