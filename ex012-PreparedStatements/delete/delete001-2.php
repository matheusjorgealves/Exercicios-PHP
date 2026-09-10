<?php

    // incluindo o arquivo da conexão com o banco de dados
    include ("../conexao.php");

    // se não existir um id através do método get, ou seja, acessaram a página sem um id
    if (!isset($_GET["id"])) {
        echo "Erro, acesse a página através do link da página inicial!";
        die; // encerrando a execução
    };

    // recebendo o id passado através do método get
    $id = $_GET["id"];

    // variável para armazenar uma instrução sql
    $sql = "SELECT * FROM produtos WHERE id = ?;";

    // statement preparado para a associação de dados aos placeholders
    $stmt = mysqli_prepare($conexao, $sql);

    // associando o dado ao placeholder
    mysqli_stmt_bind_param($stmt, "i" ,$id);

    // executando o statement
    $execucao = mysqli_stmt_execute($stmt);

    // se houver erro na execução do stmt
    if ($execucao === false) {
        echo "Erro!";
        die; // encerrando a execução
    } else {
        // recebendo um conjunto de registros (apenas 1, nesse caso) 
        $resultadoSelect = mysqli_stmt_get_result($stmt);

        $produto = mysqli_fetch_assoc($resultadoSelect);
    };

    // se o método da requisição for post e se o buttonExcluir existir
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["buttonExcluir"])) {
        // variável para armazenar uma instrução sql
        $sql = "DELETE FROM produtos WHERE id = ?";

        // statement preparado para a associação de dados aos placeholders
        $stmt = mysqli_prepare($conexao, $sql);

        // associando o dado ao placeholder do stmt
        mysqli_stmt_bind_param($stmt, "i" ,$id);

        // executando o statement
        $execucao = mysqli_stmt_execute($stmt);

        // se houver erro na execução
        if ($execucao === false) {
            echo "ERRO!";
            die;
        } else { // se o DELETE for executado
            // redirecionando o usuário para a página inicial
            header ("Location: delete001.php");
            die;
        };
    };
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exclusão de Registros</title>
</head>
<body>
    <!-- cabeçalho -->
    <header>
        <h1>Exclusão de Registros</h1>
    </header>

    <!-- corpo -->
    <main>
        <p>Produto selecionado para exclusão logo abaixo!</p>

        <table>
            <!-- cabeçalho da table -->
            <thead>
                <throw>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                </throw>
            </thead>

            <!-- corpo da table -->
            <tbody>
                <tr>
                    <td><?= $produto["id"] ?></td>
                    <td><?= $produto["nome"] ?></td>
                    <td><?= $produto["categoria"] ?></td>
                    <td><?= $produto["quantidade"] ?></td>
                    <td><?= $produto["preco"] ?></td>
                </tr>
            </tbody>
        </table>

        <!-- formulário para os botões -->
        <form action="" method="post" onsubmit="return confirm('Tem certeza que deseja excluir este produto?')">
            <!-- voltar -->
            <button type="button"><a href="delete001.php">Voltar</a></button>
            
            <!-- excluir -->
            <button type="submit" name="buttonExcluir">Excluir</button>
        </form>
    </main>
</body>
</html>