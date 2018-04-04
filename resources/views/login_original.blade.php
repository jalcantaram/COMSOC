<!DOCTYPE html>
<html lang="es">
  <head>
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{!! asset('assets/logotipos/ico_angel_cdmx.ico') !!}">

    <title>Lista de Asistentes</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{!! asset('assets/css/bootstrap/bootstrap.min.css') !!}">
    
    <!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"-->

    <!-- Custom styles for this template -->
    <link href="{!! asset('assets/css/sticky-footer.css') !!}" rel="stylesheet">
    <link href="{!! asset('assets/css/estilos.css') !!}" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

     <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" rel="home" href="#">
            <img src="{!! asset('assets/logotipos/logo_CDMX_blanco.png') !!}">
          </a>
          <a class="navbar-brand" href="{{ url('/') }}">&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dictaminación</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="{{ url('/') }}">Ayuda</a></li>
            <li><a href="{{ url('/') }}">Iniciar sesión</a></li>
            <li><a class="navButton" href="{{ url('/') }}">Registrar</a></li>
            <!--li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul-->
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    
    <div align="center" class="container">
        <div id="mensajeModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm" role="document">
              <div class="modal-content">
                  <div class="modal-body">

                  </div>
              </div>
            </div>
        </div>

        <div class="jumbotron fondoBlanco">
            <h2><strong>Iniciar sesión</strong></h2>
            <form method="post" action="{{ url('/login') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="formLogin">
                    <label>Correo electrónico</label>
                    <input name="login" type="text" placeholder="Ingrese su correo electrónico">
                    <label>Contraseña</label>
                    <input name="pass" type="password" placeholder="Ingrese su contraseña">
                    <a href="#">¿Olvidó su contraseña?</a>
                    <input type="submit" value="Iniciar sesión">
                    <label class="registro">¿Aún no tienes cuenta? <a href="#">Registrate</a></label>
                    <label class="correo"><a href="#">No recibí mi correo de confirmación</a></label>
                </div>
            </form>
        </div>
    

    </div>
    <footer class="footer">
      <div class="container">
        <a class="navbar-brand" rel="home" href="#">
            <img src="{!! asset('assets/logotipos/logo_CDMX_blanco.png') !!}">
        </a>
        <p class="text-muted"><a class="enlaceFooter" href="#">Declaración de veracidad</a>|
                              <a class="enlaceFooter" href="#">Protección de datos personales</a>|
                              <a class="enlaceFooter" href="#">Ayuda</a></p>
      </div>
    </footer>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{!! asset('assets/js/jQuery/jquery-2.2.3.min.js') !!}"></script>
    <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script-->
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="{!! asset('assets/js/bootstrap/bootstrap.min.js') !!}"></script>
    <!-- Latest compiled and minified JavaScript -->
    @if($error != '')
      <script type="text/javascript">
        $('.modal-body').css('background-color','red');
        $('.modal-body').text('{{ $error }}');
        $("#mensajeModal").modal('show');
        setTimeout("$('#mensajeModal').modal('hide')",3000);
      </script>
    @endif 
  </body>
</html>

