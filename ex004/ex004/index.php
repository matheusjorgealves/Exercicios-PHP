<?php // criando variáveis
    $nome = "matheus";
    $idade = 17;
    $cidade = "SP";
    $time = "SPFC";
    $nacionalidade = "Brasileiro";
?> 

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Você</title>
</head>
<body>
    <h1>Olá, <?php echo $nome ?>!</h1>

    <p>Para usar o PHP no html eu posso fazer uma tag chamando o PHP e inserindo valores através do <mark>echo</mark></p>

    <p>Minha idade através do <mark>echo</mark>: <?php echo $idade ?></p>

    <p>Eu também posso abreviar isso tudo usando apenas a tag PHP abreviada e usando um "=" para mostrar qualquer expressão que produza um valor. Bata que eu coloque a <mark>tag do PHP mas sem a escrita PHP</mark>, na frente da abertura da tag eu posso colocar um = e no meio dela a variável. Veja um exemplo abaixo</p>

    <p>Minha cidade: <?= $cidade ?></p>

    <p>Agora eu vou usar o echo</p>

    <p>Meu time do coração: <?php echo $time ?></p>

    <p>Agora eu simplificarei</p>

    <p>Minha nacionalidade: <?= $nacionalidade ?></p>
</body>
</html>