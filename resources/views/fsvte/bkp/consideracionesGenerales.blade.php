<h2>{{ $sidebar[Session::get('faseActual')]['nombre'] }}</h2>
<form class="form-horizontal" id="form" accept-charset="UTF-8" method="post" action="{{ url('/noexiste')}}" role="form">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
      <div class="col-lg-8">
        <label for="comentarios">Comentarios</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.comentarios') }}" 
               name="comentarios" placeholder="Ingrese comentarios">
      </div>
    </div>
    <hr>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="mi"><strong>Responsable de la inforación</strong></label>
      </div>      
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="responsableInformacion.nombre">Nombre</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.responsableInformacion.nombre') }}" 
               name="responsableInformacion[nombre]" placeholder="Ingrese nombre del responsable">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="responsableInformacion.cargo">Cargo</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.responsableInformacion.cargo') }}" 
               name="responsableInformacion[cargo]" placeholder="Ingrese cargo">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="responsableInformacion.unidad">Unidad</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.responsableInformacion.unidad') }}" 
               name="responsableInformacion[unidad]" placeholder="Ingrese unidad">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="responsableInformacion.telefonoFijo">Teléfono fijo</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.responsableInformacion.telefonoFijo') }}" 
               name="responsableInformacion[telefonoFijo]" placeholder="Ingrese teléfono fijo">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="responsableInformacion.telefonoMovil">Teléfono móvil</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.responsableInformacion.telefonoMovil') }}" 
               name="responsableInformacion[telefonoMovil]" placeholder="Ingrese teléfono móvil">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="responsableInformacion.correoInstitucional">Correo Institucional</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.responsableInformacion.correoInstitucional') }}" 
               name="responsableInformacion[correoInstitucional]" placeholder="Ingrese correo institucional">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="responsableInformacion.version">Versión</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.responsableInformacion.version') }}" 
               name="responsableInformacion[version]" placeholder="Ingrese versión">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="responsableInformacion[fecha]">Fecha</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.responsableInformacion.fecha') }}" 
               name="responsableInformacion[fecha]" placeholder="Ingrese fecha">
      </div>
    </div>
    
    <div class="form-group">
        <div class="col-lg-9">
            <input id="envio" type="submit" value="Guardar">
        </div>
    </div>
</form>
