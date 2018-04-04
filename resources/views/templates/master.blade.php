<!DOCTYPE html>
<html lang="es">
  <head>
    <title>@yield('titulo')</title>
    <meta charset="utf-8">
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="HandheldFriendly" content="true" />
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <link rel="icon" href="{!! asset('assets/logotipos/ico_angel_cdmx.ico') !!}">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{!! asset('assets/css/bootstrap/bootstrap.min.css') !!}">
    <!-- Custom styles for this template -->
    <link href="{!! asset('assets/css/sticky-footer.css') !!}" rel="stylesheet">
    <link href="{!! asset('assets/css/estilos.css') !!}" rel="stylesheet">
    <script src="{!! asset('assets/js/jQuery/jquery-2.2.3.min.js') !!}"></script>
    @yield('head')
    @if(Session::get('user.roles.1') == 'Viatinet_Operativo' || Session::get('user.roles.1') == 'Viatinet_Titular' || Session::get('user.roles.1') =='Viatinet_supTitular' || Session::get('user.roles.1') == 'Viatinet_Dga' || Session::get('user.roles.1') =='Viatinet_supDga' || Session::get('user.roles.1') == 'Viatinet_Admin')
      <style type="text/css">
        .alert-info{
          background-color: blue;
          font-weight: bold;
          color: #fff;
          position: fixed;
          z-index: 1600;
          border-color: blue;
          left: 0;
          right: 0;
          top: 13%;
          margin: 0 auto;
          width: 280px;
        }        
        .alert-danger{
          background-color: #C6383D;
          font-weight: bold;
          color: #fff;
          position: fixed;
          z-index: 1600;
          border-color: #C6383D;
          left: 0;
          right: 0;
          top: 13%;
          margin: 0 auto;
          width: 280px;
        }
      </style>
    @endif
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
          <a class="navbar-brand" rel="home" href="{{ env('APP_PLATAFORMA_PRINCIPAL').'?id='.Session::get('sessionId') }}">
            <img src="{!! asset('assets/logotipos/logo_CDMX_blanco.png') !!}">
          </a>
          <a class="navbar-brand" href="{{ url('/svte') }}">&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sistema de CGCS</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <!--li><a href="{{ url('/') }}">Ayuda</a></li-->
            @yield('nav')
              @if(!isset($errorSession))
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                     <i class="fa fa-user fa-lg"></i>
                      &nbsp;&nbsp;
                      {{ ucwords(strtolower(preg_replace('/Ñ/','ñ',\Session::get('nombres').' '.\Session::get('paterno').' '.\Session::get('materno')))) }}
                      &nbsp;&nbsp;
                     <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ env('APP_PLATAFORMA_PRINCIPAL').'?id='.Session::get('sessionId') }}">
                            <i class="fa fa-home itemMenuPlataforma"></i>
                            <span class="textMenuPlataforma">Inicio</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ env('APP_PLATAFORMA').'informacion?id='.Session::get('sessionId') }}">
                            <i class="fa fa-info itemMenuPlataforma"></i>
                            <span class="textMenuPlataforma">Información de la cuenta</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ env('APP_PLATAFORMA').'updatePsw?id='.Session::get('sessionId') }}">
                            <i class="fa fa-lock itemMenuPlataforma"></i>
                            <span class="textMenuPlataforma">Cambiar contraseña</span>
                        </a>
                    </li>
                    <li role="separator" class="divider"></li>
                    <!--li class="dropdown-header">Nav header</li>
                    <li><a href="#">Separated link</a></li-->
                    <li>
                        <a href="{{ env('APP_PLATAFORMA').'home/ayuda' }}" target="_blank">
                            <i class="fa fa-question itemMenuPlataforma"></i>
                            <span class="textMenuPlataforma">Ayuda</span>
                        </a>
                    </li>
                    <li>
                     <a href="{{ url('/logout') }}">
                          <i class="fa fa-sign-out itemMenuPlataforma"></i>
                          <span class="textMenuPlataforma">Cerrar sesión</span>
                      </a>
                    </li>
                </ul>
              </li>
              @endif
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    @yield('nav2')
    <div align="center" class="container">
      @include('flash::message')
      <div id="mensajeModal" class="modal fade bs-example-modal-sm" role="dialog" aria-labelledby="mySmallModalLabel" style="z-index: 1600;">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-body"></div>
          </div>
        </div>
      </div>
      @yield('container')
    </div>
    <footer class="footer">
      <div class="container">
        <a class="navbar-brand" rel="home" href="#">
          <img src="{!! asset('assets/logotipos/logo_CDMX_blanco.png') !!}">
        </a>
        <p class="text-muted">
          <a class="enlaceFooter" data-toggle="modal" data-target="#declaracionVeracidad" href="#">Declaración de veracidad</a>|
          <a class="enlaceFooter" data-toggle="modal" data-target="#datospersonales" href="#">Protección de datos personales</a>|
          <a class="enlaceFooter" href="{{ env('APP_PLATAFORMA').'home/ayuda' }}" target="_blank">Ayuda</a>
        </p>
      </div>
    </footer>
    <div class="modal fade" id="declaracionVeracidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header" style="border-bottom: 1px solid trasparent">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h3 class="modal-title" id="myModalLabel" style=" font-weight:bold;margin-left: 4%;margin-top:4%;">Veracidad de la información</h3>
          </div>
          <div class="modal-body" style="margin: 2% 6% 6% 6%;text-align: justify;color:#333333">La información contenida en este sitio web, así como la contenida en los documentos anexos, puede contener datos personales, por lo que su difusión es responsabilidad de quien los transmite y quien los recibe, en términos de lo dispuesto por las fracciones II y VII del artículo 4, último párrafo del artículo 8, articulo 36 párrafo II, 38 fracción I y demás aplicables de la Ley de Transparencia y Acceso a la Información Pública del Distrito Federal.<br> Los Datos Personales se encuentran protegidos por la Ley de Protección de Datos Personales del Distrito Federal, por lo que su difusión se encuentra tutelada en sus artículos 2, 5, 16, 21, 41 y demás relativos y aplicables; debiendo sujetarse en su caso, a las disposiciones relativas a la creación, modificación o supresión de datos personales previstos.<br>Asimismo, deberá estarse a lo señalado en los numerales 1, 3, 12, 18, 19, 20, 21, 23, 24, 29, 35 y demás aplicables de los Lineamientos para la Protección de Datos Personales en el Distrito Federal.<br> En el uso de las tecnologías de la información y comunicaciones del Gobierno del Distrito Federal, deberá observarse puntualmente lo dispuesto por la Ley Gobierno Electrónico del Distrito Federal, la ley para hacer de la Ciudad de México una Ciudad Más Abierta, el apartado 10 de la Circular Uno vigente y las Normas Generales que deberán observarse en materia de Seguridad de la Información en la Administración Pública del Distrito Federal.<br> 
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="datospersonales" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h3 class="modal-title" id="myModalLabel" style=" font-weight:bold;margin-left: 4%;margin-top:4%;">Protección de datos personales</h4>
          </div>
          <div class="modal-body" style="margin: 2% 6% 6% 6%;text-align: justify;color:#333333">La información contenida en este sitio web, así como la contenida en los documentos anexos, puede contener datos personales, por lo que su difusión es responsabilidad de quien los transmite y quien los recibe, en términos de lo dispuesto por las fracciones II y VII del artículo 4, último párrafo del artículo 8, articulo 36 párrafo II, 38 fracción I y demás aplicables de la Ley de Transparencia y Acceso a la Información Pública del Distrito Federal.<br> Los Datos Personales se encuentran protegidos por la Ley de Protección de Datos Personales del Distrito Federal, por lo que su difusión se encuentra tutelada en sus artículos 2, 5, 16, 21, 41 y demás relativos y aplicables; debiendo sujetarse en su caso, a las disposiciones relativas a la creación, modificación o supresión de datos personales previstos.<br>Asimismo, deberá estarse a lo señalado en los numerales 1, 3, 12, 18, 19, 20, 21, 23, 24, 29, 35 y demás aplicables de los Lineamientos para la Protección de Datos Personales en el Distrito Federal.<br>En el uso de las tecnologías de la información y comunicaciones del Gobierno del Distrito Federal, deberá observarse puntualmente lo dispuesto por la Ley Gobierno Electrónico del Distrito Federal, la ley para hacer de la Ciudad de México una Ciudad Más Abierta, el apartado 10 de la Circular Uno vigente y las Normas Generales que deberán observarse en materia de Seguridad de la Información en la Administración Pública del Distrito Federal.<br> 
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script-->
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="{!! asset('assets/js/bootstrap/bootstrap.min.js') !!}"></script>
    <!-- Latest compiled and minified JavaScript -->
    @yield('js')
    <script>
      $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
      $('#flash-overlay-modal').modal();
    </script>
    @if(isset($modal) && $modal['mensaje'] != '')
      <script type="text/javascript">
        $('.modal-body').css('background-color','{{ $modal["color"] }}');
        $('.modal-body').text('{!! $modal["mensaje"] !!}');
        $("#mensajeModal").modal('show');
        setTimeout("$('#mensajeModal').modal('hide')",3000);
      </script>
    @endif
    @yield('customjs')
  </body>
</html>