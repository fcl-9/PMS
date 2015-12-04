<?php
require_once('/common/database.php');
require_once('/common/common.php');

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

$queryVerUser = 'SELECT * FROM cliente WHERE telefone = \''.$numero.'\'';
$verUser = mysqli_query($link,$queryVerUser);
//Verificar se o utilizador já existe
if(mysqli_num_rows($verUser) == 1)
{
	//verificar se ele tenta fazer reserva na mesma hora e no mesmo dia
	//queryResAnteriores = 'SELECT';
	if()
	//{
		//falha a reserva

	//}
	//else
	//{	
		//efetua a reserva && envia e-mail

	//}

}
else
{
	//registo um utilizador
	if(!addCliente($link,$nome,$password,$numero,$apelido,$email))
	{
		echo 'Erro na query' . mysqli_error($link);
		die;
	}
	else
	{
		//Por favor confirme o seu e-mail
		//regista reserva e envia a senha e o 

	}
}

mysqli_close($link);
}


?> 