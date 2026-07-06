<?php
    // indentificando se o envio é POST ou GET
    $metodo = ($_SERVER["REQUEST_METHOD"]);

    // criando o array dos livros
    $livros = [
        "Dom Casmurro",
        "Turma da Mônica",
        "Dom Casmurro",
        "Harry Potter",
        "Percy Jackson"
    ];

    // recebendo a resposta do usuário
    if ($metodo == "POST") {
        $consultarLivro = $_POST["consultarLivro"];
    } else {
        $consultarLivro = $_GET["consultarLivro"];
    }; 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
</head>
<body>
    <h1>Resultado da consulta</h1>

    <?php
        $encontreiLivro = false; // não encontrei no array
        $quantidadeLivro = 0; // quantos livros desse no array

        // percorrendo o array com o foreach
        foreach ($livros as $livro) {
            if ($livro == $consultarLivro) { 
                $encontreiLivro = true;
                $quantidadeLivro = $quantidadeLivro + 1;
            };
        };

        // se $consultarLivro existir no array
        if ($encontreiLivro == true) {
            ?>
            <p>Encontrei o Livro <?= $consultarLivro ?> no catálogo da biblioteca!</p>
            <p>Existem <?= $quantidadeLivro ?> exemplares desse livro no catálogo da biblioteca!</p>
            <?php
        }else { // se não existir
            ?>
            <p>Não encontrei o Livro <?= $consultarLivro ?> no catálogo da biblioteca!</p>
            <p>Existem <?= $quantidadeLivro ?> exemplares desse livro no catálogo da biblioteca!</p>
            <?php
        };
    ?>
</body>
</html>