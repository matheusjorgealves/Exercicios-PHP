<?php 
    $metodo = ($_SERVER["REQUEST_METHOD"]);

    if ($metodo == "POST") {
        $nome = $_POST["nome"];
        $time = $_POST["time"];
    } else {
        $nome = $_GET["nome"];
        $time = $_GET["time"];
    };
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time do Coração</title>
</head>
<body>
    <h1>Seja bem vindo(a), <?= $nome ?>!</h1>

    <?php // abri PHP
        switch ($time) {
            case "saopaulo": // fecharei PHP ?>
                <p>Salve o tricolor paulista!</p>
                <p>Vamos São Paulo</p>
                <?php // Abri novamente
                break;

            case "santos": ?>
                <p>Vamos peixe!</p>
                <p>O time do rei</p>
                <?php
                break;
                
            case "palmeiras": ?>
                <p>Avante palestra!</p>
                <p>Vamos, sem mundial!</p>
                <?php
                break;

            case "corinthians": ?>
                <p>Vai Corinthians</p>
                <p>Vamos, 2 mundiais com 1 libertadores (roubo)!</p>
                <?php
                break;
        };?>
</body>
</html>