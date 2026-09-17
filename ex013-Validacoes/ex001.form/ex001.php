<?php

    // incluindo a conexão com o banco de dados
    include ("../conexao.php");

    // criando variáveis
    $nome = "";
    $email = "";
    $idade = 0;
    $senha = "";
    $erros = [];
    $execucao = false;
    $mensagem = "";

    // se o método da requisição for post
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // recebendo as respostas do form. trim remove os espaços entre as palavras
        $nome = trim($_POST["nome"]);
        $email = trim($_POST["email"]);
        $idade = $_POST["idade"];
        $senha = trim($_POST["senha"]);

        // validações
        // nome 
        // se o nome estiver vazio ou se o length(comprimento) for abaixo de 3
        if (empty($nome) || strlen($nome) < 3) {
            $erros[] = "Nome inválido!";
        };

        // email
        // se o email estiver vazio ou se o formato do email for inválido
        if (empty($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $erros[] = "E-mail inválido!";
        };

        // idade
        if (empty($idade) || $idade < 18 || $idade > 100) {
            $erros[] = "Idade inválida!";
        };

        // senha
        if (empty($senha) || strlen($senha) < 8) {
            $erros[] = "Senha inválida!";
        };

        // se não houverem erros
        if (empty($erros)) {
            // variável para armazenar instrução sql
            $sql = "INSERT INTO usuarios (nome, email, idade, senha) VALUES (?, ?, ?, ?);";

            // statement preparado para a associação de variáveis aos placeholders ?
            $stmt = mysqli_prepare($conexao, $sql);

            // associando variáveis, como dados, aos placeholders
            mysqli_stmt_bind_param($stmt, "ssis", $nome, $email, $idade, $senha);

            // executando o stmt no banco de dados
            $execucao = mysqli_stmt_execute($stmt);

            // se a execução do statement falhar
            if ($execucao === false) {
                $erros[] = "Não foi possível cadastrar usuário!";
                $erros[] = "Erro: ". mysqli_stmt_error($stmt);
            } else {
                // último id cadastrado no banco
                $idCadastrado = mysqli_insert_id($conexao);
                $mensagem = "Usuário cadastrado com sucesso! ID do usuário cadastrado: $idCadastrado";
            };
        };
    };

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de cadastro de usuários</title>
</head>
<body>
    <!-- cabeçalho -->
    <header>
        <h1>Sistema de cadastro de usuários</h1>
    </header>

    <!-- corpo da página -->
    <main>

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

        <?php
            // se o método da requisição for get
            if ($_SERVER["REQUEST_METHOD"] === "GET") {
                ?>
                <p>Preencha o formulário abaixo para cadastrar um usuário</p>
                <?php

            // se o método da requisição for post e não houver erro
            } elseif ($_SERVER["REQUEST_METHOD"] === "POST" && empty($erros)) {
                // se a execução for bem sucedida
                if ($execucao === true) {
                    ?>
                    <p><?= $mensagem ?></p>
                    <?php
                } else { // se a execução do stmt der errado
                    ?>
                    <p>Erro inesperado!</p>
                    <?php
                };        
            };
        ?>

        <form action="" method="post">
            <!-- nome -->
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required value="<?= $_SERVER["REQUEST_METHOD"] === "GET" ? "" : $nome ?>">
            <br> <br>

            <!-- email -->
            <label for="email">E-mail:</label>
            <input type="text" name="email" id="email" required value="<?= $_SERVER["REQUEST_METHOD"] === "GET" ? "" : $email ?>">
            <br> <br>

            <!-- idade -->
            <label for="idade">Idade:</label>
            <input type="number" name="idade" id="idade" required min="18" max="100" step="1" value="<?= $_SERVER["REQUEST_METHOD"] === "GET" ? "" : $idade ?>">
            <br> <br>

            <!-- senha -->
            <label for="senha">Senha:</label>
            <input type="text" name="senha" id="senha" required value="<?= $_SERVER["REQUEST_METHOD"] === "GET" ? "" : $senha ?>">
            <br> <br>

            <!-- botão cadastrar -->
            <button type="submit">cadastrar</button>
            <br> <br>
        </form>
    </main>

    <!-- rodapé -->
    <footer>
        <p>Site criado por <a href="https://github.com/matheusjorgealves" target="blanck">Matheus Jorge</a></p>
    </footer>
</body>
</html>