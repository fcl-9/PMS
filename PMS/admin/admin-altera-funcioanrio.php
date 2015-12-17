
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

    <?php include("common.php"); ?>
    <div class="corpo">
            <div class="col-md-12 container-fluid">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span><i class="fa"></i>Altera Funcionário</h3>
                    </div>
                    <div class="panel-body">
                        <form id="alt_funcionario" method="POST">
                            <div class="row">
                                <div class="col-md-12 form-group"> 
                                    <label for="nome">Nome Completo:</label>
                                    <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome">
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
                                <div class="col-md-12 form-group">
                                    <label for="morada">Morada:</label>
                                    <input type="text" class="form-control" name="email" id="email" placeholder="Morada">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <button type="submit" id="btn_submit" name="submit" class="btn btn-default">Adicionar</button> 
                                </div >
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


<script type="text/javascript">
  $(document).ready(function() {
    $('#alt_funcionario')
        .find('[name="numerotel"]')
            .intlTelInput({
                utilsScript: '../formvalidation/js/utils.js',
                autoPlaceholder: true,
                defaultCountry:"pt",
            });

     $('#alt_funcionario')
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
        /*.on('click', '.country-list', function() {$('#form_reserva').formValidation('revalidateField', 'numerotel');});*/
        .on('success.form.fv', function(e) {
            // Prevent form submission
            e.preventDefault();

            var $form = $(e.target),
                fv    = $form.data('formValidation');

            // Use Ajax to submit form data
            $.ajax({
                url: "form_reserva.php",
                type: 'POST',
                data: $form.serialize(),
                 success: function(data,status, xhr)
    {
       
        $('#nome').val('');
        $('#sobrenome').val('');
        $('#email').val('');
        $('#numerotel').val('');
        //$('#datahora').val('');
        $('#selMesa').val('');
        $('#selNumPes').val('');
        //Reset ao form
        $('#form_reserva').data('formValidation').resetForm(); 
 		//if success then just output the text to the status div then clear the form inputs to prepare for new data
        $("#status_text").html(data);
    },
    error: function (jqXHR, status, errorThrown)
    {
        //if fail show error and server status
        $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
    }
            }); 
            });
});

</script>
<!--Fim dos plugin de validação-->

</body>

</html>

