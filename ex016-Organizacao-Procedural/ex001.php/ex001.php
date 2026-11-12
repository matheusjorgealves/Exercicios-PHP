<?php

    // funções para calcular e verificar o desconto e o preco da compra
    function verificarDesconto($preco, $desconto) {
        // vou preservar 20% do preco do livro
        $precoPreservado = ($preco / 100) * 20;

        // valor do desconto
        $valorDesconto = $preco * ($desconto / 100);

        // preco com o desconto aplicado
        $precoFinal = $preco - $valorDesconto;

        // se o preco final for inferior a 20% do preco inicial
        if ($precoFinal < $precoPreservado) {
            return false;
        } else {
            return $precoFinal;
        }
    }

    function calcularCompra($preco, $quantidade) {
        return $preco * $quantidade;
    }

    // incializando variável
    $erros = [];

    // se o método da requisição for post
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // se o preco não existir
        if (!isset($_POST["preco"])) {
            $erros[] = "Informe o preço!";
        } else {
            $preco = $_POST["preco"];

            // validando o preco
            if ($preco < 0) {
                $erros[] = "O preço não pode ser negativo!";
            }
        }

        if (empty($erros)) {
            // USUÁRIO QUER CALCULAR O DESCONTO
            if (isset($_POST["desconto"])) {
                $desconto = $_POST["desconto"];

                // validando o desconto
                if ($desconto < 0) {
                    $erros[] = "O desconto não pode ser negativo!";
                } elseif ($desconto >= 100) {
                    $erros[] = "O desconto não pode ser superior a 100%!";
                }

                // chamando a função para verficar o desconto em relação ao preco
                $descontoVerificado = verificarDesconto($preco, $desconto);

                // chamando a função para verificar o desconto em relação ao preco
                if ($descontoVerificado === false) {
                    $erros[] = "O desconto não pode ser acima de 80% do preço do livro!";
                }

                // se não houverem erros 
                if (empty($erros)) {
                    $mensagem = "O preço do livro com o desconto de R$$desconto aplicado é R$descontoVerificado!";
                }
            }
            // USUÁRIO QUER CALCULAR O VALOR DA COMPRA
            elseif (isset($_POST["quantidade"])) {
                // se a quantidade não for um número inteiro
                if (filter_var($_POST["quantidade"], FILTER_VALIDATE_INT) === false) {
                    $erros[] = "A quantidade deve ser um número inteiro!";
                } else {
                    $quantidade = $_POST["quantidade"];

                    if ($quantidade < 1) {
                        $erros[] = "A quantidade não pode ser nula ou negativa!";
                    } else {
                        // chamando a function
                        $precoCompra = calcularCompra($preco, $quantidade);

                        $mensagem = "O preço da compra de $quantidade livro(s) é R$$precoCompra!";
                    }
                }
            } else {
                $erros[] = "Preencha os formulários!";
            }
        }
        
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papelaria Horizonte</title>
</head>
<body>
    <header>
        <h1>Papelaria Horizonte</h1>
    </header>

    <main>

        <?php
        // se o método da requisição for post
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // se houverem erros
            if (!empty($erros)) {
                foreach ($erros as $erro) {
                    ?>
                    <p>Erro: <?= htmlspecialchars($erro, ENT_QUOTES, "UTF-8") ?></p>
                    <?php
                }
            } else {
                // se a mensagem existir
                if (isset($mensagem)) {
                    ?>
                    <p><?= htmlspecialchars($mensagem, ENT_QUOTES, "UTF-8") ?></p>
                    <?php
                }
            }
        }
        ?>

        <h2>Calcular o valor do livro com desconto aplicado:</h2>
        <form action="" method="post">
            <!-- preco -->
            <label for="preco">Preço da unidade: R$</label>
            <input type="number" name="preco" id="preco" min="0" step="0.1" required>
            <br> <br>

            <!-- desconto -->
            <label for="desconto">Desconto:</label>
            <input type="number" name="desconto" id="desconto" min="0" step="0.1" required>
            <br> <br>

            <!-- button calcular -->
            <button type="submit">Calcular</button>
            <br> <br>
        </form>

        <h2>Calcular o valor da compra de livros:</h2>
        <form action="" method="post">
            <!-- preco -->
            <label for="preco">Preço da unidade: R$</label>
            <input type="number" name="preco" id="preco" min="0" step="0.1" required>
            <br> <br>

            <!-- quantidade -->
            <label for="quantidade">Quantidade de livros:</label>
            <input type="number" name="quantidade" id="quantidade" min="1" required>
            <br> <br>

            <!-- button calcular -->
            <button type="submit">Calcular</button>
            <br> <br>
        </form>
    </main>

    <footer>
        <p>Site desenvolvido por <a href="https://GitHub.com/matheusjorgealves/" target="_blank">Matheus Jorge</a></p>
    </footer>
</body>
</html>