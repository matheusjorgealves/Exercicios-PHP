<?php
    $alunos = [
        "João",
        "Matheus",
        "Deborah",
        "Pedro",
        "Theo",
        "Helena",
        "Cecília"
    ];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escola</title>
</head>
<body>
    <header>
        <h1>Escola</h1>
    </header>

    <main>
        <h2>Alunos</h2>

        <?php
            // estrutura de repetição para exibir o array (tipo o foreach)
            for ($i = 0; $i <= count($alunos) - 1; $i++) {
                ?>
                    <p>Aluno <?= $i + 1 ?>: <?= $alunos[$i] ?></p>
                <?php
            };
        ?>
    </main>
</body>
</html>