<?php

require('/common/database.php');
require('/common/common.php');
session_start();
if(isset($_SESSION['cliente_id'])) 
{
	header("Location: userpage.php?id=");
}
if(isset($_POST['numerotel'],$_POST['inputPassword'])){
	$numerotel = mysqli_real_escape_string($link, $_POST['numerotel']);
	$inputPassword = mysqli_real_escape_string($link, $_POST['inputPassword']);

	$numerotel = stripslashes($numerotel);
	$inputPassword = stripslashes($inputPassword);

	$numerotel = telefone($numerotel);

	$queryVerTelem = "SELECT * FROM cliente WHERE telefone LIKE '$numerotel' AND password LIKE '$inputPassword'";
	$result = mysqli_query($link, $queryVerTelem);

	if($result){
		if(mysqli_num_rows($result) == 1)
		{	
			$row = mysqli_fetch_assoc($result);
			$_SESSION['cliente_id'] = $row['idcliente'];
			$_SESSION['cliente_nome'] = $row['nome'];
			$_SESSION['cliente_sobrenome'] = $row['sobrenome'];
			
		}
		else{
			echo '<p align="center">	Os campos que introduziram estão incorretas. Certifique-se que colocou os campos corretos.</p>';
		}
	}
	else{
		echo "Erro na query".mysqli_error($link);
		die;
	}

	if(isset($_SESSION['cliente_id'])) {
		header("Location: userpage.php?id=");
	}
}
include('login.html');
?>