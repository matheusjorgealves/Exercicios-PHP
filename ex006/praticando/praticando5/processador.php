<?php
    $metodo = ($_SERVER["REQUEST_METHOD"]);

    if ($metodo == "POST") {
        $produtos = [
            // array associativo
            // "nome" substitui o índice 0
            "nome" => $_POST["nome"],
            "preco" => $_POST["preco"],
            "quantidade" => $_POST["quantidade"]
        ];
    } else {
        $produtos = [
            "nome" => $_GET["nome"],
            "preco" => $_GET["preco"],
            "quantidade" => $_GET["quantidade"]
        ];
    };
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lan house</title>
</head>
<body>
    <header>
        <h1>Lan house</h1>
    </header>

    <main>
        <h2>Produto cadastrado!</h2>

        <?php
            // percorrendo o array
            foreach ($produtos as $chave => $produto) {
                // se a chave for preço
                if ($chave == "preco") {
                    ?>
                    <p>preço = R$<?= $produto ?></p>
                    <?php
                } else {
                    ?>
                    <p><?= $chave ?> = <?= $produto ?></p>
                    <?php
                };
            };
        ?>
    </main>
</body>
</html>