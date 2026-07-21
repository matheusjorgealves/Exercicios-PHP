<?php

    // eu coloquei as variáveis no value dos input para manter as respostas dos usuários quando eles clicarem em cadastrar

    // nas opções do select eu usei operadores ternários para verificar se o usuário escolheu o cargo da opção, caso ele tenha escolhido eu marcarei selected na opção que ele escolheu (isso manterá a opção marcada quando ele clicar em cadastrar)

    // o operador ternário que eu usei funciona como um if else ($cargo == "x" ? --se for verdadeiro-- : --se for falso--)

    // criando as variáveis
    $nome = "";
    $idade = "";
    $cargo = "";
    $erro = "";
    $mensagemNome = "";
    $mensagemIdade = "";
    $mensagemCargo = "";

    // se o método da requisição for post
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = trim($_POST["nome"]);
        $idade = $_POST["idade"];
        $cargo = $_POST["cargo"];

        // se nome estiver vazio
        if (empty($nome)) {
            $erro = "Insira um nome válido!";
        } else {
            $mensagemNome = "Olá, $nome";
        };

        // validando idade 
        if ($idade <= 0 || $idade > 100) {
            $erro = "Insira uma idade válida!";
        } else {
            $mensagemIdade = "Idade: $idade";
        };

        // mensagem personalizada para cargo
        switch ($cargo) {
            case "gerente":
                $mensagemCargo = "Os gerentes da empresa tem cargo de confiança!";
                break;

            case "secretario":
                $mensagemCargo = "Os secretários da empresa devem acompanhar os CEOs!";
                break;

            case "rh":
                $mensagemCargo = "Os funcionários do RH da empresa cuidarão dos problemas dos demais funcionários!";
                break;

            case "financeiro": 
                $mensagemCargo = "Os funcionários do financeiro cuidam da administração dos recursos monetários da empresa!";
                break;

            default:
                $erro = "Cargo inválido!";
                break;
        };
    };

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de funcionários</title>
</head>
<body>
    <header>
        <h1>Cadastro de funcionários</h1>

        <?php
            if (empty($erro)) {
                ?>
                <p><?= $mensagemNome ?></p>
                <p><?= $mensagemIdade ?></p>
                <p><?= $mensagemCargo ?></p>
                <?php
            } else {
                ?>
                <p><?= $erro ?></p>
                <?php
            };
        ?>

        <form action="" method="post">
            <!-- nome -->
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="<?= $nome ?>">
            <br> <br>

            <!-- idade -->
            <label for="idade">Idade:</label>
            <input type="number" name="idade" id="idade" value="<?= $idade ?>" min="0" max="100">
            <br> <br>

            <!-- cargo -->
            <label for="cargo">Cargo:</label>
            <select name="cargo" id="cargo">

                <option value="gerente" <?= $cargo == "gerente" ? "selected" : "" ?>>Gerente</option>
                
                <option value="secretario" <?= $cargo == "secretario" ? "selected" : "" ?>>Secretário</option>

                <option value="rh" <?= $cargo == "rh" ? "selected" : "" ?>>RH</option>

                <option value="financeiro" <?= $cargo == "financeiro" ? "selected" : "" ?>>Financeiro</option>

            </select>
            <br> <br>

            <button type="submit">Cadastrar</button>
            <br> <br>
        </form>
    </header>
</body>
</html>