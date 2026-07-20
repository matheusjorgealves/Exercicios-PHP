<?php

    $metodo = ($_SERVER["REQUEST_METHOD"]);

    if ($metodo == "POST") {
        $nome = $_POST["nome"];
        $n1 = $_POST["n1"];
        $n2 = $_POST["n2"];
        $frequencia = $_POST["frequencia"];
    } else {
        $nome = $_GET["nome"];
        $n1 = $_GET["n1"];
        $n2 = $_GET["n2"];
        $frequencia = $_GET["frequencia"];
    };

    // validações 
    if ($n1 < 0 || $n1 > 10 || $n2 < 0 || $n2 > 10 || $frequencia < 0 || $frequencia > 100) {
        ?>
        <p>Erro: Informações Inválidas!</p>
        <?php
        exit;
    };

    // funções
    // mostrar nome
    function mostrarNome($nome) {
        ?>
        <p>Nome: <?= $nome ?></p>
        <?php
    };

    // calcular média
    function calcularMedia($n1, $n2) {
        $mediaLocal = ($n1 + $n2) / 2;
        return $mediaLocal;
    };
    // passando a function para a $media. o return serve para dizer qual é o valor que será passado para a $media
    $media = calcularMedia($n1, $n2);

    // verificar frequência
    function verificarFrequencia($frequencia) {
        if ($frequencia >= 75) {
            $situacaoFrequenciaLocal = "suficiente";
        } else {
            $situacaoFrequenciaLocal = "insuficiente";
        };
        return $situacaoFrequenciaLocal;
    };
    $situacaoFrequencia = verificarFrequencia($frequencia);

    // verificar aprovação
    function verificarAprovacao($media, $situacaoFrequencia) {
        switch ($situacaoFrequencia) {
            case "suficiente":
                if ($media >= 7) {
                    $resultadoAprovacaoLocal = "aprovado";
                } elseif ($media >= 5 && $media <= 6.9) {
                    $resultadoAprovacaoLocal = "recuperacao";
                } else {
                    $resultadoAprovacaoLocal = "reprovado";
                };
                break;

            case "insuficiente":
                $resultadoAprovacaoLocal = "reprovado";
                break;

            default:
                ?>
                <p>Erro!</p>
                <?php
                exit;
                break;
        };
        return $resultadoAprovacaoLocal;
    };
    $resultadoAprovacao = verificarAprovacao($media, $situacaoFrequencia);

    // mensagem personalizada
    function mensagemPersonalizada($resultadoAprovacao) {
        switch ($resultadoAprovacao) {
            case "aprovado":
                ?>
                <p>Parabéns pela aprovação!</p>
                <?php
                break;

            case "recuperacao":
                ?>
                <p>Não desanime pela recuperação, você NÃO está perdido!</p>
                <?php
                break;

            case "reprovado":
                ?>
                <p>Reprovado! Não desista! Busque melhorar!</p>
                <?php
                break;

            default:
                ?>
                <p>Erro!</p>
                <?php
                exit;
                break;
        };
    };

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Boletim Escolar</title>
</head>
<body>
    <header>
        <h1>Sistema de Boletim Escolar</h1>

        <?= mostrarNome($nome) ?>

        <p>Média: <?= $media ?></p>

        <p>Frequência: <?= $frequencia ?>%</p>

        <?= mensagemPersonalizada($resultadoAprovacao) ?>
    </header>
</body>
</html>