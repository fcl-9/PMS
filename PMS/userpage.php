<?php
/*
 * faz a conexao à base de dados
 * e seleciona a base de dados
 */
$servername = "eu-cdbr-azure-west-c.cloudapp.net";
$username = "b1d0197c9b0f56";
$password = "455da09c";
$db = "restaurante";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);

if (!$conn) {
 die("Connection failed: " . mysqli_connect_error());
}


$sql = "select cliente.email, cliente.passsword from cliente where cliente.email = \"{$_POST['inputEmail']}\" and cliente.passsword = \"{$_POST['inputPassword']}\"";


//echo $sql;

$resultado = mysqli_query($conn, $sql);

if (mysqli_num_rows($resultado) > 0) {
	echo "SUCESSO!\n";

}
else
{		echo "entra";
		header('login.php');
		exit();   

}

mysqli_close($conn);

?> 
