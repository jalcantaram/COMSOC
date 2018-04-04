@extends('templates.master')


@section('container')
	<style>
		body{
			background-color: white !important;
		}

		.jumbotron{
			width: 70%;
			background-color: white;
		}

		.jumbotron > .container > p > a{
			background-color: #FF149B;
			border: none;
		}

		.jumbotron > .container > p > a:active{
			background-color: #FF149B;	
		}
	</style>
	<div class="jumbotron">
      <div class="container">
        <p>Error 404</p>
        <h1>La página que solicitaste no fué encontrada en este sitio.</h1>
        <p><a class="btn btn-primary btn-lg" href="{{ url('/login') }}" role="button">Regresar</a></p>
      </div>
    </div>
@endsection