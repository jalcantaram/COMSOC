<h2>{{ $sidebar[Session::get('faseActual')]['nombre'] }}</h2>
<form class="form-horizontal" id="form" accept-charset="UTF-8" method="post" action="{{ url('/noexiste')}}" role="form">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
      <div class="col-lg-8">
        <label for="descripcionProblematica">Descripción de la problemática</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.descripcionProblematica') }}" 
               name="descripcionProblematica" placeholder="Ingrese descripcion de la problemática">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="requerimientos">Requerimientos</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.requerimientos') }}" 
               name="requerimientos" placeholder="Ingrese requerimientos">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="justificacion">Justificación</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.justificacion') }}" 
               name="justificacion" placeholder="Ingrese justificacion">
      </div>
    </div>

    <div class="form-group">
        <div class="col-lg-9">
            <input id="envio" type="submit" value="Guardar">
        </div>
    </div>

</form>