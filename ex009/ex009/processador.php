<?php

    // método de envio do form
    $metodo = ($_SERVER["REQUEST_METHOD"]);

    if ($metodo == "POST") {
        $promocao = $_POST["promocao"];
        $nome = $_POST["nome"];
    } else {
        $promocao = $_GET["promocao"];
        $nome = $_GET["nome"];
    };

    // função para mostrar a promoção
    function mostrarPromocao($promocao) {
        echo $promocao;
    };

    // função para mostrar nome
    function mostrarNome($nome) {
        return $nome;
    };

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja de doce</title>
</head>
<body>
    <header>
        <h1>Loja de doce</h1>
    </header>

    <main>
        <h2>Nova promoção: <?= mostrarPromocao($promocao) ?></h2>
        <p>Nome do novo produto: <?= mostrarNome($nome) ?></p>
    </main>
</body>
</html>