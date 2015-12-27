<?php
require_once('/common/database.php');
require_once('/common/common.php');
//Desativa commit automático, so no fim de todo o processo o utilizador 
mysqli_autocommit($link,false);
$flag = true;
if(isset($_POST['datahora'],$_POST['selMesa'],$_POST['selNumPes'],$_POST['reserva']))
{

$data_hora = mysqli_real_escape_string($link,$_POST['datahora']);
$numero = mysqli_real_escape_string($link,$_POST['numerotel']);
$numPessoas = mysqli_real_escape_string($link,$_POST['selNumPes']);
$numero = stripslashes($numero);
$email = mysqli_real_escape_string($link,$_POST['email']);


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
    $limiteInicial = date("H:i:s",$limiteInicial);
    $limiteFinal = strtotime($dateArray["hora"])+5400;
    $limiteFinal = date("H:i:s",$limiteFinal);
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
				$queryVerUser = 'SELECT c.idcliente, c.nome, c.sobrenome FROM cliente AS c WHERE c.telefone = \''.$numero.'\'';
				$getId = mysqli_query($link,$queryVerUser);
				$idCli = mysqli_fetch_array($getId);

				$corpoMsg = "Caro(a) ".$idCli["nome"]." ".$idCli["sobrenome"]."\nA sua reserva foi alterada para o dia ".$dateArray["data"]." às ".$dateArray["hora"]."\nObrigado pela sua preferência!";
				
				mailConfim('Confirmação de Alteração de Reserva Dom Petisco.',$corpoMsg,$email);
				echo 'Foi enviado um email de confirmção com os novos dados da sua reserva.'; 
				//redirecionar para a página principal
				header( "refresh:3;url=userpage.php" );
			}
		
	


mysqli_close($link);
}


?> 