<?php
require('../common/database.php');
require('../common/common.php');
session_start();
if(empty($_SESSION['funcionario_id']))
{
    echo '<p>Não tem autorização para aceder a esta página.</p> ';  
    header( "refresh:6;url=/login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Administração</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
     <link rel='shortcut icon' type='image/x-icon' href='../images/favicon.png' />

</head>

<body>

    <!--<div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                <img alt="Brand" src="..\images\drawing2.png">
              </a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <p class="navbar-text" >Bem-Vindo(a),  <?php echo $_SESSION['funcionario_nome']; ?>!</p>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#adicionar"><span class="glyphicon glyphicon-plus"></span></i> Adicionar <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="adicionar" class="collapse">
                            <li>
                                <a href="#">Reserva</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#alterar"><span class="glyphicon glyphicon-refresh"></span></i> Alterar <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="alterar" class="collapse">
                            <li>
                                <a href="#">Reserva</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                       <a href="javascript:;" data-toggle="collapse" data-target="#remover"><span class="glyphicon glyphicon-remove"></span></i> Remover <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="remover" class="collapse">
                            <li>
                                <a href="#">Reserva</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Terminar Sessão</a>
                    </li>
               
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
<div class="corpo">
<?php	
	
		
	$querydata="SELECT CURDATE()";
	$result_data= mysqli_query($link, $querydata);
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
			
                <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span><i class="fa"></i> Reservas Efetuadas</h3>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
				 <thead>
                  <tr class="info">
                  <th>Número da Reserva</th>
                  <th>Cliente</th>
                  <th>Data da Reserva</th>
                  <th>Hora da Reserva</th>
                  <th>Número de Pessoas</th>
                  <th>Mesa</th>
                  <th>Selecionada</th>
                  </tr>
				 </thead>
			 
				 <tbody>
<?php

    $data=mysqli_fetch_array($result_data)[0];
						$query_listareserva = "SELECT DISTINCT * FROM cliente, reserva, reserva_has_mesa, mesa WHERE reserva.cliente_idcliente=cliente.idcliente and reserva_has_mesa.reserva_idreserva=reserva.idreserva  and reserva_has_mesa.mesa_numero=mesa.numero and reserva.ativo='1' and reserva.data=\"".$data."\"";
												
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
					            <td><input type="radio"></td>
                               </tr>
<?php							
}
?>
 </tbody>
                                    </table>
                                </div>
                                
                        </div>
                   
             
                
<?php            
				}
			
?>			

								

</div>
                <!-- /.row -->

            </div>
            <!-- FOOTER -->
      <footer class="container text-center footer">
         <p>&copy; 2015/2016 PMS GRUPO 2. &middot; </p>
      </footer>
        </div>
            <!-- /.container-fluid -->

        <!-- /#page-wrapper -->

    <!--</div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>


</body>

</html>

