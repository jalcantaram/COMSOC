@extends('templates.master')
@section('titulo','CDMX | Contratos Abiertos')

@section('head')
    <link rel="stylesheet" href="{!! asset('assets/css/font-awesome/css/font-awesome.min.css') !!}">
@endsection

@section('nav')
	<li><a class="navButton" href="{{ url('/') }}">Cerrar sesión</a></li>
@endsection

@section('nav2')
    @include('templates.nav2',['nav2'=> [ ['nombre'=>'menu1','activo'=>'active'],
                                          ['nombre'=>'menu2'],
                                          ['nombre'=>'menu3']
                                        ]
                              ]
            )
@endsection

@section('container')  
    <!--div class="divGeneral">
    hola
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    </div-->
    <div class="divIzquierdo">
        <div class="sidebar">
            <div class="titulo">Título</div>
            <div class="elementos">
                <ul>
                    @for($i = 0; $i < 3; $i++)
                    <li><div><i class="fa fa-check check"></i>Opción {{ $i }}</div></li>
                    @endfor
                    @for($i = 0; $i < 2; $i++)
                    <li><div><i class="fa fa-close cross"></i>Opción {{ $i }}</div></li>
                    @endfor
                    
                </ul>
            </div>
        </div>
    </div>
    <div class="divDerecho">
        derecha
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    </div>
@endsection

@section('js')
    <script src="{!! asset('assets/js/jquery.lockfixed.js') !!}"></script>
@endsection

@section('customjs')
	<script type="text/javascript">
        $(document).ready(function(){
            $.lockfixed(".sidebar",{offset: {top: 100, bottom: 65}});
        });
    </script>
@endsection