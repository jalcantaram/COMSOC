@extends('templates.master')
@section('titulo','CDMX | Sistema de CGCS')

@section('head')
    <link rel="stylesheet" href="{!! asset('assets/css/font-awesome/css/font-awesome.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/css/bootstrap/dataTables.bootstrap.min.css') !!}">
@endsection

@section('nav2')
   @include('templates.nav2',['nav2'=> [ ['nombre'=>'Nueva Ficha','activo'=>'active']
                                        ]
                              ]
            )
@endsection

@section('container')  
 <div class="jumbotron fondoBlanco">
    <h2><strong>¡Bienvenido!</strong></h2>
    <h3>Comience su pre-registro</h3>
    <h5>Seleccione una de las opciones </h5>
      <form method="post" action="{{ url('/login') }}">
        <div class="formLogin">
          <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
          <input type="radio" name="rp" value="{{ url('/persona_fisica/registro')}}" required="required" id="pf">
          </div>
          <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
          <div class="parrafo2"><span id="radp">Persona física</span></div><br></div>
          <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
            <input type="radio" name="rp" value="{{ url('/persona_moral/registro')}}" required="required" id="pm">
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
             <div class="parrafo2"><span id="radm">Persona moral</span></div><br></div>
           
              {!! Form::submit('Comenzar', ['class' => "btn waves-effect waves-light col s12", 'id'=>'comenzar'] ) !!}             
          </div>
        
        </div>
    </form>
  </div>
    
@endsection

@section('js')
    
@endsection

@section('customjs')
  
@endsection