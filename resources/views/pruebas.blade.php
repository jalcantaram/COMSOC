				@if(isset($definicionDato['tipo']) && isset($definicionDato['th']))
		    		@if(!isset($definicionDato['filas']))	
		    			<table style="width:50%" align="center">
		    			@foreach($definicionDato['th'] as $th)
							<th bgcolor="#eeeeee">{{$th}}</th>
		    			@endforeach
		    			@foreach(\Session::get('fase.'.$definicion.'.'.$dato) as $x)
							<tr>	
							@foreach($x as $detalle=>$valor)
								<td>{{$valor}}</td>
								
		    				@endforeach
		    				</tr>	
		    			@endforeach
		    			</table>
		    			<br>
		    			<br>
		    		@else
		    			<table style="width:50%" align="center">
		    			@foreach($definicionDato['th'] as $th)
							<th>{{$th}}</th>
		    			@endforeach
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
		    			<br>
		    		@endif	
    			@endif

    			@if(isset($definicionDato['tipo']) && isset($definicionDato['unico']) && $definicionDato['unico']=='true' && !isset($definicionDato['tabla']))
    				<table style="width:50%" align="center">
    				@if(isset($definicionDato['encabezado']))
    					<th bgcolor="#eeeeee" colspan="2"><b>{{ $definicionDato['encabezado'] }}</b></th>
    				
					@endif
					@foreach($definicionDato['detalle'] as $def=>$valor )
						<tr>
	    					<td><b>{{ $valor['nombre']}}</b></td>
	    					<td>{{\Session::get('fase.'.$definicion.'.'.$dato.'.'.$def)}}</td>
	    				</tr>
											
					@endforeach
					</table>
    			@endif

<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

@extends('pdf.master')
@section('titulo','CDMX | Dictaminación')

@section('head')
    <link rel="stylesheet" href="{!! asset('assets/css/font-awesome/css/font-awesome.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/css/bootstrap/dataTables.bootstrap.min.css') !!}">
@endsection

@section('container')  
	<div class="container col-lg-8" align="center">
     	
        <h4 align="left">{{\Session::get('curp')}}</h3>
		<h4 align="left">{{\Session::get('nombres')}} {{\Session::get('paterno')}} {{\Session::get('materno')}}</h3>
		<h5 align="left">Fecha de tramite: {{\Session::get('sessionStart')}} </h4>

    </div>
    
    
    		
		@foreach($definiciones as $definicion=>$datos)
    		<h3>{{ $datos['name']  }}</h3>
    		<table style="width:50%" align="center">
    		@foreach($datos['data'] as $dato=>$definicionDato)
	    		
    			@if(isset($definicionDato['encabezado']) && $definicionDato['tipo']!='container') 
    				<th bgcolor="#eeeeee" colspan="2"><b>{{ $definicionDato['encabezado'] }}</b></th>
    				
				@endif
    			@if(isset($definicionDato['nombre']))
    				<tr>
    					<td bgcolor="#eeeeee"><b>{{ $definicionDato['nombre']}}</b></td>
    					<td>{{\Session::get('fase.'.$definicion.'.'.$dato)}}</td>
    				</tr>
    				
    			@endif



    			@if(isset($definicionDato['tipo']) && isset($definicionDato['unico']) && $definicionDato['unico']=='true' && !isset($definicionDato['tabla']))
    				<table style="width:50%" align="center">
    				@if(isset($definicionDato['encabezado']))
    					<th bgcolor="#eeeeee" colspan="2"><b>{{ $definicionDato['encabezado'] }}</b></th>
    				
					@endif
					@foreach($definicionDato['detalle'] as $def=>$valor )
						<tr>
	    					<td bgcolor="#eeeeee"><b>{{ $valor['nombre']}}</b></td>
	    					<td>{{\Session::get('fase.'.$definicion.'.'.$dato.'.'.$def)}}</td>
	    				</tr>
											
					@endforeach
					</table>
    			@endif


    			@if(isset($definicionDato['tipo']) && isset($definicionDato['th']))
		    		@if(!isset($definicionDato['filas']))	
		    			<table style="width:50%" align="center">
		    			@foreach($definicionDato['th'] as $th)
							<th bgcolor="#eeeeee">{{$th}}</th>
		    			@endforeach
		    			@foreach(\Session::get('fase.'.$definicion.'.'.$dato) as $x)
							<tr>	
							@foreach($x as $detalle=>$valor)
								<td>{{$valor}}</td>
								
		    				@endforeach
		    				</tr>	
		    			@endforeach
		    			</table>
		    			<br>
		    			<br>
		    		
		    		@endif	
    			@endif


			
    		@endforeach
    		</table>
    		<br>
    		<br>
    		<hr/>
		@endforeach
    	
    
	
@endsection

