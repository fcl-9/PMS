<?php
require_once('/common/database.php');
require_once('/common/common.php');
//Desativa commit automático, so no fim de todo o processo o utilizador 
mysqli_autocommit($link,false);
$flag = true;
if(isset( $_POST['nome'], $_POST['sobrenome'], $_POST['email'],$_POST['numerotel'],$_POST['datahora'],$_POST['selMesa'],$_POST['selNumPes']))
{

$nome = mysqli_real_escape_string($link,$_POST['nome']);
$apelido = mysqli_real_escape_string($link,$_POST['sobrenome']);
$email = mysqli_real_escape_string($link,$_POST['email']);
$numero = mysqli_real_escape_string($link,$_POST['numerotel']);
$data_hora = mysqli_real_escape_string($link,$_POST['datahora']);
$numPessoas = mysqli_real_escape_string($link,$_POST['selNumPes']);

$nome = stripslashes($nome);
$apelido = stripslashes($apelido);
$email = stripslashes($email);
$numero = stripslashes($numero);
$data_hora = stripslashes($data_hora);
$numPessoas = stripslashes($numPessoas);
$password = random_password(8);

$numero = telefone($numero);

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

$queryVerUser = 'SELECT * FROM cliente WHERE telefone = \''.$numero.'\' AND email = \''.$email.'\'';
$verUser = mysqli_query($link,$queryVerUser);
//Verificar se o utilizador já existe
if(mysqli_num_rows($verUser) == 1)
{
	//verificar se ele tenta fazer reserva na mesma hora e no mesmo dia
	$queryUserMail = 'SELECT idcliente, email FROM cliente WHERE telefone = \''.$numero.'\'';
	$resmail = mysqli_query($link,$queryUserMail);
	$resmail = mysqli_fetch_array($resmail);
	//Verifica se email introduzido match com o da base de dados.
	if($resmail['email'] == $email)
	{
		$limiteInicial = strtotime($dateArray["hora"])-5400; //1h30min sao 5400 segundos
		$limiteInicial = date("H:i:s",$limiteInicial);
		$limiteFinal = strtotime($dateArray["hora"])+5400;
		$limiteFinal = date("H:i:s",$limiteFinal);
		$queryResAnteriores = 'SELECT * FROM reserva as r, cliente as c WHERE r.cliente_idcliente='.$resmail['idcliente'].' AND r.hora BETWEEN \''.$limiteInicial.'\' AND \''.$limiteFinal.'\' AND r.data = \''.$dateArray["data"].'\'';
		$reservaAnteriores = mysqli_query($link,$queryResAnteriores);
		if(!$reservaAnteriores)
		{
			echo 'Erro na query #1' . mysqli_error($link);
			mysqli_rollback($link);
			//die;
		}
		if(mysqli_num_rows($reservaAnteriores) > 0)
		{
			//falha a reserva
			echo 'Já tem uma reserva para a mesma hora e para o mesmo dia.';
		}
		else
		{	
			//efetua a reserva && envia e-mail
			if(!addReserva($link,$numero,$numPessoas,$numMesa,$dateArray["data"],$dateArray["hora"],''))
			{
				mysqli_rollback($link);
			}
			else
			{
				mysqli_commit($link);
				//Info from the user
				$queryVerUser = 'SELECT c.idcliente FROM cliente AS c WHERE c.telefone = \''.$numero.'\'';
				$getId = mysqli_query($link,$queryVerUser);
				$idCli = mysqli_fetch_array($getId);

				//info from the reservation
				$getIdRes = "SELECT idreserva FROM reserva WHERE hora = '".$dateArray["hora"]."' AND data ='".$dateArray["data"]."' AND cliente_idcliente=".$idCli['idcliente']."";		 
				$getIdRes = mysqli_query($link,$getIdRes);
				$idReserva = mysqli_fetch_array($getIdRes);

				$url = sprintf( 'id=%s&email=%s&numTel=%s&idRes=%s',$idCli['idcliente'] ,md5($email), md5($numero),$idReserva['idreserva']);

				$corpoMsg = "Por favor comfirme a sua reserva através do endereço: <br>";
				$corpoMsg .= sprintf("http://localhost/ativar.php?%s",$url);
				
				mailConfim('Confirmação de Reserva Dom Petisco.',$corpoMsg,$email);
				//redirecionar para a página principal
				header( "refresh:3;url=index.html" );
			}
		}
	}
	else
	{	//email introduzido está mal pois n tá de acordo com o que está na bd
		echo 'Verifique se introduziu os dados corretamente.';
	}
}
else
{

		$queryUserMail = 'SELECT email FROM cliente WHERE telefone = \''.$numero.'\'';
		$resmail = mysqli_query($link,$queryUserMail);
		if(mysqli_num_rows($resmail) == 0)
		{
			//registo um utilizador
			if(!addCliente($link,$nome,$password,$numero,$apelido,$email))
			{
				echo 'Erro na query #2' . mysqli_error($link);
				mysqli_rollback($link);
				//die;
			}
			else
			{
				if(!addReserva($link,$numero,$numPessoas,$numMesa,$dateArray["data"],$dateArray["hora"],''))
				{
					mysqli_rollback($link);
				}
				else
				{
					mysqli_commit($link);
					//Info from the user
					$queryVerUser = 'SELECT c.idcliente FROM cliente AS c WHERE c.telefone = \''.$numero.'\'';
					$getId = mysqli_query($link,$queryVerUser);
					$idCli = mysqli_fetch_array($getId);

					//info from the reservation
					$getIdRes = "SELECT idreserva FROM reserva WHERE hora = '".$dateArray["hora"]."' AND data ='".$dateArray["data"]."' AND cliente_idcliente=".$idCli['idcliente']."";		 
					$getIdRes = mysqli_query($link,$getIdRes);
					$idReserva = mysqli_fetch_array($getIdRes);
					//Prepara link de confirmação
					$url = sprintf( 'id=%s&email=%s&numTel=%s&idRes=%s',$idCli['idcliente'] ,md5($email), md5($numero),$idReserva['idreserva']);
					$corpoMsg = "Por favor confirme a sua reserva atraves do endereço: ";
					$corpoMsg .= sprintf("http://localhost/ativar.php?%s",$url);
					
					//envia link de confirmação.
					mailConfim('Confirmacao de Reserva Dom Petisco.',$corpoMsg,$email);
					//rederecionar para a página principal.
					header( "refresh:3;url=index.html" );
				}

			}
		}
		else
		{
			//Telefone deve estar mal pois o mail já existe na base de dados
			echo 'Verifique se introduziu os dados corretamente.';
		}
}

mysqli_close($link);
}


?> 