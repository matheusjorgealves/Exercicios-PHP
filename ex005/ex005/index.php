<?php
    // criando um array
    // basta criar a variável e colocar os valores separados por vírgula dentro dos colchetes
    $nomes = ["Matheus", "Helena", "Deborah", "Pedro", "Cecília"];
    $sobrenome = ["Jorge", "Dias", "Jorge", "Silva", "Dias"];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nomes</title>
</head>
<body>
    <!-- para mostrar o array basta colocar o índice que eu quero exibir do array -->
    <h1>Olá, <?= $nomes[0] ?>!</h1>
    <p>Seu sobrenome <?= $sobrenome[0] ?>!</p>

    <?php 
        $nomes[3] = "Theo";
        ?>
        <p>Substitui um nome para <?= $nomes[3] ?></p>
        <?php
    ?>
</body>
</html>