<?php

    // funções
    function calcularEstoque($preco, $quantidade) {
        $valorEstoqueLocal = $preco * $quantidade;
        return $valorEstoqueLocal;
    };

    // criando as variáveis
    $nome = "";
    $preco = 1;
    $quantidade = 0;
    $categoria = "";
    $valorEstoque = 0;
    $erros = [];
    $mensagens = [];

    // método da requisição
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = trim($_POST["nome"]);
        $preco = $_POST["preco"];
        $quantidade = $_POST["quantidade"];
        $categoria = $_POST["categoria"];

        // validações
        // nome
        if (empty($nome)) {
            $erros[] = "Nome do produto inválido!";
        } else {
            $mensagens[] = "Nome do produto: $nome";
        };

        // preco
        if (empty($preco) || $preco < 1 || $preco > 10000) {
            $erros[] = "Preço do produto inválido!";
        } else {
            $mensagens[] = "Preço: R$$preco";
        };

        // quantidade
        if (empty($quantidade) || $quantidade < 0 || $quantidade > 10000) {
            $erros[] = "Quantidade inválida!";
        } else {
            $mensagens[] = "Quantidade: $quantidade";
        };

        // categoria
        if (empty($categoria)) {
            $erros[] = "Categoria inválida!";
        } else {
            $mensagens[] = "Categoria do produto: $categoria";
        };

        // condicional para chamar a function
        if (empty($erros)) {
            // chamando a função
            $valorEstoque = calcularEstoque($preco, $quantidade);

            $mensagens[] = "Valor em Estoque: R$$valorEstoque";
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
        <h1>Cadastro de produtos</h1>

        <?php
            // se a requisição for método post
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // se não houverem erros
                if (empty($erros)) {
                    foreach ($mensagens as $mensagem) {
                        ?>
                        <h3><?= $mensagem ?></h3>
                        <?php
                    };
                } else {
                    foreach ($erros as $indice => $erro) {
                        $indice++;
                        ?>
                        <h3><?= $indice ?>° erro: <?= $erro ?></h3>
                        <?php
                    };
                };
            };
        ?>

        <form action="" method="post">
            <!-- nome -->
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="<?= $nome ?>">
            <br> <br>

            <!-- preco -->
            <label for="preco">Preço: R$</label>
            <input type="number" name="preco" id="preco" min="1" max="10000" value="<?= $preco ?>">
            <br> <br>

            <!-- quantidade -->
            <label for="quantidade">Quantidade:</label>
            <input type="number" name="quantidade" id="quantidade" min="0" max="10000" value="<?= $quantidade ?>">
            <br> <br>

            <!-- categoria -->
            <label for="categoria">Categoria:</label>
            <select name="categoria" id="categoria">

                <option value="gamer" <?= $categoria == "gamer" ? "selected" : "" ?>>Gamer</option>

                <option value="casa" <?= $categoria == "casa" ? "selected" : "" ?>>Casa</option>

                <option value="roupas" <?= $categoria == "roupas" ? "selected" : "" ?>>Roupas</option>

                <option value="geral" <?= $categoria == "geral" ? "selected" : "" ?>>Geral</option>

            </select>
            <br> <br>

            <button type="submit">Cadastrar</button>
            <br> <br>
        </form>
    </header>
</body>
</html>