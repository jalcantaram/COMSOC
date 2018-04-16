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
      <div class="form-horizontal">
        <div class="form-group">
          <label class="col-md-1 control-label" for="tipoExp">Tipo:</label>
          <div class="col-md-6">
            <div class="checkbox">
              <label><input type="checkbox" name="tipo[]" value="prensa|Prensa">Prensa</label>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" name="tipo[]" value="radio|Radio">Radio</label>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" name="tipo[]" value="television|Televisión">Televisión</label>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" name="tipo[]" value="internet|Internet">Internet</label>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" name="tipo[]" value="monimedios|Monitor de medios">Monitor de medios</label>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" name="tipo[]" value="revista|Revista">Revista</label>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" name="tipo[]" value="otro|Otro">Otro</label>
            </div>            
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
          <select class="form-control" name="year" id="year" required style="width:80px;">
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