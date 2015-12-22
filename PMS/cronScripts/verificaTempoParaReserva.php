<?php
	require_once('../common/common.php');
	require_once('../common/database.php');
while(1==1)
{
	 $querydata="SELECT CURDATE()"; 
     $data = mysqli_query($link, $querydata);
     $hoje = mysqli_fetch_array($data)[0];

     $intervaloTempo = gmdate("H:i:s", time() + 5400); //DataAtual + 1 min 	

     $queryReservas = "SELECT * FROM reserva WHERE data = '".$hoje."' AND hora = '".$intervaloTempo."'";
     $getReserva = mysqli_query($link,$queryReservas);
 if(!$queryReservas)
     {
     	echo 'Erro '.$mysqli_error($link);
     }
     
    while(mysqli_num_rows($getReserva) > 0)
    {
    	$sacaId = mysqli_fetch_assoc($link,$getReserva);
    	//Dados do cliente.
    	$queryCli = "SELECT * FROM cliente WHERE idcliente = " .$sacaId['cliente_idcliente'];
    	$queryGetCliData = mysqli_query($link,$queryCli);
    	$dadosCli = mysql_fetch_assoc($link,$queryGetCliData);
    	
    	$corpoMsg = "Relembra-mos que tem agendada uma reserva no restaurante Dom Petisco pelas ".$intervaloTempo." do dia ".$hoje;
		mailConfim('Lembrete de reserva Dom Petisco',$corpoMsg, $dadosCli['email'] );

    }
}
?>