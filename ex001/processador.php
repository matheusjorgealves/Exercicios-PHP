<?php // assim que inicia-se um código PHP

$metodo = $_SERVER["REQUEST_METHOD"]; 
    // indentificando o método de envio

if ($metodo == "POST") {
    $nome = $_POST["nome"];
    $idade = $_POST["idade"];
    $profissao = $_POST["profissao"];
    $salario = $_POST["salario"];
    $experiencia = $_POST["experiencia"];
} else {
    $nome = $_GET["nome"];
    $idade = $_GET["idade"];
    $profissao = $_GET["profissao"];
    $salario = $_GET["salario"];
    $experiencia = $_GET["experiencia"];
}

echo "<h2>Dados Recebidos</h2>";

echo "Nome: $nome <br>";
echo "Idade: $idade <br>";
echo "Profissão: $profissao <br>";
echo "Salário pretendido: $salario <br>";
echo "Experiência anterior: $experiencia <br><br>";

echo "<h3>Mensagem personalizada para você</h3>";
echo "Olá, $nome! Vimos que você atua como $profissao. 
Desejamos sucesso na sua carreira profissional!";

echo "<hr>";

/*
PHP não é interpretado pelo navegador.

Acesse na URl (com o apache ligado):
    http://localhost/DS-modulo2/agenda2-ds/index.html
*/
?>