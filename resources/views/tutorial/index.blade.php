@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Tutorial</h1>
@stop

@section('content')
@include('includes.mensaje')
<video width="940" height="560" controls>
    <source src="videos/evaluacion.mp4" type="video/mp4">
    Tu navegador no soporta HTML5 video.
</video>   
@stop