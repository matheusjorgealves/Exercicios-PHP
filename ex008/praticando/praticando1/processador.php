<?php

    // método de envio do form
    $metodo = ($_SERVER["REQUEST_METHOD"]);

    if ($metodo == "POST") {
        $taboada = $_POST["taboada"];
        $maximo = $_POST["maximo"];
    } else {
        $taboada = $_GET["taboada"];
        $maximo = $_GET["maximo"];
    };

    // validações
    if ($maximo < 5) { // maximo for menor do que 5
        ?>
        <p>Erro: Valor máximo não pode ser infeiror a 5!</p>
        <?php
        exit;
    };
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taboada</title>
</head>
<body>
    <h1>Taboada do <?= $taboada ?></h1>

    <?php
        // exibindo tipo do valor
        if ($taboada < 0) {
            ?>
            <p>O valor escolhido é negativo!</p>
            <?php
        } else {
            ?>
            <p>O valor escolhido é positivo!</p>
            <?php
        };

        // incremento
        $c = 0;

        // exibindo taboada
        while ($c <= $maximo) {
            $resultado = $taboada * $c;
            ?>
            <p><?= $c ?> X <?= $taboada ?> = <?= $resultado ?></p>
            <?php
            $c++;
        };
    ?>
</body>
</html>