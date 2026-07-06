<?php
    $metodo = ($_SERVER["REQUEST_METHOD"]);

    // criando o array dos alunos
    $alunos = [
        "Matthews",
        "Jhon",
        "Harry",
        "Carl",
        "Marie",
        "Jhonston",
        "Jack",
        "Nicholas",
        "Andrew"
    ];

    // método get
    if ($metodo == "GET") {
        $consultar = $_GET["consultar"];
    } else { // método post
        $consultar = $_POST["consultar"];
    };
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escola</title>
    <link rel="stylesheet" href="processador.css">
</head>
<body>
    <h1>Resultado da consulta</h1>

    <h2>Alunos:</h2>
    <?php
        // variável para carregar true ou false
        $encontrei = false;

        // usando foreach para percorrer o array
        foreach ($alunos as $aluno) {
            // se o aluno requerido estiver matriculado
            if ($aluno == $consultar) {
                $encontrei = true;
                $cor = "green";
                ?>
                <hr>
                <p class="<?= $cor ?>"><?= $aluno ?></p>
                <hr>
                <?php
            } else { // se o aluno não estiver matriculado
                $cor = "red";
                ?>
                <hr>
                <p class="<?= $cor ?>"><?= $aluno ?></p>
                <hr>
                <?php
            };
        };

        // verificando se o aluno está no array com o $encontrei
        if ($encontrei == false) {
            ?>
            <p>Não encontrei o <?= $consultar ?> na lista de matrículados!</p>
            <?php
        } else {
            ?>
            <p>Encontrei o <?= $consultar ?> na lista de matrículados!</p>
            <?php
        };
    ?>
</body>
</html>