<h2>{{ $sidebar[Session::get('faseActual')]['nombre'] }}</h2>
<form class="form-horizontal" id="form" accept-charset="UTF-8" method="post" action="{{ url('/noexiste')}}" role="form">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @foreach($definicion as $key=>$item)
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
    @endforeach
    <div class="form-group">
        <div class="col-lg-9">
            <input id="envio" type="submit" value="Guardar">
        </div>
    </div>

</form>