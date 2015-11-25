<html>
<body>
<?php

/*
 * faz a conexao à base de dados
 * e seleciona a base de dados
 */
$servername = "eu-cdbr-azure-west-c.cloudapp.net";
$username = "b1d0197c9b0f56";
$password = "455da09c";

// Create connection
$conn = mysql_connect($servername, $username, $password) or die ("Erro na conexão à base de dados.");
$db = mysql_select_db("restaurante", $conn) or die ("Erro ao selecionar a base de dados.");

/*
 * monta query em SQL para insercao
 */
/*
SELECT COUNT(mesa.numero), cliente.contribuinte
FROM mesa, cliente, registado, reserva, mesa_has_reserva
WHERE cliente.contribuinte=reserva.cliente_contribuinte and mesa_has_reserva.mesa_numero=mesa.numero
*/
    

$query = "SELECT COUNT(mesa.numero), cliente.contribuinte FROM mesa, cliente, registado, reserva, mesa_has_reserva WHERE cliente.contribuinte=reserva.cliente_contribuinte and mesa_has_reserva.mesa_numero=mesa.numero";
$dave= mysql_query($query) or die(mysql_error());




//*Percorre a base de dados para encontrar o resultado da Query´s
while($row = mysql_fetch_assoc($dave)){
    foreach($row as $cname => $cvalue){
		if($cname=="COUNT(mesa.numero)") $cname="Mesa ocupada";
        print "$cname: <td>$cvalue\t </td>";
    }
    print "\r\n";
}
/*$sum = $row['mesas.numero'];
/*
 * executa a query
 */

?>

