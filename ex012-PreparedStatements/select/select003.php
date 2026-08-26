<?php

    // incluindo o arquivo da conexão com o banco de dados
    include ("../conexao.php");

    $preco = 500.00;

    // variável para armazenar uma instrução sql
    $sql = "SELECT * FROM produtos WHERE preco > ?";

    // criando um statement preparado a partir da $conexao e do $sql preparado para receber um dado no placeholder ?
    $stmt = mysqli_prepare($conexao, $sql);

    // associa o dado de $preco, cujo tipo é double (d), ao placeholder do $stmt
    mysqli_stmt_bind_param($stmt, "d", $preco);

    // recebe o resultado (bool) da execução do $stmt 
    $execucaoStmt = mysqli_stmt_execute($stmt);

    // se houverem erros na execução do $stmt
    if ($execucaoStmt === false) {
        $erro = mysqli_stmt_error($stmt);
        echo "Erro: ". $erro;
    } else {
        // recebe o resultado da execução do $stmt
        $resultadoSelect = mysqli_stmt_get_result($stmt);

        // enquanto $produto receber novos arrays associativos ou false
        while ($produto = mysqli_fetch_assoc($resultadoSelect)) {
            $produtos[] = $produto;
        }; // chat, esse comentário é para vc, eu vou tirar ele depois. Eu tinha feito o array ir diretamente para o array pai, ou seja, eu tinha feito $produtos[] = ... entende? e não tinha nada dentro do while, estava funcionando, mas como o último resultado desse array é false (o comando retorna isso quando não existe mais arrays associativos) ele dá erro na última volta do laço (que nem deveria acontecer). por essa razão, eu corrigi e fiz de maneira semelhante ao último exercício (não espiei em nada, esse arquivo foi inteiramente feito por mim sem consultar nada além da minha mente). como eu deveria fazer para passar de maneira direta?

        foreach ($produtos as $produto) {
            echo "<h2>Produto</h2>";
            // acessando os dados dos arrays associativos sem entrar em um novo laço
            echo "ID: ". $produto["id"] ."<br>";
            echo "Nome: ". $produto["nome"] ."<br>";
            echo "Categoria: ". $produto["categoria"] ."<br>";
            echo "Quantidade: ". $produto["quantidade"] ."<br>";
            echo "Preço: R$". $produto["preco"] ."<br>";
        };
    };
?> 