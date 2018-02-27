<h2>{{ $sidebar[Session::get('faseActual')]['nombre'] }}</h2>
<form class="form-horizontal" id="form" accept-charset="UTF-8" method="post" action="{{ url('/gfsvte')}}" role="form">
    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
      <div class="col-lg-8">
        <label for="nombre"><strong>Proyecto:</strong>&nbsp;&nbsp; 
          {{ Session::get('fase.'.Session::get('faseActual').'.nombre') }}
        </label>
      </div>      
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="objetivo">Objetivo del proyecto</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.objetivo') }}" 
               name="objetivo" placeholder="Ingrese objetivo del proyecto">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="tipo">Tipo de proyecto</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.tipo') }}" 
               name="tipo" placeholder="Ingrese tipo de proyecto">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="unidadResponsable">Unidad responsable</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
              value="{{ \Session::get('fase.'.\Session::get('faseActual').'.unidadResponsable') }}" 
              name="unidadResponsable" placeholder="Ingrese unidad responsable">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="responsable">Responsable del proyecto</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.responsable') }}" 
               name="responsable" placeholder="Ingrese responsable de proyecto">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="solicitante">Solicitante</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.solicitante') }}" 
               name="solicitante" placeholder="Ingrese solicitante">
      </div>
    </div>
    <hr>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="mi"><strong>Monto de la inversión</strong></label>
      </div>      
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="sinIVA">Monto de inversión sin I.V.A.</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.sinIVA') }}" 
               name="sinIVA" placeholder="Ingrese monto de inversión sin I.V.A.">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="conIVA">Monto de inversión con I.V.A.</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.conIVA') }}" 
               name="conIVA" placeholder="Ingrese monto de inversión con I.V.A.">
      </div>
    </div>
    <div class="agrega">
      <a id="origenes" href="#" class="agregaItem">
        <i class="fa fa- fa-plus-square"></i><label>Agregar origen</label>
      </a>
    </div>
    <div class="form-group">
      <table id="tabla-origenes" class="table table-striped table-bordered">
      <thead>
      <tr>
          <th>Origen de los recursos (Especificar partidas asignadas o por asignar)</th>
          <th>%</th>
          <th>Monto (incluye I.V.A.)</th>
          <th></th>
      </tr>
      </thead>
      <tbody>
        @php ($i=0)
        
        @if(!\Session::has('fase.'.\Session::get('faseActual').'.origenes'))
          <tr>
            <td>
                <input class="form-control" type="text" 
                       name="origenes[{{$i}}][origen]" placeholder="ingrese beneficio">
            </td>
            <td>
              <input class="form-control" type="text" 
                     name="origenes[{{$i}}][porcentaje]" placeholder="ingrese descripción">
            </td>
            <td>
              <input class="form-control" type="text" 
                     name="origenes[{{$i}}][montoConIVA]" placeholder="ingrese valoración">
            </td>
            <td align="center">
            </td>
        </tr>
        @else 
          @foreach(\Session::get('fase.'.\Session::get('faseActual').'.origenes') as $origen)
            <tr>
              <td>
                  <input class="form-control" value="{{ $origen['origen'] }}" type="text" 
                         name="origenes[{{$i}}][origen]" placeholder="ingrese origen de los recursos">
              </td>
              <td>
                <input class="form-control" value="{{ $origen['porcentaje'] }}" type="text" 
                       name="origenes[{{$i}}][porcentaje]" placeholder="ingrese porcentaje">
              </td>
              <td>
                <input class="form-control" value="{{ $origen['montoConIVA'] }}" type="text" 
                       name="origenes[{{$i}}][montoConIVA]" placeholder="ingrese monto">
              </td>
              <td align="center">
                @if($i>0)
                  <button type="button" class="btn btn-danger btn-delItem">
                    <span class="glyphicon glyphicon-trash"></span>
                  </button>
                @endif
              </td>
            </tr>
            @php ($i++)
          @endforeach
        @endif
        
      </tbody>
      </table>
    </div>
    <hr>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="he"><strong>Horizonte de evaluación</strong></label>
      </div>      
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="horizonteEvaluacion">Fecha de inicio de ejecución</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.horizonteEvaluacion.fechaInicio') }}" 
               name="horizonteEvaluacion[fechaInicio]" placeholder="Ingrese fecha de inicio de ejecución">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="horizonteEvaluacion">Fecha de término de ejecución</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.horizonteEvaluacion.fechaFin') }}" 
               name="horizonteEvaluacion[fechaFin]" placeholder="Ingrese fecha de fin de ejecución">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="horizonteEvaluacion">Tiempo de operación (en  meses o años - para proyectos multianuales)</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.horizonteEvaluacion.tiempoOperacion') }}" 
               name="horizonteEvaluacion[tiempoOperacion]" placeholder="Ingrese tiempo de operación">
      </div>
    </div>
    <hr>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="cp"><strong>Calendario de pagos</strong></label>
      </div>      
    </div>
    <div class="agrega">
      <a id="calendario" href="#" class="agregaItem">
        <i class="fa fa- fa-plus-square"></i><label>Agregar a calendario</label>
      </a>
    </div>
    <div class="form-group">
      <table style="margin-bottom: 0px;" id="tabla-calendario" class="table table-striped table-bordered">
      <thead>
      <tr>
          <th>Horizonte de tiempo (en meses o años - especificar de acuerdo al horizonte de tiempo)</th>
          <th>Monto (incluye I.V.A.)</th>
          <th></th>
      </tr>
      </thead>
      <tbody>
        @php ($i=0)
        @php ($sum = 0)

        @if(!\Session::has('fase.'.\Session::get('faseActual').'.pagos'))
          <tr>
            <td>
                <input class="form-control" type="text" 
                       name="pagos[{{$i}}][horizonte]" placeholder="ingrese horizonte de tiempo">
            </td>
            <td>
              <input class="form-control calendario-total" type="text" 
                     name="pagos[{{$i}}][montoConIVA]" placeholder="ingrese monto">
            </td>
            <td align="center">
            </td>
        </tr>
        @else 
          @foreach(\Session::get('fase.'.\Session::get('faseActual').'.pagos') as $pago)
            <tr>
              <td>
                  <input class="form-control" value="{{ $pago['horizonte'] }}" type="text" 
                         name="pagos[{{$i}}][horizonte]" placeholder="ingrese horizonte de tiempo">
              </td>
              <td>
                <input class="form-control calendario-total" value="{{ $pago['montoConIVA'] }}" type="text" 
                       name="pagos[{{$i}}][montoConIVA]" placeholder="ingrese monto">
                 @php ($sum += $pago['montoConIVA'] )
              </td>
              <td align="center">
                @if($i>0)
                  <button type="button" class="btn btn-danger btn-delItem">
                    <span class="glyphicon glyphicon-trash"></span>
                  </button>
                @endif
              </td>
              </tr>
            @php ($i++)
          @endforeach
        @endif
      </tbody>
      </table>
      <table style="" class="table table-striped table-bordered">
      <tbody>
        <tr>
          <td style="padding-right: 15%;" align="right">
            <strong>Total:</strong> $<span id="calendario-total">{{ number_format($sum,'2','.',',') }}</span>
          </td>
        </tr>
      <tbody>
      </table>
    </div>

    <div class="form-group">
        <div class="col-lg-9">
            <input id="envio" type="submit" value="Guardar">
        </div>
    </div>
</form>
