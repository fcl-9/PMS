<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Carousel Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="/bootstrap/docs/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/bootstrap/docs/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
    <link href="/css/carousel.css" rel="stylesheet">
    <!-- CSS partilhado por todas as paginas-->
    <link href="css/common.css" rel="stylesheet">
     <link href="/css/bootstrap-datetimepicker.css" rel="stylesheet">
     <link rel='shortcut icon' type='image/x-icon' href='/images/favicon.png' />
  </head>
<!-- NAVBAR
================================================== -->
  <body>
    <div class="navbar-wrapper">
      <div class="container">

        <nav class="navbar navbar-inverse navbar-fixed-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">
                <img alt="Brand" src="images\drawing2.png">
              </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav navbar-right">
                <li class="active"><a class="page-scroll" href="#home">Home</a></li>
                <li><a class="page-scroll" href="#reserva">Reservas</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a class="page-scroll" href="#sobre">Sobre</a></li>
              </ul>
            </div>
          </div>
        </nav>

      </div>
    </div>


    <!-- Carousel
    ================================================== -->
	<section id="home" class="home-section">
	    <div id="myCarousel" class="carousel slide" data-ride="carousel">
	      <!-- Indicators -->
	      <ol class="carousel-indicators">
	        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
	        <li data-target="#myCarousel" data-slide-to="1"></li>
	        <li data-target="#myCarousel" data-slide-to="2"></li>
	      </ol>
	      <div class="carousel-inner" role="listbox">
	        <div class="item active">
	          <img class="first-slide" src="/images/slider/slider3.jpg" alt="First slide">
	          <div class="container">
	            <div class="carousel-caption">
	              <h1>Example headline.</h1>
	              <p>Note: If you're viewing this page via a <code>file://</code> URL, the "next" and "previous" Glyphicon buttons on the left and right might not load/display properly due to web browser security rules.</p>
	              <p><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p>
	            </div>
	          </div>
	        </div>
	        <div class="item">
	          <img class="second-slide" src="/images/slider/slider1.jpg" alt="Second slide">
	          <div class="container">
	            <div class="carousel-caption">
	              <h1>Another example headline.</h1>
	              <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
	              <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
	            </div>
	          </div>
	        </div>
	        <div class="item">
	          <img class="third-slide" src="/images/slider/slider1.jpg" alt="Third slide">
	          <div class="container">
	            <div class="carousel-caption">
	              <h1>One more for good measure.</h1>
	              <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
	              <p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>
	            </div>
	          </div>
	        </div>
	      </div>
	      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
	        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	        <span class="sr-only">Previous</span>
	      </a>
	      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
	        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	        <span class="sr-only">Next</span>
	      </a>
	    </div><!-- /.carousel -->
  	</section>

    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->
    <div class="container marketing">

      <!-- Three columns of text below the carousel -->
      <div class="row">
        <div class="col-lg-4">
          <img class="img-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
          <h2>Heading</h2>
          <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna.
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img class="img-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
          <h2>Heading</h2>
          <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img class="img-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
          <h2>Heading</h2>
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
        </div><!-- /.col-lg-4 -->
      </div><!-- /.row -->



      <!-- START THE FEATURETTES -->

  <hr class="featurette-divider">
  
  <section id="reserva" class="reserva-section">
      <form id="form_reserva" action="formulario.php" method="POST">
       <div class="row">
          <div class="col-md-4 form-group"> 
            <label for="contribuinte">Número de Contribuinte:</label> 
            <input type="number" class="form-control" name="contribuinte" id="contribuinte" placeholder="Número de Contribuinte">
          </div>
        </div>
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
          <div class="col-md-6 form-group">
            <label for="numerotel">Telefone:</label>
            <input type="tel" class="form-control"  name="numerotel" id="numerotel" placeholder="Telefone">
          </div>
        </div>
        <div class="row">
          <div class='col-sm-6'>
            <div class="form-group">
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
			  <select class="form-control" id="selMesa">
			    <option></option>
          <option>Mesa 1</option>
			    <option>Mesa 2</option>
			    <option>Mesa 3</option>
			    <option>Mesa 4</option>
			  </select>
			</div>
          </div>
          <div class="col-md-3 form-group">
           	<div class="form-group">
           	 <label for="selNumPes">Número de Pessoas:</label>
  			  <select class="form-control" id="selNumPes" name="selNumPes">
    			  <option></option>
            <option>1 Pessoa</option>
 				   	<option>2 Pessoas</option>
 				   	<option>3 Pessoas</option>
    				<option>4 Pessoas</option>
  				</select>
			</div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <button type="submit" class="btn btn-default">Reservar</button>
          </div>
        </div>
    </form>
   </section>
  
  <section id="sobre" class="sobre-section">
    <hr class="featurette-divider">
      <div class="row featurette">
        <div class="col-md-7 col-md-push-5">
          <h2 class="featurette-heading">Oh yeah, it's that good. <span class="text-muted">See for yourself.</span></h2>
          <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
        </div>
        <div class="col-md-5 col-md-pull-7">
          <img class="featurette-image img-responsive center-block" data-src="holder.js/500x500/auto" alt="Generic placeholder image">
        </div>
      </div>
   </section>

      <!-- /END THE FEATURETTES -->


      <!-- FOOTER -->
      <footer >
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p>&copy; 2015 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
      </footer>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/bootstrap/docs/dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="/bootstrap/docs/assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/bootstrap/docs/assets/js/ie10-viewport-bug-workaround.js"></script>
 	

    <!-- jQuery -->
    <script src="/js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/js/bootstrap.min.js"></script>

    <!-- Scrolling Nav JavaScript -->
    <script src="/js/jquery.easing.min.js"></script>
    <script src="/js/scrolling-nav.js"></script>

    <script src="/js/moment.js"></script>
    <script src="/bootstrap/js/dropdown.js"></script>
    <script src="/bootstrap/js/transition.js"></script>
    <script src="/bootstrap/js/collapse.js"></script>
    <script type="text/javascript" src="/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="/js/locale/pt.js"></script>
   
	<script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker({
                  locale: 'pt',
                               });
            });
        </script>

    <!-- jQuery Bootstrap Form Validator -->
        <!-- <link rel="stylesheet" href="/formvalidation-master/vendor/bootstrap/css/bootstrap.css"/>-->
 	  <link rel="stylesheet" href="/formvalidation-master/dist/css/formValidation.css"/>
  <script type="text/javascript" src="/formvalidation-master/dist/js/formValidation.js"></script>
  	  <script type="text/javascript" src="/formvalidation-master/dist/js/framework/bootstrap.js"></script>
 <script type="text/javascript" src="/formvalidation-master/vendor/bootstrap/js/bootstrap.min.js"></script> 
    
	<script type="text/javascript">
$(document).ready(function() {
     $('#form_reserva').formValidation({
        message: 'This value is not valid',
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
        }
    });
});

</script>

  </body>
</html>
