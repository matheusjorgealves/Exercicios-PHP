<?php
    // passei o array do index para cá, mas reconheço que isso não está correto, fiz somente para aprender como funciona e testar a minha lógica
    $nomes = ["Matheus", "Deborah", "Pedro", "Helena", "Cecília"];

$alterar = $_POST["alterar"];
$nome = $_POST["nome"];

switch ($alterar) {
    case "0": ?>
        <p>Você alterou o nome <?= $nomes[0] ?> para <?= $nome ?></p>
        <?php
        $nomes[0] = $nome;
        break;

    case "1": ?>
        <p>Você alterou o nome <?= $nomes[1] ?> para <?= $nome ?></p> 
        <?php
        $nomes[1] = $nome;
        break;

    case "2": ?>
        <p>Você alterou o nome <?= $nomes[2] ?> para <?= $nome ?></p>
        <?php
        $nomes[2] = $nome;
        break;

    case "3": ?>
        <p>Você alterou o nome <?= $nomes[3] ?> para <?= $nome ?></p>
        <?php
        $nomes[3] = $nome;
        break;

    case "4": ?>
        <p>Você alterou o nome <?= $nomes[4] ?> para <?= $nome ?></p>
        <?php
        $nomes[4] = $nome;
        break;

    default: ?>
        <p>Erro</p>
        <?php
        exit;
        break;
};
?>
<p>0: <?= $nomes[0] ?></p>
<p>1: <?= $nomes[1] ?></p>
<p>2: <?= $nomes[2] ?></p>
<p>3: <?= $nomes[3] ?></p>
<p>4: <?= $nomes[4] ?></p>