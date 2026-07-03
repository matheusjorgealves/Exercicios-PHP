<?php 

    $metodo = ($_SERVER["REQUEST_METHOD"]);

    // usarei um array para armazenar os dados do produto
    if ($metodo == "POST") {
        $produto[] = $_POST["nome"];
        $produto[] = $_POST["preco"];
        $produto[] = $_POST["categoria"];
    } else {
        $produto[] = $_GET["nome"];
        $produto[] = $_GET["preco"];
        $produto[] = $_GET["categoria"];
    };
   
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produto Cadastrado</title>
    <link rel="stylesheet" href="processador.css">
</head>
<body>
    <header>
        <h1>Produto cadastrado!</h1>
    </header>

    <main>
        <p>Nome do produto: <?= $produto[0] ?></p>
        <p>Preço do produto: R$<?= $produto[1] ?></p>

        <?php
            // exibir mensagem por faixa de preço
            if ($produto[1] <= 99) { 
                // vou atribuir uma cor no resultado final
                $cor = "verde";
                ?>
                <p>Produto cadastrado tem o preço bem acessível</p>
                <?php
            } elseif ($produto[1] >= 100 && $produto[1] <= 999) { 
                $cor = "amarelo";
                ?>
                <p>Produto cadastrado tem o preço acessível</p>
                <?php
            } elseif ($produto[1] >= 1000 && $produto[1] <= 3999) {
                $cor = "laranja";
                ?>
                <p>Produto cadastrado tem o preço elevado</p>
                <?php
            } elseif ($produto[1] >= 4000 && $produto[1] <= 6999) {
                $cor = "vermelho";
                ?>
                <p>Produto cadastrado tem o preço bem elevado</p>
                <?php
            } elseif ($produto[1] >= 7000 && $produto[1] <= 10000) {
                $cor = "vermelhoescuro";
                ?>
                <p>Produto cadastrado está na faixa de preço mais elevada da loja</p>
                <?php
            } else {
                ?>
                <p>Produto cadastrado possui o preço inválido</p>
                <?php
                exit;
            };
        ?>

        <p>Categoria do produto cadastrado = <?= $produto[2] ?></p>

        <?php
            // vou aplicar mudanças nos preços com base nas categorias dos produtos
            switch ($produto[2]) {
                case "blusa": ?>
                    <p>Aplicaremos um desconto de 5% nas blusas</p>
                    <?php
                    // calculando desconto
                    $desconto = ($produto[1] / 100) * 5;
                    // mudando o valor do array
                    $produto[1] = $produto[1] - $desconto;
                    break;

                case "camisa": ?>
                    <p>Aplicaremos um desconto de 10% nas camisas</p>
                    <?php
                    $desconto = ($produto[1] / 100) * 10;
                    $produto[1] = $produto[1] - $desconto;
                    break;

                case "calca": ?>
                    <p>Aplicaremos um acréscimo de 3% nas calças</p>
                    <?php
                    $acrescimo = ($produto[1] / 100) * 3;
                    $produto[1] = $produto[1] + $acrescimo;
                    break;

                case "tenis": ?>
                    <p>Não aplicaremos descontos ou acréscimos nos tênis</p>
                    <?php
                    break;

                case "bolsa": ?>
                    <p>Aplicaremos uma oferta relâmpago de 30% de desconto nas bolsas</p>
                    <?php
                    $desconto = ($produto[1] / 100) * 30;
                    $produto[1] = $produto[1] - $desconto;
                    break;

                default: ?>
                    <p>Categoria inválida</p>
                    <?php
                    exit;
                    break;
            };
        ?>

        <p>Preço final do produto <mark class="<?= $cor ?>"><?= $produto[1] ?></mark></p>
    </main> 
</body>
</html>