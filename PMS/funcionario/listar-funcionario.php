<?php
	require_once("../common/common.php");
	require_once("../common/database.php");
	//require_once("../funcionario/login.php");
	session_start();
	if(empty($_SESSION['funcionario_id']))
	{
?>
		<p>Não tem autorização para aceder a esta página.</p>	
		<?php header( "refresh:6;url=/login.php" ); ?>
<?php	
	}
	else
	{
		//if($_REQUEST["estado"] == "")
		
			$query_reservas = "SELECT * FROM reserva";
			$result_reservas = mysqli_query($link, $query_reservas);
			if(!$result_reservas)
			{
				echo mysqli_error($link);
			}
			
			if (mysqli_num_rows($result_reservas) == 0)
			{
		echo "Não tem reservas para o dia de hoje";

			}
			else
			{
?>
			
				<table>
				 <thead>
				  <tr>
				   <th>Número de Reserva</th>
				   <th>Cliente</th>
				   <th>data</th>
				   <th>hora</th>
				   <th>Número de pessoas</th>
				   <th>Mesa</th>
				  </tr>
				 </thead>
			 
				 <tbody>
<?php
						$query_listareserva = "SELECT DISTINCT * FROM cliente, reserva, reserva_has_mesa, mesa WHERE reserva.cliente_idcliente=cliente.idcliente and reserva_has_mesa.reserva_idreserva=reserva.idreserva  and reserva_has_mesa.mesa_numero=mesa.numero and reserva.ativo='1'";
														
						$result_listareserva = mysqli_query($link, $query_listareserva);
				if(!$result_listareserva)
			{
				echo mysqli_error($link);
			}
						
						
							while($array_listareserva = mysqli_fetch_array($result_listareserva))
							{
?>								<tr>
								<td> <?php echo $array_listareserva["idreserva"] ?></td>
								<td> <?php echo $array_listareserva["nome"] ?> </td>
								<td> <?php echo $array_listareserva["data"] ?></td>
								<td> <?php echo $array_listareserva["hora"] ?></td>
								<td> <?php echo $array_listareserva["capacidade"] ?></td>
								<td> <?php echo $array_listareserva["numero"] ?></td>
					           </tr>
<?php							
}
            
				}
			}
?>			

								