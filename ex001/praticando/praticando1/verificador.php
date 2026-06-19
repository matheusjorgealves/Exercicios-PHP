<?php // início do arquivo .php

$metodo = $_SERVER["REQUEST_METHOD"]; // método de envio

if ($metodo == "POST") { // se for post
    $resp1 = $_POST["resp1"];
    $resp2 = $_POST["resp2"];
    $resp3 = $_POST["resp3"];
} else { // se for get
    $resp1 = $_GET["resp1"];
    $resp2 = $_GET["resp2"];
    $resp3 = $_GET["resp3"];
}


if (strtolower($resp1) == "uruguai") { // verificando resposta 1
    echo "<p> Resposta 1 Correta </p>";
} else {
    echo "<p> Resposta 1 Incorreta </p>";
}

if ($resp2 == "1962") { // verificando resposta 2
    echo "<p> Resposta 2 Correta </p>";
} else {
    echo "<p> Resposta 2 Incorreta </p>";
}

if (strtolower($resp3) == "argentina") { // verificando resposta 3
    echo "<p> Resposta 3 Correta </p>";
} else {
    echo "<p> Resposta 3 Incorreta </p>";
}