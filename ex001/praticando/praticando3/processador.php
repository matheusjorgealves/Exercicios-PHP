<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado</title>
    <link rel="stylesheet" href="resultado.css">
</head>
<body>
    
    <?php

    $metodo = $_SERVER["REQUEST_METHOD"];

    if ($metodo == "POST") {
        $tipoCalc = $_POST["tipoCalc"];
        $n1 = $_POST["n1"];
        $n2 = $_POST["n2"];
    } elseif ($metodo == "GET") {
        $tipoCalc = $_GET["tipoCalc"];
        $n1 = $_GET["n1"];
        $n2 = $_GET["n2"];
    }

    echo "<h1>Resultado:</h1> ";

    if ($tipoCalc == "adicao") {
        $resultado = $n1 + $n2;
    } elseif ($tipoCalc == "subtracao") {
        $resultado = $n1 - $n2;
    } elseif ($tipoCalc == "multiplicacao") {
        $resultado = $n1 * $n2;
    } else {
        $resultado = $n1 / $n2;
    }

    echo "<p>1° número: ".$n1."</p>";
    echo "<p>2° número: ".$n2."</p>";
    echo "<p>Operação escolhida: ".$tipoCalc."</p>";
    echo "<p>Resultado:".$resultado."</p>";

    ?>

</body>
</html>