<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time do Coração</title>
</head>
<body>
    <h1>Time do Coração</h1>

    <form action="processador.php" method="post">
        <label for="nome">Nome: </label>
        <input type="text" name="nome" id="nome" required> <br> <br>

        <label for="time">Escolha o seu time</label>
        <select name="time" id="time" required>
            <option value="saopaulo">São Paulo</option>
            <option value="santos">Santos</option>
            <option value="palmeiras">Palmeiras</option>
            <option value="corinthians">Corinthians</option>
        </select> <br> <br>

        <button type="submit">Enviar</button>
    </form>
</body>
</html>