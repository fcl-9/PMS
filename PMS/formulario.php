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


$sql = "insert into cliente (contribuinte,nome, telemovel,email,apelido) values ({$_POST['contribuinte']},'{$_POST['nome']}','{$_POST['numero']}','{$_POST['email']}','{$_POST['apelido']}')";


echo $sql;

$resultado = mysqli_query($conn, $sql);

if (mysqli_num_rows($resultado) > 0) {
	echo "SUCESSO!\n";

}

mysqli_close($conn);

?> 
