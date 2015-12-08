<?php
	require_once('/common/database.php');
	require_once('/common/common.php');
mysqli_autocommit($link,false);
$flag = true;

	$id = $_GET['id'];
	$emailMd5 = $_GET['email'];
	$numTel = $_GET['numTel'];
	$idReserva = $_GET['idRes'];

	//Verificar se a reserva já está ativa.
	$verificaReserva = 'SELECT 	ativo FROM reserva WHERE idreserva = '.$idReserva.'';
	$verAtivo = mysqli_query($link,$verificaReserva);
	//Query ok? 
	if($verAtivo)
	{
		$verAtivo = mysqli_fetch_array($verAtivo);
			//Query inativa?
			if($verAtivo['ativo'] == 0)
			{
				$queryVerUser = 'SELECT * FROM cliente WHERE idcliente = '.$id.'';
				$result = mysqli_query($link,$queryVerUser);
				if(!$result)
				{
					echo 'Erro ao executar query #8'. mysqli_error($link);
					mysqli_rollback($link);
				}
				$controlVar = true;
				//Verifica se o id existe
				if(mysqli_num_rows($result) <= 0)
				{				
					$controlVar = false;
				}

				$result = mysqli_fetch_array($result); 
				if(md5($result['telefone']) != $numTel)
				{
					$controlVar = false;
				}
				$emailSendInfo = $result['email'];
				if(md5($emailSendInfo) != $emailMd5)
				{
					$controlVar = false;
				}

				if($controlVar == true)
				{
					$updateQuery = 'UPDATE reserva SET ativo = 1 WHERE idreserva ='.$idReserva.'';
					$result = mysqli_query($link,$updateQuery);
					if(!$result)
					{
						echo 'Erro ao executar query #9'. mysqli_error($link);
						mysqli_rollback($link);
					}
					else
					{
						echo 'Reserva confirmada.';
						//Gerar nova password e enviar por mail a password a hora o dia 
						$password = random_password(8);
						$updatePassword = 'UPDATE cliente SET password = '.$password.' WHERE idcliente = '.$id.'';	
						$sucessPwd = mysqli_query($link,$updatePassword);
						if($sucessPwd)
						{
							echo 'Erro ao executar query #10'. mysqli_error($link);
							mysqli_rollback($link);
						}

						$getReservDetails = 'SELECT * FROM reserva WHERE idreserva ='.$idReserva.'';
						$getDetails = mysqli_query($link, $getReservDetails);
						if(!$getDetails)
						{
							echo 'Erro ao executar query #11'. mysqli_error($link);
							mysqli_rollback($link);
						}

						$getDetails = mysqli_fetch_array($getDetails);

						$corpoMsg = "Por favor comfirme a sua reserva através do endereço: ";
						$corpoMsg .= "A sua nova password de acesso é ".$password." utilize a nossa àrea de login se desejar efetuar alterações. ";
						$corpoMsg .= "A sua reserva está agendada para o dia ".$getDetails['data']." pelas ".$getDetails['hora']." Agradecemos a sua preferência.";

						mailConfim('Reserva agendada.',$corpoMsg, $emailSendInfo);

						mysqli_commit($link);
						//header( "refresh:3;url=index.html" );
					}
				}
			}
			else
			{
				echo 'Reserva já se encontra validada.';
				header( "refresh:3;url=index.html" );
			}
		}
		else
		{
				echo 'Erro ao executar query #12'. mysqli_error($link);
				die;
		}
	mysqli_close($link);
?>