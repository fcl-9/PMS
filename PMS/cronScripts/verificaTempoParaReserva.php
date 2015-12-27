#!/usr/bin/php
<?php

	set_include_path('/var/www/html/common');
	require('common.php');
	require('database.php');

	 $querydata="SELECT CURDATE()"; 
     $data = mysqli_query($link, $querydata);
     $hoje = mysqli_fetch_array($data)[0];

     $intervaloTempo = gmdate("H:i:s", time() + 5399); //hora atual + 1h:30 - 1seg 	

     $queryReservas = "SELECT * FROM reserva WHERE data = '".$hoje."' AND hora = '".$intervaloTempo."'";
     
     $getReserva = mysqli_query($link,$queryReservas);
 if(!$queryReservas)
     {
     	echo 'Erro '.mysqli_error($link);
     }
    
    while($sacaId = mysqli_fetch_assoc($getReserva))
    {
    	//$sacaId = mysqli_fetch_assoc($link,$getReserva);
    
	//Dados do cliente.
    	$queryCli = "SELECT * FROM cliente WHERE idcliente = " .$sacaId['cliente_idcliente'];
    	$queryGetCliData = mysqli_query($link,$queryCli);
    	$dadosCli = mysqli_fetch_assoc($queryGetCliData);
	    	
    	$corpoMsg = "Relembramos que tem agendada uma reserva no restaurante Dom Petisco pelas ".$intervaloTempo." do dia ".$hoje;
		mailConfim('Lembrete de reserva Dom Petisco',$corpoMsg, $dadosCli['email'] );

		 file_put_contents("/var/www/html/cronScripts/notificaEmails.txt", "Email enviado para  ".$dadosCli['email']." as ".gmdate("H:i:s", time())."\n ",FILE_APPEND);
    }

    $horaCancela = gmdate("H:i:s", time() - 2701); //hora atual - 45 min
    $queryCancelaReservas = 'DELETE FROM reserva WHERE hora = \''.$horaCancela.'\'';
    echo $queryCancelaReservas;
    $queryCancelaReservas = mysqli_query($link,$queryCancelaReservas);
    if(!$queryCancelaReservas)
    {
        echo 'Erro '.mysqli_error($link);
    }
    else
    {
        file_put_contents("/var/www/html/cronScripts/reservasRemovidas.txt", "Foi removidas reservas as ".gmdate("H:i:s", time())."\n ",FILE_APPEND);
    }
    
    file_put_contents("/var/www/html/cronScripts/logsEnvioMails.txt", "Crontab rodou em: ". $hoje." ". gmdate("H:i:s", time())."\n ",FILE_APPEND);


?>
