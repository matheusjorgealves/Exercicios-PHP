<?php 
    $metodo = ($_SERVER["REQUEST_METHOD"]);

    // método == POST
    if ($metodo == "POST") {
        // array $aluno[]
        $aluno = [
            $_POST["nome"],
            $_POST["comportamento"],
            $_POST["n1"],
            $_POST["n2"],
            $_POST["n3"],
            $_POST["n4"]
        ];
    } else { // método == GET
        $aluno = [
            $_GET["nome"],
            $_GET["comportamento"],
            $_GET["n1"],
            $_GET["n2"],
            $_GET["n3"],
            $_GET["n4"]
        ];
    };
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta realizada</title>
    <link rel="stylesheet" href="processador.css">
</head>
<body>
    <header>
        <h1>Consulta realizada com sucesso!</h1>
    </header>

    <main>
        <!-- nome -->
        <p>Nome: <?= $aluno[0] ?></p>

        <!-- validando as notas e criando a média -->
        <?php 
            // se alguma nota for negativa
            if ($aluno[2] < 0 || $aluno[3] < 0 || $aluno[4] < 0 || $aluno[5] < 0) { ?>
                <p>Nota negativa inválida</p>
                <?php
                exit;

            // se alguma nota for positiva
            } elseif ($aluno[2] > 10 || $aluno[3] > 10 || $aluno[4] > 10 || $aluno[5] > 10) { ?>
                <p>Nota excedente inválida</p>
                <?php
                exit;

            // se a nota for válida
            } else {
                // média recebe as notas
                $media = ($aluno[2] + $aluno[3] + $aluno[4] + $aluno[5]) / 4; 

                // mudando a média conforme comportamento
                switch ($aluno[1]) {
                    case "ruim": ?>
                        <p>Comportamento ruim reduziu a média!</p>
                        <?php
                        $media = $media - 2;
                        break;

                    case "regular": ?>
                        <p>Comportamento regular não interferiu na média!</p>
                        <?php
                        break;

                    case "bom": ?>
                        <p>Comportamento bom aumentou a média!</p>
                        <?php
                        $media = $media + 1;
                        break;

                    case "excelente": ?>
                        <p>Comportamento excelente aumentou bastante a média!</p>
                        <?php
                        $media = $media + 2;
                        break;

                    default: ?>
                        <p>Comportamento inválido!</p>
                        <?php
                        exit;
                        break;
                };

                // array recebendo a média do aluno
                $aluno[6] = $media;
                
                // se a média for negativa
                if ($aluno[6] < 0) { 
                    $aluno[6] = 0;
                    $cor = "minimo";
                    ?>
                    <p>Aluno(a) obteve média mínima e foi <mark class="<?= $cor ?>">reprovado!</mark></p>
                    <?php

                // média <= 4
                } elseif ($aluno[6] <= 4) { 
                    $cor = "reprovado";
                    ?>
                    <p>Aluno(a) reprovado com <mark class="<?= $cor ?>">média = <?= $aluno[6] ?></mark></p>
                    <?php

                // se a média for acima de 10
                } elseif ($aluno[6] > 10) {
                    $aluno[6] = 10;
                    $cor = "maximo"
                    ?>
                    <p>Aluno(a) obteve média máxima e foi <mark class="<?= $cor ?>">aprovado com honras!</mark></p>
                    <?php

                // média ok
                } else { 
                    $cor = "aprovado";
                    ?>
                    <p>Aluno(a) aprovado com <mark class="<?= $cor ?>">média = <?= $aluno[6] ?></mark></p>
                    <?php
                };
            };
        ?>
    </main>
</body>
</html>