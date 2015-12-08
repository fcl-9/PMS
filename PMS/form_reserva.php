<?php
require_once('/common/database.php');
require_once('/common/common.php');
//Desativa commit automático, so no fim de todo o processo o utilizador 
mysqli_autocommit($link,false);
$flag = true;
if(isset( $_POST['nome'], $_POST['sobrenome'], $_POST['email'],$_POST['numerotel'],$_POST['datahora'],$_POST['selMesa'],$_POST['selNumPes']))
{

$nome = mysql_real_escape_string($_POST['nome']);
$apelido = mysql_real_escape_string($_POST['sobrenome']);
$email = mysql_real_escape_string($_POST['email']);
$numero = mysql_real_escape_string($_POST['numerotel']);
$data_hora = mysql_real_escape_string($_POST['datahora']);
$numMesa = mysql_real_escape_string($_POST['selMesa']);
$numPessoas = mysql_real_escape_string($_POST['selNumPes']);

$nome = stripslashes($nome);
$apelido = stripslashes($apelido);
$email = stripslashes($email);
$numero = stripslashes($numero);
$data_hora = stripslashes($data_hora);
$numMesa = stripslashes($numMesa);
$numPessoas = stripslashes($numPessoas);
$password = random_password(8);

$numero = telefone($numero);

$dateArray =converteDataHora($data_hora);

$queryVerUser = 'SELECT * FROM cliente WHERE telefone = \''.$numero.'\' AND email = \''.$email.'\'';
$verUser = mysqli_query($link,$queryVerUser);
//Verificar se o utilizador já existe
if(mysqli_num_rows($verUser) == 1)
{
	//verificar se ele tenta fazer reserva na mesma hora e no mesmo dia
	$queryUserMail = 'SELECT email FROM cliente WHERE telefone = \''.$numero.'\'';
	$resmail = mysqli_query($link,$queryUserMail);
	$resmail = mysqli_fetch_array($resmail);
	//Verifica se email introduzido match com o da base de dados.
	if($resmail['email'] == $email)
	{
		$queryResAnteriores = 'SELECT * FROM reserva as r, cliente as c WHERE c.idcliente = r.cliente_idcliente AND r.hora = \''.$dateArray["hora"].'\' AND r.data = \''.$dateArray["data"].'\'';
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