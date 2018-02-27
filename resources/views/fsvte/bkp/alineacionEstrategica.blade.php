<h2>{{ $sidebar[Session::get('faseActual')]['nombre'] }}</h2>
<form class="form-horizontal" id="form" accept-charset="UTF-8" method="post" action="{{ url('/newItem')}}" role="form">
    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
      <div class="col-lg-8">
        <label for="eje">Eje</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.eje') }}" 
               name="eje" placeholder="Ingrese eje">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="areaOportunidad">Área Oportunidad</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.areaOportunidad') }}" 
               name="areaOportunidad" placeholder="Ingrese área de oportunidad">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="objetivo">Objetivo</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.objetivo') }}" 
               name="objetivo" placeholder="Ingrese objetivo">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="lineaAccion">Linea de acción</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.lineaAccion') }}" 
               name="lineaAccion" placeholder="Ingrese linea de acción">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="proyectoEstrategico">Proyecto Estratégico</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.proyectoEstrategico') }}" 
               name="proyectoEstrategico" placeholder="Ingrese proyecto estratégico">
      </div>
    </div>
    <hr>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="programas"><strong>Programas ó proyectos complementarios relacionados</strong></label>
      </div>      
    </div>
    <div class="agrega">
    	<a id="programa-proyecto" href="#" class="agregaItem">
    		<i class="fa fa- fa-plus-square"></i><label>Agregar programa/proyecto</label>
    	</a>
    </div>
    <div class="form-group">
	    <table id="tabla-programa-proyecto" class="table table-striped table-bordered">
	    <thead>
	    <tr>
	        <th>Programa/Proyecto</th>
	        <th>Relación</th>
	        <th></th>
	    </tr>
	    </thead>
	    <tbody>
	      @php ($i=0)
	      
	      @if(!\Session::has('fase.'.\Session::get('faseActual').'.programas'))
	      	<tr>
		        <td>
		            <input class="form-control" type="text" 
		                   name="programas[{{$i}}][programa]" placeholder="ingrese programa/proyecto">
		        </td>
		        <td>
		        	<input class="form-control" type="text" 
		        	       name="programas[{{$i}}][relacion]" placeholder="ingrese relación">
		        </td>
		        <td align="center">
		        </td>
		    </tr>
	      @else	
		      @foreach(\Session::get('fase.'.\Session::get('faseActual').'.programas') as $programa)
			    <tr>
			        <td>
			            <input class="form-control" value="{{ $programa['programa'] }}" type="text" 
			                   name="programas[{{$i}}][programa]" placeholder="ingrese programa/proyecto">
			        </td>
			        <td>
			        	<input class="form-control" value="{{ $programa['relacion'] }}" type="text" 
			        	       name="programas[{{$i}}][relacion]" placeholder="ingrese relación">
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
    <div class="form-group">
        <div class="col-lg-9">
            <input id="envio" type="submit" value="Guardar">
        </div>
    </div>

</form>