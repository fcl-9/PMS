<?php
require_once('common/database.php');
require_once('common/common.php');
session_start();
if(empty($_SESSION['cliente_id'])) 
{
    header("Location: login.php");
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
    		<p class="navbar-text" >Bem-Vindo(a), <?php echo $_SESSION['cliente_nome']; ?>!</p>
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
        <div class="corpo-user">
        	<div class="col-md-3 buttons" id="buttons">

        		
                <div class="botao">
                        <a  class="btn btn-primary" href="userpage_alterarserva.php"><span class="glyphicon glyphicon-refresh"></span> Alterar Reserva</a>
                </div>
                <div class="botao">

                        <a class="btn btn-warning" href="#"><span class="glyphicon glyphicon-remove"></span> Cancelar Reserva</a>

                </div >
            
            
                <div class="botao">

                        <a class="btn btn-success" href="userpage_alteradados.php"><span class="glyphicon glyphicon-user"></span> Alterar Dados do Cliente</a>

                </div>
                <div class="botao">            

                        <a class="btn btn-danger" href="logout.php"><span class="glyphicon glyphicon-off"></span> Terminar Sessão</a>

                </div>
            

        	</div>


        	<div class="corpo">
        		<div class="col-md-9 container-fluid">
        			<div class="panel panel-default">
        				<div class="panel-heading">
        					<h3 class="panel-title"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span><i class="fa"></i> Alterar Dados Cliente</h3>
        				</div>
        				<div class="panel-body">
        					<form id="alt_dados" method="POST">
        						<div class="row">
        							<div class="col-md-6 form-group"> 
        								<label for="nome">Nome:</label>
        								<input type="text" class="form-control" name="nome" id="nome" placeholder="Nome" disabled>
        							</div>
        							<div class="col-md-6 form-group"> 
        								<label for="sobrenome">Sobrenome:</label>
        								<input type="text" class="form-control" name="sobrenome" id="sobrenome" placeholder="Sobrenome" disabled>
        							</div>
        						</div>
        						<div class="row">
        							<div class="col-md-6 form-group">           
        								<label for="email">Email:</label>
        								<input type="email" class="form-control" name="email" id="email" placeholder="Email">
        							</div>
        							<div class="col-md-6 form-group telErroIcon">
        								<label for="numerotel">Telefone:</label></label><br>
        								<input type="text" class="form-control teste"  name="numerotel" id="numerotel" placeholder="Número telefone">
        							</div>
        						</div>
        						<div class="row">
        							<div class="col-md-6 form-group">
        								<label for="numerotel">Palavra Passe:</label></label><br>
        								<input type="text" class="form-control"  name="password" id="password" placeholder="Palavra Passe">
        							</div>
        						</div>
        					</div>
        					</div>
        					<table>
        						<tr>
        							<td>
        								<div class="col-md-12">
        									<button type="submit" id="btn_submit" name="submit" class="btn btn-default">Concluir Reserva</button>                      
        								</div>
        							</td>
        							<td>
        								<div class="col-md-12">
        									<button type="submit" id="btn_submit" name="submit" class="btn btn-default">Cancelar</button> 
        								</div>
        							</td>
        						</tr>
        					</table>
        				</div>
        			</form>
        		</div>
        	</div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<!-- /#page-wrapper -->

    <!--</div>
    <!-- /.container-fluid -->

    <!-- /#page-wrapper -->

    <!--</div>
    <!-- /#wrapper -->
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../js/holder.min.js"></script>

</body>

</html>