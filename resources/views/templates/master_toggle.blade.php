<!DOCTYPE html>
<html lang="es">
  <head>
  	<title>@yield('titulo')</title>
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
    
    <!-- Custom styles for this template -->
    <link href="{!! asset('assets/css/sticky-footer.css') !!}" rel="stylesheet">
    <link href="{!! asset('assets/css/estilos.css') !!}" rel="stylesheet">

  	@yield('head')
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
          	@yield('nav')
            <li><a href="{{ url('/') }}">Ayuda</a></li>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
  	<div id="wrapper">
  		@yield('sidebar')
	  	
	  	<div align="center" class="container" id="page-content-wrapper">
	  		<div id="mensajeModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	            <div class="modal-dialog modal-sm" role="document">
	              <div class="modal-content">
	                  <div class="modal-body">

	                  </div>
	              </div>
	            </div>
	        </div>
	  		@yield('container')


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
    @yield('js')
    @if(isset($modal) && $modal['mensaje'] != '')
      <script type="text/javascript">
        $('.modal-body').css('background-color','{{ $modal["color"] }}');
        $('.modal-body').text('{{ $modal["mensaje"] }}');
        $("#mensajeModal").modal('show');
        setTimeout("$('#mensajeModal').modal('hide')",3000);
      </script>
    @endif
    @yield('customjs')
  </body>

</html>