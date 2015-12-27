<?php
require_once('../common/database.php');
require_once('../common/common.php');
//Desativa commit automático, so no fim de todo o processo o utilizador 
mysqli_autocommit($link,false);
$flag = true;
if(isset($_POST['datahora'],$_POST['selMesa'],$_POST['selNumPes'],$_POST['reserva']))
{

$data_hora = mysql_real_escape_string($_POST['datahora']);
$numero = mysql_real_escape_string($_POST['numerotel']);
$numPessoas = mysql_real_escape_string($_POST['selNumPes']);
$numero = stripslashes($numero);
$email = mysql_real_escape_string($_POST['email']);


$data_hora = stripslashes($data_hora);
$numPessoas = stripslashes($numPessoas);
$email = stripslashes($email);
$numero = stripslashes($numero);

$dateArray =converteDataHora($data_hora);


// Tratamento das mesas
if($_POST['necessarioJuntar'] == 1)
{
	$numMesa = unserialize(base64_decode($_POST['selMesa']));  //Se for necessário juntar volto a colocar as mesas num array para mais fácil manipulação
}
else
{
	$numMesa = array(0=>$_POST['selMesa']);
}

// Caso não seja preenchida mesa gera mesa aleatória
if($_POST['selMesa'] == '')
{
	$limiteInicial = strtotime($dateArray["hora"])-5400; //1h30min sao 5400 segundos
    $limiteInicial = gmdate("H:i:s",$limiteInicial);
    $limiteFinal = strtotime($dateArray["hora"])+5400;
    $limiteFinal = gmdate("H:i:s",$limiteFinal);
    $mesasLivres = "SELECT m.numero, m.capacidade FROM mesa AS m WHERE m.numero NOT IN (SELECT rhm.mesa_numero FROM reserva_has_mesa as rhm , reserva as r WHERE r.hora BETWEEN \''.$limiteInicial.'\' AND \''.$limiteFinal.'\' AND r.data ='".$dateArray['data']."' AND rhm.reserva_idreserva = r.idreserva)";
    $mesasLivres = mysqli_query($link, $mesasLivres);
    if(!$mesasLivres)
    {
    	echo 'ERRO '.mysqli_error($link).'<br>';
    }
    while($numerosMesa = mysqli_fetch_assoc($mesasLivres))
    {
    	if($numerosMesa['capacidade'] >= $_POST['selNumPes'])
    	{
    		$numMesa = array(0=>$numerosMesa['numero']);
    		break;
    	}
    }
}
			//efetua a reserva && envia e-mail
			if(!updateReserva($link,$numPessoas,$numMesa,$dateArray["data"],$dateArray["hora"],$_POST['reserva']))
			{
				mysqli_rollback($link);
			}
			else
			{
				mysqli_commit($link);
				//Info from the user
							
				echo 'Reserva alterada com sucesso!'; 
				echo "A sua reserva foi alterada para o dia ".$dateArray["data"]." às ".$dateArray["hora"]."\nObrigado pela sua preferência!";
				
				//redirecionar para a página principal
				header( "refresh:5;url=funcmain.php" );
			}
		
	


mysqli_close($link);
}
?> 
<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Administração</title>

	<!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">


	<!-- Custom CSS -->
	<link href="../css/sb-admin.css" rel="stylesheet">

	<!-- Custom Fonts -->
	<link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link rel='shortcut icon' type='image/x-icon' href='../images/favicon.png' />

        <link href="../css/bootstrap-datetimepicker.css" rel="stylesheet">
        

    </head>
</html>
