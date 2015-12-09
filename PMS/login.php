<?php

require('/common/database.php');
require('/common/common.php');

session_start();

mysqli_autocommit($link,false);

if(isset($_POST['numerotel'],$_POST['inputPassword'])){
	$numerotel = mysql_real_escape_string($_POST['numerotel']);
	$inputPassword = mysql_real_escape_string($_POST['inputPassword']);

	$numerotel = stripslashes($numerotel);
	$inputPassword = stripslashes($inputPassword);

	$numerotel = telefone($numerotel);

	$queryVerTelem = "SELECT * FROM cliente WHERE telefone LIKE '$numerotel' AND password LIKE '$inputPassword'";
	$result = mysqli_query($link, $queryVerTelem);

	if($result){
		if(mysqli_num_rows($result) > 0){
			
			while($row = mysqli_fetch_assoc($result)){
				$_SESSION['cliente_id'] = $row['idcliente'];
				$_SESSION['cliente_nome'] = $row['nome'];
				$_SESSION['cliente_sobrenome'] = $row['sobrenome'];
			}
		}
		else{
			echo "Os campos que introduziram estão incorretas. Certifique-se que colocou os campos corretos.";
		}
	}
	else{
		echo "Erro na query".mysqli_error($link);
		die;
	}

	if(isset($_SESSION['cliente'])) {
		header("Location: userpage.php");
	}

}
else{
	echo "Erro em colocar os nomes.";
}

?>