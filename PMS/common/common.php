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
			for($i = 0; $i < count($numMesa);$i++)
			{
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
				$queryMesaRes = 'INSERT INTO `reserva_has_mesa`(`reserva_idreserva`, `mesa_numero`, `num_pessoas`) VALUES ('.$idReserva['idreserva'].','.$numMesa[$i].','.$numPessoas.')';
				$reservaFinish = mysqli_query($link,$queryMesaRes);
				if(!$reservaFinish)
				{
					echo 'Erro ao executar query #7'. mysqli_error($link);
					return false;
					//die;
				}
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
function updateReserva($link,$numPessoas,$numMesa,$data,$hora,$idReserva)
{
		$queryInsRes = "UPDATE `reserva` SET data = '".$data."', hora = '".$hora."' WHERE idreserva = ".$idReserva;
		$reservaAtualizada = mysqli_query($link,$queryInsRes);
		if($reservaAtualizada)
		{
			//Verifico quantas mesas estão associadas a reserva que vou alterar
			$verificaMesas = "SELECT * FROM reserva_has_mesa WHERE reserva_idreserva = ".$idReserva;
			$verificaMesas = mysqli_query($link,$verificaMesas);
			//Atualiza a relação muitos para muitos entre mesa e reserva
			for($i = 0; $i < count($numMesa);$i++)
			{				
				if(count($numMesa) >= mysqli_num_rows($verificaMesas))
				{
					if($i==0)
					{
						$queryMesaRes = 'UPDATE `reserva_has_mesa` SET mesa_numero = '.$numMesa[$i].', num_pessoas = '.$numPessoas.' WHERE reserva_idreserva = '.$idReserva;
						$mesaAtualizada = mysqli_query($link,$queryMesaRes);
						if(!$mesaAtualizada)
						{
							echo 'Erro ao executar query #8'. mysqli_error($link);
							return false;
							//die;
						}
					}
					else
					{
						$queryMesaRes = 'INSERT INTO `reserva_has_mesa`(`reserva_idreserva`, `mesa_numero`, `num_pessoas`) VALUES ('.$idReserva.','.$numMesa[$i].','.$numPessoas.')';
						$reservaFinish = mysqli_query($link,$queryMesaRes);
						if(!$reservaFinish)
						{
							echo 'Erro ao executar query #9'. mysqli_error($link);
							return false;
							//die;
						}
					}
				}
				else
				{
						if($i==0)
						{
							$queryMesaRes = 'DELETE * FROM reserva_has_mesa  WHERE reserva_idreserva = '.$idReserva;
							$reservaFinish = mysqli_query($link,$queryMesaRes);
							if(!$reservaFinish)
							{
								echo 'Erro ao executar query #10'. mysqli_error($link);
								return false;
								//die;
							}
						}
						
						$queryMesaRes = 'INSERT INTO `reserva_has_mesa`(`reserva_idreserva`, `mesa_numero`, `num_pessoas`) VALUES ('.$idReserva.','.$numMesa[$i].','.$numPessoas.')';
						$reservaFinish = mysqli_query($link,$queryMesaRes);
						if(!$reservaFinish)
						{
							echo 'Erro ao executar query #11'. mysqli_error($link);
							return false;
							//die;
						}
					
				}
				
			}
			
			return true; 
		}
		else
		{
			echo 'Erro ao executar query #9'. mysqli_error($link);
			return false;
			//die;
		}
	
}

	/*Envia um email ao cliente recebe o assunto o corpo da mensagem, ainda o email do cliente.*/
	function mailConfim($assunto,$corpoMsg,$emailCli)
	{
		$mail = new PHPMailer(); // create a new object
		$mail->CharSet = 'UTF-8';
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true; // authentication enabled
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465; // or 587
				$mail->Username = "dompetisco.pms@gmail.com";
		$mail->Password = "12345678nao";
		$mail->SetFrom("dompetisco.pms@gmail.com","Dom Petisco");
		$mail->AddReplyTo("dompetisco.pms@gmail.com","Dom Petisco");
		$mail->Subject = $assunto;
		$mail->Body = $corpoMsg;
		$mail->IsHTML(true);
		$mail->AddAddress($emailCli);

	 	if(!$mail->Send()) {
		    echo "Erro ao gerar o email de confirmação. Por favor contacte a gerência " . $mail->ErrorInfo;
		} else {
		  //  echo "Foi enviado um email com um link de confirmação.";
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

	function juntaDataHora($data,$hora)
	{
		$dataHora = $data.' '.$hora;
		return substr($dataHora,0,-3);
	}
?>