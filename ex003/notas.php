<?php

$alunos = array ( // array para guardar os alunos
    array ("Matheus", 5.0, 4.0, 7.0, 6.0),
    array ("Anna", 9.0, 8.5, 10.0, 7.0),
    array ("Deborah", 0.5, 1.5, 2.5, 10.0),
    array ("Helena", 9.0, 8.0, 6.5, 9.5),
    array ("Pedro", 3.0, 7.0, 9.0, 5.0),
    array ("Theo", 3.0, 9.0, 10.0, 10.0),
    array ("Cecília", 10.0, 10.0, 9.5, 10.0)
);

echo "<table border='1'>"; // criando a table
echo "<tr>
        <th>Nome</th>
        <th>1º Nota</th>
        <th>2º Nota</th>
        <th>3º Nota</th>
        <th>4º Nota</th>
        <th>Média</th>
      </tr>"; // adiciona elemento na table
   
for ($c = 0; $c < count($alunos); $c++) { 
    // percorre os alunos no array

    $soma = 0; // vai zerar para cada aluno do array

    echo "<tr>";

    for ($n = 0; $n < count($alunos[$c]); $n++) { 
        // percorre os elementos dentro do aluno

        echo "<td>" . $alunos[$c][$n] . "</td>";
        // adiciona linha um "bloco" na tabela

        if ($n > 0) { // $n deve ser maior do que 0, pois 0 é o nome
            $soma += $alunos[$c][$n];
        }
    }

    // terminou de percorrer 1 aluno e pegou a soma de suas notas

    $quantNotas = count($alunos[$c]) - 1;
    // vai receber a quantidade de elementos dentro do aluno - 1 (nome)
    $media = $soma / $quantNotas;

    if ($media >= 6){
        $cor = "green";
    } else {
        $cor = "red";
    }

    echo "<td class='$cor'>" . number_format($media, 1) . "</td>";

    echo "</tr>";
}

echo "</table>";

?>