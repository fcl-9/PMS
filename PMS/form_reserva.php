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

$queryVerUser = 'SELECT * FROM cliente WHERE telefone = \''.$numero.'\'';
$verUser = mysqli_query($link,$queryVerUser);
//Verificar se o utilizador já existe
if(mysqli_num_rows($verUser) == 1)
{
	//verificar se ele tenta fazer reserva na mesma hora e no mesmo dia
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
			echo 'RESERVA EFETUADA';
			//Falta mandar o mail com o link de confirmação para ativar a reserva.
		}
	}

}
else
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
			echo 'RESERVA EFETUADA';
			//Falta mandar o mail com o link de confirmação para ativar a reserva.
		}

	}
}

mysqli_close($link);
}


?> 