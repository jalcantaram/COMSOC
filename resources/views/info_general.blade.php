@extends('pdf.master')

@section('titulo','CDMX | Dictaminación')

@section('head')
    
    
@endsection

@section('container')  
	
    <body>
    	
    
        <h4 align="left">{{\Session::get('curp')}}</h4>
		<h4 align="left">{{\Session::get('nombres')}} {{\Session::get('paterno')}} {{\Session::get('materno')}}</h4>
		<h4 align="left">Fecha de tramite: {{\Session::get('sessionStart')}} </h4>
    
    
    	<?php $cont=1; ?>	
		@foreach($definiciones as $definicion=>$datos)
    		<h3 align="center">{{$cont}}. {{ $datos['name']  }}</h3>
    		<table style="width:100%" align="center">
    		@foreach($datos['data'] as $dato=>$definicionDato)
	    			
    			@if(isset($definicionDato['encabezado']) && $definicionDato['tipo']!='container') 
    			
    				<tr ><td bgcolor="#eeeeee" colspan="2" align="center">{{ $definicionDato['encabezado'] }}</td></tr>
    				
    			<br/>
				@endif
    			@if(isset($definicionDato['nombre']))
    			
    				<tr>
    					<td bgcolor="#eeeeee"><b>{{ $definicionDato['nombre']}}</b></td>
    					<td>{{ \Session::get('fase.'.$definicion.'.'.$dato) }} </td>
    				</tr>
    				
    			@endif
			
				@if($definicionDato['tipo']=='container'  && $definicionDato['unico']=='true' && isset($definicionDato['encabezado']) && !isset($definicionDato['tabla']))
					<br>
					<table style="width:100%" align="center">
						<tr><td  bgcolor="#eeeeee" colspan="2" align="center">{{$definicionDato['encabezado']}}</td></tr>

						@foreach($definicionDato['detalle'] as $detalle=>$det)
							<tr>
								<td bgcolor="#eeeeee">{{$det['nombre']}}</td>
								<td>{{\Session::get('fase.'.$definicion.'.'.$dato.'.'.$detalle)}}</td>
							</tr>
						@endforeach

					</table>
					<br>
				@endif

				@if($definicionDato['tipo']=='container'  && $definicionDato['unico']!='true' && isset($definicionDato['th']) && isset($definicionDato['encabezado']) && !isset($definicionDato['tabla']))
					<br>
					<table style="width:100%" align="center">
						<tr><td bgcolor="#eeeeee" colspan="{{count($definicionDato['th'])}}" align="center">{{$definicionDato['encabezado']}}</td></tr>
					
						<tr>
						@foreach($definicionDato['th'] as $th)
							<td bgcolor="#eeeeee">{{$th}}</td>
						@endforeach
						</tr>

						@foreach(\Session::get('fase.'.$definicion.'.'.$dato) as $x)
							<tr>	
							@foreach($x as $detalle=>$valor)
								<td>{{$valor}}</td>
								
		    				@endforeach
		    				</tr>	
		    			@endforeach

					</table>
					<br>
				@endif

				@if($definicionDato['tipo']=='container'  && $definicionDato['unico']!='true' && isset($definicionDato['th']) && !isset($definicionDato['encabezado']) && !isset($definicionDato['tabla']))
					<br>
					<table style="width:100%" align="center">
						<tr>
						@foreach($definicionDato['th'] as $th)
							<td bgcolor="#eeeeee" align="center">{{$th}}</td>
						@endforeach
						</tr>
						@foreach(\Session::get('fase.'.$definicion.'.'.$dato) as $x)
							<tr>	
							@foreach($x as $detalle=>$valor)
								<td>{{$valor}}</td>
								
		    				@endforeach
		    				</tr>	
		    			@endforeach

					</table>
					<br>
				@endif

				@if($definicionDato['tipo']=='container'  && $definicionDato['unico']=='true' && isset($definicionDato['th']) && isset($definicionDato['encabezado']) && isset($definicionDato['tabla']))
					<br>
					<table style="width:100%" align="center">
						<tr>
		    			@foreach($definicionDato['th'] as $th)
							<td align="center" bgcolor="#eeeeee">{{$th}}</td>
		    			@endforeach
		    			</tr>
		    			@foreach($definicionDato['filas'] as $filas=>$contfila)
							
								<?php $x=\Session::get('fase.'.$definicion.'.'.$dato.'.'.$filas); ?>
								
								<tr>
									<td bgcolor="#eeeeee">{{$contfila}}</td>
									<td>{{$x['estimado']}}</td>
									<td>{{$x['especifique']}}</td>
								</tr>  		
			    				 
															
		    			@endforeach
		    		</table>
		    		<br>
				@endif
				
    	@endforeach
		</table>
		<br>
		<br>
		<hr/>

		<?php $cont=$cont+1;?>
	@endforeach
	</body>
@endsection

