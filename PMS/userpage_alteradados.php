<?php
require_once('common/database.php');
require_once('common/common.php');
session_start();
if(empty($_SESSION['cliente_id'])) 
{
	header("Location: login.php");
}
else
{
	$queryClient = 'SELECT * FROM cliente WHERE idcliente = '.$_SESSION['cliente_id'];
	$getCli = mysqli_query($link, $queryClient);
	$data = mysqli_fetch_assoc($getCli);
	$nome = $data['nome'];
	$sobrenome = $data['sobrenome'];
	$telefone = $data['telefone'];
	$mail = $data['email'];
	$password = $data['password'];

	if(isset($_POST['cancel']))
	{
		header("Location: userpage.php?id=");
	}
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
	<link href="/css/bootstrap-datetimepicker.css" rel="stylesheet">
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
<!--
        		
        		<div class="botao">
        			<a  class="btn btn-primary" href="userpage_alterarserva.php"><span class="glyphicon glyphicon-refresh"></span> Alterar Reserva</a>
        		</div>-->
        		<div class="botao">

        			<a class="btn btn-warning" href="userpage.php?id="><span class="glyphicon glyphicon-remove"></span> Voltar</a>

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
        					<form id="alt_dados"  method="POST">	
        						<div class="row">
        							<div class="col-md-6 form-group"> 
        								<label for="nome">Nome:</label>
        								<input type="text" class="form-control" name="nome" id="nome" value="<?php echo $nome ?>" placeholder="Nome"  readonly="">
        							</div>
        							<div class="col-md-6 form-group"> 
        								<label for="sobrenome">Sobrenome:</label>
        								<input type="text" class="form-control" name="sobrenome" id="sobrenome" value="<?php echo $sobrenome ?>" placeholder="Sobrenome"  readonly="">
        							</div>
        						</div>
        						
        						<div class="row">
        							<div class="col-md-6 form-group">           
        								<label for="email">Email:</label>
        								<input type="email" class="form-control" name="email" id="email" value="<?php echo $mail ?>" placeholder="Email">
        							</div>
        							<div class="col-md-6 form-group telErroIcon">
        								<label for="numerotel">Telefone:</label></label><br>
        								<input type="text" class="form-control teste"  name="numerotel" id="numerotel" value="<?php echo $telefone?>" placeholder="Número telefone">
        							</div>
        						</div>
        						<div class="row">
        							<div class="col-md-6 form-group">
        								<label for="numerotel">Palavra Passe:</label></label><br>
        								<input type="password" class="form-control"  name="password" id="password" placeholder="Palavra Passe">
        							</div>
        						</div>
        					</div>
        				</div>

        				<?php
        				if(isset($_POST['submit']))
        				{
    						
        					mysqli_autocommit($link,false);
        					$corpoMsg = "Os seus dados foram alterados. ";
        					if(telefone($_POST['numerotel']) != $telefone )
        					{
        						$corpoMsg .= " O seu novo número de telefone é: ".$_POST['numerotel']." utilize-o para fazer login. ";

        						$uTelef = 'UPDATE cliente SET telefone='.$_POST['numerotel'].' WHERE idcliente ='.$_SESSION['cliente_id'] ;
        						$utelefSuc = mysqli_query($link,$uTelef);
        						if(!$utelefSuc)
        						{
        							echo 'Erro na query #1 Altera dados.';
        							mysqli_rollback($link);
        						}
        					}	
        					if(empty($_POST['password']))
        					{
        					}
        					else
        					{
        						$corpoMsg .= "A sua nova password é : " . $_POST['password'] . " deverá utiliza-la no seu próximo login. ";
        						
        						$uPassword = 'UPDATE cliente SET password=\''.$_POST['password'].'\' WHERE idcliente ='.$_SESSION['cliente_id'] ;

        						$uPwdSucess = mysqli_query($link,$uPassword);
        						if(!$uPwdSucess)
        						{
        							echo 'Erro na query #2 Altera dados.';
        							mysqli_rollback($link);
        						}
        					}
        					
                            if(empty($_POST['password']) && $_POST['email'] == $mail && $_POST['numerotel'] == $telefone)
                            {
                                echo 'Os seus dados não foram alterados.';
                            }
        					else if($_POST['email'] != $mail)
        					{
        						$corpoMsg .= " O seu novo email é: " . $_POST['email'];
								//Altera o email para um novo mail
        						$mail  = $_POST['email'];

        						$uMail = 'UPDATE cliente SET email=\''.$_POST['email'].'\' WHERE idcliente ='.$_SESSION['cliente_id'] ;
        						$uMailSuc = mysqli_query($link,$uMail);
        						if(!$uMailSuc)
        						{
        							echo 'Erro na query #3 Altera dados.';
        							mysqli_rollback($link);
        						}
        						else
        						{
        							mailConfim('Os seus novos dados.',$corpoMsg, $mail);
        							echo "Irá receber um email no seu novo email, com os seus novos dados.";
        							mysqli_commit($link);
        							echo "<meta http-equiv='refresh' content='5'>";

        						}
        					}
        					else if($_POST['numerotel'] != $telefone || isset($_POST['password']))
        					{	
        						mailConfim('Os seus novos dados.',$corpoMsg, $_POST['email']);
        						echo "Irá receber um email com os seus novos dados.";

        						mysqli_commit($link);        	
        						echo "<meta http-equiv='refresh' content='5'>";
        						
        					}
        				}
        				?>	
        				<table>
        					<tr>
        						<td>
        							<div class="col-md-12">
        								<button type="submit" id="validateButton" name="submit" class="btn btn-default">Alterar Dados</button>                      
        							</div>
        						</td>
        						<td>
        							<div class="col-md-12">
        							     <!-- <button type="submit" id="btn_submit" name="cancel" class="btn btn-default">Cancelar</button> -->
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

    <!-- Scrolling Nav JavaScript -->
    <script src="../js/jquery.easing.min.js"></script>
    <script src="../js/scrolling-nav.js"></script>
    <!--Traduz datapicker pra pt e data atual-->
    <script src="../js/moment.js"></script>
    <script type="text/javascript" src="../js/locale/pt.js"></script>
    <script type="text/javascript" src="../js/bootstrap-datetimepicker.min.js"></script>


<!-- jQuery Bootstrap Form Validator -->
<link rel="stylesheet" href="/formvalidation/css/formValidation.css"/>
<script type="text/javascript" src="/formvalidation/js/formValidation.js"></script>
<script type="text/javascript" src="/formvalidation/js/framework/bootstrap.js"></script>
<!--Validação de input números de telefone plugin pro form validation-->



</body>
</html>

