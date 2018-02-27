<h2>{{ $sidebar[Session::get('faseActual')]['nombre'] }}</h2>
<form class="form-horizontal" id="form" accept-charset="UTF-8" method="post" action="{{ url('/newItem')}}" role="form">
    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
      <div class="col-lg-8">
        <label for="descripcionGeneral">Descripción general del proyecto</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.descripcionGeneral') }}" 
               name="descripcionGeneral" placeholder="Ingrese descripcion general">
      </div>
    </div>
    <div class="agrega">
    	<a id="componentes" href="#" class="agregaItem">
    		<i class="fa fa- fa-plus-square"></i><label>Agregar componentes del proyecto</label>
    	</a>
    </div>
    <div class="form-group">
	    <table id="tabla-componentes" class="table table-striped table-bordered">
	    <thead>
	    <tr>
	        <th>Componente</th>
	        <th>Descripción</th>
	        <th>Costo unitario (con I.V.A.)</th>
	        <th>Cantidad</th>
	        <th>Monto total (incluye I.V.A.)</th>
	        <th></th>
	    </tr>
	    </thead>
	    <tbody>
	      @php ($i=0)
	      
	      @if(!\Session::has('fase.'.\Session::get('faseActual').'.componentes'))
	      	<tr>
		        <td>
		            <input class="form-control" type="text" 
		                   name="componentes[{{$i}}][componente]" placeholder="ingrese componente">
		        </td>
		        <td>
		        	<input class="form-control" type="text" 
		        	       name="componentes[{{$i}}][descripcion]" placeholder="ingrese descripción">
		        </td>
		        <td>
		            <input class="form-control" type="text" 
		                   name="componentes[{{$i}}][costoUnitarioConIVA]" placeholder="ingrese costo unitario">
		        </td>
		        <td>
		            <input class="form-control" type="text" 
		                   name="componentes[{{$i}}][cantidad]" placeholder="ingrese cantidad">
		        </td>
		        <td>
		            <input class="form-control" type="text" 
		                   name="componentes[{{$i}}][montoTotalConIVA]" placeholder="ingrese monto total">
		        </td>
		        <td align="center">
		        </td>
		    </tr>
	      @else	
		      @foreach(\Session::get('fase.'.\Session::get('faseActual').'.componentes') as $componente)
		      	<tr>
			        <td>
			            <input class="form-control" value="{{ $componente['componente'] }}" type="text" 
			                   name="componentes[{{$i}}][componente]" placeholder="ingrese componente">
			        </td>
			        <td>
			        	<input class="form-control" value="{{ $componente['descripcion'] }}" type="text" 
			        	       name="componentes[{{$i}}][descripcion]" placeholder="ingrese descripción">
			        </td>
			        <td>
			            <input class="form-control" value="{{ $componente['costoUnitarioConIVA'] }}" type="text" 
			                   name="componentes[{{$i}}][costoUnitarioConIVA]" placeholder="ingrese costo unitario">
			        </td>
			        <td>
			            <input class="form-control" value="{{ $componente['cantidad'] }}" type="text" 
			                   name="componentes[{{$i}}][cantidad]" placeholder="ingrese cantidad">
			        </td>
			        <td>
			            <input class="form-control" value="{{ $componente['montoTotalConIVA'] }}" type="text" 
			                   name="componentes[{{$i}}][montoTotalConIVA]" placeholder="ingrese monto total">
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
      <div class="col-lg-8">
        <label for="aspectosRelevantes">Aspectos más relevantes: técnicos, ambientales y legales</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.aspectosRelevantes') }}" 
               name="aspectosRelevantes" placeholder="Ingrese aspectos relevantes">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="alcance">Alcance</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.alcance') }}" 
               name="alcance" placeholder="Ingrese alcance">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="entregables">Entregables</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.entregables') }}" 
               name="entregables" placeholder="Ingrese entregables">
      </div>
    </div>
    <div class="form-group">
        <div class="col-lg-9">
            <input id="envio" type="submit" value="Guardar">
        </div>
    </div>

</form>