<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra efetuada</title>
    <link rel="stylesheet" href="processador.css">
</head>
<body>
    
    <?php

        // Se o método de envio do formulário for GET
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $nome = $_GET["nome"];
            $bebida = $_GET["bebida"];
            $quantidade = $_GET["quantidade"];
            $pagamento = $_GET["pagamento"];
        } else { // se for POST
            $nome = $_POST["nome"];
            $bebida = $_POST["bebida"];
            $quantidade = $_POST["quantidade"];
            $pagamento = $_POST["pagamento"];
        };

        // Estrutura para agregar um preço a diferentes bebidas
        switch ($bebida) {
            case "refrigerante":
                $valor = 8;
                break;
            
            case "cerveja":
                $valor = 12;
                break;

            case "destilados":
                $valor = 10;
                break;
                
            case "batidas":
                $valor = 18;
                break;
                
            case "agua":
                $valor = 5;
                break;    
        };

        // Atribuir mudanças de preços em virtude da quantidade
        switch ($quantidade) {
            case "dose":
                $precoQuantidade = 3;
                $valorQuantidade = $valor - $precoQuantidade;
                break;
            
            case "lata":
                $precoQuantidade = 1;
                $valorQuantidade = $valor - $precoQuantidade;
                break;

            case "litro";
                $precoQuantidade = 5;
                $valorQuantidade = $valor + $precoQuantidade;
                break;    
        };

        // Estrutura para criar descontos ou acréscimos
        switch ($pagamento) {
            case "pix":
                $desconto = $valorQuantidade * 0.05;
                break;
            
            case "debito":
                $desconto = 0;
                break;

            case "credito":
                $acrescimo = $valorQuantidade * 0.05;
                break;
        };

        // Saída e checagem se receberá desconto ou acréscimo
        switch ($pagamento) {
            // Pix == desconto
            case "pix":
                echo "<h1>Sua compra foi concluída com sucesso, $nome</h1>";
                echo "<h2>Detalhes da compra: </h2>";
                echo "<p>Bebida: $bebida = R$$valor</p>";

                // se a quantidade for abaixar o valor da bebida
                if ($quantidade == "dose") {
                    echo "<p>Quantidade: $quantidade = R$$valor - R$$precoQuantidade</p>";
                } elseif ($quantidade == "lata") {
                    echo "<p>Quantidade: $quantidade = R$$valor - R$$precoQuantidade</p>";
                } else { // se for aumentar
                    echo "<p>Quantidade: $quantidade = R$$valor + R$$precoQuantidade</p>";
                };

                echo "<p>Forma de pagamento = $pagamento</p>";
                echo "<p>Desconto = R$$desconto</p>";

                $total = $valorQuantidade - $desconto;

                echo "<p>Total a pagar = R$$total</p>";
                break;

            // Débito == desconto é zero
            case "debito":
                echo "<h1>Sua compra foi concluída com sucesso, $nome</h1>";
                echo "<h2>Detalhes da compra: </h2>";
                echo "<p>Bebida: $bebida = R$$valor</p>";

                // se a quantidade for abaixar o valor da bebida
                if ($quantidade == "dose") {
                    echo "<p>Quantidade: $quantidade = R$$valor - R$$precoQuantidade</p>";
                } elseif ($quantidade == "lata") {
                    echo "<p>Quantidade: $quantidade = R$$valor - R$$precoQuantidade</p>";
                } else { // se for aumentar
                    echo "<p>Quantidade: $quantidade = R$$valor + R$$precoQuantidade</p>";
                };

                echo "<p>Forma de pagamento = $pagamento</p>";
                echo "<p>Desconto = R$$desconto</p>";

                $total = $valorQuantidade - $desconto;

                echo "<p>Total a pagar = R$$total</p>";
                break;    

            // Crédito == acréscimo
            case "credito":
                echo "<h1>Sua compra foi concluída com sucesso, $nome</h1>";
                echo "<h2>Detalhes da compra: </h2>";
                echo "<p>Bebida: $bebida = R$$valor</p>";

                // se a quantidade for abaixar o valor da bebida
                if ($quantidade == "dose") {
                    echo "<p>Quantidade: $quantidade = R$$valor - R$$precoQuantidade</p>";
                } elseif ($quantidade == "lata") {
                    echo "<p>Quantidade: $quantidade = R$$valor - R$$precoQuantidade</p>";
                } else { // se for aumentar
                    echo "<p>Quantidade: $quantidade = R$$valor + R$$precoQuantidade</p>";
                };

                echo "<p>Forma de pagamento = $pagamento</p>";
                echo "<p>Acréscimo = R$$acrescimo</p>";

                $total = $valorQuantidade + $acrescimo;

                echo "<p>Total a pagar = R$$total</p>";
                break;
        };

        /* Antes eu havia pensado na estrutura if else, mas eu optei por switch
        if ($desconto) {
            echo "<h1>Sua compra foi concluída com sucesso, $nome</h1>";
            echo "<h2>Detalhes da compra: </h2>";
            echo "<p>Bebida: $bebida = R$</p>";
            echo "<p>Quantidade = $quantidade</p>";
            echo "<p>Forma de pagamento = $pagamento</p>";

            $total = $valorQuantidade - $desconto;

            echo "<p>Total a pagar = R$</p>";
        } else {
            echo "<h1>Sua compra foi concluída com sucesso, $nome</h1>";
            echo "<h2>Detalhes da compra: </h2>";
            echo "<p>Bebida: $bebida = R$</p>";
            echo "<p>Quantidade = $quantidade</p>";
            echo "<p>Forma de pagamento = $pagamento</p>";

            $total = $valorQuantidade + $acrescimo;

            echo "<p>Total a pagar = R$</p>";
        };
        */

    ?>

</body>
</html>