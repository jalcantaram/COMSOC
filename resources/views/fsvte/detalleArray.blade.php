<h2>{{ $sidebar[Session::get('faseActual')]['nombre'] }}</h2>
<div class="agrega">
  <a href="{{ url('/addFicha') }}">
    <i class="fa fa- fa-plus-square"></i>
    <label>Agregar {{ $sidebar[Session::get('faseActual')]['addItemLabel'] }}</label>
  </a>
</div>
<table id="fichas" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <!--th>ID</th-->
            <th>Nombre del Comisionado</th>
            <th>Editar</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>
      @php( $display = explode('.',$sidebar[Session::get('faseActual')]['tableDisplay']))
      @foreach(Session::get('fase.'.Session::get('faseActual').'.comisionados') as $id=>$ficha)
        @if($sidebar[Session::get('faseActual')]['dynamicField'] !== false)
            @php($display = str_replace('_dynamic_',$ficha[$sidebar[Session::get('faseActual')]['dynamicField']],$sidebar[Session::get('faseActual')]['tableDisplay']))
            @php ($descripcion = mb_strtoupper(Session::get($display)))
        @else
          @php ($descripcion = mb_strtoupper($ficha[$display[1]]." ".$ficha[$display[2]]." ".$ficha[$display[3]]))
        @endif
        <tr>
            <td>{{ $descripcion }}</td>
            <td align="center">
              <a href="{{url('/editFicha/'.$id)}}" class="btn btn-default" role="button">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
              </a>
            </td>
            <td align="center">
              <a href="{{ url('/deleteFicha/'.$id) }}" class="btn btn-danger" role=button>
                <span class="glyphicon glyphicon-trash"></span>
              </a>
            </td>
        </tr>
      @endforeach
    </tbody>
</table>
<form class="form-horizontal" id="formFin" accept-charset="UTF-8" method="post" action="{{ url('/ffsvte')}}" role="form">
  <div class="row">
    <div class="col-md-12">
      @if(Session::get('faseActual') != 'detalleComision')
        @if(Session::get('fase.detalleComision.nombre') == 'nacional')
          @php
            $isregPerNaTit = Session::get('fase.registroPersonalNacional.observacionesTitular');
            $isregPerNaDGA = Session::get('fase.registroPersonalNacional.observacionesDGA');
          @endphp
          @if(isset($isregPerNaTit))
            <div class="form-group">
              <div class="col-md-12">
                <h4><strong>Observaciones de los Comisionados (Titular):</strong></h4>
              </div>
              <div class="col-lg-12">
                <textarea class="form-control" rows="3" name="observacionesTitular" readonly>{{ Session::get('fase.registroPersonalNacional.observacionesTitular') }}</textarea>          
              </div>
            </div>
          @endif
          @if(isset($isregPerNaDGA))
            <div class="form-group">
              <div class="col-md-12">
                <h4><strong>Observaciones de los Comisionados (DGA):</strong></h4>
              </div>
              <div class="col-lg-12">
                <textarea class="form-control" rows="3" name="observacionesDGA" readonly>{{ Session::get('fase.registroPersonalNacional.observacionesDGA') }}</textarea>          
              </div>
            </div>      
          @endif
        @else
          @php
            $isregPerInTit = Session::get('fase.registroPersonalInternacional.observacionesTitular');
            $isregPerInDGA = Session::get('fase.registroPersonalInternacional.observacionesDGA');
          @endphp
          @if(isset($isregPerInTit))
            <div class="form-group">
              <div class="col-md-12">
                <h4><strong>Observaciones del Detalle de la Comisión (Titular):</strong></h4>
              </div>
              <div class="col-lg-12">
                <textarea class="form-control" rows="3" name="observacionesTitular" readonly>{{ Session::get('fase.registroPersonalInternacional.observacionesTitular') }}</textarea>          
              </div>
            </div>
          @endif
          @if(isset($isregPerInDGA))
            <div class="form-group">
              <div class="col-md-12">
                <h4><strong>Observaciones del Detalle de la Comisión (DGA):</strong></h4>
              </div>
              <div class="col-lg-12">
                <textarea class="form-control" rows="3" name="observacionesDGA" readonly>{{ Session::get('fase.registroPersonalInternacional.observacionesDGA') }}</textarea>          
              </div>
            </div>      
          @endif
        @endif
      @endif
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
      <div class="form-group">
        <div class="col-lg-2">
          <input id="envioFin" type="submit" onClick="this.disabled=true" value="Finalizar Registro">
        </div>
      </div>      
    </div>
  </div>
</form>