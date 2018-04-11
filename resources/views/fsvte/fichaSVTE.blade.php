@extends('templates.master')
@section('titulo','CDMX | Sistema de CGCS')
@section('head')
<link rel="stylesheet" href="{!! asset('assets/css/font-awesome/css/font-awesome.min.css') !!}">
<link rel="stylesheet" href="{!! asset('assets/css/jquery.datetimepicker.css') !!}">
<link rel="stylesheet" href="{!! asset('assets/css/tipsy.css') !!}">
@endsection
@section('nav2')
  @include('templates.nav2',[
    'nav2'=>[ 
      ['nombre'=>'&laquo; Regresar', 'href'=> url(Session::get('urlBack'))],

    ]
  ])
@endsection
@section('container')
    <input type="hidden" id="cambio" value="0">
    <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header" style="border-bottom: 1px solid trasparent">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="itemModalLabel" style="text-align: left;"></h4>
          </div>
          <div id="itemModalBody" class="modal-body" style="margin: 2% 6% 6% 6%; color:#333333">
          </div>
        </div>
      </div>
    </div>  
    <div class="divIzquierdo">
      <div class="sidebar">
        <div class="titulo" style="font-size:18px">Registro de Viático</div>
        <div class="elementos">
          <ul>
            @foreach($sidebar as $key => $item)
              @php
                $tipoFase = []; 
                $fases = Session::get('fase.type');
              @endphp
              @foreach($item['type'] as $type)
                @foreach(array_keys($fases) as $k => $dataFase)
                  @if($type == $k)
                    @php $tipoFase[] = in_array($type, array_keys($fases)); @endphp
                  @endif
                @endforeach
              @endforeach
                {{--  @if(in_array(true, $tipoFase))  --}}
                {{--  @php dd([$key, Session::get('fase.'.$key.'.vacio'), !Session::has('fase.'.$key.'.vacio')]); @endphp  --}}
                @if(in_array(true,$tipoFase))
                  <li class="{{ (isset($item['active']))? 'active':'' }}">
                    <a class="enviaFase" href="{{ url('/svte/'.$item['id']) }}">
                      <div>

                        {{--  @if($key != 'requisicion')
                          @if(Session::get('fase.'.$key.'.vacio') || !Session::has('fase.'.$key.'.vacio'))
                              <i id="{{ $item['id'] }}" class="fa fa-close cross"></i>
                          @else
                              <i id="{{ $item['id'] }}" class="fa fa-check check"></i>
                          @endif
                        @else  --}}
                          @if(Session::get('fase.'.$key.'.vacio') || !Session::has('fase.'.$key.'.vacio'))
                              <i id="{{ $item['id'] }}" class="fa fa-close cross"></i>
                          @else
                              <i id="{{ $item['id'] }}" class="fa fa-check check"></i>
                          @endif
                        {{--  @endif  --}}
                        <label class="sideBarItem">{{ $item['nombre'] }}</label>
                      </div>
                    </a>
                  </li>
                @endif
            @endforeach
          </ul>
        </div>
      </div>
    </div>
    <div class="divDerecho">
    @php ($view = 'fsvte.'.Session::get('faseActual'))
    @if($sidebar[Session::get('faseActual')]['array'] && Session::get('faseStatus.'.Session::get('faseActual'))=='table')
      @include('fsvte.detalleArray')
    @else
      @include('fsvte.detalle')
    @endif
    </div>
@endsection
@section('js')
  <script src="{!! asset('assets/js/jquery.lockfixed.js') !!}"></script>
  <script src="{!! asset('assets/js/jquery.number.js') !!}"></script>
  <script src="{!! asset('assets/js/jquery.datetimepicker.js') !!}"></script>
  <script src="{!! asset('assets/js/jquery.tipsy.js') !!}"></script>

  <script src="{!! asset('js/upload/vendor/jquery.ui.widget.js') !!}"></script>
  <script src="{!! asset('js/upload/jquery.iframe-transport.js') !!}"></script>
  <script src="{!! asset('js/upload/jquery.fileupload.js') !!}"></script>


