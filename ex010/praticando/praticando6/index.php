<?php

    // funções
    function calcularValorFinanciado($valor, $entrada) {
        $valorFinanciadoLocal = $valor - $entrada;
        return $valorFinanciadoLocal;
    };

    function calcularJuros($parcelas, $juros, $valorFinanciado) {
        switch ($parcelas) {
            case 12:
                $valorJurosLocal = ($juros / 100) * 1;
                break;

            case 24:
                $valorJurosLocal = ($juros / 100) * 2;
                break;

            case 36:
                $valorJurosLocal = ($juros / 100) * 3;
                break;

            case 48:
                $valorJurosLocal = ($juros / 100) * 4;
                break;

            default:
                $erros[] = "Erro por conta das parcelas!";
                break;
        };
        $valorFinanciadoJurosLocal = $valorFinanciado * $valorJurosLocal;
        return $valorFinanciadoJurosLocal;
    };

    function calcularTotal($valorFinanciado, $valorFinanciadoJuros) {
        $totalLocal = $valorFinanciadoJuros + $valorFinanciado;
        return $totalLocal;
    };

    function classificarFinanciamento($total) {
        if ($total <= 50000) {
            $classificacaoFinanciamentoLocal = "Financiamento barato!";
        } elseif ($total > 50000 && $total < 100000) {
            $classificacaoFinanciamentoLocal = "Financiamento moderado!";
        } else {
            $classificacaoFinanciamentoLocal = "Financiamento caro!";
        };
        return $classificacaoFinanciamentoLocal;
    };

    // criação das variáveis
    $nome = "";
    $valor = 5000;
    $entrada = 0;
    $parcelas = 12;
    $juros = 0;
    $erros = [];
    $mensagens = [];

    // se o método da requisição for post
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = trim($_POST["nome"]);
        $valor = $_POST["valor"];
        $entrada = $_POST["entrada"];
        $parcelas = $_POST["parcelas"];
        $juros = $_POST["juros"];

        // validações 
        // nome
        if (empty($nome)) {
            $erros[] = "Nome inválido!";
        } else {
            $mensagens[] = "Nome: $nome";
        };

        // valor
        if ($valor == "" || $valor < 5000 || $valor > 1000000) {
            $erros[] = "Valor do veículo inválido!";
        } else {
            $mensagens[] = "Valor do veículo: R$$valor";
        };

        // entrada
        if ($entrada == "" || $entrada < 0 || $entrada > 500000 || $entrada >= $valor) {
            $erros[] = "Valor de entrada inválido!";
        } else {
            $mensagens[] = "Valor da entrada: R$$entrada";
        };

        // parcelas
        if ($parcelas != 12 && $parcelas != 24 && $parcelas != 36 && $parcelas != 48) {
            $erros[] = "Parcelas inválidas!";
        } else {
            $mensagens[] = "Parcelas: $parcelas";
        };

        // juros
        if ($juros == "" || $juros < 0 || $juros > 100) {
            $erros[] = "Juros inválidos!";
        } else {
            $mensagens[] = "Taxa de juros anual: $juros%";
        };

        // se não houverem erros
        if (empty($erros)) {
            // chamando as functions
            $valorFinanciado = calcularValorFinanciado($valor, $entrada);

            $valorFinanciadoJuros = calcularJuros($parcelas, $juros, $valorFinanciado);

            $total = calcularTotal($valorFinanciado, $valorFinanciadoJuros);

            $classificacaoFinanciamento = classificarFinanciamento($total);

            $mensagens[] = "Valor financiado: R$$valorFinanciado";
            $mensagens[] = "Juros totais: R$$valorFinanciadoJuros";
            $mensagens[] = "Valor total: R$$total";
            $mensagens[] = "$classificacaoFinanciamento";
        };
    };
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de financiamento de veículos</title>
</head>
<body>
    <header>
        <h1>Sistema de financiamento de veículos</h1>

        <?php
            // se o usuário acessar pelo post
            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                // se não houverem erros
                if (empty($erros)) {
                    foreach ($mensagens as $mensagem) {
                        ?>
                        <p><?= $mensagem ?></p>
                        <?php
                    };
                } else {
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

            <!-- valor -->
            <label for="valor">Valor do veículo: R$</label>
            <input type="number" name="valor" id="valor" min="5000" max="1000000" value="<?= $valor ?>">
            <br> <br>

            <!-- entrada -->
            <label for="entrada">Valor da entrada: R$</label>
            <input type="number" name="entrada" id="entrada" min="0" max="500000" value="<?= $entrada ?>">
            <br> <br>

            <!-- parcelas -->
            <label for="parcelas">Parcelas:</label>
            <select name="parcelas" id="parcelas">

                <option value="12" <?= $parcelas == "12" ? "selected" : "" ?>>12</option>

                <option value="24" <?= $parcelas == "24" ? "selected" : "" ?>>24</option>

                <option value="36" <?= $parcelas == "36" ? "selected" : "" ?>>36</option>

                <option value="48" <?= $parcelas == "48" ? "selected" : "" ?>>48</option>

            </select>
            <br> <br>

            <!-- juros -->
            <label for="juros">Taxa de juros anual: </label>%
            <input type="number" name="juros" id="juros" min="0" max="100" value="<?= $juros ?>">
            <br> <br>

            <!-- botão -->
            <button type="submit">Simular</button>
        </form>
    </header>
</body>
</html>