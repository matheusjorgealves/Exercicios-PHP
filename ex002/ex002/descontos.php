<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // se o método de envio for POST

        $nome = $_POST["txtNome"];
        $valorCompra = $_POST["txtValorCompra"];
        $formaPagamento = $_POST["cmbPag"];
        $desconto = 0;
        $valorFinal = 0;
    } // conversão das repostas para variáveis

    if ($formaPagamento == "cartaoCredito") {
        // sem desconto

        $valorFinal = $valorCompra - $desconto;
        $mensagem = "Olá $nome, sua compra de R$$valorCompra foi realizada com cartão de crédito. Não há desconto. Valor a pagar: R$$valorFinal";

    } elseif ($formaPagamento == "boleto") {
        // desconto de 8%

        $desconto = $valorCompra * 0.08; 
        $valorFinal = $valorCompra - $desconto;
        $mensagem = "Olá $nome, sua compra de R$$valorCompra foi realizada com boleto. Seu desconto é de R$ $desconto. Valor a pagar: R$$valorFinal";

    } elseif ($formaPagamento == "deposito") {
        // desconto de 10%

        $desconto = $valorCompra * 0.10;
        $valorFinal = $valorCompra - $desconto;
        $mensagem = "Olá $nome, sua compra de R$$valorCompra foi realizada com depósito. Seu desconto é de R$ $desconto. Valor a pagar: R$$valorFinal";

    } else {

        $mensagem = "Forma de pagamento inválida.";
    }

    // se o valor da compra for negativo
    if ($valorCompra < 0) {
        echo "O valor da compra não pode ser negativo";
        exit; // vai parar a execução
    }

    echo "<div class='w3-panel w3-green'>$mensagem</div>";
    // saída já formatada para o usuário
    
    
?>