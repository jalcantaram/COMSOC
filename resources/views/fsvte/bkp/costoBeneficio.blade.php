<h2>{{ $sidebar[Session::get('faseActual')]['nombre'] }}</h2>
<form class="form-horizontal" id="form" accept-charset="UTF-8" method="post" action="{{ url('/newItem')}}" role="form">
    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
      <div class="col-lg-8">
        <label for="mi"><strong>Identificación de costos</strong></label>
      </div>      
    </div>
    <div class="agrega">
    	<a id="costos" href="#" class="agregaItem">
    		<i class="fa fa- fa-plus-square"></i><label>Agregar costo</label>
    	</a>
    </div>
    <div class="form-group">
	    <table id="tabla-costos" class="table table-striped table-bordered">
	    <thead>
	    <tr>
	        <th>Tipo de costo: inversión, operación o mantenimiento</th>
	        <th>Descripción y Temporalidad</th>
	        <th>Cuantificación</th>
	        <th>Periodicidad</th>
	        <th></th>
	    </tr>
	    </thead>
	    <tbody>
	      @php ($i=0)
	      
	      @if(!\Session::has('fase.'.\Session::get('faseActual').'.costos'))
	      	<tr>
		        <td>
		            <input class="form-control" type="text" 
		                   name="costos[{{$i}}][tipoCosto]" placeholder="ingrese tipo de costo">
		        </td>
		        <td>
		        	<input class="form-control" type="text" 
		        	       name="costos[{{$i}}][descripcionTemporalidad]" placeholder="ingrese descripción y temporalidad">
		        </td>
		        <td>
		        	<input class="form-control" type="text" 
		        	       name="costos[{{$i}}][cuantificacion]" placeholder="ingrese cuantificación">
		        </td>
		        <td>
		        	<input class="form-control" type="text" 
		        	       name="costos[{{$i}}][periodicidad]" placeholder="ingrese periodicidad">
		        </td>
		        <td align="center">
		        </td>
		    </tr>
	      @else	
		      @foreach(\Session::get('fase.'.\Session::get('faseActual').'.costos') as $costo)
		      	<tr>
			        <td>
			            <input class="form-control" value="{{ $costo['tipoCosto'] }}" type="text" 
			                   name="costos[{{$i}}][tipoCosto]" placeholder="ingrese tipo de costo">
			        </td>
			        <td>
			        	<input class="form-control" value="{{ $costo['descripcionTemporalidad'] }}" type="text" 
			        	       name="costos[{{$i}}][descripcionTemporalidad]" placeholder="ingrese descripción y temporalidad">
			        </td>
			        <td>
			        	<input class="form-control" value="{{ $costo['cuantificacion'] }}" type="text" 
			        	       name="costos[{{$i}}][cuantificacion]" placeholder="ingrese cuantificación">
			        </td>
			        <td>
			        	<input class="form-control" value="{{ $costo['periodicidad'] }}" type="text" 
			        	       name="costos[{{$i}}][periodicidad]" placeholder="ingrese periodicidad">
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
        <label for="mi"><strong>Identificación de beneficios</strong></label>
      </div>      
    </div>
	<div class="agrega">
    	<a id="beneficios" href="#" class="agregaItem">
    		<i class="fa fa- fa-plus-square"></i><label>Agregar beneficio</label>
    	</a>
    </div>
	<div class="form-group">
	    <table id="tabla-beneficios" class="table table-striped table-bordered">
	    <thead>
	    <tr>
	        <th>Beneficio</th>
	        <th>Descripción</th>
	        <th>Valoración</th>
	        <th>Periodicidad</th>
	        <th></th>
	    </tr>
	    </thead>
	    <tbody>
	      @php ($i=0)
	      
	      @if(!\Session::has('fase.'.\Session::get('faseActual').'.beneficios'))
	      	<tr>
		        <td>
		            <input class="form-control" type="text" 
		                   name="beneficios[{{$i}}][beneficio]" placeholder="ingrese beneficio">
		        </td>
		        <td>
		        	<input class="form-control" type="text" 
		        	       name="beneficios[{{$i}}][descripcion]" placeholder="ingrese descripción">
		        </td>
		        <td>
		        	<input class="form-control" type="text" 
		        	       name="beneficios[{{$i}}][valoracion]" placeholder="ingrese valoración">
		        </td>
		        <td>
		        	<input class="form-control" type="text" 
		        	       name="beneficios[{{$i}}][periodicidad]" placeholder="ingrese periodicidad">
		        </td>
		        <td align="center">
		        </td>
		    </tr>
	      @else	
		      @foreach(\Session::get('fase.'.\Session::get('faseActual').'.beneficios') as $beneficio)
		      	<tr>
			        <td>
			            <input class="form-control" value="{{ $beneficio['beneficio'] }}" type="text" 
			                   name="beneficios[{{$i}}][beneficio]" placeholder="ingrese beneficio">
			        </td>
			        <td>
			        	<input class="form-control" value="{{ $beneficio['descripcion'] }}" type="text" 
			        	       name="beneficios[{{$i}}][descripcion]" placeholder="ingrese descripción">
			        </td>
			        <td>
			        	<input class="form-control" value="{{ $beneficio['valoracion'] }}" type="text" 
			        	       name="beneficios[{{$i}}][valoracion]" placeholder="ingrese valoración">
			        </td>
			        <td>
			        	<input class="form-control" value="{{ $beneficio['periodicidad'] }}" type="text" 
			        	       name="beneficios[{{$i}}][periodicidad]" placeholder="ingrese periodicidad">
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
        <label for="mi"><strong>Impacto hacia</strong></label>
      </div>      
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="ciudadania">La ciudadanía</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.impactoHacia.ciudadania') }}" 
               name="impactoHacia[ciudadania]" placeholder="Ingrese impacto hacia la ciudadanía">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="solicitante">El solicitante</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.impactoHacia.solicitante') }}" 
               name="impactoHacia[solicitante]" placeholder="Ingrese impacto hacia el solicitante">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-8">
        <label for="otrasDependencias">Otras dependencias, órganos desconcentrados, delegaciones o entidades</label>
      </div>
      <div class="col-lg-6">
        <input class="form-control" type="text" 
               value="{{ \Session::get('fase.'.\Session::get('faseActual').'.impactoHacia.otrasDependencias') }}" 
               name="impactoHacia[otrasDependencias]" placeholder="Ingrese impacto hacia otras dependencias, órganos desconcentrados, delegaciones o entidades">
      </div>
    </div>
    <hr>
	<div class="form-group">
      <div class="col-lg-8">
        <label for="mi"><strong>Estimados</strong></label>
      </div>      
    </div>
    <div class="form-group">
	    <table class="table table-striped table-bordered">
	    <thead>
	    <tr>
	        <th>Beneficiados</th>
	        <th>Estimado</th>
	        <th>Especifique como se obtuvo la cifra</th>
	    </tr>
	    </thead>
	    <tbody>
	      	<tr>
		        <td>
		            Ciudadanos
		        </td>
		        <td>
		        	<input class="form-control" type="text" 
		        		   value="{{ \Session::get('fase.'.\Session::get('faseActual').'.estimadoBeneficios.ciudadanos.estimado') }}"
		        	       name="estimadoBeneficios[ciudadanos][estimado]" placeholder="ingrese estimado">
		        </td>
		        <td>
		        	<input class="form-control" type="text"
		        		   value="{{ \Session::get('fase.'.\Session::get('faseActual').'.estimadoBeneficios.ciudadanos.especifique') }}" 
		        	       name="estimadoBeneficios[ciudadanos][especifique]" placeholder="ingrese especifique">
		        </td>
		    </tr>
		    <tr>
		        <td>
		            Servidores públicos
		        </td>
		        <td>
		        	<input class="form-control" type="text" 
		        	       value="{{ \Session::get('fase.'.\Session::get('faseActual').'.estimadoBeneficios.servidoresPublicos.estimado') }}"
		        	       name="estimadoBeneficios[servidoresPublicos][estimado]" placeholder="ingrese estimado">
		        </td>
		        <td>
		        	<input class="form-control" type="text" 
		        	       value="{{ \Session::get('fase.'.\Session::get('faseActual').'.estimadoBeneficios.servidoresPublicos.especifique') }}"
		        	       name="estimadoBeneficios[servidoresPublicos][especifique]" placeholder="ingrese especifique">
		        </td>
		    </tr>
		    <tr>
		        <td>
		            Otras dependencias, órganos desconcentrados, delegaciones ó entidades
		        </td>
		        <td>
		        	<input class="form-control" type="text" 
		        	       value="{{ \Session::get('fase.'.\Session::get('faseActual').'.estimadoBeneficios.otrasDependencias.estimado') }}"
		        	       name="estimadoBeneficios[otrasDependencias][estimado]" placeholder="ingrese estimado">
		        </td>
		        <td>
		        	<input class="form-control" type="text" 
		        	       value="{{ \Session::get('fase.'.\Session::get('faseActual').'.estimadoBeneficios.otrasDependencias.especifique') }}"
		        	       name="estimadoBeneficios[otrasDependencias][especifique]" placeholder="ingrese especifique">
		        </td>
		    </tr>
	    </tbody>
		</table>
	</div>
    <div class="form-group">
        <div class="col-lg-9">
            <input id="envio" type="submit" value="Guardar">
        </div>
    </div>

</form>