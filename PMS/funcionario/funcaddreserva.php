        <?php

        require('../common/database.php');
        require('../common/common.php');
        session_start();
        if(empty($_SESSION['funcionario_id'])) 
        {
          header("Location: login.php");
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
            						<a href="funcalterareserva.php">Reserva</a>
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
            				<a href="forms.html"><i class="fa fa-fw fa-power-off"></i> Terminar Sessão</a>
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
            									<input type='text' class="form-control" name="datahora" placeholder="Data e Hora" />
            									<span class="input-group-addon">
            										<span class="glyphicon glyphicon-calendar"></span>
            									</span>
            								</div>
            							</div>
            						</div>
            						<div class="col-md-3 form-group">
            							<div class="form-group">
            								<label for="selMesa">Número de Mesa:</label>
            								<select class="form-control" id="selMesa" name="selMesa">
            									<option></option>
            									<option>1</option>
            									<option>2</option>
            									<option>3</option>
            									<option>4</option>
            								</select>
            							</div>
            						</div>
            						<div class="col-md-3 form-group">
            							<div class="form-group selectNumPess">
            								<label for="selNumPes">Número de Pessoas:</label>
            								<select class="form-control" id="selNumPes" name="selNumPes">
            									<option></option>
            									<option>1</option>
            									<option>2</option>
            									<option>3</option>
            									<option>4</option>
                                                <option>5</option>
                                                <option>6</option>
                                                <option>7</option>
                                                <option>8</option>
                                                <option>9</option>
            								</select>
            							</div>
            						</div>
                                </div>
                                <div>
                                    <div class="row">   
                                    <?php
        //Desativa commit automático, so no fim de todo o processo o utilizador 
    mysqli_autocommit($link,false);
    $flag = true;
    if(isset( $_POST['nome'], $_POST['sobrenome'], $_POST['email'],$_POST['numerotel'],$_POST['datahora'],$_POST['selMesa'],$_POST['selNumPes']))
    {

        $nome = mysqli_real_escape_string($link, $_POST['nome']);
        $apelido = mysqli_real_escape_string($link, $_POST['sobrenome']);
        $email = mysqli_real_escape_string($link, $_POST['email']);
        $numero = mysqli_real_escape_string($link, $_POST['numerotel']);
        $data_hora = mysqli_real_escape_string($link, $_POST['datahora']);
        $numMesa = mysqli_real_escape_string($link, $_POST['selMesa']);
        $numPessoas = mysqli_real_escape_string($link, $_POST['selNumPes']);

        $nome = stripslashes($nome);
        $apelido = stripslashes($apelido);
        $email = stripslashes($email);
        $numero = stripslashes($numero);
        $data_hora = stripslashes($data_hora);
        $numMesa = stripslashes($numMesa);
        $numPessoas = stripslashes($numPessoas);
        $password = random_password(8);

        $numero = telefone($numero);

        $dateArray =converteDataHora($data_hora);

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
                $queryResAnteriores = 'SELECT * FROM reserva as r, cliente as c WHERE c.idcliente = r.cliente_idcliente AND r.hora = \''.$dateArray["hora"].'\' AND r.data = \''.$dateArray["data"].'\'';
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
                    echo 'Já tem uma reserva para a mesma hora e para o mesmo dia.';
                }
                else
                {   
                //efetua a reserva && envia e-mail
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
                            echo 'Reserva efetuada com sucesso!';
                        }


                           
                    }
                }
            }
            else
            {   //email introduzido está mal pois n tá de acordo com o que está na bd
                echo 'Verifique se introduziu os dados corretamente.';
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

                    print_r($idReserva);

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
                        echo 'Reserva efetuada com sucesso!';
                    }
                    
                    
                }

            }
        }
        else
        {
                //Telefone deve estar mal pois o mail já existe na base de dados
            echo 'Verifique se introduziu os dados corretamente.';
        }
    }

    mysqli_close($link);
    }

        ?>
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
            var date = new Date();
            date.setMinutes(date.getMinutes() + 50);

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

        <!--
            <script type="text/javascript">
            $(document).ready(function() {
                $('#add_reserva')
                .find('[name="numerotel"]')
                .intlTelInput({
                    utilsScript: '../formvalidation/js/utils.js',
                    autoPlaceholder: true,
                    defaultCountry:"pt",
                });

                $('#add_reserva')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                      contribuinte: {
                        row: '.row',
                        validators: {
                            notEmpty: {
                                message: 'Deve introduzir o seu contribuinte.'
                            },
                            stringLength: {
                                min: 9,
                                max: 9,
                                message: 'O número de contribuinte deve conter exatamente 9 digitos'
                            },
                        } 
                    },
                    nome: {
                        message: 'O nome não é válido',
                        validators: {
                            notEmpty: {
                                message: 'Deve introduzir o seu nome.'
                            },
                            stringLength: {
                                min: 3,
                                max: 30,
                                message: 'O nome deve conter pelo menos 3 carateres e um máximo de 30 carateres.'
                            },
                            regexp: {
                                regexp: /^[a-zA-Z0-9_\.]+$/,
                                message: 'O nome só pode ter letras, numeros, pontos.'
                            }
                        }
                    },
                    sobrenome: {
                        row: '.col-md-6',
                        message: 'O sobrenome não é válido.',
                        validators: {
                            notEmpty: {
                                message: 'Deve introduzir o seu sobrenome.'
                            },
                            stringLength: {
                                min: 3,
                                max: 30,
                                message: 'O sobrenome deve conter pelo menos 3 carateres e um máximo de 30 carateres.'
                            },
                            regexp: {
                                regexp: /^[a-zA-Z0-9\.]+$/,
                                message: 'O sobrenome só pode ter letras, numeros, pontos.'
                            }
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'Deve introduzir o seu endereço de email.'
                            },
                            emailAddress: {
                                message: 'O endereço de email introduzido não é válido.'
                            }
                        }
                    },
                    selNumPes: {
                        validators: {
                            notEmpty: {
                                message: 'Selecione o número de pessoas.'
                            }
                        }
                    },
                    numerotel: {
                        validators: {
                            notEmpty: {
                              message: 'Deve introduzir o seu número de telefone.'
                          },
                          callback: {
                              message: 'O número de telefone introduzido não é válido.',
                              callback: function(value, validator, $field) {
                                  return value === '' || $field.intlTelInput('isValidNumber');
                              }
                          }
                      }
                  }
              }
          })
        .on('click', '.country-list', function() {$('#add_reserva').formValidation('revalidateField', 'numerotel');});

        });
    -->
        </script>
        <!--Fim dos plugin de validação-->

        </body>

        </html>

