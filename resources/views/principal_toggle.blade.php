@extends('templates.master')
@section('titulo','CDMX | Sistema de Dictaminación')

@section('head')
	<link rel="stylesheet" href="{!! asset('assets/css/bootstrap/simple-sidebar.bootstrap.css') !!}">
@stop

@section('nav')
	<li><a class="navButton" href="{{ url('/') }}">Cerrar sesión</a></li>
@stop

@section('sidebar')
	<div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <a href="#">
                    Start Bootstrap
                </a>
            </li>
            <li>
                <a href="#">Dashboard</a>
            </li>
            <li>
                <a href="#">Shortcuts</a>
            </li>
            <li>
                <a href="#">Overview</a>
            </li>
            <li>
                <a href="#">Events</a>
            </li>
            <li>
                <a href="#">About</a>
            </li>
            <li>
                <a href="#">Services</a>
            </li>
            <li>
                <a href="#">Contact</a>
            </li>
            
        </ul>
    </div>
@stop 

@section('container')
	
	<a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>

@stop

@section('customjs')
	<script>
	    $("#menu-toggle").click(function(e) {
	        e.preventDefault();
	        $("#wrapper").toggleClass("toggled");
	    });
   	</script>
@stop