<?php

    // funções
    function calcularMedia($n1, $n2, $n3, $n4) {
        $mediaLocal = ($n1 + $n2 + $n3 + $n4) / 4;

        return $mediaLocal;
    };

    function verificarFrequencia($frequencia) {
        if ($frequencia >= 70 && $frequencia <= 100) {
            $resultadoFrequenciaLocal = true;
        } else {
            $resultadoFrequenciaLocal = false;
        };

        return $resultadoFrequenciaLocal;
    };

    function verificarAprovacao($media, $resultadoFrequencia) {
        if ($resultadoFrequencia == true && $media >= 7) {
            $situacaoAlunoLocal = "Parabéns, Aprovado!";
        } else {
            $situacaoAlunoLocal = "Reprovado!";
        };

        return $situacaoAlunoLocal;
    };

    // criando as variáveis
    $nome = "";
    $n1 = 0;
    $n2 = 0;
    $n3 = 0;
    $n4 = 0;
    $media = 0;
    $frequencia = 0;
    $resultadoFrequencia = false;
    $situacaoAluno = "";
    $erros = [];
    $mensagens = [];

    // se o método da requisição for POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = trim($_POST["nome"]);
        $n1 = $_POST["n1"];
        $n2 = $_POST["n2"];
        $n3 = $_POST["n3"];
        $n4 = $_POST["n4"];
        $frequencia = $_POST["frequencia"];

        // validações:
        // nome
        if (empty($nome)) {
            $erros[] = "Nome inválido!";
        } else {
            $mensagens[] = "Nome: $nome";
        };

        // n1
        if (empty($n1) || $n1 < 0 || $n1 > 10) {
            $erros[] = "1° Nota inválida!";
        } else {
            $mensagens[] = "Nota do 1° Bimestre: $n1";
        };

        // n2
        if (empty($n2) || $n2 < 0 || $n2 > 10) {
            $erros[] = "2° Nota inválida!";
        } else {
            $mensagens[] = "Nota do 2° Bimestre: $n2";
        };

        // n3
        if (empty($n3) || $n3 < 0 || $n3 > 10) {
            $erros[] = "3° Nota inválida!";
        } else {
            $mensagens[] = "Nota do 3° Bimestre: $n3";
        };

        // n4
        if (empty($n4) || $n4 < 0 || $n4 > 10) {
            $erros[] = "4° Nota inválida!";
        } else {
            $mensagens[] = "Nota do 4° Bimestre: $n4";
        };

        // frequencia
        if (empty($frequencia) || $frequencia < 0 || $frequencia > 100) {
            $erros[] = "Frequência inválida!";
        } else {
            $mensagens[] = "Frequência = $frequencia%";
        };

        // se não houverem erros
        if (empty($erros)) {
            // chamando as functions
            $media = calcularMedia($n1, $n2, $n3, $n4);
            $resultadoFrequencia = verificarFrequencia($frequencia);
            $situacaoAluno = verificarAprovacao($media, $resultadoFrequencia);

            // colocando os resultados dentro das mensagens
            $mensagens[] = "Média: $media";

            if ($resultadoFrequencia == true) {
                $mensagens[] = "Frequência: suficiente!";
            } else {
                $mensagens[] = "Frequência: insuficiente!";
            };

            $mensagens[] = "$situacaoAluno";
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

        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // se não houverem erros
                if (empty($erros)) {
                    foreach ($mensagens as $mensagem) {
                        ?>
                        <p><?= $mensagem ?></p>
                        <?php
                    };
                } else { // se houverem erros
                    foreach ($erros as $indice => $erro) {
                        ?>
                        <p><?= $indice + 1 ?>° erro: <?= $erro ?></p>
                        <?php
                    };
                };
            };
        ?>

        <form action="" method="post">
            <!-- nome -->
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="<?= $nome ?>">
            <br> <br>

            <!-- n1 -->
            <label for="n1">Nota do 1° Bimestre:</label>
            <input type="number" name="n1" id="n1" min="0" max="10" step="0.5" value="<?= $n1 ?>">
            <br> <br>

            <!-- n2 -->
            <label for="n2">Nota do 2° Bimestre:</label>
            <input type="number" name="n2" id="n2" min="0" max="10" step="0.5" value="<?= $n2 ?>">
            <br> <br>

            <!-- n3 -->
            <label for="n3">Nota do 3° Bimestre:</label>
            <input type="number" name="n3" id="n3" min="0" max="10" step="0.5" value="<?= $n3 ?>">
            <br> <br>

            <!-- n4 -->
            <label for="n4">Nota do 4° Bimestre:</label>
            <input type="number" name="n4" id="n4" min="0" max="10" step="0.5" value="<?= $n4 ?>">
            <br> <br>

            <!-- frequencia -->
            <label for="frequencia">Frequência:</label>%
            <input type="number" name="frequencia" id="frequencia" min="0" max="100" step="0.01" value="<?= $frequencia ?>">
            <br> <br>

            <button type="submit">Consultar</button>
        </form>
    </header>
</body>
</html>