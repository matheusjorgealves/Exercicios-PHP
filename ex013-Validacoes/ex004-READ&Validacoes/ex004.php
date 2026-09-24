<?php

    // inclusão do arquivo de conexão com o banco de dados
    include ("../conexao.php");

    // inicializando a variável
    $erros = [];

    // se o método da requisição for get
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        // se não houver id na url
        if (!isset($_GET["id"])) {
            $erros[] = "Não foi passado nenhum id através da URL!";
        } else { // há id na url
            // recebendo o id da url
            $id = $_GET["id"];

            // se o id estiver vazio
            if (empty($id)) {
                $erros[] = "Id nulo é inválido!";
            }

            // se o id for negativo ou zero
            if ($id < 1) {
                $erros[] = "Id negativo ou zero é inválido!";
            }
        }
    } else { // método post
        $erros[] = "O método da requisição deve ser GET";
    }

    // se não houverem erros
    if (empty($erros)) {
        // ------ SELECT id ------
        $sql = "SELECT * FROM usuarios WHERE id = ?;";

        // statement preparado para a associação de dados aos placeholders
        $stmt = mysqli_prepare($conexao, $sql);

        // associando o parâmetro ao placeholder
        mysqli_stmt_bind_param($stmt, "i" ,$id);

        // executando o stmt
        $execucao = mysqli_stmt_execute($stmt);

        // se a execução do stmt falhar
        if ($execucao === false) {
            $erros[] = "Não foi possível carregar os dados!";
        } else {
            // recebendo o conjunto de registros resultantes da consulta
            $resultadoSelect = mysqli_stmt_get_result($stmt);

            // recebendo o registro retornado pela consulta
            $usuario = mysqli_fetch_assoc($resultadoSelect);

            // se o id existir
            if (isset($usuario["id"])) {
                // recebendo os dados do usuário
                $nome = $usuario["nome"];
                $email = $usuario["email"];
                $idade = $usuario["idade"];
            } else {
                $erros[] = "Id $id não existe no banco de dados";
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualize seus dados</title>
</head>
<body>
    <!-- cabeçalho -->
    <header>
        <h1>Visualize seus dados</h1>
    </header>

    <!-- conteúdo principal -->
    <main>
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

        <p>Preencha o formulário abaixo para visualizar o usuário de id correspondente</p>

        <form action="" method="get">
            <!-- id -->
            <label for="id">Id:</label>
            <input type="number" name="id" id="id" min="1" required value="<?= !isset($id) ? "" : $id ?>">
            <br> <br>

            <!-- visualizar -->
            <button type="submit">Visualizar</button>
            <br> <br>
        </form>

        <!-- ------ usuário ------ -->
        <?php
            // se não houverem erros
            if (empty($erros)) {
                ?>
                <!-- tabela do usuário de id correspondente -->
                <table>
                    <thead>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Idade</th>
                        <th>Ação</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $id ?></td>
                            <td><?= $nome ?></td>
                            <td><?= $email ?></td>
                            <td><?= $idade ?></td>
                            <td><a href="../ex003-Update&Regras/ex003.php?id=<?= $id ?>" target="blank">Editar</a></td>
                        </tr>
                    </tbody>
                </table>
                <?php
            }
        ?>
    </main>

    <!-- rodapé -->
    <footer>
        <p>Site feito por <a href="https://github.com/matheusjorgealves" target="blank">Matheus Jorge</a></p>
    </footer>
</body>
</html>