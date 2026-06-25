<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado</title>
    <link rel="stylesheet" href="processador.css">
</head>
<body>

    <?php

    // recebendo as respostas e transformando-as em variáveis
    $nome = $_POST["nome"];
    $valor = $_POST["valor"];
    $pagamento = $_POST["pagamento"];

    echo "<h1> Resultado: </h1>";
    echo "<p> Parabéns ".$nome.", você concluiu sua compra! </p>";
    echo "<p> Valor da sua compra: R$".$valor."</p>";

    // verificando a forma de pagamento e aplicando desconto
    if ($pagamento == "cartao") {
        $desconto = $valor * 0.07;
    } elseif ($pagamento == "boleto") {
        $desconto = $valor * 0.08;
    } elseif ($pagamento == "deposito") {
        $desconto = $valor * 0.09;
    };

    // saída
    $total = $valor - $desconto;
    echo "<p> Desconto recebido: R$".$desconto."</p>";
    echo "<p> Total a pagar: R$".$total."</p>";
    
    ?>

</body>
</html>