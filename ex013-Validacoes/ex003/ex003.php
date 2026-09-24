<?php

    // incluindo a conexão com o banco de dados
    include ("../conexao.php");

    // inicializando variáveis
    $nome = "";
    $email = "";
    $idade = 0;
    $senha = "";
    $verificacaoId = false;
    $verificacaoEmail = false;
    $atualizacao = false;
    $erros = [];

    // se o método da requisição for get e o ID for passado pela URL
    if ($_SERVER["REQUEST_METHOD"] === "GET" && !isset($_GET["id"])) {
        echo "Id não foi passado pela URL";
        die;
    } else {
        // recebendo o id
        $id = $_GET["id"];

        // validações iniciais do id
        if (empty($id)) {
            echo "Id está vazio!";
            die;
        } elseif ($id < 0) {
            echo "Id negativo não existe!";
            die;
        }
    } 

    // ------ SELECT id ------
    // variável para armazenar uma instrução sql
    $sql = "SELECT * FROM usuarios WHERE id = ?;";

    // statement preparado para a associação de dados aos placeholders
    $stmt = mysqli_prepare($conexao, $sql);

    // associando os parâmetros aos placeholders
    mysqli_stmt_bind_param($stmt, "i", $id);

    // executando o stmt no banco de dados
    $execucao = mysqli_stmt_execute($stmt);

    // se a execução falhar
    if ($execucao === false) {
        $erros[] = "Erro: ". mysqli_stmt_error($stmt);
    } else {
        // recebendo o resultado
        $resultadoSelect = mysqli_stmt_get_result($stmt);

        // enquanto houver usuários
        while ($usuarioId = mysqli_fetch_assoc($resultadoSelect)) {
            // recebendo os dados do usuário
            $nome = $usuarioId["nome"];
            $email = $usuarioId["email"];
            $emailAntigo = $usuarioId["email"]; // essa variável guardará esse email
            $idade = $usuarioId["idade"];
            $senha = $usuarioId["senha"];

            // verificação da existência do id da URL no banco de dados
            $verificacaoId = true;
        }
    }

    // se o id for inexistente
    if ($verificacaoId === false) {
        echo "ID inexistente!";
        die;
    }

    // se o método da requisição for post
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // recebendo as respostas do formulário
        $nome = trim($_POST["nome"]);
        $email = trim($_POST["email"]);
        $idade = $_POST["idade"];
        $senha = trim($_POST["senha"]);

        // ------ validações ------
        // nenhuma pode not null

        // nome 
        if (empty($nome)) {
            $erros[] = "Nome vazio!";
        } elseif (strlen($nome) < 3 || strlen($nome) > 100) {
            $erros[] = "Nome contém quantidade inválida de caracteres";
        }
        
        // email
        if (empty($email)) {
            $erros[] = "E-mail vazio!";
        } elseif (strlen($email) < 5 || strlen($email) > 150) {
            $erros[] = "E-mail contém quantidade inválida de caracteres";
        } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $erros[] = "E-mail possui formato inválido!";
        } 

        // idade 
        if ($idade < 18) {
            $erros[] = "Idade não pode ser inferior a 18";
        } elseif ($idade > 100) {
            $erros[] = "Idade não pode ser superior a 100";
        }

        // senha
        if (empty($senha)) {
            $erros[] = "Senha não pode estar vazia";
        } elseif (strlen($senha) < 8) {
            $erros[] = "Senha não pode conter menos de 8 caracteres";
        } elseif (strlen($senha) > 200) {
            $erros[] = "Senha não pode conter mais de 200 caracteres";
        }

        // se não houverem erros
        if (empty($erros)) {
            // ------ SELECT email ------
            // variável com uma instrução sql
            $sql = "SELECT * FROM usuarios WHERE email = ?;";

            // statement preparado para a associação de dados ao placeholder
            $stmt = mysqli_prepare($conexao, $sql);

            // associando os parâmetros ao placeholder
            mysqli_stmt_bind_param($stmt, "s", $email);

            // executando o stmt
            $consultaEmail = mysqli_stmt_execute($stmt);

            // se houver erro na execução
            if ($consultaEmail === false) {
                $erros[] = "Erro: ". mysqli_stmt_error($stmt);
            } else {
                // recebendo o resultado da consulta
                $resultadoSelect = mysqli_stmt_get_result($stmt);

                // se o email for existente
                while ($usuarioEmail = mysqli_fetch_assoc($resultadoSelect)) {
                    // se o email for o do próprio usuário 
                    if ($email === $emailAntigo) {
                        // verificação do email validada
                        $verificacaoEmail = true;
                        
                        // validando a variável de verificação do while
                        $verificacaoWhile = true;
                    } 

                    // se o email é existente e não pertencente ao registro de id respectivo
                    $verificacaoWhile = false;
                }

                // se o email for inexistente
                if (!isset($verificacaoWhile)) {
                    $verificacaoEmail = true;
                }
            }
        }

        // se a consulta do email acontecer e ele for inválido
        if (isset($consultaEmail) && $verificacaoEmail === false) {
            $erros[] = "E-mail já existente!";
        }

        // se não houverem erros
        if (empty($erros)) {
            // ------ UPATE usuarios ------
            // variável para armazenar uma instrução sql
            $sql = "UPDATE usuarios SET nome = ?, email = ?, idade = ?, senha = ? WHERE id = ?;";

            // statement preparado para a associação de parâmetros aos placeholders
            $stmt = mysqli_prepare($conexao, $sql);

            // associando os parâmetros aos placeholders do stmt
            mysqli_stmt_bind_param($stmt, "ssisi",$nome, $email, $idade, $senha, $id);

            // executando o stmt
            $execucao = mysqli_stmt_execute($stmt);
            
            // se houver erro na execução
            if ($execucao === false) {
                $erros[] = "Erro: ". mysqli_stmt_error($stmt);
            } else {
                // atualização concluida
                $atualizacao = true;
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuários</title>
</head>
<body>
    <!-- cabeçalho -->
    <header>
        <h1>Editar dados do usuário</h1>
    </header>

    <!-- conteúdo principal -->
    <main>
        <p>Id do usuário: <?= $id ?></p>
        
        <?php
            // se houverem erros
            if (!empty($erros)) {
                // percorrendo os erros
                foreach ($erros as $erro) {
                    ?>
                    <p><mark>Erro: <?= $erro ?></mark></p>
                    <?php
                }
            }

            // se o usuário ainda não foi atualizado
            if ($atualizacao === false) {
                ?>
                <p>Edite dados do usuário no formulário abaixo</p>
                <?php
            } else {
                ?>
                <p>Usuário de ID = <?= $id ?> teve seus dados atualizados!</p>
                <?php
            }
        ?>

        <!-- formulário post -->
        <form action="" method="post">
            <!-- nome -->
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required value="<?= $nome ?>">
            <br> <br>

            <!-- email -->
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" required value="<?= $email ?>">
            <br> <br>

            <!-- idade -->
            <label for="idade">Idade:</label>
            <input type="number" name="idade" id="idade" min="18" max="100" step="1" required value="<?= $idade ?>">
            <br> <br>

            <!-- senha -->
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required value="<?= $senha ?>">
            <br> <br>

            <!-- botão atualizar -->
            <button type="submit">Atualizar Usuário</button>
            <br> <br>
        </form>
    </main>

    <!-- rodapé -->
    <footer>
        <p>Site criado por <a href="https://github.com/matheusjorgealves/" target="blank">Matheus Jorge</a></p>
    </footer>
</body>
</html>