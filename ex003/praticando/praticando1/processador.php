<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado</title>
    <link rel="stylesheet" href="style.css">
</head>
<body id="php">
    
    <?php

        // Método POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = $_POST["nome"];
            $nota1 = $_POST["nota1"];
            $nota2 = $_POST["nota2"];
            $nota3 = $_POST["nota3"];
            $nota4 = $_POST["nota4"];
            $frequencia = $_POST["frequencia"];
            $disciplina = $_POST["disciplina"];
        } else { // Método GET
            $nome = $_GET["nome"];
            $nota1 = $_GET["nota1"];
            $nota2 = $_GET["nota2"];
            $nota3 = $_GET["nota3"];
            $nota4 = $_GET["nota4"];
            $frequencia = $_GET["frequencia"];
            $disciplina = $_GET["disciplina"];
        };

        // Nome
        echo "<header id=php>";
        echo "<h1>Seja bem vindo(a) $nome</h1>";
        echo "</header>";

        // Cálculo das notas --> Notas positivas
        if ($nota1 >= 0 && $nota2 >= 0 && $nota3 >= 0 && $nota4 >= 0) {
            $nota = ($nota1 + $nota2 + $nota3 + $nota4) / 4;
        } else { // Notas negativas
            echo "Valor negativo é inválido";
            exit;
        };

        // Disciplinas
        echo "<main id=php>";
        switch ($disciplina){
            case "matematica":
                echo "<h2>Matemática</h2>";
                echo "<p>Nota = $nota</p>";
                echo "<p>Nota mínima = 6</p>";
                echo "<p>Frequência = $frequencia%</p>";
                echo "<p>Frequência mínima: 70%</p>";

                if ($nota >= 6 && $frequencia >= 70) {
                    $resultado = "aprovado";
                } elseif ($nota >= 4 && $frequencia >= 60) {
                    $resultado = "recuperacao";
                } else {
                    $resultado = "reprovado";
                };
                break;

            case "portugues":
                echo "<h2>Português</h2>";
                echo "<p>Nota = $nota</p>";
                echo "<p>Nota mínima = 5</p>";
                echo "<p>Frequência = $frequencia%</p>";
                echo "<p>Frequência mínima: 60%</p>";
                
                if ($nota >= 5 && $frequencia >= 60) {
                    $resultado = "aprovado";
                } elseif ($nota >= 4 && $frequencia >= 50) {
                    $resultado = "recuperacao";
                } else {
                    $resultado = "reprovado";
                };
                break;

            case "historia":
                echo "<h2>História</h2>";
                echo "<p>Nota = $nota</p>";
                echo "<p>Nota mínima = 8</p>";
                echo "<p>Frequência = $frequencia%</p>";
                echo "<p>Frequência mínima: 80%</p>";

                if ($nota >= 8 && $frequencia >= 80) {
                    $resultado = "aprovado";
                } elseif ($nota >= 6 && $frequencia >= 60) {
                    $resultado = "recuperacao";
                } else {
                    $resultado = "reprovado";
                };
                break;

            case "geografia":
                echo "<h2>Geografia</h2>";
                echo "<p>Nota = $nota</p>";
                echo "<p>Nota mínima = 4</p>";
                echo "<p>Frequência = $frequencia%</p>";
                echo "<p>Frequência mínima: 40%</p>";

                if ($nota >= 4 && $frequencia >= 40) {
                    $resultado = "aprovado";
                } elseif ($nota >= 3 && $frequencia >= 35) {
                    $resultado = "recuperacao";
                } else {
                    $resultado = "reprovado";
                };
                break;   

            case "ingles":
                echo "<h2>Inglês</h2>";
                echo "<p>Nota = $nota</p>";
                echo "<p>Nota mínima = 9</p>";
                echo "<p>Frequência = $frequencia%</p>";
                echo "<p>Frequência mínima: 90%</p>";

                if ($nota >= 9 && $frequencia >= 90) {
                    $resultado = "aprovado";
                } elseif ($nota >= 7 && $frequencia >= 70) {
                    $resultado = "recuperacao";
                } else {
                    $resultado = "reprovado";
                };
                break;
        };
        
        // Resultado final
        switch ($resultado) {
            case "aprovado":
                $cor = "green";
                echo "<h2 id=$cor>Resultado: Aprovado(a)</h2>";
                break;

            case "recuperacao":
                $cor = "yellow";
                echo "<h2 id=$cor>Resultado: Recuperação</h2>";
                break;    

            case "reprovado":
                $cor = "red";
                echo "<h2 id=$cor>Resultado: Reprovado(a)</h2>";
                break;
        };

        // Botão voltar
        echo
            "<form action=index.html method=post id=php> 
                <button type=submit id=php>Voltar</button>
            </form>"
        ;    

        // Fim do Main
        echo "</main>";

    ?>



</body>
</html>