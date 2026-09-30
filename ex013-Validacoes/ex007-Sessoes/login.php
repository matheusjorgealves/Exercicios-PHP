<?php

    // inclui a conexão com o banco de dados
    include ("../conexao.php");

    // inicializando sessão
    session_start();

    // variável de erros
    $erros = [];
    $usuariosCadastrados = [];
    $validacaoEmailSenha = false;

    // se o método da requisição for post
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // recebendo as respostas do form
        $email = trim($_POST["email"]);
        $senha = $_POST["senha"];

        // validaçõe - not null em todas
        // email
        if (empty($email) || is_string($email) === false || strlen($email) < 5 || strlen($email) > 100 || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $erros[] = "E-mail inválido!";
        }

        // senha 
        if (empty($senha) || is_string($senha) === false || strlen($senha) < 8 || strlen($senha) > 100) {
            $erros[] = "Senha inválida!";
        }

        // se não houverem erros
        if (empty($erros)) {
            // ------ SELECT email e senha ------

            // instrução sql dentro de uma variável
            $sql = "SELECT id, nome, email, senha FROM usuarios WHERE email = ?;";

            // statement preparado para a associação do parâmetro ao placeholder
            $stmt = mysqli_prepare($conexao, $sql);

            // associando o parâmetro ao placeholder
            mysqli_stmt_bind_param($stmt, "s", $email);

            // executando o stmt
            $execucao = mysqli_stmt_execute($stmt);

            // se a execução falhar
            if ($execucao === false) {
                $erros[] = "Não foi possível carregar os dados para validação de usuário!";
            } else {
                // recebendo o conjunto de resultados retornados pela consulta
                $resultadoSelect = mysqli_stmt_get_result($stmt);

                // enquanto houverem usuários cadastrados com esse email
                while ($usuarioCadastrado = mysqli_fetch_assoc($resultadoSelect)) {
                    $usuariosCadastrados[] = $usuarioCadastrado;
                }

                // se não houverem usuários com esse email
                if (empty($usuariosCadastrados)) {
                    $erros[] = "E-mail não cadastrado!";
                } else {
                    // percorrendo os usuários com esse email
                    foreach ($usuariosCadastrados as $usuarioCadastrado) {
                        // se o email e a senha existirem em um mesmo usuário
                        if ($email === $usuarioCadastrado["email"] && password_verify($senha, $usuarioCadastrado["senha"])) {
                            // email e senha são validados
                            $validacaoEmailSenha = true;

                            // guardando o id e o nome do usuário na sessão
                            $_SESSION["id_usuario"] = $usuarioCadastrado["id"];
                            $_SESSION["nome_usuario"] = $usuarioCadastrado["nome"]; 

                            // guardando o id do usuário 
                            $id = $usuarioCadastrado["id"];
                        }
                    }

                    // se não existir um usuário cadastrado com esse email e senha
                    if ($validacaoEmailSenha === false) {
                        $erros[] = "E-mail ou senha incorretos!";
                    }
                }
            }
        }

        // se não houverem erros e o usuário for autenticado
        if (empty($erros) && $validacaoEmailSenha === true) {
            // direcionando o usuário para a página protegida
            header("Location: paginaProtegida.php");
            exit; // encerrando a execução dessa página
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de usuário</title>
</head>
<body>
    <header>
        <h1>Login de usuário</h1>
    </header>

    <main>
        <h2>Faça login no formulário abaixo</h2>

        <!-- php -->
        <?php
        // se houverem erros
        if (!empty($erros)) {
            // percorrendo os erros
            foreach ($erros as $erro) {
                ?>
                <p>Erro: <?= $erro ?></p>
                <?php
            }
        }
        ?>

        <form action="" method="post">
            <!-- não usarei persistência de dados no form -->

            <!-- email -->
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" required>
            <br> <br>

            <!-- senha -->
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required>
            <br> <br>

            <!-- button Login -->
            <button type="submit">Login</button>
        </form>
    </main>

    <footer>
        <p>Site desenvolvido por <a href="https://GitHub.com/matheusjorgealves" target="blank">Matheus Jorge</a></p>
    </footer>
</body>
</html>