<?php
require_once("/phpmailer/class.phpmailer.php");

/*Gera um conjunto de caratéres que servirá de password.*/
function random_password( $length = 8 ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}
/*Função para adicionar cliente*/
function addCliente($link,$nome,$password,$numero,$apelido,$email)
{
	$queryReserva = 'INSERT INTO `cliente`(`idcliente`, `nome`, `password`, `telefone`, `sobrenome`, `email`) VALUES ( NULL,\''.$nome.'\',\''.$password.'\',\''.$numero.'\',\''.$apelido.'\',\''.$email.'\')';
	$resultado = mysqli_query($link, $queryReserva);
	if($resultado)
	{

		return true;
	}
	else
	{	mysqli_error($link);
		return false;
	}
}

/*Função que permite aos clientes ou funcionários criar reservas.*/
function addReserva($link,$numtel,$numPessoas,$numMesa,$data,$hora,$idFunc)
{
	$queryVerUser = 'SELECT c.idcliente FROM cliente AS c WHERE c.telefone = \''.$numtel.'\'';
	$getId = mysqli_query($link,$queryVerUser);
	if($getId)
	{
		$idCli = mysqli_fetch_array($getId);
		$queryInsRes = "INSERT INTO `reserva`(`idreserva`, `hora`, `data`, `funcionario_idfuncionario`, `cliente_idcliente`) VALUES (NULL,'".$hora."','".$data."',".(($idFunc=='')?"NULL":("'".$idFunc."'")).",".$idCli['idcliente'].")";
		$reservaDone = mysqli_query($link,$queryInsRes);
		if($reservaDone)
		{
			//Encontra o id da mesa a adicionar
			$queryAddMesa = 'SELECT numero FROM mesa WHERE numero ='.$numMesa;
			$getIdMesa = mysqli_query($link,$queryAddMesa);
			if(!$getIdMesa)
			{
				echo 'Erro ao executar query #3'. mysqli_error($link);
				return false;
				//die;
			}
			//Recebe o id da reserva feita neste momento
			$getIdRes = "SELECT idreserva FROM reserva WHERE hora = '".$hora."' AND data ='".$data."' AND cliente_idcliente=".$idCli['idcliente']."";		 
			$getIdRes = mysqli_query($link,$getIdRes);
			if(!$getIdRes)
			{
				echo 'Erro ao executar query #4'. mysqli_error($link);
				return false;
				//die;
			}
			//Transofrmar em array associativo
			$idReserva = mysqli_fetch_array($getIdRes);
			//echo $idReserva['idreserva'].'<br>';
			$queryMesaRes = 'INSERT INTO `reserva_has_mesa`(`reserva_idreserva`, `mesa_numero`, `num_pessoas`) VALUES ('.$idReserva['idreserva'].','.$numMesa.','.$numPessoas.')';
			$reservaFinish = mysqli_query($link,$queryMesaRes);
			if(!$reservaFinish)
			{
				echo 'Erro ao executar query #7'. mysqli_error($link);
				return false;
				//die;
			}
			return true; 
		}
		else
		{
			echo 'Erro ao executar query #5'. mysqli_error($link);
			return false;
			//die;
		}
	}
	else
	{
		echo 'Erro ao executar query  #6'. mysqli_error($link);
		return false;
		//die;
	}
}
	/*Envia um email ao cliente recebe o assunto o corpo da mensagem, ainda o email do cliente.*/
	function mailConfim($assunto,$corpoMsg,$emailCli)
	{
		$mail = new PHPMailer(); // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true; // authentication enabled
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465; // or 587
		$mail->IsHTML(true);
		$mail->Username = "dompetisco.pms@gmail.com";
		$mail->Password = "12345678nao";
		$mail->SetFrom("dompetisco.pms@gmail.com","Dom Petisco");
		$mail->AddReplyTo("dompetisco.pms@gmail.com","Dom Petisco");
		$mail->Subject = $assunto;
		$mail->Body = $corpoMsg;
		$mail->AddAddress($emailCli);

	 	if(!$mail->Send()) {
		    echo "Erro ao gerar o email de confirmação. Por favor contacte a gerência" . $mail->ErrorInfo;
		} else {
		    echo "Foi enviado um email com um link de confirmação.";
		}
	}
	/*Converte a data e a hora do datapicker para uma base de dados.*/
	function converteDataHora($dataHora)
	{
 		 $data = substr($dataHora, 0, 10);
 		 $hora = substr($dataHora, 11).':00';
 		 $array = array("data" => $data, "hora" => $hora);
 		 return $array;
	}
	//Remove espaços dos números de telefone
	function telefone($string)
	{
		return str_replace(' ','',$string);
	}
?>