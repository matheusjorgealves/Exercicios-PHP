<?php

    // mysqli_query executa comandos sql, eu passo duas variáveis como parâmetro, a primeira é a conexão e a segunda é o comando sql
    // mysqli_error mostra a última mensagem do mysql, então se houver algum erro ele guarda esse erro e eu posso mostra-lo

    include("conexao.php");

    // criando as variávies
    $nome = "";
    $categoria = "";
    $preco = 0;
    $quantidade = 0;
    $erros = [];
    $resultadoQuery = false;

    // se o método da requisição for post
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // criação das variáveis com as respostas
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
           $erros[] = "Preço não pode ser negativo!";
        };

        // quantidade
        if ($quantidade < 0) {
            $erros[] = "Quantidade não pode ser negativa!";
        };

        // se não houverem erros
        if (empty($erros)) {
            // cria a variável sql
            $sql = "INSERT INTO produtos (nome, categoria, preco, quantidade) VALUES ('$nome', '$categoria', $preco, $quantidade);";
            
            // envia a instrução SQL para o banco e armazena o resultado retornado
            $resultadoQuery = mysqli_query($conexao, $sql);

            // validando a criação do registro
            if ($resultadoQuery === true) {
                $mensagemQuery = "Produto cadastrado com sucesso!";
            } else {
                $erros[] = mysqli_error($conexao);
            };
        };
    };

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto</title>
</head>
<body>
    <header>
        <h1>Cadastrar Produto</h1>

        <?php
            // se o método for post
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // se houverem erros
                if (!empty($erros)) {
                    ?>
                    <ul> <!-- ficarão representados em lista -->
                    <?php
                    foreach ($erros as $erro) {
                        ?>
                        <li>Erro: <?= $erro ?></li>
                        <?php
                    };
                    ?>
                    </ul>
                    <?php
                } else { // se não houverem erros
                    ?>
                    <p><?= $mensagemQuery ?></p>
                    <?php
                };
            };
        ?>

        <form action="" method="post">
            <!-- nome -->
            <label for="nome">Nome do produto:</label>
            <input type="text" name="nome" id="nome" required value="<?= $resultadoQuery == true ? "" : $nome ?>">
            <br> <br>

            <!-- categoria -->
            <label for="categoria">Categoria do produto:</label>
            <input type="text" name="categoria" id="categoria" required value="<?= $resultadoQuery == true ? "" : $categoria ?>">
            <br> <br>

            <!-- preco -->
            <label for="preco">Preço do produto: R$</label>
            <input type="number" name="preco" id="preco" min="0" step="0.01" required value="<?= $resultadoQuery == true ? "" : $preco ?>">
            <br> <br>

            <!-- quantidade -->
            <label for="quantidade">Quantidade em estoque:</label>
            <input type="number" name="quantidade" id="quantidade" min="0" required value="<?= $resultadoQuery == true ? "" : $quantidade ?>">
            <br> <br>

            <button type="submit">Cadastrar</button>
            <br> <br>
        </form>
    </header>
</body>
</html>