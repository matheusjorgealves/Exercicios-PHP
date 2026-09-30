<?php

    // inclui a conexão com o banco de dados
    include ("../conexao.php");

    // inicializando as variáveis
    $metodoPost = false;
    $nome = "";
    $email = "";
    $idade = 0;
    $senha = "";
    $erros = [];
    $emailsConsulta = [];

    // se o método da requisição for post
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $metodoPost = true;

        // recebendo as respostas do formulário através do método post
        $nome = trim($_POST["nome"]);
        $email = trim($_POST["email"]);
        $idade = $_POST["idade"];
        $senha = $_POST["senha"];

        // validações - not null em todas
        // nome
        if (is_string($nome) === false || empty($nome) || strlen($nome) < 3 || strlen($nome) > 100) {
            $erros[] = "Nome inválido!";
        }

        // email
        if (is_string($email) === false || empty($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false || strlen($email) < 5 || strlen($email) > 100) {
            $erros[] = "E-mail inválido!";
        }

        // idade 
        if (empty($idade) || $idade < 18 || $idade > 100) {
            $erros[] = "Idade inválida!";
        }

        // senha 
        if (is_string($senha) === false || empty($senha) || strlen($senha) < 8) {
            $erros[] = "Senha inválida!";
        } else {
            // criando um hash da senha, PASSWORD_DEFAULT serve para o php entender o padrão da criação do hash
            $hash = password_hash($senha, PASSWORD_DEFAULT);
        }

        // se não houverem erros - consulta email
        if (empty($erros)) {
            // ------ SELECT email ------
            
            // comando sql dentro da variável
            $sql = "SELECT email FROM usuarios;";

            // statement preparado para executar no banco de dados
            $stmt = mysqli_prepare($conexao, $sql);

            // executando o stmt
            $execucao = mysqli_stmt_execute($stmt);

            // se houverem erros de execução
            if ($execucao === false) {
                $erros[] = "Não foi possível carregar os dados para validar o E-mail!";
            } else {
                // recebendo o conjunto de registros retornados pela consulta
                $resultadoSelect = mysqli_stmt_get_result($stmt);

                // enquanto houverem registros
                while ($emailConsulta = mysqli_fetch_assoc($resultadoSelect)) {
                    $emailsConsulta[] = $emailConsulta;
                }

                // percorrendo o array dos emails consultados
                foreach ($emailsConsulta as $emailConsulta) {
                    // se o email for igual ao email consultado
                    if ($email === $emailConsulta["email"]) {
                        $erros[] = "E-mail já cadastrado!";
                    }
                }
            }
        }

        // se o hash existir
        if (isset($hash)) {
            // se o hash não for equivalente a senha
            if (!password_verify($senha, $hash)) {
                $erros[] = "A senha não foi processada corretamente!";
            }
        } else {
            $erros[] = "A senha não foi processada corretamente!";
        }

        // se não houverem erros
        if (empty($erros)) {
            // ------ INSERT usuarios ------

            // instrução sql dentro de uma variável 
            $sql = "INSERT INTO usuarios (nome, email, idade, senha) VALUES (?, ?, ?, ?);";

            // statement preparado para a associação de parâmetros ao placeholder
            $stmt = mysqli_prepare($conexao, $sql);

            // associando os parâmetros aos placeholders
            mysqli_stmt_bind_param($stmt, "ssis", $nome, $email, $idade, $hash);

            // exectando o stmt
            $execucao = mysqli_stmt_execute($stmt);

            // se houverem erros na execução do stmt
            if ($execucao === false) {
                $erros[] = "Não foi possível cadastrar-te!";
            } else {
                // recebendo o id do usuário cadastrado
                $id = mysqli_insert_id($conexao);

                // criando mensagem de sucesso
                $mensagem = "Usuário cadastrado! Id do usuário = ". $id;
            }
        }

        // se não houverem erros
        if (empty($erros)) {
            // ------ SELECT usuarios para validar hash ------

            // instrução sql dentro de uma variável
            $sql = "SELECT senha FROM usuarios WHERE id = ?;";

            // statement preparado para a associação de parâmetros ao placeholder
            $stmt = mysqli_prepare($conexao, $sql);

            // associando o parâmetro ao placeholder
            mysqli_stmt_bind_param($stmt, "i", $id);

            // executando o stmt
            $execucao = mysqli_stmt_execute($stmt);

            // se houverem falhas na execução do stmt
            if ($execucao === false) {
                $erros[] = "Não foi possível carregar os dados para validação da sua senha!";
            } else {
                // recebendo o conjunto de registros retornados pela consulta
                $resultadoSelect = mysqli_stmt_get_result($stmt);

                // buscando o registro retornado pela consulta
                $usuarioCadastrado = mysqli_fetch_assoc($resultadoSelect);

                // armazenando a senha salva
                $hashCadastrado = $usuarioCadastrado["senha"];
            }
        }

        // se não houverem erros 
        if (empty($erros)) {
            // validação do hash cadastrado
            if (!password_verify($senha, $hashCadastrado)) {
                $erros[] = "Erro ao salvar a senha!";
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de cadastro</title>
</head>
<body>
    <!-- cabeçalho -->
    <header>
        <h1>Tela de cadastro</h1>
    </header>

    <!-- conteúdo principal -->
    <main>
        <h2>Cadastre-se no formulário abaixo</h2>

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

            // se a mensagem de sucesso existir e não houver erros
            if (isset($mensagem) && empty($erros)) {
                ?>
                <p><?= $mensagem ?></p>
                <?php
            }

        ?>

        <form action="" method="post">
            <!-- nome -->
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required value="<?= $metodoPost === true ? $nome : "" ?>">
            <br> <br>

            <!-- email -->
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" required value="<?= $metodoPost === true ? $email : "" ?>">
            <br> <br>

            <!-- idade -->
            <label for="idade">Idade:</label>
            <input type="number" name="idade" id="idade" min="18" max="100" required value="<?= $metodoPost === true ? $idade : "" ?>">
            <br> <br>

            <!-- senha -->
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required>
            <br> <br>

            <!-- button cadastrar -->
            <button type="submit">Cadastrar</button>
            <br> <br>
        </form>
    </main>

    <!-- rodapé da página -->
    <footer>
        <p>Site desenvolvido por GitHub.com/matheusjorgealves<a href="https://" target="blank">Matheus Jorge</a></p>
    </footer>
</body>
</html>