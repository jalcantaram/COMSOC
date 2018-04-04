@extends('templates.master')

@section('head')
    <link rel="stylesheet" href="{!! asset('assets/css/font-awesome/css/font-awesome.min.css') !!}">
@endsection

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
        <p>Error</p>
        <h1>{{ $msg }}</h1>
        <p><a class="btn btn-primary btn-lg" href="{{ url('/principal') }}" role="button">Regresar</a></p>
      </div>
    </div>
@endsection