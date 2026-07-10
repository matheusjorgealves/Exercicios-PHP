<?php
    // método de envio do form
    $metodo = ($_SERVER["REQUEST_METHOD"]);

    // array filmes
    $filmes = [
        // array dentro de filmes
        [
            "titulo" => "300",
            "genero" => "acao",
            "lancamento" => "12/12/2000",
            "preco" => 50,
            "quantidade" => 27
        ],

        [
            "titulo" => "Gente Grande",
            "genero" => "comedia",
            "lancamento" => "10/05/2004",
            "preco" => 30,
            "quantidade" => 7
        ],

        [
            "titulo" => "Vingadores",
            "genero" => "ação",
            "lancamento" => "30/03/2010",
            "preco" => 67,
            "quantidade" => 47
        ],

        [
            "titulo" => "A Freira",
            "genero" => "terror",
            "lancamento" => "03/11/2016",
            "preco" => 88.9,
            "quantidade" => 86
        ]
    ];

    if ($metodo == "POST") { // método post
        $titulo = $_POST["titulo"];
        $genero = $_POST["genero"];
        $lancamento = $_POST["lancamento"];
        $preco = $_POST["preco"];
        $quantidade = $_POST["quantidade"];
    } else { // método get
        $titulo = $_GET["titulo"];
        $genero = $_GET["genero"];
        $lancamento = $_GET["lancamento"];
        $preco = $_GET["preco"];
        $quantidade = $_GET["quantidade"];
    };

    // percorre o array $filmes. os internos = $filme
    foreach ($filmes as $filme) {
        // se o filme a cadastrar já estiver cadastrado
        if ($filme["titulo"] == $titulo) {
            ?>
            <p>[ERRO]: Filme já consta em cadastro!</p>
            <?php
            exit;
        }
    };

    // inserindo o filme ao array
    $filmes[] = [
        "titulo" => $titulo,
        "genero" => $genero,
        "lancamento" => $lancamento,
        "preco" => $preco,
        "quantidade" => $quantidade
        ];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locadora do Vini</title>
</head>
<body>
    <header>
        <h1>Locadora do Vini</h1>
    </header>

    <main>
        <h2>Filmes da locadora:</h2>

        <?php
            // saída de dados dos filmes
            foreach ($filmes as $indice => $filme) {
                $indice++; // começará no 1
                ?>
                <hr>
                <p>Filme: <?= $indice ?></p>
                <?php
                foreach ($filme as $chave => $informacoes) {
                    // switch para personalizar ainda mais a saída
                    switch ($chave) {
                        case "titulo":
                            ?>
                            <p>Título: <?= $informacoes ?></p>
                            <?php
                            break;

                        case "genero":
                            ?>
                            <p>Gênero: <?= $informacoes ?></p>
                            <?php
                            break;

                        case "lancamento":
                            ?>
                            <p>Lançamento: <?= $informacoes ?></p>
                            <?php
                            break;

                        case "preco":
                            ?>
                            <p>Preço: R$<?= $informacoes ?></p>
                            <?php
                            break;

                        default:
                            ?>
                            <p><?= $chave ?>: <?= $informacoes ?></p>
                            <?php
                    };
                };
            };
        ?>

        <hr>
        <p>Existem <?= $indice ?> Filmes cadastrados!</p>
    </main>
</body>
</html>