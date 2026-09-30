<?php

    // inclui a conexão com o banco de dados
    include ("../conexao.php");

    // variável de erros
    $erros = [];

    // retomando a sessão
    session_start();

    // se o método da requisição for get
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        // se não existir um id de usuário na sessão
        if (!isset($_SESSION["id_usuario"])) {
            $erros[] = "Erro ao autenticar na página protegida!";
        }

        // se não houverem erros
        if (empty($erros)) {
            // mensagem de sucesso ao autenticar na página protegida
            $mensagem = "Você conseguiu fazer login, ". $_SESSION["nome_usuario"]."!";
        }
    }

    // se o método da requisição for post
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // destruindo a sessão atual
        session_destroy();

        // redirecionando o usuário para a página de login
        header("Location: login.php");
        exit;
    }

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página protegida</title>
</head>
<body>
    <header>
        <h1>Página protegida</h1>
    </header>

    <main>
        <!-- php -->
        <?php
        // se houverem erros
        if (!empty($erros)) {
            // percorrendo os erros
            foreach ($erros as $erro) {
                ?>
                <p>Erro: <?= $erro ?></p>
                <?php
            }
        }

        // se não houverem erros
        if (empty($erros)) {
            // se a mensagem for criada 
            if (isset($mensagem)) {
                ?>
                <p><?= $mensagem ?></p>
                <?php
            }
        }
        ?>

        <!-- formulário -->
        <form action="" method="post">
            <!-- button logout -->
            <button type="submit">Logout</button>
            <br> <br>
        </form>
    </main>

    <footer>
        <p>Site feito por <a href="https://GitHub.com/matheusjorgealves" target="blank">Matheus Jorge</a></p>
    </footer>
</body>
</html>