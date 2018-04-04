<h2>{{ $sidebar[Session::get('faseActual')]['nombre'] }}</h2>
<form class="form-horizontal" id="form" accept-charset="UTF-8" method="post" action="{{ url('/gfsvte')}}" role="form">
    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">

    @foreach($definicion as $key=>$item)
      @if(isset($item['encabezado']))
        <hr>
        <div class="form-group">
          <div class="col-lg-8">
            <label><strong>{{ $item['encabezado'] }}</strong></label>
          </div>      
        </div>
      @endif
      @if($item['tipo'] != 'container')
        @if($item['tipo'] == 'label')
          <div class="form-group">
            <div class="col-lg-8">
              <label for="{{ $key }}"><strong>Proyecto:</strong>&nbsp;&nbsp; 
                {{ Session::get('fase.'.Session::get('faseActual').'.'.$key) }}
              </label>
            </div>      
          </div>
        @else
          <div class="form-group">
            <div class="col-lg-8">
              <label for="{{ $key }}">{{ $item['nombre'] }}</label>
            </div>
            <div class="col-lg-6">
              <input class="form-control {{ $item['tipo'] }}" type="text" 
                     value="{{ \Session::get('fase.'.\Session::get('faseActual').'.'.$key) }}" 
                     name="{{ $key }}" placeholder="Ingrese {{ lcfirst($item['nombre']) }}">
            </div>
          </div>
        @endif
      @else
        @if(!$item['unico'])
          <div class="agrega">
            <a id="{{ $key }}" href="#" class="agregaItem">
              <i class="fa fa- fa-plus-square"></i><label>Agregar {{ $key }}</label>
            </a>
          </div>
          <div class="form-group">
            <table style="{{ isset($item['footer'])? "margin-bottom: 0px;": '' }}" id="tabla-{{ $key }}" class="table table-striped table-bordered">
            <thead>
            <tr>
              @foreach($item['th'] as $th)
                <th>{{ $th }}</th>
              @endforeach
              <th></th>
            </tr>
            </thead>
            <tbody>
              @php ($i=0)

              @if(isset($item['footer']))
                @php ($sum = 0)
              @endif

              @if(!\Session::has('fase.'.\Session::get('faseActual').'.'.$key))
                <tr>
                  @foreach($item['detalle'] as $ktd => $td)
                    <td>
                        <input class="form-control" type="text" 
                               name="{{ $key }}[{{$i}}][{{ $ktd }}]" placeholder="ingrese {{ $ktd }}">
                    </td>
                  @endforeach
                  <td align="center">
                  </td>
                </tr>
              @else 
                @foreach(\Session::get('fase.'.\Session::get('faseActual').'.'.$key) as $valor)
                  <tr>
                    @foreach($item['detalle'] as $ktd => $td)
                      <td>
                        <input class="form-control {{ $td['tipo'] }} {{ (isset($item['footer']) && $ktd=='montoConIVA')?'calendario-total':'' }}" 
                               value="{{ $valor[$ktd] }}" type="text" 
                               name="{{ $key }}[{{$i}}][{{ $ktd }}]" placeholder="ingrese {{ $ktd }}">
                      </td>
                    @endforeach
                    @if(isset($item['footer']) )
                      @php ($sum += $valor['montoConIVA'] )
                    @endif
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
            @if(isset($item['footer']))
              <table style="" class="table table-striped table-bordered">
              <tbody>
                <tr>
                  <td style="padding-right: 15%;" align="right">
                    <strong>Total:</strong> $<span id="calendario-total">{{ number_format($sum,'2','.',',') }}</span>
                  </td>
                </tr>
              <tbody>
              </table>
            @endif
          </div>

        @else
          @foreach($item['detalle'] as $kdiv => $div)
          <div class="form-group">
            <div class="col-lg-8">
              <label for="{{ $key }}">{{ $div['nombre'] }}</label>
            </div>
            <div class="col-lg-6">
              <input class="form-control {{ $div['tipo'] }}" type="text" 
                     value="{{ \Session::get('fase.'.\Session::get('faseActual').'.'.$key.'.'.$kdiv) }}" 
                     name="{{ $key }}[{{ $kdiv }}]" placeholder="Ingrese {{ $div['nombre'] }}">
            </div>
          </div>
          @endforeach
        @endif
      @endif
    @endforeach
    <div class="form-group">
        <div class="col-lg-9">
            <input id="envio" type="submit" value="Guardar">
        </div>
    </div>
</form>
