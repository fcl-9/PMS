<?php
	require_once('/common/database.php');

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
					die;
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

				if(md5($result['email']) != $emailMd5)
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
						die;
					}
					else
					{
						echo 'Reserva confirmada.';
					}
				}
			}
			else
			{
				echo 'Reserva já se encontra validada.';
			}
		}
		else
		{
				echo 'Erro ao executar query #10'. mysqli_error($link);
				die;
		}
?>