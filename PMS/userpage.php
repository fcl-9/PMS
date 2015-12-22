<?php
require_once('common/database.php');
require_once('common/common.php');
session_start();
if(empty($_SESSION['cliente_id'])) 
{
    header("Location: login.php");
}
if(isset($_POST['cancelar'])) {
    $queryCancelar = sprintf("
        DELETE FROM reserva WHERE idreserva='%s'
    ", mysqli_real_escape_string($link, $_POST['cancelar']));
    echo $queryCancelar;
    mysqli_query($link, $queryCancelar);
}
?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Utilizador</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- CSS partilhado por todas as paginas-->
    <link href="css/common.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
     <link rel='shortcut icon' type='image/x-icon' href='/images/favicon.png' />

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
                <a class="navbar-brand" href="index.php">
                <img alt="Brand" src="images\drawing2.png">
              </a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <p class="navbar-text" >Bem-Vindo(a), <?php echo $_SESSION['cliente_nome'] .' '. $_SESSION['cliente_sobrenome']; ?> !</p>
            </ul>
        </nav>
<div class="corpo-user">
        <div class="col-md-3 buttons" id="buttons">
            
              <div class="botao">
                        <a  class="btn btn-primary" href="index.php#reserva"><span class="glyphicon glyphicon-refresh"></span> Reservar </a>
                </div>

          <!--        <div class="botao">
                    <a class="btn btn-warning"><span class="glyphicon glyphicon-remove"></span> Cancelar Reserva</a>
                </div >
            -->
                <div class="botao">

                        <a class="btn btn-success" href="userpage_alteradados.php"><span class="glyphicon glyphicon-user"></span> Alterar Dados do Cliente</a>

                </div>
                <div class="botao">            

                        <a class="btn btn-danger" href="logout.php"><span class="glyphicon glyphicon-off"></span> Terminar Sessão</a>

                </div>
            
        </div>
       

            <div class="col-md-9 container-fluid">
                <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span><i class="fa"></i> Reservas Efetuadas</h3>
                            </div>
                            <div class="panel-body">
							
                                <?php
								
								 $querydata="SELECT CURDATE()";
								 $result_data= mysqli_query($link, $querydata);
								  $data=mysqli_fetch_array($result_data)[0];
								//$intervalodias = gmdate("Y-m-d",time()+ 1);
								$intervaloTempo = gmdate("H:i:s", time() +60);
								  
								  
									  
                                    $query = sprintf("
                                        SELECT DISTINCT idreserva AS id, hora, data, cliente_idcliente, num_pessoas, mesa_numero
                                        FROM reserva, reserva_has_mesa,cliente 
                                        WHERE cliente_idcliente = '%s' AND ativo = '1' AND reserva_idreserva = idreserva and ((reserva.data = \"".$data."\" and reserva.hora>=\"".$intervaloTempo."\")or reserva.data > \"".$data."\")", mysqli_real_escape_string($link, $_SESSION['cliente_id']));
                                    $result = mysqli_query($link, $query);
                                    if (!$result) {
                                        die("Query error: " . mysqli_error($link));
                                        //con_close();
                                    }
                                    //echo mysqli_error($link) . "\n";
                                    if($result ):
                                ?> 
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr class="info">
                                                <th>Número da Reserva</th>
                                                <th>Data da Reserva</th>
                                                <th>Hora da Reserva</th>
                                                <th>Número de Pessoas</th>
                                                <th>Mesa</th>
                                                <th>Alterar</th>
                                                <th>Cancelar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($row = mysqli_fetch_assoc($result)): ?>
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['data']; ?></td>
                                                <td><?php echo $row['hora']; ?></td>
                                                <td><?php echo $row['num_pessoas']; ?></td>
                                                <td><?php echo $row['mesa_numero']; ?></td>
                                                <td>
                                                    <form id='alterar_reserva'action="userpage_alterarserva.php" method='POST'>
                                                        <input type='hidden' name='alterar' value=<?php echo "'" . $row['id'] . "'"; ?> />
                                                        <input type="submit" value='Alterar' />
                                                    </form>
                                                </td>
                                                <td>
                                                    <form id='cancelar_reserva'  method='POST'>
                                                        <input type='hidden' name='cancelar' value=<?php echo "'" . $row['id'] . "'"; ?> />
                                                        <input type="submit" onClick="return confirm('Tem a certeza que deseja cancelar esta reserva ?')" value='Cancelar' />
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php else: ?>
                                <div><p>Não tem reservas.</p></div>
                            <?php endif; ?>
                                
                        </div>
                   
             
                </div>
            <!-- /.container-fluid -->

        <!-- /#page-wrapper -->

    <!--</div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

</body>

</html>


