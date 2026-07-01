<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sua idade</title>
</head>
<body>
    <!-- Declarando as variáveis localmente -->
    <?php
        $nome = "matheus";
        $idade = 94;
    ?>

    <h1>Seja bem vindo(a), <?= $nome ?>!</h1>

    <!-- Utilizando o PHP juntamente com o html -->
    <?php if ($idade < 5) { // fecha o PHP aqui e volta html ?>
        <p>Você ainda é um bebê</p>
        <!-- Depois abre o PHP e fecha as chaves do if -->
    <?php } elseif ($idade >= 5 && $idade <= 12) { ?>
        <p>Você é uma criança</p>
    <?php } elseif ($idade > 12 && $idade < 18) { ?>
        <p>Você é um adolescente</p>
    <?php } elseif ($idade >= 18 && $idade < 65) { ?>
        <p>Você é um adulto</p>
    <?php } else {?>
        <p>Você é um idoso</p>
    <?php } ?>
</body>
</html>