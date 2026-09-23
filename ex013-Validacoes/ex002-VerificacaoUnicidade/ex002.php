<?php

    // incluindo a conexão com o banco de dados
    include ("../conexao.php");

    // variáveis
    $nome = "";
    $email = "";
    $idade = 0;
    $senha = "";
    $msgInicial = "Cadastre-se no formulário abaixo";
    $verifEmail = false;
    $erros = [];
    $armazemEmailSQL = [];
    $cadastro = false;

    // se o método da requisição for post
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // recebendo as respostas do form
        $nome = trim($_POST["nome"]);
        $email = trim($_POST["email"]);
        $idade = $_POST["idade"];
        $senha = trim($_POST["senha"]);

        // VALIDAÇÕES - não pode null
        // nome - mínimo 3 caracteres
        if (empty($nome) || strlen($nome) < 3) {
            $erros[] = "Nome inválido!";
        }

        // email - not null, formato deve ser de email e se já existir email
        if (empty($email)) {
            $erros[] = "E-mail inválido!";
        } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $erros[] = "Formato do e-mail inválido!";
        }

        // idade - 18 a 100 anos de idade
        if ($idade < 18 || $idade > 100) {
            $erros[] = "Idade inválida!";
        }

        // senha - not null e mínimo 8 caracteres
        if (empty($senha)) {
            $erros[] = "Senha inválida!";
        } elseif (strlen($senha) < 8) {
            $erros[] = "Senha inválida! Mínimo 8 caracteres";
        }

        //  ----- SELECT email -----

        // se não existirem erros
        if (empty($erros)) {
            // variável para armazenar instrução sql
            $sql = "SELECT * FROM usuarios where email = ?;";

            // statement preparado para a associação de dados aos placeholders ?
            $stmt = mysqli_prepare($conexao, $sql);

            // associando dados aos placeholders do stmt
            mysqli_stmt_bind_param($stmt, "s",$email);

            // executando o stmt
            $execucao = mysqli_stmt_execute($stmt);

            // se a execução do stmt falhar
            if ($execucao === false) {
                $erros[] = "Erro: ". mysqli_stmt_error($stmt);
            } else {
                // recebendo o resultado da consulta (conjunto de registros)
                $resultadoSelect = mysqli_stmt_get_result($stmt);

                // enquanto houverem registros
                while ($emailSQL = mysqli_fetch_assoc($resultadoSelect)) {
                    $armazemEmailSQL[] = $emailSQL;
                }

                // se email for único
                if (empty($armazemEmailSQL)) {
                    $verifEmail = true;
                }
            }
        }

        // se o e-mail já existir
        if ($verifEmail === false) {
            $erros[] = "E-mail já existente!";
        }
        
        // se não houverem erros
        if (empty($erros)) {
            // ----- INSERT -----

            // variável para armazenar instrução sql
            $sql = "INSERT INTO usuarios (nome, email, idade, senha) VALUES (?, ?, ?, ?);";

            // statement preparado para a associação de dados nos placeholders
            $stmt = mysqli_prepare($conexao, $sql);

            // associando os dados aos placeholders
            mysqli_stmt_bind_param($stmt, "ssis",$nome, $email, $idade, $senha);

            // executando o stmt 
            $execucao = mysqli_stmt_execute($stmt);

            // se houver erro na execução
            if ($execucao === false) {
                $erros[] = "Erro:". mysqli_stmt_error($stmt);
            } else {
                // cadastro deu certo 
                $cadastro = true;

                // armazenando o resultado do id do último usuário criado no banco
                $idUsuario = mysqli_insert_id($conexao);
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de usuários</title>
</head>
<body>
    <!-- cabeçalho -->
    <header>
        <h1>Cadastro de usuários</h1>
    </header>

    <!-- conteúdo principal -->
    <main>
        <?php
            // se o cadastro foi concluído
            if ($cadastro === true) {
                // mudando a mensagem inicial
                $msgInicial = "Id do usuário cadastrado:". $idUsuario;
            }

            // mensagem inicial
            ?>
            <p><?= $msgInicial ?></p>
            <?php

            // se houverem erros
            if (!empty($erros)) {
                // percorrendo  os erros
                foreach ($erros as $erro) {
                    ?>
                    <p><mark>Erro: <?= $erro ?></mark></p>
                    <?php
                }
            }
        ?>

        <form action="" method="post">
            <!-- nome -->
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required value="<?= $_SERVER["REQUEST_METHOD"] === "POST" && $cadastro === false ? $nome : "" ?>">
            <br> <br>

            <!-- email -->
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" required value="<?= $_SERVER["REQUEST_METHOD"] === "POST" && $cadastro === false ? $email : "" ?>">
            <br> <br>

            <!-- idade -->
            <label for="idade">Idade:</label>
            <input type="number" name="idade" id="idade" min="18" max="100" required value="<?= $_SERVER["REQUEST_METHOD"] === "POST" && $cadastro === false ? $idade : "" ?>" >
            <br> <br>

            <!-- senha -->
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required value="<?= $_SERVER["REQUEST_METHOD"] === "POST" && $cadastro === false ? $senha : "" ?>">
            <br> <br>

            <!-- botão cadastrar -->
            <button type="submit">Cadastrar usuário</button>
        </form>
    </main>

    <!-- rodapé -->
    <footer>
        <p>Site desenvolvido por <a href="https://github.com/matheusjorgealves" target="blanck">Matheus Jorge</a></p>
    </footer>
</body>
</html>