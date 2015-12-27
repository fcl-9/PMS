<?php
require('../common/database.php');
require('../common/common.php');
session_start();
$printMsgVal = false;
$sucessoNaReserva = false;
$checkTelefone = false;
$checkEmail = false;
$reservaMade = false;
if(empty($_SESSION['funcionario_id'])) 
{
    header("Location: login.php");
}
else
{
    if((empty($_POST['nome']) || empty($_POST['sobrenome']) || empty($_POST['email']) || empty($_POST['numerotel']) || empty($_POST['datahora']) || empty($_POST['selNumPes']))&&isset($_POST['finish']))
    {
        $printMsgVal = true;
        $valorConvertido = converteDataHora($_POST['datahora']);
        $_POST['data']  = $valorConvertido['data'];
        $_POST['hora'] =  $valorConvertido['hora'];
        $_POST['juntar'] = $_POST['juntar'] ;
    }
    else
    {
        //Desativa commit automático, so no fim de todo o processo o utilizador 
        mysqli_autocommit($link,false);
        $flag = true;
        if(isset($_POST['finish']) && preg_match("/^[0-9]{5,15}+$/", telefone($_POST['numerotel']))===0)
        {
            $checkTelefone=true;
        }
        else if (isset($_POST['finish']) && !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
        {
            $checkEmail = true;
        }
        else
        {
            if(isset( $_POST['nome'], $_POST['sobrenome'], $_POST['email'],$_POST['numerotel'],$_POST['datahora'],$_POST['selMesa'],$_POST['selNumPes']))
            {
                $nome = mysqli_real_escape_string($link, $_POST['nome']);
                $apelido = mysqli_real_escape_string($link, $_POST['sobrenome']);
                $email = mysqli_real_escape_string($link, $_POST['email']);
                $numero = mysqli_real_escape_string($link, $_POST['numerotel']);
                $data_hora = mysqli_real_escape_string($link, $_POST['datahora']);
                $numPessoas = mysqli_real_escape_string($link, $_POST['selNumPes']);

                $nome = stripslashes($nome);
                $apelido = stripslashes($apelido);
                $email = stripslashes($email);
                $numero = stripslashes($numero);
                $data_hora = stripslashes($data_hora);
                $numPessoas = stripslashes($numPessoas);
                $password = random_password(8);
                $numero = telefone($numero);

                $dateArray =converteDataHora($_POST['datahora']);

                // Tratamento das mesas
                if($_POST['necessarioJuntar'] == 1)
                {
                    $numMesa = unserialize(base64_decode($_POST['selMesa']));  //Se for necessário juntar volto a colocar as mesas num array para mais fácil manipulação
                }
                else
                {
                    $numMesa = array(0=>$_POST['selMesa']);
                }

                $queryVerUser = 'SELECT * FROM cliente WHERE telefone = \''.$numero.'\' AND email = \''.$email.'\'';
                $verUser = mysqli_query($link,$queryVerUser);
                //Verificar se o utilizador já existe
                if(mysqli_num_rows($verUser) == 1)
                {
                    //verificar se ele tenta fazer reserva na mesma hora e no mesmo dia
                    $queryUserMail = 'SELECT email FROM cliente WHERE telefone = \''.$numero.'\'';
                    $resmail = mysqli_query($link,$queryUserMail);
                    $resmail = mysqli_fetch_array($resmail);
                    //Verifica se email introduzido match com o da base de dados.
                    if($resmail['email'] == $email)
                    {
                        $limiteInicial = strtotime($dateArray["hora"])-5400; //1h30min sao 5400 segundos
                        $limiteInicial = gmdate("H:i:s",$limiteInicial);
                        $limiteFinal = strtotime($dateArray["hora"])+5400;
                        $limiteFinal = gmdate("H:i:s",$limiteFinal);
                        $queryResAnteriores = 'SELECT * FROM reserva as r, cliente as c WHERE r.cliente_idcliente='.$resmail['idcliente'].' AND r.hora BETWEEN \''.$limiteInicial.'\' AND \''.$limiteFinal.'\' AND r.data = \''.$dateArray["data"].'\'';
                        $reservaAnteriores = mysqli_query($link,$queryResAnteriores);
                        if(!$reservaAnteriores)
                        {
                            echo 'Erro na query #1' . mysqli_error($link);
                            mysqli_rollback($link);
                            //die;
                        }
                        if(mysqli_num_rows($reservaAnteriores) > 0)
                        {
                            //falha a reserva
                            $reservaMade = true;
                        }
                        else
                        {   
                            //efetua a reserva && envia e-mail
                            if($_POST['selMesa'] == '')
                            {
                                $limiteInicial = strtotime($dateArray["hora"])-5400; //1h30min sao 5400 segundos
                                $limiteInicial = gmdate("H:i:s",$limiteInicial);
                                $limiteFinal = strtotime($dateArray["hora"])+5400;
                                $limiteFinal = gmdate("H:i:s",$limiteFinal);
                                $mesasLivres = "SELECT m.numero, m.capacidade FROM mesa AS m WHERE m.numero NOT IN (SELECT rhm.mesa_numero FROM reserva_has_mesa as rhm , reserva as r WHERE r.hora BETWEEN \''.$limiteInicial.'\' AND \''.$limiteFinal.'\' AND r.data ='".$dateArray['data']."' AND rhm.reserva_idreserva = r.idreserva)";
                                $mesasLivres = mysqli_query($link, $mesasLivres);
                                if(!$mesasLivres)
                                {
                                    echo 'ERRO '.mysqli_error($link).'<br>';
                                }
                                while($numerosMesa = mysqli_fetch_assoc($mesasLivres))
                                {
                                    if($numerosMesa['capacidade'] >= $_POST['selNumPes'])
                                    {
                                        $numMesa = array(0=>$numerosMesa['numero']);
                                        break;
                                    }
                                }
                            }
                            if(!addReserva($link,$numero,$numPessoas,$numMesa,$dateArray["data"],$dateArray["hora"],$_SESSION['funcionario_id']))
                            {
                                mysqli_rollback($link);
                            }
                            else
                            {
                                mysqli_commit($link);
                                //Info from the user
                                $queryVerUser = 'SELECT c.idcliente FROM cliente AS c WHERE c.telefone = \''.$numero.'\'';
                                $getId = mysqli_query($link,$queryVerUser);
                                $idCli = mysqli_fetch_array($getId);

                                //info from the reservation
                                $getIdRes = "SELECT idreserva FROM reserva WHERE hora = '".$dateArray["hora"]."' AND data ='".$dateArray["data"]."' AND cliente_idcliente=".$idCli['idcliente']."";      
                                $getIdRes = mysqli_query($link,$getIdRes);
                                $idReserva = mysqli_fetch_array($getIdRes);

                                $ativaReserva = "UPDATE reserva SET ativo = 1 WHERE idreserva=".$idReserva['idreserva'];
                                $ativaReserva = mysqli_query($link,$ativaReserva);
                                if(!$ativaReserva)
                                {
                                    echo "ERRO #9".mysqli_error($link);
                                    mysqli_rollback($link);
                                }
                                else
                                {
                                    mysqli_commit($link);
                                    $sucessoNaReserva = true;
                                }
                            }
                        }
                    }
                    else
                    {
                        //email introduzido está mal pois n tá de acordo com o que está na bd
                        $checkEmail = true;

                        $valorConvertido = converteDataHora($_POST['datahora']);
                        $_POST['data']  = $valorConvertido['data'];
                        $_POST['hora'] =  $valorConvertido['hora'];
                        $_POST['juntar'] = $_POST['juntar'] ;
                    }
                }
                else
                {
                    $queryUserMail = 'SELECT email FROM cliente WHERE telefone = \''.$numero.'\'';
                    $resmail = mysqli_query($link,$queryUserMail);
                    if(mysqli_num_rows($resmail) == 0)
                    {
                        //registo um utilizador
                        if(!addCliente($link,$nome,$password,$numero,$apelido,$email))
                        {
                            echo 'Erro na query #2' . mysqli_error($link);
                            mysqli_rollback($link);
                            //die;
                        }
                        else
                        {
                            if($_POST['selMesa'] == '')
                            {
                                $mesasLivres = "SELECT m.numero, m.capacidade FROM mesa AS m WHERE m.numero NOT IN (SELECT rhm.mesa_numero FROM reserva_has_mesa as rhm , reserva as r WHERE r.hora = '".$dateArray['hora']."' AND r.data ='".$dateArray['data']."' AND rhm.reserva_idreserva = r.idreserva)";
                                $mesasLivres = mysqli_query($link, $mesasLivres);
                                if(!$mesasLivres)
                                {
                                    echo 'ERRO '.mysqli_error($link).'<br>';
                                }
                                while($numerosMesa = mysqli_fetch_assoc($mesasLivres))
                                {
                                    if($numerosMesa['capacidade'] >= $_POST['selNumPes'])
                                    {
                                        $numMesa = array(0=>$numerosMesa['numero']);
                                        break;
                                    }
                                }
                            }
                            if(!addReserva($link,$numero,$numPessoas,$numMesa,$dateArray["data"],$dateArray["hora"],$_SESSION['funcionario_id']))
                            {
                                mysqli_rollback($link);
                            }
                            else
                            {
                                mysqli_commit($link);
                                //Info from the user
                                $queryVerUser = 'SELECT c.idcliente FROM cliente AS c WHERE c.telefone = \''.$numero.'\'';
                                $getId = mysqli_query($link,$queryVerUser);
                                $idCli = mysqli_fetch_array($getId);

                                //info from the reservation
                                $getIdRes = "SELECT idreserva FROM reserva WHERE hora = '".$dateArray["hora"]."' AND data ='".$dateArray["data"]."' AND cliente_idcliente=".$idCli['idcliente']."";      
                                $getIdRes = mysqli_query($link,$getIdRes);
                                $idReserva = mysqli_fetch_array($getIdRes);

                                $ativaReserva = "UPDATE reserva SET ativo = 1 WHERE idreserva=".$idReserva['idreserva'];
                                $ativaReserva = mysqli_query($link,$ativaReserva);
                                if(!$ativaReserva)
                                {
                                    echo "ERRO #8".mysqli_error($link);
                                    mysqli_rollback($link);
                                }
                                else
                                {
                                    mysqli_commit($link);
                                    $sucessoNaReserva = true;
                                }
                            }
                        }
                    }
                    else
                    {
                        //Telefone deve estar mal pois o mail já existe na base de dados
                        $checkEmail =true;
                        $valorConvertido = converteDataHora($_POST['datahora']);
                        $_POST['data']  = $valorConvertido['data'];
                        $_POST['hora'] =  $valorConvertido['hora'];
                        $_POST['juntar'] = $_POST['juntar'] ;
                        //echo 'Verifique se introduziu os dados corretamente.';
                    }
                }
            }
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
            		<a class="navbar-brand" href="funcmain.php">
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
                    <h3 class="panel-title"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span><i class="fa"></i>Adicionar reserva</h3>
                </div>
                <div class="panel-body">
                    <form id="add_reserva" method="POST">
                        <input type="hidden" name="hora" value=<?php echo $_POST["hora"];?>>
                        <input type="hidden" name="data" value=<?php echo $_POST["data"];?>>
                       <div class="row">
                          <div class="col-md-6 form-group"> 
                             <label for="nome">Nome:</label>
                             <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome">
                         </div>
                         <div class="col-md-6 form-group"> 
                             <label for="sobrenome">Sobrenome:</label>
                             <input type="text" class="form-control" name="sobrenome" id="sobrenome" placeholder="Sobrenome">
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
              <input type="hidden" name="juntar" value=<?php echo $_POST["juntar"];?>>
              <div class="col-md-3 form-group">
                 <div class="form-group">
                    <label for="selMesa">Número de Mesa:</label>
                    <!--Adiciona à escolha do utilizador-->
                    <?php
                    if($_POST["juntar"] == 1)
                    {
                        $limiteInicial = strtotime($_POST["hora"])-5400; //1h30min sao 5400 segundos
                        $limiteInicial = gmdate("H:i:s",$limiteInicial);
                        $limiteFinal = strtotime($_POST["hora"])+5400;
                        $limiteFinal = gmdate("H:i:s",$limiteFinal);
                        $mesasLivres = "SELECT m.numero, m.capacidade FROM mesa AS m WHERE m.numero NOT IN (SELECT rhm.mesa_numero FROM reserva_has_mesa as rhm , reserva as r WHERE r.hora BETWEEN '".$limiteInicial."' AND '".$limiteFinal."' AND r.data ='".$_POST['data']."' AND rhm.reserva_idreserva = r.idreserva)";
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

                        
                    <select class="form-control" id="selMesa"  name="selMesa">
                        <option></option>
                        <?php
                        $limiteInicial = strtotime($_POST["hora"])-5400; //1h30min sao 5400 segundos
                        $limiteInicial = gmdate("H:i:s",$limiteInicial);
                        $limiteFinal = strtotime($_POST["hora"])+5400;
                        $limiteFinal = gmdate("H:i:s",$limiteFinal);
                        $mesasLivresq = "SELECT m.numero, m.capacidade FROM mesa AS m WHERE m.numero NOT IN (SELECT rhm.mesa_numero FROM reserva_has_mesa as rhm , reserva as r WHERE r.hora BETWEEN '".$limiteInicial."' AND '".$limiteFinal."' AND r.data ='".$_POST['data']."' AND rhm.reserva_idreserva = r.idreserva)";
                        $mesasLivres = mysqli_query($link, $mesasLivresq);
                        if(!$mesasLivres)
                        {
                            echo '<option>ERRO '.mysqli_error($link).'</option>';
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
               <option><?php echo $_POST['selNumPes'] ?></option>
           </select>
       </div>
   </div>
</div>
<div>
    <div class="row">   
        <?php
        if($printMsgVal == true)
        {
            echo 'Verifique se preencheu todos os campos do formulário.';
        }
        if($sucessoNaReserva == true)
        {
            echo 'Reserva concluida com sucesso';
            echo '<meta http-equiv="refresh" content="1;url=index.php"/>';
        }
        if(  $checkEmail == true)
        {
            echo 'Verifique se introduziu os dados corretamente.';
        }
        if($reservaMade == true)
        {
            echo 'Já tem uma reserva para a mesma hora e para o mesmo dia.';
        }
        if($checkEmail==true)
        {
            echo 'Verifique se introduziu um endereço de e-mail válido';
        }
        if($checkTelefone==true)
        {
            echo 'Verifique se introduziu um número de telefone válido';
        }
     ?>
 </div>
 <table>
     <tr>
        <td>
            <div class="col-md-12">
                <button type="submit" id="finish" name="finish" class="btn btn-default">Concluir Reserva</button>     					
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
                      minDate:  date,
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


        </body>

        </html>

