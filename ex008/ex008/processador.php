<?php

    // método do form
    $metodo = ($_SERVER["REQUEST_METHOD"]);

    if ($metodo == "POST") { // post
        $etiquetas = $_POST["etiquetas"];
    } else { // get
        $etiquetas = $_GET["etiquetas"];
    };

    if ($etiquetas < 0) { // se etiquetas for negativo
        ?>
        <p>Erro: Você não pode imprimir um valor negativo!</p>
        <?php
    } else {
        ?>
            <!DOCTYPE html>
            <html lang="pt-br">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Gráfica do Tô</title>
            </head>
            <body>
                <header>
                    <h1>Gráfica do Tô</h1>
                </header>

                <main>
                    <h2>Etiquetas imprimidas:</h2>

                    <?php
                        // c é a variável contadora
                        $c = 1;
                        while ($c <= $etiquetas) {
                            ?>
                            <p>Etiqueta: <?= $c ?></p>
                            <?php
                            $c++; // incremento
                        };
                    ?>
                </main>
            </body>
            </html>
        <?php
    }
?>