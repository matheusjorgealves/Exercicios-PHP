<?php

    /*
    trim == remove os espaços no início e no fim da variável
    empty == se a variável não tiver nenhum valor 
    isset == se a variável existir
    */

    // se o método da requisição for post
    if (($_SERVER["REQUEST_METHOD"]) == "POST") {
        $nome = trim($_POST["nome"]);

        // se $nome estiver vazio 
        if (empty($nome)) {
            $mensagem = "Escreva um nome válido abaixo!";
        } else { // se $nome estiver preenchido
            $mensagem = "Olá, $nome";
        };
    };

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seu nome</title>
</head>
<body>
    <header>
        <h1>Seu nome</h1>

        <?php
            // se a variável $mensagem existir
            if (isset($mensagem)) {
                ?>
                <p><?= $mensagem ?></p>
                <?php
            };
        ?>

        <form action="" method="post">
            <!-- nome -->
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome">

            <button type="submit">Enviar</button>
        </form>
    </header>
</body>
</html>