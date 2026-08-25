mysqli_connect

    O que é?: mysqli_connect é uma função PHP da extensão MySQLi utilizada para estabelecer uma conexão com um banco de dados MySQL/MariaDB.

    Parâmetros:
        Servidor
        Usuário
        Senha
        Banco
        Porta

    Comando: mysqli_connect($servidor, $usuario, $senha, $banco, $porta);


mysqli_report

    O que é?: mysqli_report é uma função PHP da extensão MySQLi utilizado para desabilitar avisos de erro e permitir realizar testes

    Comando: mysqli_report(MYSQLI_REPORT_OFF);


mysqli_query

    O que é?: mysqli_query é uma função PHP da extensão MySQLi utilizado para enviar comandos ao banco de dados e retornar os resultados da execução. Ele é capaz de criar registros, fazer consultas ao banco de dados, etc

    Parâmetros:
        Conexão
        Comando SQL em forma de variável (exemplo: $sql = "SELECT nome FROM produtos WHERE id = 1;";)

    Comando: mysqli_query($conexao, $sql);


mysqli_fetch_assoc

    O que é?: mysqli_fetch_assoc é um comando SQL utilizado para percorrer consultas realizadas pelo mysqli_query.
    Funciona da seguinte maneira: ele verifica se existem registros retornados pelo mysqli_query, caso exista, ele devolverá um array associativo desse registro, caso não exista mais registros (ele já percorreu todos e chegou no último) ele retornará false. 

    Retorna o que?: O mysqli_fetch_assoc pode retornar um array associativo ou false
    
    Como usar?: Quando o mysqli_query é usado para realizar consultas ao banco de dados, ele retorna sempre uma "pasta" com o nome de "registros" e coloca outras "pastas" dentro dessa com cada registro específicado. O mysqli_fetch_assoc pode ser usado juntamente com o while para percorrer cada um desses registros dentro das "pastas", quando isso acontece o mysqli_fetch_assoc consegue "transformar" cada um desses registros em um array associativo, dessa maneira, eu posso usar uma variável para armazenar isso e passar esse array para fora do laço do while.

    Parâmetros: 
        Resultado do comando de consulta ao banco de dados (alguma variável)

    Comando: mysqli_fetch_assoc($resultadoDaConsulta);


mysqli_error

    O que é?: mysqli_error é um comando SQL que retorna a última mensagem de erro do banco de dados (caso exista alguma).

    Parâmetros:
        Conexão com o banco ($conexao);
        
    Comando: mysqli_error($conexao);