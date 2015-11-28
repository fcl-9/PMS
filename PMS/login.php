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

    <title>Restaurante</title>

    <!-- Bootstrap core CSS -->
    <link href="/bootstrap/docs/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/login.css" rel="stylesheet">
    <!-- CSS partilhado por todas as paginas-->
    <link href="css/common.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/bootstrap/docs/dist/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

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
              <a class="navbar-brand" href="">Project name</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav navbar-right">
                <li class="active"><a class="page-scroll" href="index.php/#home">Home</a></li>
                <li><a class="page-scroll" href="index.php/#reserva">Reservas</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a class="page-scroll" href="index.php/#sobre">Sobre</a></li>
              </ul>
            </div>
          </div>
        </nav>

      </div>
    </div>


    <div class="container">
      <form class="form-signin" action="userpage.php" method="POST">
        <h2 class="form-signin-heading">Restaurante</h2>
        <label for="inputNIF" class="sr-only">NIF</label>
        <input type="email" id="inputNIF" name ="inputNIF" class="form-control" placeholder="Número de identificação fiscal" required autofocus>
        <label for="inputPassword" class="sr-only">Palavra-Passe</label>
        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Palavra-Passe" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Lembrar-me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar sessão</button>
      </form>

    </div> <!-- /container -->
    

      ><div class="navbar-fixed-bottom">
        <!-- FOOTER -->
      	<footer>
      	 <div class="text-center">
	        <p>&copy; 2015c Company, In. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
    	</div>
      </footer
      </div>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/bootstrap/docs/assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>

<body> 
</html>
