<?php

    // método de envio do form
    $metodo = ($_SERVER["REQUEST_METHOD"]);

    if ($metodo == "POST") {
        $inicio = $_POST["inicio"];
        $passo = $_POST["passo"];
        $fim = $_POST["fim"];
    } else {
        $inicio = $_GET["inicio"];
        $passo = $_GET["passo"];
        $fim = $_GET["fim"];
    };

    // validações
    if ($inicio < 0) { // inicio negativo
        ?>
        <p>Início não pode ser inferior a zero!</p>
        <?php
        exit;
    } elseif ($passo < 1) { // passo inferior a 1
        ?>
        <p>Incremento não pode ser inferior a 1!</p>
        <?php
        exit;
    } elseif ($fim < 10) { // fim inferior a 10
        ?>   
        <p>Fim não pode ser inferior a 10!</p>
        <?php
        exit;
    } elseif ($inicio >= $fim) { // inicio maior ou igual ao fim
        ?>
        <p>Início não pode ser superior ou igual ao Fim!</p>
        <?php
        exit;
    } else { // se for válido
        ?>
            <!DOCTYPE html>
            <html lang="pt-br">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Padaria do João</title>
            </head>
            <body>
                <h1>Padaria do João</h1>

                <h2>Senhas:</h2>

                <?php
                    for ($i = $inicio; $i <= $fim; $i = $i + $passo) {
                        ?>
                            <p>Senha: <?= $i ?></p>
                        <?php
                    };
                ?>
            </body>
            </html>
        <?php
    };

?>