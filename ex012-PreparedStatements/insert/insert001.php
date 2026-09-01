<?php

    // objetivo: criar página para inserir um novo registro no banco de dados (os dados do registro virão do form)

    // incluíndo a conexão com o banco de dados
    include ("../conexao.php");

    // criando variáveis
    $nome = "";
    $categoria = "";
    $quantidade = 0;
    $preco = 0;

    // se o método da requisição for POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // recebendo os dados do form
        $nome = $_POST["nome"];
        $categoria = $_POST["categoria"];
        $quantidade = $_POST["quantidade"];
        $preco = $_POST["preco"];

        // variável para receber uma instrução SQL
        $sql = "INSERT INTO produtos (nome, categoria, quantidade, preco) VALUES (?, ?, ?, ?);";

        // statement criado a partir da conexão e da instrução sql. preparado para receber dados nos placeholders ?
        $stmt = mysqli_prepare($conexao, $sql);

        // associando as variáveis ao placeholders ? do stmt
        mysqli_stmt_bind_param($stmt, "ssid", $nome, $categoria, $quantidade, $preco);

        // executa o statement no banco e obtém o resultado (bool)
        $execucao = mysqli_stmt_execute($stmt);

        // se houve algum erro
        if ($execucao === false) {
            $erro = "Erro: ". mysqli_stmt_error($stmt);
        } else {
            // comando para identificar o último id criado no banco de dados
            $idNovo = mysqli_insert_id($conexao);
            $mensagem = "Produto Cadastrado com sucesso! O ID gerado foi $idNovo";
        };
    };

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criando Produtos</title>
</head>
<body>
    <h1>Registre um novo produto</h1>

    <?php
        // se o método da requisição for post
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($execucao != false) {
                ?>
                <p><?= $mensagem ?></p>
                <?php
            } else {
                ?>
                <p><?= $erro ?></p>
                <?php
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
        <input type="text" name="categoria" id="categoria">
        <br> <br>

        <!-- quantidade -->
        <label for="quantidade">Quantidade:</label>
        <input type="text" name="quantidade" id="quantidade">
        <br> <br>

        <!-- preco -->
        <label for="preco">Preço: R$</label>
        <input type="number" name="preco" id="preco">
        <br> <br>

        <!-- botão -->
        <button type="submit">Cadastrar</button>
        <br> <br>
    </form>
</body>
</html>