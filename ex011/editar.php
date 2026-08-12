<?php

    // incluindo o conexao.php
    include ("conexao.php");

    // se id foi passado através da requisição GET
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
    } else { // se não veio nenhum id através da requisição GET
        echo "Erro!";
        die;
    };
    
    // trazendo o registro do id correpondente
    $sql = "SELECT * FROM produtos WHERE id = ".$id.";";

    // realizando consulta
    $resultadoConsulta = mysqli_query($conexao, $sql);

    // se houver erro na consulta
    if ($resultadoConsulta === false) {
        $erro = mysqli_error($conexao);
        echo ("Erro: $erro");
    } else { // se não houverem erros na consulta
        $produto = mysqli_fetch_assoc($resultadoConsulta);
    };

    // declarando as variáveis
    $nome = $produto["nome"];
    $categoria = $produto["categoria"];
    $preco = $produto["preco"];
    $quantidade = $produto["quantidade"];
    $erros = [];

    // se o método da requisição for POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = trim($_POST["nome"]);
        $categoria = trim($_POST["categoria"]);
        $preco = $_POST["preco"];
        $quantidade = $_POST["quantidade"];

        // validações
        // nome
        if (empty($nome)) {
            $erros[] = "Nome inválido!";
        };

        // categoria
        if (empty($categoria)) {
            $erros[] = "Categoria inválida!";
        };

        // preco
        if ($preco < 0) {
            $erros[] = "Preço inválido!";
        };

        // quantidade
        if ($quantidade < 0) {
            $erros[] = "Quantidade inválida!";
        };

        // se não houverem erros
        if (empty($erros)) {
            // comando sql update
            $sql = 
            "UPDATE produtos 
            SET nome = '".$nome."', categoria = '".$categoria."', preco = ".$preco.", quantidade = ".$quantidade."
            WHERE id = ".$id.";";

            // executando o comando sql
            $resultadoUpdate = mysqli_query($conexao, $sql);

            // validando o resultado do comando
            if ($resultadoUpdate === false) {
                $erros[] = mysqli_error($conexao);
            } else { // se deu certo
                // redirecionando usuário pra index.php
                header("Location: index.php");
                // parando a execução
                die;
            };
        };
    };

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Produto</title>
</head>
<body>
    <header>
        <h1>Atualizar Produto</h1>
    </header>

    <main>
        <h2>Atualize os dados do produto</h2>

        <?php
            // se houverem erros
            if (!empty($erros)) {
                foreach ($erros as $erro) {
                    ?>
                    <p>Erro: <?= $erro ?></p>
                    <?php
                };
            };
        ?>

        <form action="" method="post">
            <!-- nome -->
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required value="<?= $nome ?>"> 
            <br> <br>

            <!-- categoria -->
            <label for="categoria">Categoria:</label>
            <input type="text" name="categoria" id="categoria" required value="<?= $categoria ?>">
            <br> <br>

            <!-- preco -->
            <label for="preco">Preço: R$</label>
            <input type="number" name="preco" id="preco" min="0" step="0.01" required value="<?= $preco ?>">
            <br> <br>

            <!-- quantidade -->
            <label for="quantidade">Quantidade:</label>
            <input type="number" name="quantidade" id="quantidade" min="0" step="1" required value="<?= $quantidade ?>">
            <br> <br>

            <!-- botão -->
            <button type="submit">Atualizar</button>
        </form>
    </main>
</body>
</html>