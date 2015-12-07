<?php
require('/common/database.php');
require('/common/common.php');
mysqli_autocommit($link,false);
if(isset($_POST['numerotel'],$_POST['inputPassword']))
{
	$numerotel = mysql_real_escape_string($_POST['numerotel']);
	$inputPassword = mysql_real_escape_string($_POST['inputPassword']);

	$numerotel = stripslashes($numerotel);
	$inputPassword = stripslashes($inputPassword);

	$numerotel = telefone($numerotel);

	$queryVerTelem = 'SELECT * FROM cliente WHERE telefone = \''.$numerotel.'\' AND password = \''.$inputPassword.'\'';
	$result = mysqli_query($link, $queryVerTelem);

	if($result)
	{
		if(mysqli_num_rows($result) == 1)
		{
			header("Location: userpage.html");  
		}
		else
		{
			echo "Os campos que introduziram estão incorretas.Certifique-se que colocou os campos corretos.";
		}
	}
	else
	{
		echo "Erro na query".mysqli_error($link);
		die;
	}
}
else
{
	echo "erro em colucar os nomes";
}
?>