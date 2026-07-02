<?php
    $nomes = ["Matheus", "Deborah", "Pedro", "Helena", "Cecília"];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nomes e alterações</title>
</head>
<body>
    <header>
        <h1>Nomes:</h1>
    </header>

    <main>
        <!-- exibindo os nomes através dos indíces do array -->
        <p>0: <?= $nomes[0] ?></p>
        <p>1: <?= $nomes[1] ?></p>
        <p>2: <?= $nomes[2] ?></p>
        <p>3: <?= $nomes[3] ?></p>
        <p>4: <?= $nomes[4] ?></p>

        <!-- form para alterar algum nome -->
        <form action="processador.php" method="post">

            <!-- nome para alterar -->
            <label for="alterar">Selecione o nome que você quer alterar</label>

            <select name="alterar" id="alterar" required>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select> <br> <br>

            <!-- nome novo -->
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required> <br> <br>

            <!-- enviar -->
             <button type="submit">Enviar</button>
        </form>
    </main>
</body>
</html>