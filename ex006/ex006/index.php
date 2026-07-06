<?php

    // criando um array
    $cursos = [
        "Informática",
        "JavaScript",
        "Python",
        "PHP",
        "HTML",
        "CSS",
        "Git",
        "SQL"
    ];

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos</title>
</head>
<body>
    <h1>Cursos disponíveis</h1>

    <?php
        // exibindo os cursos disponíveis usando foreach
        foreach ($cursos as $curso) {
            ?>
            <p><?= $curso ?></p>
            <?php
        };
    ?>
</body>
</html>