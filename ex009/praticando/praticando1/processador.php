<?php

    // array produtos
    $produtos = [
        [
            "nome" => "Playstation 5",
            "categoria" => "gamer",
            "preco" => 3500,
            "quantidade" => 54
        ],

        [
            "nome" => "Camisa do Brasil",
            "categoria" => "roupa",
            "preco" => 400,
            "quantidade" => 193
        ],

        [
            "nome" => "Coca-Cola",
            "categoria" => "alimento",
            "preco" => 13,
            "quantidade" => 100
        ],

        [
            "nome" => "Hotwells",
            "categoria" => "brinquedo",
            "preco" => 30,
            "quantidade" => 3
        ]
    ];

    // método de envio do form
    $metodo = ($_SERVER["REQUEST_METHOD"]);

    if ($metodo == "POST") { // post
        $nome = $_POST["nome"]; 
        $categoria = $_POST["categoria"];
        $preco = $_POST["preco"];
        $quantidade = $_POST["quantidade"];
    } else { // get
        $nome = $_GET["nome"];
        $categoria = $_GET["categoria"];
        $preco = $_GET["preco"];
        $quantidade = $_GET["quantidade"];
    };

    // validações
    if ($preco < 1) { // preco abaixo de 1
        ?>
        <p>Erro: preço abaixo do esperado!</p>
        <?php
        exit;
    } elseif ($quantidade < 0 || $quantidade > 200) {
        ?>
        <p>Erro: quantidade irregular!</p>
        <?php
        exit;
    } else { // se tudo for válido
        $produtos[] = [
            "nome" => $nome,
            "categoria" => $categoria,
            "preco" => $preco,
            "quantidade" => $quantidade
        ];

        // cria o html
        ?>
        <!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Cadastro de produtos</title>
        </head>
        <body>
            <header>
                <h1>Cadastro de produtos</h1>
            </header>

            <main>
                <h2>Produto cadastrado com sucesso!</h2>

                <!-- criação das funções -->
                <?php
                    // verifica quantidade 
                    function verificarQuantidade($quantidade) {
                        if ($quantidade == 0) {
                            $mensagem = "Indisponível";
                        } else {
                            $mensagem = "Disponível";
                        };
                        return $mensagem;
                    };

                    // verifica preco
                    function verificarPreco($preco) {
                        if ($preco > 1000) {
                            $mensagem = "Premium";
                        } else {
                            $mensagem = "Popular";
                        };
                        return $mensagem;
                    };

                    // verifica e cria mensagem de categoria
                    function verificarCategoria($categoria) {
                        switch ($categoria) {
                            case "gamer":
                                $mensagem = "A categoria gamer faz muito sucesso entre os jovens!";
                                break;

                            case "roupa":
                                $mensagem = "Invista nas roupas da estação atual!";
                                break;

                            case "alimento":
                                $mensagem = "Evite vender ultraprocessados!";
                                break;

                            case "brinquedo":
                                $mensagem = "Invista em brinquedos resistentes!";
                                break;

                            default:
                                $mensagem = "Categoria Inválida!";
                                exit;
                        };
                        return $mensagem;
                    };

                ?>

                <p>Status do estoque: <?= verificarQuantidade($quantidade)?></p>

                <p>Status do preço: <?= verificarPreco($preco)?></p>

                <p><?= $categoria ?>: <?= verificarCategoria($categoria) ?></p>

                <h3>Lista dos produtos cadastrados:</h3>

                <!-- exibindo produtos cadastrados -->
                <?php
                foreach ($produtos as $indice => $produto) {
                    ?>
                    <hr>
                    <p>Produto <?= $indice + 1 ?>:</p>
                    <?php
                    foreach ($produto as $chave => $informacoes) {
                        ?>
                        <p><?= $chave ?>: <?= $informacoes ?></p>
                        <?php
                    };
                };
                ?>
            </main>
        </body>
        </html>
        <?php
    };

?>