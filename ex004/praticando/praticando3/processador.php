<?php // recebendo os dados e criando variáveis
    $metodo = ($_SERVER["REQUEST_METHOD"]);

    if ($metodo == "POST") {
        $nome = $_POST["nome"];
        $idade = $_POST["idade"];
        $cidade = $_POST["cidade"];
        $time = $_POST["time"];
        $escolaridade = $_POST["escolaridade"];

        // isset verifica se a caixa foi marcada
        if (isset($_POST["novidades"])) {
            $novidades = $_POST["novidades"];
        } else {
            $novidades = false;
        };
    } else {
        $nome = $_GET["nome"];
        $idade = $_GET["idade"];
        $cidade = $_GET["cidade"];
        $time = $_GET["time"];
        $escolaridade = $_GET["escolaridade"];

        if (isset($_GET["novidades"])) {
            $novidades = $_GET["novidades"];
        };
    };
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha de cadastro</title>
</head>
<body>
    
    <header>
        <!-- mostrando a variável chamando o php -->
        <h1>Cadastro concluído com sucesso, <?= $nome ?>!</h1>
    </header>

    <main>
        <!-- idade -->
        <p>Você tem <?= $idade ?> anos de idade</p>
        <?php 
            if ($idade >= 0 && $idade < 5) { ?>
                <p>Você tem a idade de um bebê!</p>
                <?php
            } elseif ($idade >= 5 && $idade <= 10) { ?>
                <p>Você tem a idade de uma criança!</p>
                <?php
            } elseif ($idade > 10 && $idade <= 13) { ?>
                <p>Você tem a idade de um pré-adolescente!</p>
                <?php
            } elseif ($idade > 13 && $idade < 18) { ?>
                <p>Você tem a idade de um adolescente!</p>
                <?php
            } elseif ($idade >= 18 && $idade < 65) { ?>
                <p>Você tem a idade de um adulto!</p>
                <?php
            } elseif ($idade >= 65) { ?>
                <p>Você tem a idade de um idoso!</p>
                <?php
            } else { ?>
                <p>Idade invalida!</p>
                <?php
                exit;
            };
        ?>

        <!-- cidade -->
        <p>Você é da cidade de <?= $cidade ?>!</p>

        <!-- time -->
        <?php 
            switch ($time){
                // vou testar uma possibilidade, fechar o php e escrever em html. depois abrirei o php novamente
                case "saopaulo": ?>
                    <p>Você é São Paulino. Vamos São Paulo!</p>
                    <?php
                    break;

                case "santos": ?>
                    <p>Você é Santista. Vamos Peixe!</p>
                    <?php
                    break;

                case "palmeiras": ?>
                    <p>Você é Palmeirense. Avante Palestra!</p>
                    <?php
                    break;

                case "corinthians": ?>
                    <p>Você é Corinthiano. Vai Corinthians!</p>
                    <?php
                    break;

                case "gremio": ?>
                    <p>Você é Gremista. Dale tricolor!</p>
                    <?php
                    break;

                case "flamengo": ?>
                    <p>Você é Flamenguista. Vamos Flamengo!</p>
                    <?php
                    break;

                case "cruzeiro": ?>
                    <p>Você é Cruzeirense. Vai Cabuloso!</p>
                    <?php
                    break;

                case "bahia": ?>
                    <p>Você é Bahiano. Vamos, Tricolor!</p>
                    <?php
                    break;

                default: ?>
                    <p>Time inválido!</p>
                    <?php
                    exit;
                    break;
            };
        ?>

        <!-- escolaridade -->
        <?php
            switch ($escolaridade) {
                case "superior": ?>
                    <p>Você tem o ensino superior completo, parabéns!</p>
                    <?php
                    break;

                case "medio": ?>
                    <p>Você tem o ensino médio completo!</p>
                    <?php
                    break;

                case "incompleto": ?>
                    <p>Você não completou o ensino médio!</p>
                    <?php
                    break;

                default: ?>
                    <p>Escolaridade inválida</p>
                    <?php
                    exit;
                    break;
            }
        ?> 

        <!-- novidades -->
        <?php
            switch ($novidades) {
                case "futebol": ?>
                    <p>Você escolheu receber novidades de futebol, então lá vai!</p> 
                    <p>O brasileirão irá receber, após o término da copa do mundo, a implementação do impedimento semi-automático!</p>
                    <?php
                    break;

                case "ufc": ?> 
                    <p>Você escolheu receber novidades de UFC, bora lá!</p> 
                    <p>O ex-campeão do UFC, Connor McGreggor voltará a lutar após 3 anos!</p>
                    <?php
                    break;

                case "copa": ?>
                    <p>Você quer saber mais sobre a Copa do Mundo? É pra já!</p> 
                    <p>A edição de 2026 é a primeira edição da história da Copa do Mundo que teremos a disputa dos 16 avos de final. Além de também ser a primeira vez que está sendo realizada a para para a hidratação (decisão bem impopular)!</p>
                    <?php
                    break;

                default: ?>
                    <p>Novidade inexistente!</p>
                    <?php
                    exit;
                    break;
            };
        ?>
    </main>
</body>
</html>