<?php

    $metodo = ($_SERVER["REQUEST_METHOD"]);

    if ($metodo == "POST") {
        $nome = $_POST["nome"];
        $produto = $_POST["produto"];
        $valorProduto = $_POST["valorProduto"];
        $quantidade = $_POST["quantidade"];
        $cupom = $_POST["cupom"];
    } else {
        $nome = $_GET["nome"];
        $produto = $_GET["produto"];
        $valorProduto = $_GET["valorProduto"];
        $quantidade = $_GET["quantidade"];
        $cupom = $_GET["cupom"];
    };

    // validações 
    // valorProduto
    if ($valorProduto < 5 || $valorProduto > 1000) {
        ?>
        <p>Erro: Valor do produto é inválido!</p>
        <?php
        exit;
    };

    // quantidade
    if ($quantidade < 1 || $quantidade > 100) {
        ?>
        <p>Erro: Quantidade inválida!</p>
        <?php
        exit;
    };

    // funções
    // mostrarNome
    function mostrarNome($nome) {
        ?>
        <p>Nome: <?= $nome ?></p>
        <?php
    };

    // mostrarProduto
    function mostrarProduto($produto) {
        ?>
        <p>Produto: <?= $produto ?></p>
        <?php
    };

    // mostrarValorProduto
    function mostrarValorProduto($valorProduto) {
        ?>
        <p>Valor unitário do produto: R$<?= $valorProduto ?></p>
        <?php
    };

    // calcularProduto
    function calcularProduto($valorProduto, $quantidade) {
        $subtotalLocal = $valorProduto * $quantidade;
        return $subtotalLocal;
    };
    // $subtotal recebe o return da function calcularProduto()
    $subtotal = calcularProduto($valorProduto, $quantidade);

    // verificarCupom
    function verificarCupom($cupom) {
        switch ($cupom) {
            case "sim":
                $aplicarCupomLocal = true;
                break;
                
            case "nao":
                $aplicarCupomLocal = false;
                break;

            default:
                ?>
                <p>Erro: Cupom inválido!!!</p>
                <?php
                exit;
                break;
        };
        return $aplicarCupomLocal;
    };
    $aplicarCupom = verificarCupom($cupom);

    // calcularCupom
    function calcularCupom($aplicarCupom, $subtotal) {
        if ($aplicarCupom == true) {
            $descontoLocal = $subtotal * 0.10;
        } else {
            $descontoLocal = 0;
        };
        return $descontoLocal;
    };
    $desconto = calcularCupom($aplicarCupom, $subtotal);

    // calcularTotal
    function calcularTotal($subtotal, $desconto) {
        $totalLocal = $subtotal - $desconto;
        return $totalLocal;
    };
    $total = calcularTotal($subtotal, $desconto);

    // mensagemPersonalizada
    function mensagemPersonalizada($total) {
        if ($total >= 500) {
            $mensagemLocal = "Obrigado por consumir de forma tão nobre na nossa loja!";
        } else {
            $mensagemLocal = "Obrigado por consumir um produto da nossa loja!";
        };
        return $mensagemLocal;
    };
    $mensagem = mensagemPersonalizada($total);
    
    // mostrarResultadoFinal
    function mostrarResultadoFinal($desconto, $subtotal, $total, $mensagem) {
        ?>
        <p>Desconto: R$<?= $desconto ?></p>
        <p>Subtotal: R$<?= $subtotal ?></p>
        <p>Total: R$<?= $total ?></p>
        <p><?= $mensagem ?></p>
        <?php
    };
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de loja virtual</title>
</head>
<body>
    <header>
        <h1>Sistema de loja virtual</h1>

        <?= mostrarNome($nome) ?>

        <?= mostrarProduto($produto) ?>

        <?= mostrarValorProduto($valorProduto) ?>

        <?= mostrarResultadoFinal($desconto, $subtotal, $total, $mensagem) ?>
    </header>
</body>
</html>