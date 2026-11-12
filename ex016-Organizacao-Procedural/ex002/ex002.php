<?php

    // $conexao guarda a conexão com o banco de dados
    include ("../conexao.php");

    function verificarEstoque($estoque, $minimo) {
        if ($estoque < $minimo) {
            return false;
        } else {
            return true;
        }
    }

    function calcularCompra($estoque, $estoqueMinimo, $precoAquisicao) {
        $quantidadeProdutos = $estoqueMinimo - $estoque;

        return $precoAquisicao * $quantidadeProdutos;
    }

    // inicializando variáveis
    $erros = [];
    $mensagens = [];

    // se o método da requisição http for post
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // validando o id
        if (!isset($_POST["id"])) {
            $erros[] = "Insira o id!";
        } else {
            if (filter_var($_POST["id"], FILTER_VALIDATE_INT) === false) {
                $erros[] = "O id deve ser um número inteiro!";
            } else {
                $id = $_POST["id"];

                if ($id < 1) {
                    $erros[] = "Mínimo para id é 1!";
                }
            }
        }

        // validando o estoqueMinimo 
        if (!isset($_POST["estoqueMinimo"])) {
            $erros[] = "Insira a quantidade do estoque mínimo!";
        } else {
            if (filter_var($_POST["estoqueMinimo"], FILTER_VALIDATE_INT) === false) {
                $erros[] = "O valor do estoque mínimo deve ser um número inteiro!";
            } else {
                $estoqueMinimo = $_POST["estoqueMinimo"];

                if ($estoqueMinimo < 0) {
                    $erros[] = "O estoque mínimo não pode ser negativo!";
                }
            }
        }

        // validando o precoAquisicao
        if (!isset($_POST["precoAquisicao"])) {
            $erros[] = "Insira o preço da aquisição do produto!";
        } else {
            if (filter_var($_POST["precoAquisicao"], FILTER_VALIDATE_FLOAT) === false) {
                $erros[] = "O preço da aquisição deve ser um valor numérico!";
            } else {
                $precoAquisicao = $_POST["precoAquisicao"];

                if ($precoAquisicao < 0) {
                    $erros[] = "O preço da aquisição do produto não pode ser negativo!";
                }
            }
        }

        if (empty($erros)) {
            try {
                // CONSULTA AO BANCO DE DADOS
                $sql = "SELECT nome, estoque FROM produtos
                    WHERE id = ?;";

                $stmt = mysqli_prepare($conexao, $sql);

                mysqli_stmt_bind_param($stmt, "i", $id);

                $execucao = mysqli_stmt_execute($stmt);

                if ($execucao === false) {
                    throw new Exception("Não foi possível consultar o produto!");
                } else {
                    $resultadoSelect = mysqli_stmt_get_result($stmt);

                    $produto = mysqli_fetch_assoc($resultadoSelect);

                    if (empty($produto)) {
                        throw new Exception("O produto informado não está cadastrado no banco de dados!");
                    } else {
                        $nome = $produto["nome"];
                        $estoque = $produto["estoque"];
                    }
                }
            } 
            // exception de erro do sql
            catch (mysqli_sql_exception $erro) {
                $erros[] = $erro->getMessage();
            } 
            // exception comum
            catch (Exception $erro) {
                $erros[] = $erro->getMessage();
            }
        }

        if (empty($erros)) {
            // se o estoque mínimo for um número positivo
            if ($estoqueMinimo > 0) {
                // chamando a function para verificar o estoque
                $verificacaoEstoque = verificarEstoque($estoque, $estoqueMinimo);

                // se o estoque não for verificado
                if ($verificacaoEstoque === false) {
                    // chamando a function para calcular o total
                    $total = calcularCompra($estoque, $estoqueMinimo, $precoAquisicao);

                    $mensagens[] = "O estoque do produto está abaixo do valor mínimo!";
                    $mensagens[] = "Será necessário investir R$$total para repor a quantidade mínima do estoque!";
                } else {
                    $mensagens[] = "A quantidade de produtos no estoque está adequada!";
                }
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papelaria Horizonte</title>
</head>
<body>
    <header>
        <h1>Papelaria Horizonte</h1>
    </header>

    <main>

        <?php
        // se houverem erros
        if (!empty($erros)) {
            foreach ($erros as $erro) {
                ?>
                <p>Erro: <mark><?= htmlspecialchars($erro, ENT_QUOTES, "UTF-8") ?></mark></p>
                <?php
            }
        }
            
        // se o método da requisição for post e não houverem erros
        if ($_SERVER["REQUEST_METHOD"] === "POST" && empty($erros)) {
            ?>
            <table>
                <!-- cabeçalho da table -->
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Estoque</th>
                        <th>Estoque Mínimo</th>
                        <th>Preço Aquisição</th>
                    </tr>
                </thead>

                <!-- corpo da table -->
                <tbody>
                    <tr>
                        <td><?= htmlspecialchars($id, ENT_QUOTES, "UTF-8") ?></td>
                        <td><?= htmlspecialchars($nome, ENT_QUOTES, "UTF-8") ?></td>
                        <td><?= htmlspecialchars($estoque, ENT_QUOTES, "UTF-8") ?></td>
                        <td><?= htmlspecialchars($estoqueMinimo, ENT_QUOTES, "UTF-8") ?></td>
                        <td><?= htmlspecialchars($precoAquisicao, ENT_QUOTES, "UTF-8") ?></td>
                    </tr>
                </tbody>
            </table>

                <?php
                // se as mensagens não estiverem vazias
                if (!empty($mensagens)) {
                    foreach ($mensagens as $mensagem) {
                        ?>
                        <p><?= htmlspecialchars($mensagem, ENT_QUOTES, "UTF-8") ?></p>
                        <?php
                    }
                }
                ?>
            <?php
        }
        ?>

        <p>Consulte a situação de cada produto. Informe o id do produto e a quantidade de unidades que você deseja para o estoque</p>

        <form action="" method="post">
            <!-- id -->
            <label for="id">Id:</label>
            <input type="number" name="id" id="id" min="1" required>
            <br> <br>

            <!-- estoqueMinimo -->
            <label for="estoqueMinimo">Estoque Mínimo:</label>
            <input type="number" name="estoqueMinimo" id="estoqueMinimo" min="0" required>
            <br> <br>

            <!-- precoAquisicao -->
            <label for="precoAquisicao">Preço da aquisição do produto: R$</label>
            <input type="number" name="precoAquisicao" id="precoAquisicao" min="0" step="0.01" required>
            <br> <br>

            <!-- button consultar -->
            <button type="submit">Consultar</button>
            <br> <br>
        </form>
    </main>

    <footer>
        <p>Site desenvolvido por <a href="https://GitHub.com/mateusjorgealves/" target="_blank">Matheus Jorge</a></p>
    </footer>
</body>
</html>