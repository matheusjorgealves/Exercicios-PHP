<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
    <link rel="stylesheet" href="resultado.css">
</head>
<body>

    <!-- Eu fiz o html para que essa página carregasse o arquivo css através do link css -->

    <?php // inicializando o php

    // capturando as respostas do usuário
    $sexo = $_POST["sexo"]; 
    $nome = $_POST["nome"];
    $idade = $_POST["idade"];
    $nacionalidade = $_POST["nacionalidade"];
    $profissao = $_POST["profissao"];

    if (strtolower($sexo) == "masculino") {
        $cor = "blue";
    } else {
        $cor = "pink";
    }

    // Saída dos dados
    echo "<h1> Olá ".$nome.", abaixo estão as suas informações </h1>";

    echo "<p class='$cor'> Sexo: ".$sexo."</p>";
    echo "<p> Nome: ".$nome."</p>";
    echo "<p> Idade: ".$idade."</p>";
    echo "<p> Nacionalidade: ".$nacionalidade."</p>";
    echo "<p> Profissão: ".$profissao."</p>";

    ?>

</body>
</html>