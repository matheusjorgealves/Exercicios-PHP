<?php

    // objetivo: página com formulário simples que permita ao usuário informar uma categoria

    // incluindo a conexão com o banco de dados
    include ("../conexao.php");

    // caso o usuário tenha enviado o form
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // recebendo a resposta do usuário
        $categoria = $_POST["categoria"];

        // variável para armazenar uma instrução sql
        $sql = "SELECT * FROM produtos WHERE categoria = ?;";

        // statement preparado e criado a partir da conexão e da instrução SQL 
        $stmt = mysqli_prepare($conexao, $sql);

        // associando $categoria (tipo string = "s") ao ? do stmt
        mysqli_stmt_bind_param($stmt, "s", $categoria);

        // executando statement e armazenando o resultado (bool)
        $execucao = mysqli_stmt_execute($stmt);

        // se houver erro na execução do stmt
        if ($execucao === false) {
            $erro = mysqli_stmt_error($stmt);
            echo "Erro: ". $erro;
        } else {
            // recebendo o resultado do conjunto de registros do stmt
            $resultadoSelect = mysqli_stmt_get_result($stmt);

            // armazenando os conjuntos de registros em um array
            while ($produto = mysqli_fetch_assoc($resultadoSelect)) {
                $produtos[] = $produto;
            };

            foreach ($produtos as $indice => $produto) {
                $indice++;
                echo "<p>Produto $indice:</p>";
                echo "Id: ". $produto["id"] ."<br>";
                echo "Nome: ".$produto["nome"] ."<br>";
                echo "Categoria: ".$produto["categoria"] ."<br>";
                echo "Quantidade: ".$produto["quantidade"] ."<br>";
                echo "Preço: R$".$produto["preco"] ."<br>";
            };
        };
    };

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qual categoria?</title>
</head>
<body>
    <h1>Escolha uma categoria</h1>

    <!-- formulário post -->
    <form action="" method="post">
        <!-- select -->
        <select name="categoria" id="categoria">Categoria
            <option value="Perifericos">Periféricos</option>
            <option value="Eletronicos">Eletrônicos</option>
            <option value="Moveis">Móveis</option>
            <option value="Audio">Aúdio</option>
        </select>

        <!-- botão -->
        <button type="submit">Enviar</button>
    </form>
</body>
</html>