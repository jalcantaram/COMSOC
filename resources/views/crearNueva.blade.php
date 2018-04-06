@extends('templates.master')
@section('titulo','CDMX | Sistema de CGCS')

@section('nav')
@section('nav2')
  @include('templates.nav2',[
    'nav2'=> [ 
      ['nombre'=>'&laquo; Gobierno Digital CDMX','href'=> env('APP_PLATAFORMA_PRINCIPAL')],
      ['nombre'=>'Registros', 'href'=> url('/svte')],
      ['nombre'=>'Registrar expediente', 'activo'=>'active'],
      ['nombre'=>'Autorizadas', 'href'=> url('/autorizadas')],
      ['nombre'=>'Rechazadas', 'href'=> url('/rechazadas')]
    ]
  ])
@endsection

@section('container')
<div class="divGeneral">
  <h2>Captura de Expedinte</h2>
    <form id="form" action="{{ url('/nfsvte')}}" role="form" method="POST">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="form-inline">
        <div class="form-group">
          <label class="col-md-2 control-label" for="tipoExp">Tipo:</label>
          <div class="col-xs-3">
            <select class="form-control" name="tipo[]" id="tipoExp" multiple required>
              <option selected disabled value="">Selecciona el tipo de expediente</option>
              <option value="prensa|Prensa">Prensa</option>
              <option value="radio|Radio">Radio</option>
              <option value="television|Televisión">Televisión</option>
              <option value="internet|Internet">Internet</option>
              <option value="monimedios|Monitor de medios">Monitor de medios</option>
              <option value="revista|Revista">Revista</option>
              <option value="otro|Otro">Otro</option>
            </select>
          </div>
        </div>
      </div>
      <br>
      <div class="form-inline">
        <div class="form-group">
          <input class="form-control" type="text" value="OM"  readonly=""  name="estandar"  placeholder="" style="width:55px;">
        </div>
        <div class="form-group">
          <h4>/</h4>
        </div>
        <div class="form-group">
          <input class="form-control" type="text" value="CGCS"  readonly=""  name="cgcs"  placeholder="" style="width:70px;">
        </div>
        <div class="form-group">
          <h4>/</h4>
        </div>
        <div class="form-group">
          <input class="form-control" type="text" value="CPS"  readonly=""  name="cps"  placeholder="" style="width:60px;">
        </div>
        <div class="form-group">
          <h4>-</h4>
        </div>
        <div class="form-group">
          <input class="form-control" id="folio" type="text" value="001"  readonly=""  name="folio"  placeholder="" style="width:65px;">
        </div>
        <div class="form-group">
          <h4>-</h4>
        </div>
        <div class="form-group">
          <input class="form-control" type="text" value="0"  readonly=""  name="numero" placeholder="" style="width:55px;">
        </div>
        <div class="form-group">
          <h4>-</h4>
        </div>
        <div class="form-group">
          <select class="form-control" name="year" id="year" required>
            <option selected disabled value="">Selecciona un año</option>
          </select>
        </div>
      </div>
      <br>
      <div class="form-horizontal">
        <div class="form-group">
          <input type="submit" value="Crear expedinte">
        </div>
      </div>
    </form>
</div>
@stop
@section('customjs') 
  <script>
    $(document).ready(function(){
      var myDate = new Date();
      var year = myDate.getFullYear();
      for(var i = 2014; i < year+1; i++){
        $("#year").append('<option value="'+i+'">'+i+'</option>');
      }
      $('#year').on('change', function(e){
        e.preventDefault();
        var anio = $(this).val();
        // console.log(anio);
        $.ajax({
          type: 'post',
          url:'{{ url("/getSecuencia") }}',
          data:{ _token : '{{ csrf_token() }}', anio : anio },
          dataType: 'json',
          success: function(response){
            console.log(response);
            var sec = '00' + (response.secuencia + 1);
            console.log(sec);
            $('#folio').val(sec);
          }
        });
      });
    }); 
  </script>
@endsection