<?php

    // criando o array dos alunos
    $alunos = [
        "Matheus",
        "Ana",
        "Deborah",
        "Leonídia",
        "Samuel",
        "Victor",
        "Fernando",
        "Julia",
        "Guilherme",
        "Vinícius",
        "Nayara"
    ];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academia da Cidade líder</title>
</head>
<body>
    <h1>Academia da Cidade Líder</h1>

    <?php
        // exibindo os dados do array através do uso do foreach
        foreach ($alunos as $aluno) {
            ?>
            <div>
                <hr>
                <p><?= $aluno ?></p>
                <hr>
            </div>
            <?php
        };
    ?>
</body>
</html>