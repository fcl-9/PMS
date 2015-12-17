<?php	
	require_once("../common/common.php");
	require_once("../common/database.php");
	
	if(!isset($_SESSION['cliente_id']) || $_SESSION['cliente_id'] == '')
	{
?>
		<p>Não tem autorização para aceder a esta página.</p>	
<?php	
	}
	else
	{
		if($_REQUEST["estado"] == "")
		{
			$query_reservas = "SELECT * FROM reservas";
			$result_reservas = mysqli_query($query_reservas);
			
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
			
					//$query_comp_type = "SELECT id, name FROM comp_type GROUP BY name";
					//$result_comp_type = mysql_query($query_comp_type);
			
					
						$query_listareserva = "SELECT * FROM cliente, reserva, reserva_has_mesa, mesa,
				WHERE reserva.cliente.id=cliente.id and reserva.ativo='1',
								GROUP BY reserva.date and reserva.time";
														
						$result_listareserva = mysqli_query($query_listareserva);
				
						
						
							while($array_listareserva = mysql_fetch_array($result_listareserva))
							{
?>
								<td> <?php echo $array_listareserva["reserva.id"] ?></td>
								<td> <?php echo $array_listareserva["cliente.nome"] ?> </td>
								<td> <?php echo $array_listareserva["reserva.data"] ?></td>
								<td> <?php echo $array_listareserva["reserva.hora"] ?></td>
								<td> <?php echo $array_listareserva["mesa.num_pessoas"] ?></td>
								<td> <?php echo $array_listareserva["mesa.id"] ?></td>
<?php						
								if($array_listareserva["state"] == "active")
								{
?>							
									<td>ativo</td>
									<td>[editar] [desativar]</td>
<?php
								}
								else
								{
?>							
								<td>inativo</td>
								<td>[editar] [desativar]</td>
<?php
								}							
?>
							</tr>
<?php						}									
						}				
					}			
?>
				 </tbody>
				</table>			
<?php					
			}
?>			
			