<?php
    $metodo = ($_SERVER["REQUEST_METHOD"]);

    // array multidimensional
    $livros = [
        [
            "titulo" => "Harry Potter",
            "autor" => "Dono do Harry Potter",
            "preco" => 30
        ],

        [
            "titulo" => "Pearcy Jackson",
            "autor" => "Percivaldo Jack",
            "preco" => 40 
        ]
    ];

    // método POST
    if ($metodo == "POST") {
        $livros[] = 
            [
                "titulo" => $_POST["titulo"],
                "autor" => $_POST["autor"],
                "preco" => $_POST["preco"]
            ];
    } else { // método GET
        $livros[] =
            [
                "titulo" => $_GET["titulo"],
                "autor" => $_GET["autor"],
                "preco" => $_GET["preco"]
            ];
    };

    // percorrendo os livros dentro de livros 
    foreach ($livros as $indice => $livro) {
        ?>
        <hr>
        <p>Livro <?= $indice ?></p>
        <?php
        // percorrendo informações dentro de um único livro
        foreach ($livro as $chave => $informacao) {
            ?>
            <p><?= $chave ?>: <?= $informacao ?></p>
            <?php
        };
        ?>
        <hr>
        <?php
    };
?>