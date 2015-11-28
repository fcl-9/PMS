<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Bootstrap Admin Template</title>

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
                <a class="navbar-brand" href="#">
                <img alt="Brand" src="images\drawing2.png">
              </a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <p class="navbar-text" >Bem-Vindo(a), John Smith!</p>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <!--<div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="index.html"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span><i class="fa"></i> Alterar Reserva</a>
                    </li>
                    <li>
                        <a href="charts.html"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span><i class="fa"></i> Cancelar Reserva</a>
                    </li>
                    <li>
                        <a href="tables.html"><i class="fa fa-fw fa-user"></i> Alterar Dados do Cliente</a>
                    </li>
                    <li>
                        <a href="forms.html"><i class="fa fa-fw fa-power-off"></i> Terminar Sessão</a>
                    </li>
               
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
<div class="corpo">
        <div class="col-md-3 buttons" id="buttons">
            
                <div class="botao">
                        <a  class="btn btn-primary" href="index.html"><span class="glyphicon glyphicon-refresh"></span> Alterar Reserva</a>
                </div>
                <div class="botao">

                        <a class="btn btn-warning" href="charts.html"><span class="glyphicon glyphicon-remove"></span> Cancelar Reserva</a>

                </div >
            
            
                <div class="botao">

                        <a class="btn btn-success" href="tables.html"><span class="glyphicon glyphicon-user"></span> Alterar Dados do Cliente</a>

                </div>
                <div class="botao">            

                        <a class="btn btn-danger" href="forms.html"><span class="glyphicon glyphicon-off"></span> Terminar Sessão</a>

                </div>
            
        </div>
       

            <div class="col-md-9 container-fluid">

                            <div class="panel-heading">
                                <h3 class="panel-title"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span><i class="fa"></i> Reservas Efetuadas</h3>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr class="info">
                                                <th>Número da Reserva</th>
                                                <th>Data da Reserva</th>
                                                <th>Hora da Reserva</th>
                                                <th>Número de Pessoas</th>
                                                <th>Mesa</th>
                                                <th>Selecionada</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>3326</td>
                                                <td>10/21/2013</td>
                                                <td>3:29 PM</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td><input type="checkbox"></td>
                                            </tr>
                                            <tr class="info">
                                                <td>3325</td>
                                                <td>10/21/2013</td>
                                                <td>3:20 PM</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td><input type="checkbox"></td>
                                            </tr>
                                            <tr>
                                                <td>3324</td>
                                                <td>10/21/2013</td>
                                                <td>3:03 PM</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td><input type="checkbox"></td>
                                            </tr>
                                            <tr class="info">
                                                <td>3323</td>
                                                <td>10/21/2013</td>
                                                <td>3:00 PM</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td><input type="checkbox"></td>
                                            </tr>
                                            <tr>
                                                <td>3322</td>
                                                <td>10/21/2013</td>
                                                <td>2:49 PM</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td><input type="checkbox"></td>
                                            </tr>
                                            <tr class="info">
                                                <td>3321</td>
                                                <td>10/21/2013</td>
                                                <td>2:23 PM</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td><input type="checkbox"></td>
                                            </tr>
                                            <tr >
                                                <td>3320</td>
                                                <td>10/21/2013</td>
                                                <td>2:15 PM</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td><input type="checkbox"></td>
                                            </tr>
                                            <tr class="info">
                                                <td>3319</td>
                                                <td>10/21/2013</td>
                                                <td>2:13 PM</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td><input type="checkbox"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-right">
                                    <a href="#">Ver todas as reservas<i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                   
             
                </div>
                <!-- /.row -->

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


<?php
/*
 * faz a conexao à base de dados
 * e seleciona a base de dados
 */
$servername = "eu-cdbr-azure-west-c.cloudapp.net";
$username = "b1d0197c9b0f56";
$password = "455da09c";
$db = "restaurante";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);

if (!$conn) {
 die("Connection failed: " . mysqli_connect_error());
}


$sql = "select cliente.email, cliente.passsword from cliente where cliente.email = \"{$_POST['inputEmail']}\" and cliente.passsword = \"{$_POST['inputPassword']}\"";


//echo $sql;

$resultado = mysqli_query($conn, $sql);

if (mysqli_num_rows($resultado) > 0) {
	echo "SUCESSO!\n";

}
else
{		echo "entra";
		header('login.php');
		exit();   

}

mysqli_close($conn);

?> 
