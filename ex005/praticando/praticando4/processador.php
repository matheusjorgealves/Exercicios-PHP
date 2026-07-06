<?php
    $metodo = ($_SERVER["REQUEST_METHOD"]);

    // criando o array livros
    $livros = [
        "Dom Casmurro",
        "O Pequeno Príncipe",
        "Percy Jackson",
        "Harry Potter",
        "Turma da Mônica"
    ];

    if ($metodo == "POST") {
        $consultar = $_POST["consultar"];
        $alterar = $_POST["alterar"];
        $alterarNome = $_POST["alterarNome"];
        $adicionar = $_POST["adicionar"];
    } else{
        $consultar = $_GET["consultar"];
        $alterar = $_GET["alterar"];
        $alterarNome = $_GET["alterarNome"];
        $adicionar = $_GET["adicionar"];
    };
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
</head>
<body>
    <h1>Resultado:</h1>

    <?php
        // consultar
        switch ($consultar) {
            case 0: ?>
                <p>O livro que você escolheu consultar é: <?= $livros[0] ?></p>
                <?php
                break;

            case 1: ?>
                <p>O livro que você escolheu consultar é: <?= $livros[1] ?></p>
                <?php
                break;

            case 2: ?>
                <p>O livro que você escolheu consultar é: <?= $livros[2] ?></p>
                <?php
                break;

            case 3: ?>
                <p>O livro que você escolheu consultar é: <?= $livros[3] ?></p>
                <?php
                break;

            case 4: ?>
                <p>O livro que você escolheu consultar é: <?= $livros[4] ?></p>
                <?php
                break;

            default: ?>
                <p>O livro que você escolheu consultar é inválido!</p>
                <?php
                exit;
                break;
        };

        // alterar
        switch ($alterar) {
            case 0: ?>
                <p>Você alterou o livro <?= $livros[0] ?> para <?= $alterarNome ?></p>
                <?php
                $livros[0] = $alterarNome;
                break;

            case 1: ?>
                <p>Você alterou o livro <?= $livros[1] ?> para <?= $alterarNome ?></p>
                <?php
                $livros[1] = $alterarNome;
                break;

            case 2: ?>
                <p>Você alterou o livro <?= $livros[2] ?> para <?= $alterarNome ?></p>
                <?php
                $livros[2] = $alterarNome;
                break;

            case 3: ?>
                <p>Você alterou o livro <?= $livros[3] ?> para <?= $alterarNome ?></p>
                <?php
                $livros[3] = $alterarNome;
                break;

            case 4: ?>
                <p>Você alterou o livro <?= $livros[4] ?> para <?= $alterarNome ?></p>
                <?php
                $livros[4] = $alterarNome;
                break;
        };

        // adicionar
        $livros[] = $adicionar;

        // exibir catálogo
        ?>
        <table>
            <tr>
                <th>Índice</th>
                <th>Livro</th>
            </tr>
            <tr>
                <td>0</td>
                <td><?= $livros[0] ?></td>
            </tr>
            <tr>
                <td>1</td>
                <td><?= $livros[1] ?></td>
            </tr>
            <tr>
                <td>2</td>
                <td><?= $livros[2] ?></td>
            </tr>
            <tr>
                <td>3</td>
                <td><?= $livros[3] ?></td>
            </tr>
            <tr>
                <td>4</td>
                <td><?= $livros[4] ?></td>
            </tr>
            <tr>
                <td>5</td>
                <td><?= $livros[5] ?></td>
            </tr>
        </table>
        <?php
    ?>
</body>
</html>