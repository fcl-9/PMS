<?php
require_once('../common/database.php');
require_once('../common/common.php');
session_start();
if(empty($_SESSION['funcionario_id'])) 
{
    header("Location: login.php");
}
else
{
    if(isset($_POST['idCliente']))
        {
            echo ''. $_POST['idCliente'];
        $queryClient = 'SELECT * FROM cliente WHERE idcliente = '.$_POST['idCliente']; 
        $getCli = mysqli_query($link, $queryClient);
        if(!$getCli)
        {
            echo "Erro na query #1" . mysqli_error($link);
        }
       else{
        $data = mysqli_fetch_assoc($getCli);
        $nome = $data['nome'];
        $sobrenome = $data['sobrenome'];
        $telefone = $data['telefone'];
        $mail = $data['email'];
    }
}

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

        <link href="../css/bootstrap-datetimepicker.css" rel="stylesheet">
        

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
    		<p class="navbar-text" >Bem-Vindo(a),  <?php echo $_SESSION['funcionario_nome']; ?></p>
    	</ul>
    	<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    	<div class="collapse navbar-collapse navbar-ex1-collapse">
            		<ul class="nav navbar-nav side-nav">
            			<li>
                            <a href="funcmain.php"><span class="glyphicon glyphicon-home"></span> Voltar Atrás</a>
                         </li>
            			 <li>
                            <a href="funcaddreserva.php"><span class="glyphicon glyphicon-plus"></span> Adicionar Reserva</a>
                         </li>
                         <li>
                             <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Terminar Sessão</a>
                         </li>
            		</ul>
            	</div>
    	<!-- /.navbar-collapse -->
    </nav>
    <div class="corpo">
    	<div class="col-md-9 container-fluid">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span><i class="fa"></i>Alterar Reserva</h3>
    			</div>
    			<div class="panel-body">
    				<form id="alt_reserva" action="update_reserva.php" method="POST">
    					<div class="row">
    						<div class="col-md-4 form-group"> 
    							<label for="reserva">Reserva:</label> 
    							<input type="number" class="form-control" name="reserva" id="reserva" value="<?php echo $_POST['idreserva'] ?>" placeholder="ID Reserva" readonly="">
    						</div>
    					</div>
    					<div class="row">
    						<div class="col-md-6 form-group"> 
    							<label for="nome">Nome:</label>
    							<input type="text" class="form-control" name="nome" id="nome" value="<?php echo $nome ?>" placeholder="Nome" readonly="">
    						</div>
    						<div class="col-md-6 form-group"> 
    							<label for="sobrenome">Sobrenome:</label>
    							<input type="text" class="form-control" name="sobrenome" id="sobrenome" value="<?php echo $sobrenome ?>" placeholder="Sobrenome" readonly="">
    						</div>
    					</div>
    					<div class="row">
    						<div class="col-md-6 form-group">           
    							<label for="email">Email:</label>
    							<input type="email" class="form-control" name="email" id="email" value="<?php echo $mail ?>" placeholder="Email" readonly="">
    						</div>
    						<div class="col-md-6 form-group telErroIcon">
    							<label for="numerotel">Telefone:</label></label><br>
    							<input type="text" class="form-control teste"  name="numerotel" id="numerotel" value="<?php echo $telefone ?>" placeholder="Número telefone" readonly="">
    						</div>
    					</div>
    					<div class="row">
    						<div class='col-sm-6'>
    							<div class="form-group errorIcon">
    								<label for="datetimepicker1">Data e Hora: </label>
    								<div class='input-group date' id='datetimepicker1' name="datetimepicker1">
    									<input type='text' class="form-control" name="datahora" placeholder="Data e Hora" readonly/>
    									<span class="input-group-addon">
    										<span class="glyphicon glyphicon-calendar"></span>
    									</span>
    								</div>
    							</div>
    						</div>
    						<div class="col-md-3 form-group">
    							<div class="form-group">
    								<label for="selMesa">Número de Mesa:</label>
                                    <?php
                                            print_r($_POST);
                                            if($_POST["juntar"] == 1)
                                            {
                                                $mesasLivres = "SELECT m.numero, m.capacidade FROM mesa AS m WHERE m.numero NOT IN (SELECT rhm.mesa_numero FROM reserva_has_mesa as rhm , reserva as r WHERE r.hora = '".$_POST['hora']."' AND r.data ='".$_POST['data']."' AND rhm.reserva_idreserva = r.idreserva)";
                                                $mesasLivres = mysqli_query($link, $mesasLivres);
                                                $capacidadeJuntas = 0;
                                                $mesasJuntas = array();
                                                $indiceMesas = 0;
                                                if(!$mesasLivres)
                                                {
                                                    echo 'ERRO '.mysqli_error($link).'<br>';
                                                }
                                                while($row = mysqli_fetch_assoc($mesasLivres))
                                                {
                                                    if($capacidadeJuntas < $_POST['selNumPes'])
                                                    {
                                                        $capacidadeJuntas = $capacidadeJuntas + $row['capacidade'];
                                                        $mesasJuntas[$indiceMesas] = $row['numero'];
                                                        $indiceMesas++;
                                                    }
                                                }
                                                echo 'As caraterísticas da sua reserva não lhe permitem selecionar a mesa. No entanto se continuar com a sua reserva serão juntas as seguintes mesas: ';
                                                for($i = 0; $i < count($mesasJuntas); $i++)
                                                {
                                                    if($i == count($mesasJuntas) - 1)
                                                    {
                                                        echo $mesasJuntas[$i].'.';
                                                    }
                                                    else
                                                    {
                                                        echo $mesasJuntas[$i].', ';
                                                    }  
                                                }
                    $arrayString = base64_encode(serialize($mesasJuntas)); // Transforma o array em string para poder ser passado pelo POST
                    echo '<input type="hidden" name="selMesa" value="'.$arrayString.'">';
                    echo '<input type="hidden" name ="necessarioJuntar" value="1">'; // Indica que é necessário juntar mesas. É utilizado para a inserção na BD
                }
                else
                {
                    ?>
    								<select class="form-control" id="selMesa" name ="selMesa">
    									<option></option>
    									<?php
                                            $mesasLivres = "SELECT m.numero, m.capacidade FROM mesa AS m WHERE m.numero NOT IN (SELECT rhm.mesa_numero FROM reserva_has_mesa as rhm , reserva as r WHERE r.hora = '".$_POST['hora']."' AND r.data ='".$_POST['data']."' AND rhm.reserva_idreserva = r.idreserva)";
                                            $mesasLivres = mysqli_query($link, $mesasLivres);
                                            if(!$mesasLivres)
                                            {
                                                echo 'ERRO '.mysqli_error($link).'<br>';
                                            }
                                            while($row = mysqli_fetch_assoc($mesasLivres))
                                            {
                                                if($row['capacidade'] >= $_POST['selNumPes'])
                                                {
                                                    echo '<option>'.$row['numero'].'</option>';
                                                }
                                            }
                                            echo '<input type="hidden" name ="necessarioJuntar" value="0">';
                                            ?>
    								</select>
                                    <?php
                }
                ?>
    							</div>
    						</div>
    						<div class="col-md-3 form-group">
    							<div class="form-group selectNumPess">
    								<label for="selNumPes">Número de Pessoas:</label>
    								<select class="form-control" id="selNumPes" name="selNumPes" readonly>
    									<option selected="selected"><?php echo $_POST['selNumPes'];?></option>
    								</select>
    							</div>
    						</div>
    						<table>
    							<tr>
    								<td>
    									<div class="col-md-12">
           									 <button type="submit" id="btn_submit" name="submit" class="btn btn-default">Concluir Reserva</button>     					
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
    
   <script type="text/javascript">
            var datestring = <?php echo json_encode(juntaDataHora($_POST['data'],$_POST['hora'])); ?>;
            var date = new Date(datestring);
            var dateToday = new Date();
            dateToday.setMinutes(date.getMinutes() + 50);

            $(function () {
                $('#datetimepicker1').datetimepicker({
                  locale: 'pt',
                  format: 'YYYY-MM-DD HH:mm',
                  useCurrent: false,
                  minDate: dateToday,
                  defaultDate:  date,
                  enabledHours: [12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22],
                  sideBySide:true}).on('changeDate', function(e) {
                  // Revalidate the date field
                 $('#dateRangeForm').formValidation('revalidateField', 'datahora');
        });
            });
        </script>
  

       
 <!-- jQuery Bootstrap Form Validator -->
 <link rel="stylesheet" href="../formvalidation/css/formValidation.css"/>
 <script type="text/javascript" src="../formvalidation/js/formValidation.js"></script>
 <script type="text/javascript" src="../formvalidation/js/framework/bootstrap.js"></script>
<!--Validação de input números de telefone plugin pro form validation-->
<link rel="stylesheet" href="../formvalidation/css/intlTelInput.css" />
<script src="../formvalidation/js/intlTelInput.min.js"></script>

<!--Fim dos plugin de validação-->

</body>

</html>