@endsection
@section('customjs')
  @if(Session::get('fase.detalleComision.nombre') == 'nacional' && Session::get('faseActual') != 'detalleComision')
    <script type="text/javascript">
      var sesOption = <?php $sesOption = json_encode(Session::get('fase'));  echo $sesOption; ?>;
      var sesArray = <?php $sesArray = json_encode(Session::get('fase.'.Session::get('faseActual').'.comisionados.'.Session::get('faseArrayEdit')));  echo $sesArray; ?>;
      var valSaliendo = <?php $valSaliendo = json_encode(Session::get('fase.'.Session::get('faseActual').'.comisionados.'.Session::get('faseArrayEdit').'.saliendoEstadoNacional'));  echo $valSaliendo; ?>;
      var valSaliendoMun = <?php $valSaliendoMun = json_encode(Session::get('fase.'.Session::get('faseActual').'.comisionados.'.Session::get('faseArrayEdit').'.saliendoMunicipioNacional'));  echo $valSaliendoMun; ?>;
      var valLlegando = <?php $valLlegando = json_encode(Session::get('fase.'.Session::get('faseActual').'.comisionados.'.Session::get('faseArrayEdit').'.llegandoEstadoNacional'));  echo $valLlegando; ?>;
      var valLlegandoMun = <?php $valLlegandoMun = json_encode(Session::get('fase.'.Session::get('faseActual').'.comisionados.'.Session::get('faseArrayEdit').'.llegandoMunicipioNacional'));  echo $valLlegandoMun; ?>;
      var sesRegNac = sesOption.registroPersonalNacional.comisionados;
      if (sesRegNac.length >= 0 && sesArray != null) {
        $('select[name="saliendoEstadoNacional"]').ready(function(){
          $.ajax({
            type: "GET",
            url: '{{ url("/getEstados") }}',
            cache: "false",
            success: function(response){
              $.each(response, function(k, i){
                if (valSaliendo == i[1]) {
                  var select = 'selected="selected"';
                }else{
                  var select = '';
                }
                $('select[name="saliendoEstadoNacional"]').append('<option value="'+i[1]+'" '+select+'>'+i[2]+'</option>');
              });
              $('select[name="saliendoEstadoNacional"]').ready(function() {
                $('select[name="saliendoMunicipioNacional"]').find('option').remove()
                var estado = valSaliendo;
                $.ajax({
                  type: "GET",
                  url: '{{ url("/getMunicipio") }}',
                  data: {_token: '{{ csrf_token() }}',municipio: estado },
                  cache: "false",
                  success: function(response){
                    var mun = response;
                    $.each(mun, function(k, i){
                      if (valSaliendoMun == i.nombreMunicipio) {
                        var select = 'selected="selected"';
                      }else{
                        var select = '';
                      }
                      $('select[name="saliendoMunicipioNacional"]').append('<option value="'+i.nombreMunicipio+'" '+select+'>'+i.nombreMunicipio+'</option>');
                    });
                    $('select[name="saliendoEstadoNacional"]').on('change' ,function(){
                      $('select[name="saliendoMunicipioNacional"]').find('option').remove()
                      var estado = $('select[name="saliendoEstadoNacional"]').val();
                      $.ajax({
                        type: "GET",
                        url: '{{ url("/getMunicipio") }}',
                        data: {_token: '{{ csrf_token() }}',municipio: estado },
                        cache: "false",
                        success: function(response){
                          var mun = response;
                          $.each(mun, function(k, i){
                            $('select[name="saliendoMunicipioNacional"]').append('<option value="'+i.nombreMunicipio+'">'+i.nombreMunicipio+'</option>');
                          });
                        }
                      });
                    });
                  }
                });
              });
            }
          });
        });
        $('select[name="llegandoEstadoNacional"]').ready(function(){
          $.ajax({
            type: "GET",
            url: '{{ url("/getEstados") }}',
            cache: "false",
            success: function(response){
              $.each(response, function(k, i){
                if (valLlegando == i[1]) {
                  var select = 'selected="selected"';
                }else{
                  var select = '';
                }
                $('select[name="llegandoEstadoNacional"]').append('<option value="'+i[1]+'" '+select+'>'+i[2]+'</option>');
              });
              $('select[name="llegandoEstadoNacional"]').ready(function() {
                $('select[name="llegandoMunicipioNacional"]').find('option').remove()
                var estado = valLlegando;
                $.ajax({
                  type: "GET",
                  url: '{{ url("/getMunicipio") }}',
                  data: {_token: '{{ csrf_token() }}',municipio: estado },
                  cache: "false",
                  success: function(response){
                    var mun = response;
                    $.each(mun, function(k, i){
                      if (valLlegandoMun == i.nombreMunicipio) {
                        var select = 'selected="selected"';
                      }else{
                        var select = '';
                      }
                      $('select[name="llegandoMunicipioNacional"]').append('<option value="'+i.nombreMunicipio+'" '+select+'>'+i.nombreMunicipio+'</option>');
                    });
                    $('select[name="llegandoEstadoNacional"]').on('change' ,function(){
                      $('select[name="llegandoMunicipioNacional"]').find('option').remove()
                      var estado = $('select[name="llegandoEstadoNacional"]').val();
                      $.ajax({
                        type: "GET",
                        url: '{{ url("/getMunicipio") }}',
                        data: {_token: '{{ csrf_token() }}',municipio: estado },
                        cache: "false",
                        success: function(response){
                          var mun = response;
                          $.each(mun, function(k, i){
                            $('select[name="llegandoMunicipioNacional"]').append('<option value="'+i.nombreMunicipio+'">'+i.nombreMunicipio+'</option>');
                          });
                        }
                      });
                    });
                  }
                });
              });
            }
          });
        });
      }else{
        $('select[name="saliendoEstadoNacional"]').append('<option selected="selected" disabled="disabled" hidden="hidden" value="">Selecciona una opción ...</option>');
        $('select[name="saliendoEstadoNacional"]').ready(function(){
          $.ajax({
            type: "GET",
            url: '{{ url("/getEstados") }}',
            cache: "false",
            success: function(response){
              $.each(response, function(k, i){
                $('select[name="saliendoEstadoNacional"]').append('<option value="'+i[1]+'">'+i[2]+'</option>');
              });
              $('select[name="saliendoEstadoNacional"]').on('change' ,function(){
                $('select[name="saliendoMunicipioNacional"]').find('option').remove()
                var estado = $('select[name="saliendoEstadoNacional"]').val();
                $.ajax({
                  type: "GET",
                  url: '{{ url("/getMunicipio") }}',
                  data: {_token: '{{ csrf_token() }}',municipio: estado },
                  cache: "false",
                  success: function(response){
                    var mun = response;
                    $('select[name="saliendoMunicipioNacional"]').append('<option selected="selected" disabled="disabled" hidden="hidden" value="">Selecciona una opción ...</option>');
                    $.each(mun, function(k, i){
                      $('select[name="saliendoMunicipioNacional"]').append('<option value="'+i.nombreMunicipio+'">'+i.nombreMunicipio+'</option>');
                    });
                  }
                });
              });
            }
          });
        });
        $('select[name="llegandoEstadoNacional"]').append('<option selected="selected" disabled="disabled" hidden="hidden" value="">Selecciona una opción ...</option>');
        $('select[name="llegandoEstadoNacional"]').ready(function(){
          $.ajax({
            type: "GET",
            url: '{{ url("/getEstados") }}',
            cache: "false",
            success: function(response){
              $('select[name="llegandoEstadoNacional"]').append('<option selected="selected" disabled="disabled" hidden="hidden" value="">Selecciona una opción ...</option>');
              $.each(response, function(k, i){
                $('select[name="llegandoEstadoNacional"]').append('<option value="'+i[1]+'">'+i[2]+'</option>');
              });
              $('select[name="llegandoEstadoNacional"]').on('change' ,function(){
                $('select[name="llegandoMunicipioNacional"]').find('option').remove()
                var estado = $('select[name="llegandoEstadoNacional"]').val();
                $.ajax({
                  type: "GET",
                  url: '{{ url("/getMunicipio") }}',
                  data: {_token: '{{ csrf_token() }}',municipio: estado },
                  cache: "false",
                  success: function(response){
                    var mun = response;
                    $('select[name="llegandoMunicipioNacional"]').append('<option selected="selected" disabled="disabled" hidden="hidden" value="">Selecciona una opción ...</option>');
                    $.each(mun, function(k, i){
                      $('select[name="llegandoMunicipioNacional"]').append('<option value="'+i.nombreMunicipio+'">'+i.nombreMunicipio+'</option>');
                    });
                  }
                });
              });
            }
          });
        });
      } 
    </script>
  @elseif(Session::get('fase.detalleComision.nombre') == 'internacional' && Session::get('faseActual') != 'detalleComision')
    <script type="text/javascript">
      var sesOption = <?php $sesOption = json_encode(Session::get('fase'));  echo $sesOption; ?>;
      var sesArray = <?php $sesArray = json_encode(Session::get('fase.'.Session::get('faseActual').'.comisionados.'.Session::get('faseArrayEdit')));  echo $sesArray; ?>;
      var valSaliendoInt = <?php $valSaliendoInt = json_encode(Session::get('fase.'.Session::get('faseActual').'.comisionados.'.Session::get('faseArrayEdit').'.saliendoContinenteInternacional'));  echo $valSaliendoInt; ?>;
      var valSaliendoIntPais = <?php $valSaliendoIntPais = json_encode(Session::get('fase.'.Session::get('faseActual').'.comisionados.'.Session::get('faseArrayEdit').'.saliendoPaisInternacional'));  echo $valSaliendoIntPais; ?>;
      var valSaliendoIntEntidad = <?php $valSaliendoIntEntidad = json_encode(Session::get('fase.'.Session::get('faseActual').'.comisionados.'.Session::get('faseArrayEdit').'.saliendoEntidadInternacional'));  echo $valSaliendoIntEntidad; ?>;
      var valLlegandoInt = <?php $valLlegandoInt = json_encode(Session::get('fase.'.Session::get('faseActual').'.comisionados.'.Session::get('faseArrayEdit').'.llegandoContinenteInternacional'));  echo $valLlegandoInt; ?>;
      var valLlegandoIntPais = <?php $valLlegandoIntPais = json_encode(Session::get('fase.'.Session::get('faseActual').'.comisionados.'.Session::get('faseArrayEdit').'.llegandoPaisInternacional'));  echo $valLlegandoIntPais; ?>;
      var valLlegandoIntEntidad = <?php $valLlegandoIntEntidad = json_encode(Session::get('fase.'.Session::get('faseActual').'.comisionados.'.Session::get('faseArrayEdit').'.llegandoEntidadInternacional'));  echo $valLlegandoIntEntidad; ?>;
      var sesRegInt = sesOption.registroPersonalInternacional.comisionados;
      if(sesRegInt.length >= 0 && sesArray != null) {
        $('select[name="saliendoContinenteInternacional"]').ready(function(){
          var continente = valSaliendoInt;
          $.ajax({
            type: "GET",
            url: '{{ url("/getContinente") }}',
            data: {_token: '{{ csrf_token() }}', continente: continente },
            cache: "false",
            success: function(response){
              $.each(response, function(k, i){
                if (valSaliendoIntPais == i[1]) {
                  var select = 'selected="selected"';
                }else{
                  var select = '';
                }
                $('select[name="saliendoPaisInternacional"]').append('<option value="'+i[1]+'" '+select+'>'+i[2]+'</option>');
              });
              $('select[name="saliendoPaisInternacional"]').ready(function(){
                var pais = valSaliendoIntPais;
                $.ajax({
                  type: 'GET',
                  url: '{{ url("/getPaisInternacional") }}',
                  data: {_token: '{{ csrf_token() }}', continente: continente, pais: pais},
                  cache: "false",
                  success:function(response){
                    $.each(response, function(k, i){
                      if (valSaliendoIntEntidad == i[1]) {
                        var select = 'selected="selected"';
                      }else{
                        var select = '';
                      }
                      $('select[name="saliendoEntidadInternacional"]').append('<option value="'+i[1]+'" '+select+'>'+i[1]+'</option>');
                    });
                  }
                });
              });
            }
          });
        });
        $('select[name="llegandoContinenteInternacional"]').ready(function(){
          var continente = valLlegandoInt;
          $.ajax({
            type: "GET",
            url: '{{ url("/getContinente") }}',
            data: {_token: '{{ csrf_token() }}', continente: continente },
            cache: "false",
            success: function(response){
              $.each(response, function(k, i){
                if (valLlegandoIntPais == i[1]) {
                  var select = 'selected="selected"';
                }else{
                  var select = '';
                }
                $('select[name="llegandoPaisInternacional"]').append('<option value="'+i[1]+'" '+select+'>'+i[2]+'</option>');
              });
              $('select[name="llegandoPaisInternacional"]').ready(function(){
                var pais = valLlegandoIntPais;
                $.ajax({
                  type: 'GET',
                  url: '{{ url("/getPaisInternacional") }}',
                  data: {_token: '{{ csrf_token() }}', continente: continente, pais: pais},
                  cache: "false",
                  success:function(response){
                    $.each(response, function(k, i){
                      if (valLlegandoIntEntidad == i[1]) {
                        var select = 'selected="selected"';
                      }else{
                        var select = '';
                      }
                      $('select[name="llegandoEntidadInternacional"]').append('<option value="'+i[1]+'" '+select+'>'+i[1]+'</option>');
                    });
                  }
                });
              });
            }
          });
        });
        $('select[name="saliendoContinenteInternacional"]').on('change', function(){
          $('select[name="saliendoPaisInternacional"]').find('option').remove();
          var continente = $('select[name="saliendoContinenteInternacional"]').val();
          $.ajax({
            type: "GET",
            url: '{{ url("/getContinente") }}',
            data: {_token: '{{ csrf_token() }}', continente: continente },
            cache: "false",
            success: function(response){
              $('select[name="saliendoPaisInternacional"]').append('<option selected="selected" disabled="disabled" hidden="hidden" value="">Selecciona una opción ...</option>');
              $.each(response, function(k, i){
                $('select[name="saliendoPaisInternacional"]').append('<option value="'+i[1]+'">'+i[2]+'</option>');
              });
              $('select[name="saliendoPaisInternacional"]').on('change', function(){
                var pais = $('select[name="saliendoPaisInternacional"]').val();
                $.ajax({
                  type: 'GET',
                  url: '{{ url("/getPaisInternacional") }}',
                  data: {_token: '{{ csrf_token() }}', continente: continente, pais: pais},
                  cache: "false",
                  success:function(response){
                    $('select[name="saliendoEntidadInternacional"]').find('option').remove();
                    $('select[name="saliendoEntidadInternacional"]').append('<option selected="selected" disabled="disabled" hidden="hidden" value="">Selecciona una opción ...</option>');
                    $.each(response, function(k, i){
                      $('select[name="saliendoEntidadInternacional"]').append('<option value="'+i[1]+'">'+i[1]+'</option>');
                    });
                  }
                });
              });
            }
          });
        });
        $('select[name="llegandoContinenteInternacional"]').on('change', function(){
          $('select[name="llegandoPaisInternacional"]').find('option').remove();
          var continente = $('select[name="llegandoContinenteInternacional"]').val();
          $.ajax({
            type: "GET",
            url: '{{ url("/getContinente") }}',
            data: {_token: '{{ csrf_token() }}', continente: continente },
            cache: "false",
            success: function(response){
              $('select[name="llegandoPaisInternacional"]').append('<option selected="selected" disabled="disabled" hidden="hidden" value="">Selecciona una opción ...</option>');
              $.each(response, function(k, i){
                $('select[name="llegandoPaisInternacional"]').append('<option value="'+i[1]+'">'+i[2]+'</option>');
              });
              $('select[name="llegandoPaisInternacional"]').on('change', function(){
                var pais = $('select[name="llegandoPaisInternacional"]').val();
                $.ajax({
                  type: 'GET',
                  url: '{{ url("/getPaisInternacional") }}',
                  data: {_token: '{{ csrf_token() }}', continente: continente, pais: pais},
                  cache: "false",
                  success:function(response){
                    $('select[name="llegandoEntidadInternacional"]').find('option').remove();
                    $('select[name="llegandoEntidadInternacional"]').append('<option selected="selected" disabled="disabled" hidden="hidden" value="">Selecciona una opción ...</option>');
                    $.each(response, function(k, i){
                      $('select[name="llegandoEntidadInternacional"]').append('<option value="'+i[1]+'">'+i[1]+'</option>');
                    });
                  }
                });
              });
            }
          });
        });           
      }else{
        $('select[name="saliendoContinenteInternacional"]').append('<option selected="selected" disabled="disabled" hidden="hidden" value="">Selecciona una opción ...</option>');
        $('select[name="saliendoContinenteInternacional"]').on('change', function(){
          $('select[name="saliendoPaisInternacional"]').find('option').remove();
          var continente = $('select[name="saliendoContinenteInternacional"]').val();
          $.ajax({
            type: "GET",
            url: '{{ url("/getContinente") }}',
            data: {_token: '{{ csrf_token() }}', continente: continente },
            cache: "false",
            success: function(response){
              $('select[name="saliendoPaisInternacional"]').append('<option selected="selected" disabled="disabled" hidden="hidden" value="">Selecciona una opción ...</option>');
              $.each(response, function(k, i){
                $('select[name="saliendoPaisInternacional"]').append('<option value="'+i[1]+'">'+i[2]+'</option>');
              });
              $('select[name="saliendoPaisInternacional"]').on('change', function(){
                var pais = $('select[name="saliendoPaisInternacional"]').val();
                $.ajax({
                  type: 'GET',
                  url: '{{ url("/getPaisInternacional") }}',
                  data: {_token: '{{ csrf_token() }}', continente: continente, pais: pais},
                  cache: "false",
                  success:function(response){
                    $('select[name="saliendoEntidadInternacional"]').find('option').remove();
                    $('select[name="saliendoEntidadInternacional"]').append('<option selected="selected" disabled="disabled" hidden="hidden" value="">Selecciona una opción ...</option>');
                    $.each(response, function(k, i){
                      $('select[name="saliendoEntidadInternacional"]').append('<option value="'+i[1]+'">'+i[1]+'</option>');
                    });
                  }
                });
              });
            }
          });
        });
        $('select[name="llegandoContinenteInternacional"]').append('<option selected="selected" disabled="disabled" hidden="hidden" value="">Selecciona una opción ...</option>');
        $('select[name="llegandoContinenteInternacional"]').on('change', function(){
          $('select[name="llegandoPaisInternacional"]').find('option').remove();
          var continente = $('select[name="llegandoContinenteInternacional"]').val();
          $.ajax({
            type: "GET",
            url: '{{ url("/getContinente") }}',
            data: {_token: '{{ csrf_token() }}', continente: continente },
            cache: "false",
            success: function(response){
              $('select[name="llegandoPaisInternacional"]').append('<option selected="selected" disabled="disabled" hidden="hidden" value="">Selecciona una opción ...</option>');
              $.each(response, function(k, i){
                $('select[name="llegandoPaisInternacional"]').append('<option value="'+i[1]+'">'+i[2]+'</option>');
              });
              $('select[name="llegandoPaisInternacional"]').on('change', function(){
                var pais = $('select[name="llegandoPaisInternacional"]').val();
                $.ajax({
                  type: 'GET',
                  url: '{{ url("/getPaisInternacional") }}',
                  data: {_token: '{{ csrf_token() }}', continente: continente, pais: pais},
                  cache: "false",
                  success:function(response){
                    $('select[name="llegandoEntidadInternacional"]').find('option').remove();
                    $('select[name="llegandoEntidadInternacional"]').append('<option selected="selected" disabled="disabled" hidden="hidden" value="">Selecciona una opción ...</option>');
                    $.each(response, function(k, i){
                      $('select[name="llegandoEntidadInternacional"]').append('<option value="'+i[1]+'">'+i[1]+'</option>');
                    });
                  }
                });
              });
            }
          });
        });      
      }
    </script>
  @endif
  <script type="text/javascript">
    $(document).ready(function(){
      $.lockfixed(".sidebar",{offset: {top: 100, bottom: 65}}); 
      var tipoV = "<?php echo Session::get('fase.detalleComision.nombre'); ?>";
      var faseValida = "<?php echo Session::get('faseActual'); ?>";
      var auxiliar = '';
      var countOptionpasajes = $('#tabla-pasajes tr td select[name="pasajes[0][pasajesPartida]"] option').length;
      var countOptionviaticos = $('#tabla-viaticos tr td select[name="viaticos[0][viaticosPartida]"] option').length;
      $('input[name="nomComision"]').attr('placeholder', 'Ejemplo: Quinta Semana de Transparencia y Rendición ...');
      $('input[name="nivelPuesto"]').attr('maxlength', '3');
      $('input[name="numeroEmpleado"]').attr('minlength', '4').attr('maxlength', '10');


      // var countRowsTablePasajes = document.getElementById('tabla-pasajes') ? document.getElementById('tabla-pasajes').tBodies[0].rows.length : null;
      var rowsTablePasajes = document.getElementById('tabla-pasajes') ? document.getElementById('tabla-pasajes').tBodies[0].rows : null;
      var getValuePasajes = document.getElementById('tabla-pasajes') ? document.getElementById('tabla-pasajes').querySelector('select') : null;
      var getFirstValPasajes = document.getElementById('tabla-pasajes') ? document.getElementById('tabla-pasajes').querySelector('select[name="pasajes[0][pasajesPartida]"]').value : null;
      var tablaPasajes = document.getElementById('tabla-pasajes') ? document.getElementById('tabla-pasajes') : null;
      if (tablaPasajes != null) {
        document.getElementById('tabla-pasajes').addEventListener('change', function(){
          var countRowsTablePasajesN = document.getElementById('tabla-pasajes').tBodies[0].rows.length;
          if(countRowsTablePasajesN !== 1){
            var getValPasajes0 = document.getElementById('tabla-pasajes').querySelector('select[name="pasajes[0][pasajesPartida]"]').value;
            var getValPasajes1 = document.getElementById('tabla-pasajes').querySelector('select[name="pasajes[1][pasajesPartida]"]') ? document.getElementById('tabla-pasajes').querySelector('select[name="pasajes[1][pasajesPartida]"]').value : 1;
            var getValPasajes2 = document.getElementById('tabla-pasajes').querySelector('select[name="pasajes[2][pasajesPartida]"]') ? document.getElementById('tabla-pasajes').querySelector('select[name="pasajes[2][pasajesPartida]"]').value : 2;
            var getValPasajes3 = document.getElementById('tabla-pasajes').querySelector('select[name="pasajes[3][pasajesPartida]"]') ? document.getElementById('tabla-pasajes').querySelector('select[name="pasajes[3][pasajesPartida]"]').value : 3;
            var regla1 = (getValPasajes0 == getValPasajes1 && getValPasajes2 == 2 && getValPasajes3 == 3); 
            var regla2 = (getValPasajes0 == getValPasajes1 && getValPasajes0 == getValPasajes2 && getValPasajes1 == getValPasajes2 && getValPasajes3 == null);
            var regla3 = (getValPasajes0 == getValPasajes1 && getValPasajes0 == getValPasajes2 && getValPasajes0 == getValPasajes3);
            var regla4 = (getValPasajes0 == getValPasajes3 && getValPasajes1 == "" && getValPasajes2 == "");
            var regla5 = (getValPasajes0 == getValPasajes1 && getValPasajes1 == getValPasajes2 && getValPasajes2 == getValPasajes3 && getValPasajes0 == getValPasajes3);
            var regla6 = (getValPasajes0 == getValPasajes1 && getValPasajes2 == getValPasajes3);
            var regla7 = (getValPasajes0 == getValPasajes2 && getValPasajes1 == "" && getValPasajes3 == null);
            var regla8 = (getValPasajes0 == getValPasajes3 && getValPasajes1 == "" && getValPasajes2 == "");
            var regla9 = (getValPasajes0 == getValPasajes3 && getValPasajes1 == "" && getValPasajes2 == getValPasajes3);
            var regla10 = (getValPasajes0 == getValPasajes3 && getValPasajes1 == getValPasajes2);
            var regla11 = (getValPasajes1 == getValPasajes2 && getValPasajes3 == null);
            var regla12 = (getValPasajes2 == getValPasajes3 && getValPasajes1 == "" && getValPasajes3 != getValPasajes0);
            var regla13 = (getValPasajes0 == getValPasajes1 && getValPasajes2 != getValPasajes0 && getValPasajes2 != getValPasajes1 && getValPasajes3 == 3);
            var regla14 = (getValPasajes0 == getValPasajes1 && getValPasajes1 == getValPasajes2 && getValPasajes0 == getValPasajes2 && getValPasajes3 == 3);
            var regla15 = (getValPasajes0 == getValPasajes2 && getValPasajes1 == "" && getValPasajes2 != getValPasajes1 && getValPasajes3 == 3);
            var regla16 = (getValPasajes0 == getValPasajes2 && getValPasajes1 != "" && getValPasajes2 != getValPasajes1 && getValPasajes3 == 3);
            console.log([{getValPasajes0, getValPasajes1, getValPasajes2, getValPasajes3},{regla1, regla2, regla3, regla4, regla5, regla6, regla7, regla8, regla9, regla10, regla11, regla12, regla13, regla14, regla15, regla16}]);
          }else{
            var getValPasajes = document.getElementById('tabla-pasajes').querySelector('select[name="pasajes[0][pasajesPartida]"]').value;
            console.log(getValPasajes);
          }
        });
      }



      $('#pasajes.agregaItem').click(function(event){
          event.preventDefault();
          if($('#tabla-'+$(this).attr('id')).children('tbody').children().size() >= countOptionpasajes){
              $('.modal-body').css('background-color','#C6383D');
              $('.modal-body').text('Máximo '+countOptionpasajes+' elementos.');
              $("#mensajeModal").modal('show');
              setTimeout("$('#mensajeModal').modal('hide')",3000);
          }else{
            var params={};
            params['id']=$(this).attr('id');
            params['position']=$('#tabla-'+$(this).attr('id')).children('tbody').children().size();
            params['_token']=$('#token').val();
            params['keyCom'] = Object.keys(<?php $sesOption = json_encode(Session::get('fase.'.Session::get('faseActual')));  echo $sesOption; ?>)[2];
            $.ajax({
              url: '{{ url("/newItem") }}',
              data: params,
              type: 'post',
              dataType: 'json',
              success: function(response){
                $(response.id).children('tbody').append(response.item);
                $('.double').number(true,2);
              }
            });
          }
      });

      $('#viaticos.agregaItem').click(function(event){
          event.preventDefault();
          if($('#tabla-'+$(this).attr('id')).children('tbody').children().size() >= countOptionviaticos){
              $('.modal-body').css('background-color','#C6383D');
              $('.modal-body').text('Máximo '+countOptionviaticos+' elementos.');
              $("#mensajeModal").modal('show');
              setTimeout("$('#mensajeModal').modal('hide')",3000);
          }else{
            var params={};
            params['id']=$(this).attr('id');
            params['position']=$('#tabla-'+$(this).attr('id')).children('tbody').children().size();
            params['_token']=$('#token').val();
            params['keyCom'] = Object.keys(<?php $sesOption = json_encode(Session::get('fase.'.Session::get('faseActual')));  echo $sesOption; ?>)[2];
            $.ajax({
              url: '{{ url("/newItem") }}',
              data: params,
              type: 'post',
              dataType: 'json',
              success: function(response){
                $(response.id).children('tbody').append(response.item);
                $('.double').number(true,2);
              }
            });
          }
      });

      $(".modal-body").on('click','.notifySi',function(){ setTimeout("$('#mensajeModal').modal('hide')",10); location.href = auxiliar; });
      $(".modal-body").on('click','.notifyNo',function(){ setTimeout("$('#mensajeModal').modal('hide')",10); });
      $(".modal-body").on('click','.notifyDel',function(){ auxiliar.parent().parent().remove(); auxiliar=''; setTimeout("$('#mensajeModal').modal('hide')",10); });
      $('#form').on('click','.btn-delItem',function(){
        $('.modal-body').css('background-color','#C6383D');
        $('.modal-body').css('font-weight','normal');
        $('.modal-body').html('<br>¿Desea eliminar el elemento?<br><br>'+
          '<button class="botonesNotify notifyDel">Si</button>'+
          '<button class="botonesNotify notifyNo">No</button><br><br>');
        $("#mensajeModal").modal('show');
        auxiliar = $(this);
      });

      $(".enviaFase").click(function(event){
          if($("#cambio").val() != '0'){
              $('.modal-body').css('background-color','#C6383D');
              $('.modal-body').css('font-weight','normal');
              $('.modal-body').html('<br>No guardó los cambios,<br>se perderán si continua. <br>¿Desea continuar?<br><br>'+
                                    '<button class="botonesNotify notifySi">Si</button>'+
                                    '<button class="botonesNotify notifyNo">No</button><br><br>');
              $("#mensajeModal").modal('show');
              event.preventDefault();
              auxiliar = $(this).prop('href');
          }
      });

      $("#form").on('keyup','input',function(){ $("#cambio").val('1'); });

      $('#envioFin').click(function(event){
          event.preventDefault();
          $("input").removeClass('bordeRojo');
          $("select").removeClass('bordeRojo');
          $("textarea").removeClass('bordeRojo');
          $('.tipsy').remove();
          $.ajax({
              url: '{{ url("/ffsvte") }}',
              data: $("#formFin").serialize(),
              type: 'post',
              dataType: 'json',
              success: function(response){
                if(response.error == 0){
                    $('#'+response.etapa).removeClass('fa-close cross').addClass('fa-check check');
                    $("#cambio").val('0');
                }else{
                    if(response.error == 99){
                        $.each(response.validacion,function(k,i){ 
                            if(jQuery.type(i) != 'object' && jQuery.type(i) != 'array'){
                                if(i!=0){ 
                                    $("input[name='"+k+"']").addClass('bordeRojo')
                                                            .attr('original-title',i)
                                                            .tipsy({ trigger: 'manual', gravity: 'w'})
                                                            .tipsy('show');
                                    $("select[name='"+k+"']").addClass('bordeRojo')
                                                             .attr('original-title',i)
                                                             .tipsy({ trigger: 'manual', gravity: 'w'})
                                                             .tipsy('show');
                                    $("textarea[name='"+k+"']").addClass('bordeRojo')
                                                               .attr('original-title',i)
                                                               .tipsy({ trigger: 'manual', gravity: 'w'})
                                                               .tipsy('show');
                                }
                            }else{
                                $.each(i,function(k2,i2){
                                    if(jQuery.type(i2) != 'object'){
                                        if(i2!=0){ 
                                            $("input[name='"+k+"["+k2+"]']").addClass('bordeRojo')
                                                            .attr('original-title',i2)
                                                            .tipsy({ trigger: 'manual', gravity: 'w'})
                                                            .tipsy('show');
                                            $("select[name='"+k+"["+k2+"]']").addClass('bordeRojo')
                                                                     .attr('original-title',i2)
                                                                     .tipsy({ trigger: 'manual', gravity: 'w'})
                                                                     .tipsy('show');
                                            $("textarea[name='"+k+"["+k2+"]']").addClass('bordeRojo')
                                                                       .attr('original-title',i2)
                                                                       .tipsy({ trigger: 'manual', gravity: 'w'})
                                                                       .tipsy('show');
                                        }
                                    }else{
                                        $.each(i2,function(k3,i3){
                                            if(i3!=0){ 
                                                $("input[name='"+k+"["+k2+"]["+k3+"]']").addClass('bordeRojo')
                                                                .attr('original-title',i3)
                                                                .tipsy({ trigger: 'manual', gravity: 's'})
                                                                .tipsy('show');
                                                $("select[name='"+k+"["+k2+"]["+k3+"]']").addClass('bordeRojo')
                                                                         .attr('original-title',i3)
                                                                         .tipsy({ trigger: 'manual', gravity: 's'})
                                                                         .tipsy('show');
                                                $("textarea[name='"+k+"["+k2+"]["+k3+"]']").addClass('bordeRojo')
                                                                           .attr('original-title',i3)
                                                                           .tipsy({ trigger: 'manual', gravity: 's'})
                                                                           .tipsy('show');
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    }
                }
                $('.modal-body').css('background-color',response.color);
                $('.modal-body').html(response.msg+'<br> <br>'+'NOTA: Este tramite se ha enviado a la bandeja del Titular para su validación');
                $("#mensajeModal").modal('show');
                $('#collapse1').collapse('show');
                setTimeout(function(){
                    $('#mensajeModal').modal('hide');
                    setTimeout(function(){
                        if(response.error == 0){
                            location.href = "{{ url('/svte/') }}";
                        }
                    },500);
                },5500);
              }
          });
      });

      $('#envio').click(function(event){
          event.preventDefault();
          $("input").removeClass('bordeRojo');
          $("select").removeClass('bordeRojo');
          $("textarea").removeClass('bordeRojo');
          $('.tipsy').remove();
          $('#collapse1').collapse('show');
          $('#collapse2').collapse('show');
          $('#collapse3').collapse('show');
          $('#collapse4').collapse('show');
          $.ajax({
              url: '{{ url("/gfsvte") }}',
              data: $("#form").serialize(),
              type: 'post',
              dataType: 'json',
              success: function(response){
                // console.log(response);
                if(response.error == 0){
                    $('#'+response.etapa).removeClass('fa-close cross').addClass('fa-check check');
                    $("#cambio").val('0');
                }else{
                    if(response.error == 99){
                        $.each(response.validacion,function(k,i){ 
                            if(jQuery.type(i) != 'object' && jQuery.type(i) != 'array'){
                              if(i!=0){
                                // console.log(k);
                                $("input[name='"+k+"']").addClass('bordeRojo')
                                  .attr('original-title',i)
                                  .tipsy({ trigger: 'manual', gravity: 'w'})
                                  .tipsy('show');
                                $("select[name='"+k+"']").addClass('bordeRojo')
                                  .attr('original-title',i)
                                  .tipsy({ trigger: 'manual', gravity: 'w'})
                                  .tipsy('show');
                                $("textarea[name='"+k+"']").addClass('bordeRojo')
                                  .attr('original-title',i)
                                  .tipsy({ trigger: 'manual', gravity: 'w'})
                                  .tipsy('show');
                              }
                            }else{
                                $.each(i,function(k2,i2){
                                  // console.log({k2, k, i, i2});
                                    if(jQuery.type(i2) != 'object'){
                                        if(i2!=0){ 
                                          $("input[name='"+k+"["+k2+"]']").addClass('bordeRojo')
                                                          .attr('original-title',i2)
                                                          .tipsy({ trigger: 'manual', gravity: 'w'})
                                                          .tipsy('show');
                                          $("select[name='"+k+"["+k2+"]']").addClass('bordeRojo')
                                                                   .attr('original-title',i2)
                                                                   .tipsy({ trigger: 'manual', gravity: 'w'})
                                                                   .tipsy('show');
                                          $("textarea[name='"+k+"["+k2+"]']").addClass('bordeRojo')
                                                                     .attr('original-title',i2)
                                                                     .tipsy({ trigger: 'manual', gravity: 'w'})
                                                                     .tipsy('show');
                                          var l = 0;
                                          if (k2 == 'montoPasajes') {
                                            var t = 'input[name="'+k+'[pasajes]['+(l++)+']['+k2+']"]';
                                            console.log(t);
                                            $(t).addClass('bordeRojo')
                                              .attr('original-title',i2)
                                              .tipsy({ trigger: 'manual', gravity: 'w'})
                                              .tipsy('show');                                              
                                          }
                                        }
                                    }else{
                                        $.each(i2,function(k3,i3){
                                            if(i3!=0){ 
                                              $("input[name='"+k+"["+k2+"]["+k3+"]']").addClass('bordeRojo')
                                                              .attr('original-title',i3)
                                                              .tipsy({ trigger: 'manual', gravity: 's'})
                                                              .tipsy('show');
                                              $("select[name='"+k+"["+k2+"]["+k3+"]']").addClass('bordeRojo')
                                                                       .attr('original-title',i3)
                                                                       .tipsy({ trigger: 'manual', gravity: 's'})
                                                                       .tipsy('show');
                                              $("textarea[name='"+k+"["+k2+"]["+k3+"]']").addClass('bordeRojo')
                                                                         .attr('original-title',i3)
                                                                         .tipsy({ trigger: 'manual', gravity: 's'})
                                                                         .tipsy('show');
                                           }
                                        });
                                    }
                                });
                            }
                        });
                    }
                }
                $('.modal-body').css('background-color',response.color);
                $('.modal-body').text(response.msg);
                $("#mensajeModal").modal('show');
                if (faseValida != 'detalleComision') {
                  setTimeout(function(){
                    $('#mensajeModal').modal('hide');
                    setTimeout(function(){
                      if(response.error == 0){
                        location.href = "{{ url('/svte/'.Session::get('faseActual')) }}";
                      }
                    },500);
                  },3000);
                }else{
                  if (tipoV == 'nacional') {
                    setTimeout(function(){
                      $('#mensajeModal').modal('hide');
                      setTimeout(function(){
                        if(response.error == 0){
                          location.href = "{{ url('/svte/registroPersonalNacional') }}";
                        }
                      },500);
                    },3000);
                  }else{
                    setTimeout(function(){
                      $('#mensajeModal').modal('hide');
                      setTimeout(function(){
                        if(response.error == 0){
                          location.href = "{{ url('/svte/registroPersonalInternacional') }}";
                        }
                      },500);
                    },3000);
                  }
                }
              }
          });
      });

      function actualizaTotal(){ var sum = 0; $('.calendario-total').each(function(){sum += parseInt($(this).val()); }); $("#calendario-total").number( sum , 2, '.', ',' ); }

      jQuery.datetimepicker.setLocale('es');

      $('.date').datetimepicker({ timepicker: false, scrollInput:false, format: 'd-m-Y' });

      $('.datetime').datetimepicker({ format: 'd-m-Y H:i', scrollInput:false, });

      $('.time').datetimepicker({ datepicker: false, scrollInput:false, format: 'H:i' });

      $('.integer').number(true,0);

      $('.unsigned').number(true,0,'','');

      $('.pct').number(true,0,'','');

      $('.double').number(true,2);

      $('.float').number(true,2);

      $('.real').number(true,2);

      $('#form').on('keyup','.calendario-total',function(){ actualizaTotal(); });

      $('#form').on('blur','.calendario-total',function(){ actualizaTotal(); });

      $(document).on('click','.agregaItemModal',function(event){
        event.preventDefault();
        $("#itemModalBody").css('background-color','#FFFFFF');
        $("#itemModalLabel").text($(this).children('.itemModalLabel').val());
        var params={};
        params['id']=$(this).children('.itemModalId').val();
        params['position']=0;
        params['_token']=$('#token').val();
        params['itemToken']=$(this).children('.itemModalToken').val();
        $.ajax({
          url: '{{ url("/newItemModal") }}',
          data: params,
          type: 'post',
          dataType: 'json',
          success: function(response){
            $("#itemModalBody").html(response.item);
            $("#itemModal").modal('show');
          }
        });
      });

      $("#itemModal").on('click','.cargaItemModal',function(event){
          event.preventDefault();

          $.ajax({
              url: '{{ url("/loadItemModal") }}',
              data: $('#formItemModal').serialize()+'&_token='+$('#token').val(),
              type: 'post',
              dataType: 'json',
              success: function(response){
                  $("#"+$("#idItemModal").val()).val(response.item);
                  $("#itemModal").modal('hide');
              }
          });
      });
    });
  </script>
@endsection