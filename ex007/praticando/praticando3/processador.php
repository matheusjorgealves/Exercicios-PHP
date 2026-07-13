<?php

    $metodo = ($_SERVER["REQUEST_METHOD"]);

    if ($metodo == "POST") {
        $fileiras = $_POST["fileiras"];
        $colunas = $_POST["colunas"];
    } else {
        $fileiras = $_GET["fileiras"];
        $colunas = $_GET["colunas"];
    };

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinemark</title>
</head>
<body>
    <header>
        <h1>Cinemark</h1>
    </header>

    <main>
        <h2>Poltronas:</h2>

        <?php
            // validações 
            if ($fileiras < 1) { // fileiras igual a 0
                ?>
                <p>erro: fileiras não podem ser iguais a zero</p>
                <?php
                exit;
            } elseif ($fileiras > 20) { // fileiras maiores que 20
                ?>
                <p>erro: fileiras não podem ser maiores de 20</p>
                <?php
                exit;
            } elseif ($colunas < 1) { // colunas igual a 0
                ?>
                <p>erro: colunas não podem ser iguais a zero</p>
                <?php
                exit;
            } else { // se for válido
                for ($f = 1; $f <= $fileiras; $f++) { // fileiras
                    ?>
                    <p>Fileira: <?= $f ?></p>
                    <?php
                    for ($c = 1; $c <= $colunas; $c++) { // colunas
                        ?>
                        <p>Poltrona: <?= $c ?></p>
                        <?php
                    };
                };
            };
        ?>
    </main>
</body>
</html>