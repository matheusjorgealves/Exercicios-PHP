<?php

    // recebendo a o método da requisição
    $metodo = ($_SERVER["REQUEST_METHOD"]);

    // se for post as variáveis são criadas
    if ($metodo == "POST") {
        $nome = $_POST["nome"];
        $mensagem = "Olá, $nome! Seja bem vindo(a).";
    }

?>

<!DOCTYPE html>
<html lang="pt-bt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seu nome</title>
</head>
<body>
    <header>
        <h1>Seja bem-vindo(a)</h1>

        <?php
            // se a variável mensagem existir
            if (isset($mensagem)) {
                ?>
                <p><?= $mensagem ?></p>
                <?php
            };
        ?>

        <!-- form sendo tratado no próprio arquivo -->
        <form action="index.php" method="post">
            <!-- nome -->
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required>
            <br> <br>

            <button type="submit">Enviar</button>
        </form>
    </header>
</body>
</html>