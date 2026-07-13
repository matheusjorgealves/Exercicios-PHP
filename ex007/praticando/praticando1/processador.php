<?php

    // método de envio do form
    $metodo = ($_SERVER["REQUEST_METHOD"]);

    if ($metodo == "POST") {
        $inicio = $_POST["inicio"];
        $passo = $_POST["passo"];
        $fim = $_POST["fim"];
        $senhaC = $_POST["senhaCliente"];
    } else {
        $inicio = $_GET["inicio"];
        $passo = $_GET["passo"];
        $fim = $_GET["fim"];
        $senhaC = $_GET["senhaCliente"];
    };

    // validações
    if ($inicio < 0 && $senhaC < 0) { // inicio negativo
        ?>
        <p>Senha não pode ser inferior a zero!</p>
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
    } elseif ($inicio >= $fim && $senhaC >= $fim) { // inicio e senha maior ou igual ao fim
        ?>
        <p>Senha não pode ser superior ou igual ao Fim!</p>
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

                <p>Senha do cliente <?= $senhaC ?></p>

                <!-- senha do cliente -->
                <?php 
                    if ($fim / 2 < $senhaC) { // senha na segunda metade
                        ?>
                        <p>A senha do cliente está na segunda metade das senhas</p>
                        <?php
                    } elseif ($fim / 2 > $senhaC) {
                        ?>
                        <p>A senha do cliente está na primeira metade das senhas</p>
                        <?php
                    } else { // senha do cliente na metade das senhas
                        ?>
                        <p>A senha do cliente está exatamente na metade das senhas!</p>
                        <?php
                    };

                    // quantas pessoas na frente do cliente
                    /* o ideal era pegar a senha que está sendo atendida e subtrair esse valor com a senha do cliente, caso a senha atual fosse maior do que a senha do cliente o ideal seria fazer não aparecer nenhuma mensagem*/
                    $verificarSenha = $senhaC - $inicio;

                    ?>
                    <p>Existem <?= $verificarSenha ?> senhas na sua frente!</p>
                    <?php
                ?>

                <h2>Senhas:</h2>

                <!-- gerando senhas -->
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