<?php

    // criação das funções
    function calcularIMC($peso, $altura) {
        $imcLocal = $peso / ($altura * $altura);
        return $imcLocal;
    };

    function verificarIMC($imc) {
        if ($imc < 18.5) {
            $situacaoIMC = "Baixo peso!";
        } elseif ($imc >= 18.5 && $imc < 25) {
            $situacaoIMC = "Peso normal!";
        } elseif ($imc >= 25 && $imc < 30) {
            $situacaoIMC = "Sobrepeso!";
        } else {
            $situacaoIMC = "Obesidade!";
        };
        return $situacaoIMC;
    };

    // declarando as variáveis
    $nome = "";
    $peso = 3;
    $altura = 0.40;
    $mensagens = []; // array para guardar as mensagens
    $erros = []; // array para guardar os erros
    $imc = 0;

    // se o método da requisição for post 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = trim($_POST["nome"]);
        $peso = $_POST["peso"];
        $altura = $_POST["altura"];  

        // validações
        if (empty($nome)) { // se o nome estiver vazio
            $erros[] = "Nome inválido!";
        } else {
            $mensagens[] = "Nome: $nome";
        };
        
        if (empty($peso)) {
            $erros[] = "Peso inválido!";
        } elseif ($peso < 3) { // se o peso for menor que 0
            $erros[] = "Peso inválido!"; 
        } else {
            $mensagens[] = "Peso: $peso";
        };

        if (empty($altura)) {
            $erros[] = "Altura inválida!";
        } elseif ($altura < 0.40 || $altura > 3.0) { // altura irregular
            $erros[] = "Altura inválida!";
        } else {
            $mensagens[] = "Altura: $altura";
        };
    };
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora IMC</title>
</head>
<body>
    <header>
        <h1>Calculadora IMC</h1>

        <?php
            // se não houver erros
            if (empty($erros)) {
                // chamando as funções
                $imc = calcularIMC($peso, $altura);
                $mensagens[] = "IMC = $imc";

                $mensagens[] = verificarIMC($imc);
            } else {
                // percorrendo o array erros
                foreach ($erros as $erro) {
                    ?>
                    <p><?= $erro ?></p>
                    <?php
                };
            };
            
            // percorrendo o array mensagens
            foreach ($mensagens as $mensagem) {
                ?>
                <p><?= $mensagem ?></p>
                <?php
            };
        ?>

        <form action="" method="post">
            <!-- nome -->
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="<?= $_SERVER["REQUEST_METHOD"] == "POST" ? "$nome" : "" ?>">
            <br> <br>

            <!-- peso -->
            <label for="peso">Peso:</label>
            <input type="number" name="peso" id="peso" value="<?= $_SERVER["REQUEST_METHOD"] == "POST" ? "$peso" : "" ?>" min="3">KG
            <br> <br>

            <!-- altura -->
            <label for="altura">Altura:</label>
            <input type="number" name="altura" id="altura" value="<?= $_SERVER["REQUEST_METHOD"] == "POST" ? "$altura" : "" ?>" min="0.40" max="3.0" step="0.01">
            <br> <br>

            <button type="submit">Calcular</button>
            <br> <br>
        </form>
    </header>
</body>
</html>