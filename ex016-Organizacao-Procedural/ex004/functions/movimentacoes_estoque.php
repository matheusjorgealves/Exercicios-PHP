<?php

    function atualizarEstoque($id, $quantidade, $conexao) {
        // variável de erros
        $erros = [];

        try {
            // INSERINDO A MOVIMENTAÇÃO NO BANCO DE DADOS
            $sql = "INSERT INTO movimentacoes_estoque (id_produto, tipo, motivo, descricao,
                    quantidade)
                    VALUES (?, 'entrada', 'compra', 'Compra de mercadorias', ?);";

            $stmt = mysqli_prepare($conexao, $sql);

            mysqli_stmt_bind_param($stmt, "ii", $id, $quantidade);

            $execucao = mysqli_stmt_execute($stmt);

            if ($execucao == false) {
                throw new Exception;
            } else {
                // buscando o id inserido
                $resultado = mysqli_insert_id($conexao);
            }
        } catch (mysqli_sql_exception $erro) {
            $erros[] = "Não foi possível atualizar o estoque por conta do banco de dados!";
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
                "resultado" => $resultado
            ];
        }
    }

?>