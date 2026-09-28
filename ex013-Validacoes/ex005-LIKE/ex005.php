<?php

    // inclui conexão
    include ("../conexao.php");

    // inicializando variável
    $erros = [];
    $usuarios = [];
    $usuariosPesquisados = [];

    // ------ se o método da requisição for POST ------
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $pesquisaBruta = $_POST["pesquisa"];

        // se a pesquisa não for string
        if (!is_string($pesquisaBruta)) {
            $erros[] = "Use palavras para pesquisar o nome de usuário!";
        } else {
            // remove espaços no início e no fim da varíavel
            $pesquisa = trim($pesquisaBruta);
        }

        // validações
        if (isset($pesquisa) && empty($pesquisa)) {
            $pesquisou = false;
        } elseif (isset($pesquisa) && !empty($pesquisa)) {
            $pesquisou = true;
        }

        // se o usuário pesquisou e não houve erro
        if (isset($pesquisa) && $pesquisou === true && empty($erros)) {
            // ------ SELECT nome pesquisado ------
            // intrução sql dentro de uma variável
            $sql = "SELECT id, nome, email, idade FROM usuarios WHERE nome LIKE ?;";

            // stmt preparado para a associação do nome ao placeholder
            $stmt = mysqli_prepare($conexao, $sql);

            // criando uma variável para armazenar o valor de pesquisa entre os caracteres que possibilitam que o LIKE seja feito da maneira correta
            $pesquisaAjustada = "%". $pesquisa ."%";

            // associando o parâmetro ao placeholder
            mysqli_stmt_bind_param($stmt, "s", $pesquisaAjustada);

            // executando o stmt
            $execucao = mysqli_stmt_execute($stmt);

            // se a execução falhar
            if ($execucao === false) {
                $erros[] = "Não foi possível carregar os dados!";
            } else {
                // buscando o conjunto de resultados retornado pelo select
                $resultadoSelect = mysqli_stmt_get_result($stmt);

                // enquanto houverem usuários
                while ($usuarioPesquisado = mysqli_fetch_assoc($resultadoSelect)) {
                    $usuariosPesquisados[] = $usuarioPesquisado; 
                }

                // se nenhum usuário for encontrado
                if (empty($usuariosPesquisados)) {
                    $erros[] = "Não foi encontrado nenhum usuário com o nome $pesquisa";
                }
            }
        }
    } 

    // se o método da requisição for get ou $pesquisou for false
    if ($_SERVER["REQUEST_METHOD"] === "GET" || isset($pesquisou) && $pesquisou === false) {
        // ------ SELECT usuarios ------
        // instrução sql dentro de uma variável
        $sql = "SELECT id, nome, email, idade FROM usuarios;";

        // statement
        $stmt = mysqli_prepare($conexao, $sql);

        // executa o stmt
        $execucao = mysqli_stmt_execute($stmt);

        // se a execução falhar 
        if ($execucao === false) {
            $erros[] = "Não foi possível carregar os dados!";
        } else {
            // buscando o conjunto de registros retornado pela consulta
            $resultadoSelect = mysqli_stmt_get_result($stmt);

            // enquanto houverem usuários
            while ($usuario = mysqli_fetch_assoc($resultadoSelect)) {
                $usuarios[] = $usuario;
            }

            // se não houverem usuários
            if (empty($usuarios)) {
                $erros[] = "Nenhum usuário cadastrado!";
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar usuários</title>
</head>
<body>
    <header>
        <h1>Visualizar usuários</h1>
    </header>

    <main>
        <!-- formulário para a pesquisa de usuário -->
        <form action="" method="POST">
            <label for="pesquisa">Nome do usuário:</label>
            <input type="text" name="pesquisa" id="pesquisa">

            <button type="submit">Pesquisar</button>
            <br> <br>
        </form>

        <?php
            // se houverem erros
            if (!empty($erros)) {
                foreach ($erros as $erro) {
                    ?>
                    <p>Erro: <?= $erro ?></p>
                    <?php
                }
            } else {
                // se o usuário não pesquisou ou pesquisou deixando o campo pesquisa vazio
                if ($_SERVER["REQUEST_METHOD"] === "GET" || $pesquisou === false) {

                    // abrindo o html
                    ?>
                    <h2>Tabela de Usuários</h2>

                    <table>
                        <!-- cabeçalho da table -->
                        <thead>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Idade</th>
                            <th>Ação</th>
                        </thead>

                        <!-- corpo da table -->
                        <tbody>
                            <?php
                                // percorrendo os usuários
                                foreach ($usuarios as $usuario) {
                                    // declarando as variáveis
                                    $id = $usuario["id"];
                                    $nome = $usuario["nome"];
                                    $email = $usuario["email"];
                                    $idade = $usuario["idade"];
                                    ?>
                                    <tr>
                                        <td><?= $id ?></td>
                                        <td><?= $nome ?></td>
                                        <td><?= $email ?></td>
                                        <td><?= $idade ?></td>
                                        <td><a href="../ex004-READ&Validacoes/ex004.php?id=<?= $id ?>">Visualizar</a></td>
                                    </tr>
                                    <?php
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php
                    // fechamento do html
                } 
                // se o usuário pesquisou
                elseif (isset($pesquisa) && $pesquisou === true) {
                    // tabela com o resultado da pesquisa
                    ?>
                    <table>
                        <!-- cabeçalho da table -->
                        <thead>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Idade</th>
                            <th>Ação</th>
                        </thead>

                        <!-- corpo da table -->
                        <tbody>
                            <?php
                                // percorrendo os usuários pesquisados
                                foreach ($usuariosPesquisados as $usuarioPesquisado) {
                                    // declarando as variáveis
                                    $id = $usuarioPesquisado["id"];
                                    $nome = $usuarioPesquisado["nome"];
                                    $email = $usuarioPesquisado["email"];
                                    $idade = $usuarioPesquisado["idade"];
                                    ?>
                                    <tr>
                                        <td><?= $id ?></td>
                                        <td><?= $nome ?></td>
                                        <td><?= $email ?></td>
                                        <td><?= $idade ?></td>
                                        <td><a href="../ex004-READ&Validacoes/ex004.php?id=<?= $id ?>">Visualizar</a></td>
                                    </tr>
                                    <?php
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php
                }
            }
        ?>
    </main>

    <footer>
        <p>Site feito por <a href="https://GitHub.com/matheusjorgealves" target="blank">Matheus Jorge</a></p>
    </footer>
</body>
</html>