<h2>{{ $sidebar[Session::get('faseActual')]['nombre'] }}</h2>
<form class="form-horizontal" id="form" accept-charset="UTF-8" method="post" action="{{ url('/newItem')}}" role="form">
    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
    <div class="agrega">
    	<a id="alternativas" href="#" class="agregaItem">
    		<i class="fa fa- fa-plus-square"></i><label>Agregar alternativa de solución</label>
    	</a>
    </div>
    <div class="form-group">
	    <table id="tabla-alternativas" class="table table-striped table-bordered">
	    <thead>
	    <tr>
	        <th>Descripción de las alternativas de solución desechadas</th>
	        <th>Costo total (incluye I.V.A.)</th>
	        <th></th>
	    </tr>
	    </thead>
	    <tbody>
	      @php ($i=0)
	      
	      @if(!\Session::has('fase.'.\Session::get('faseActual').'.alternativas'))
	      	<tr>
		        <td>
		            <input class="form-control" type="text" 
		                   name="alternativas[{{$i}}][descripcion]" placeholder="ingrese descripción">
		        </td>
		        <td>
		        	<input class="form-control" type="text" 
		        	       name="alternativas[{{$i}}][costoTotalConIVA]" placeholder="ingrese costo total (incluye I.V.A.)">
		        </td>
		        <td align="center">
		        </td>
		    </tr>
	      @else	
		      @foreach(\Session::get('fase.'.\Session::get('faseActual').'.alternativas') as $alternativa)
			    <tr>
			        <td>
			            <input class="form-control" value="{{ $alternativa['descripcion'] }}" type="text" 
			                   name="alternativas[{{$i}}][descripcion]" placeholder="ingrese descripción">
			        </td>
			        <td>
			        	<input class="form-control" value="{{ $alternativa['costoTotalConIVA'] }}" type="text" 
			        	       name="alternativas[{{$i}}][costoTotalConIVA]" placeholder="ingrese costo total (incluye I.V.A.)">
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
        <label for="justificacion">Justificación de la alternativa de solución seleccionada</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.justificacion') }}" 
               name="justificacion" placeholder="Ingrese justificación de la alternativa de solución">
      </div>
    </div>
    <div class="form-group">
        <div class="col-lg-9">
            <input id="envio" type="submit" value="Guardar">
        </div>
    </div>

</form>