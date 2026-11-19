<?php

    // função para consultar produtos
    function consultarproduto($id, $conexao) {
        // variável de erros
        $erros = [];

        try {
            // CONSULTA DE PRODUTO AO BANCO 
            $sql = "SELECT nome, estoque, preco FROM produtos
                    WHERE id = ?;";

            $stmt = mysqli_prepare($conexao, $sql);

            mysqli_stmt_bind_param($stmt, "i", $id);

            $execucao = mysqli_stmt_execute($stmt);

            if ($execucao === false) {
                throw new Exception;
            } else {
                // recebendo o conjunto de registros
                $resultadoSelect = mysqli_stmt_get_result($stmt);

                // recebendo o produto
                $produto = mysqli_fetch_assoc($resultadoSelect);

                // se o produto não estiver cadastrado no banco de dados
                if (empty($produto)) {
                    $erros[] = "Produto inexistente!";
                }
            }
        } catch (mysqli_sql_exception $erro) {
            $erros[] = "Não foi possível concluir a consulta por conta do banco de dados!";
        } catch (Exception $erro) {
            $erros[] = $erro->getMessage();
        }

        // se houverem erros
        if (!empty($erros)) {
            return [
                "sucesso" => false,
                "mensagem" => $erros
            ];
        } else {
            return [
                "sucesso" => true,
                "resultado" => $produto
            ];
        }
    }

?>