<?php

    include ("../conexao.php");

    // criando variáveis
    $erros = [];
    $nome = "";
    $categoria = "";
    $quantidade = 0;
    $preco = 0;

    // se a página for acessada sem passar um id. isset significa "se existir"
    if (!isset($_GET["id"])) {
        echo "Acesse a página com um ID!";
        die;
    } else { // se a página for acessada com um id
        $id = $_GET["id"];
    };

    // variável para armazenar uma instrução sql
    $sql = "SELECT * FROM produtos WHERE id = ?;";

    // statement preparado para receber dados no lugar dos placeholders
    $stmt = mysqli_prepare($conexao, $sql);

    // associando um parâmetro ao placeholder ? do stmt
    mysqli_stmt_bind_param($stmt, "i" ,$id);

    // executando o stmt
    $execucao = mysqli_stmt_execute($stmt);

    // se a execução falhar
    if ($execucao === false) {
        $erros[] = mysqli_stmt_error($stmt);
    } else {
        // recebendo o conjunto de registros retornados pela consulta
        $resultadoSelect = mysqli_stmt_get_result($stmt);

        // buscando próximo (o único, nesse caso) registro do conjunto
        $produto = mysqli_fetch_assoc($resultadoSelect);

        // criando variáveis para receberem os dados do produto
        $nome = $produto["nome"];
        $categoria = $produto["categoria"];
        $quantidade = $produto["quantidade"];
        $preco = $produto["preco"];
    };

    // if o método da requisição for post
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // variáveis para receberem a resposta do form
        $nome = $_POST["nome"];
        $categoria = $_POST["categoria"];
        $quantidade = $_POST["quantidade"];
        $preco = $_POST["preco"];

        // variável para armazenar instrução sql
        $sql = "UPDATE produtos set nome = ?, categoria = ?, quantidade = ?, preco = ? WHERE id = ?;";

        // statement praparado para a associação de dados aos placeholders
        $stmt = mysqli_prepare($conexao, $sql);

        // associando dados aos placeholders do stmt
        mysqli_stmt_bind_param($stmt, "ssidi" ,$nome, $categoria, $quantidade, $preco, $id);

        // executando o stmt
        $execucao = mysqli_stmt_execute($stmt);

        // se houver erro na execução do stmt
        if ($execucao === false) {
            echo "Erro: ". mysqli_stmt_error($stmt);
        } else {
            // redirecionando o usuário para a página inicial
            header ("Location: update001.php");
            die; // encerrando... 
        };
    };
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Produto</title>
</head>
<body>
    <!-- cabeçalho -->
    <header>
        <h1>Alterar Produto</h1>
    </header>

    <!-- corpo -->
    <main>
        <p>Altere o produto no formulário abaixo</p>

        <form action="" method="post">
            <!-- nome -->
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="<?= $nome ?>">
            <br> <br>

            <!-- categoria -->
            <label for="categoria">Categoria:</label>
            <input type="text" name="categoria" id="categoria" value="<?= $categoria ?>">
            <br> <br>

            <!-- quantidade -->
            <label for="quantidade">Quantidade:</label>
            <input type="number" name="quantidade" id="quantidade" value="<?= $quantidade ?>">
            <br> <br>

            <!-- preco -->
            <label for="preco">Preço: R$</label>
            <input type="number" name="preco" id="preco" value="<?= $preco ?>">
            <br> <br>

            <!-- alterar -->
            <button type="submit">Alterar</button>
            <br> <br>
        </form>
    </main>

    <!-- rodapé -->
    <footer>
        <p>Site criado por <a href="https://github.com/matheusjorgealves" target="blanck">Matheus Jorge</a></p>
    </footer>
</body>
</html>