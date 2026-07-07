<?php 

    $metodo = ($_SERVER["REQUEST_METHOD"]);

    // método POST
    if ($metodo == "POST") {
        // isset verifica se usuário digitou algo no input
        if (isset($_POST["novo"])) {
            $novo = $_POST["novo"];
        } else {
            $novo = false;
        };
    } else { // método GET
        if (isset($_GET["novo"])) {
            $novo = $_GET["novo"];
        } else {
            $novo = false;
        };
    };

    // array para armazenar os animais
    $animais = [
        "Gorila",
        "Macaco",
        "Leão",
        "Lontra",
        "Elefante",
        "Cavalo",
        "Tigre",
        "Onça",
        "Leopardo",
        "Urso",
        "Tamanduá"
    ];

    // array cresce conforme usuário insere novos animais
    $animais[] = $novo;
    
    // verificando se já havia esse animal cadastrado
    $quantidade = 0;
    foreach ($animais as $animal) {
        if ($animal == $novo) {
            $quantidade = $quantidade + 1;
        }
    };
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoológico</title>
</head>
<body>
    <header>
        <h1>Zoológico</h1>
    </header>

    <main>
        <?php
            // se o animal for o único em registro
            if ($quantidade == 1) {
                ?>
                <p>Você acabou de registrar <?= $novo ?> no seu zoológico</p>
                <?php
            } elseif ($quantidade > 1) { 
                // se esse animal já estava em registro
                ?>
                <p>Você agora tem <?= $quantidade ?> animais da espécie <?= $novo ?> registrados no seu zoológico!</p>
                <?php
            };
        ?>
    
        <h2>Animais cadastrados no zoológico:</h2>

        <?php
        // lista dos animais cadastrados
        foreach ($animais as $indice => $animal) {
            ?>
            <hr>
            <p>Animal <?= $indice ?>: <?= $animal ?></p>
            <hr>
            <?php
        };
        ?>
    </main>
</body>
</html>