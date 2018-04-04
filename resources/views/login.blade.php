@extends('templates.master')
@section('titulo','CDMX | Sistema de Dictaminación')

@section('nav')
	<li class="active"><a href="{{ url('/') }}">Iniciar sesión</a></li>
	<!--li><a class="navButton" href="{{ url('/') }}">Registrar</a></li-->
@stop

@section('container')
	<div class="jumbotron fondoBlanco">
        <h1>Iniciar sesión</h1>
        <form method="post" action="{{ url('/login') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="formLogin">
                <label>Correo electrónico</label>
                <input name="login" type="text" placeholder="Ingrese su correo electrónico">
                <label>Contraseña</label>
                <input name="pass" type="password" placeholder="Ingrese su contraseña">
                <a href="#">¿Olvidó su contraseña?</a>
                <input type="submit" value="Iniciar sesión">
                <label class="registro">¿Aún no tienes cuenta? <a href="#">Registrate</a></label>
                <label class="correo"><a href="#">No recibí mi correo de confirmación</a></label>
            </div>
        </form>
    </div>
@stop