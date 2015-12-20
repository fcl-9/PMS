<?php

require('common/database.php');
require('common/common.php');


if(isset($_POST['numerotel'])){
	$numerotel = mysqli_real_escape_string($link,$_POST['numerotel']);

	$numerotel = stripslashes($numerotel);

	$numerotel = telefone($numerotel);

	$queryVerTelem = "SELECT * FROM cliente WHERE telefone = '$numerotel'";
	$result = mysqli_query($link, $queryVerTelem);
	//$emailSendInfo = $result['email'];
	
	
	
	if (mysqli_num_rows($result) == 0)
	{	
		echo "O número de telefone não é válido. Verifique e volte a tentar";	
		header('Refresh: 2; recover.html');
	}
	else{
		while($array_result = mysqli_fetch_array($result))
		{
			$emailSendInfo = $array_result["email"];
			$passe= $array_result['password'];
			echo $array_result["nome"]." enviamos um e-mail para ".$array_result["email"]." para recuperares a tua palavra passe.";
		}	   
		$assunto = "Recuperar a sua senha\n"."A sua palavra passe de acesso é <strong>".$passe."</strong> utilize a nossa área de login se desejar efetuar alterações.\n"."Agradecemos a sua preferência.";
		$titulo = "Recuperação de Password";
		mailConfim($titulo,$assunto,$emailSendInfo);
		header('Refresh: 2; login.php');
	}
}


?>