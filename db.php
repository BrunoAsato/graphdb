<?php
$conexao = mysql_connect("localhost","root","180693");
//die(print_r($conexao));
//seleciona o banco de dados que será usado

//mysql_select_db("ejem");
$sql = "SELECT * FROM information_schema.columns WHERE table_schema = 'ejem'";
$query = mysql_query($sql);
?>
<table>
<tr>
    <th>Nome da tabela</th>
    <th>Posição</th>
    <th>Nome da coluna</th>
    <th>Nullo</th>
    <th>Largura</th>
    <th>Tipo</th>
    <th>Chave</th>
    <th>Extra</th>
</tr>
<?php
$table = "";
while($dados = mysql_fetch_array($query)) {
    echo "<tr>";
    if($table != $dados['TABLE_NAME']){
        echo "<tr><td colspan='9'></td></tr><tr><td colspan='9'></td></tr><tr><td colspan='9'></td></tr>";
        echo "<td>" . $dados['TABLE_NAME'] . "</td>";
    } else {
        echo "<td></td>";
    }

    $table = $dados['TABLE_NAME'];
    echo "<td>" . $dados['ORDINAL_POSITION'] . "</td>";
    echo "<td>" . $dados['COLUMN_NAME'] . "</td>";
    echo "<td>" . $dados['IS_NULLABLE'] . "</td>";
    echo "<td>" . $dados['CHARACTER_MAXIMUM_LENGTH'] . "</td>";
    echo "<td>" . $dados['COLUMN_TYPE'] . "</td>";
    echo "<td>" . $dados['COLUMN_KEY'] . "</td>";
    echo "<td>" . $dados['EXTRA'] . "</td>";
    echo "</tr>";
}
?>
</table>
<?php

/*


[0] => def
    [TABLE_CATALOG] => def
    [1] => ejem
    [TABLE_SCHEMA] => ejem
    [2] => atividade
    [TABLE_NAME] => atividade
    [3] => id_atividade
    [COLUMN_NAME] => id_atividade
    [4] => 1
    [ORDINAL_POSITION] => 1
    [5] => 
    [COLUMN_DEFAULT] => 
    [6] => NO
    [IS_NULLABLE] => NO
    [7] => int
    [DATA_TYPE] => int
    [8] => 
    [CHARACTER_MAXIMUM_LENGTH] => 
    [9] => 
    [CHARACTER_OCTET_LENGTH] => 
    [10] => 10
    [NUMERIC_PRECISION] => 10
    [11] => 0
    [NUMERIC_SCALE] => 0
    [12] => 
    [CHARACTER_SET_NAME] => 
    [13] => 
    [COLLATION_NAME] => 
    [14] => int(11)
    [COLUMN_TYPE] => int(11)
    [15] => PRI
    [COLUMN_KEY] => PRI
    [16] => auto_increment
    [EXTRA] => auto_increment
    [17] => select,insert,update,references
    [PRIVILEGES] => select,insert,update,references
    [18] => 
    [COLUMN_COMMENT] => 

    */
   ?>