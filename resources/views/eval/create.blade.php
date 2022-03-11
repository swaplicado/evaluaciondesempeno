@extends('adminlte::page')

@section('title', 'Evaluación Desempeño 2021')

@section('content_header')
    <h1>Mis objetivos de negocio (QUÉ)</h1>
@stop
<style>
    textarea {
      resize: none;
    }
</style>
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{route('guardar_objetivo')}}" id="form-general" class="form-horizontal" method="POST" autocomplete="off">
            @csrf
            <input type="hidden" value="{{$id}}" name="id" id="id">
            <div class="form-group">
                <label for="name" class="form-label">Objetivo:*</label>
                <input type="text" name="name" id="name" class="form-control" required/>
            </div>
            <div class="form-group">
                <label for="description" class="form-label">Actividades*:</label>
                <textarea rows="5" cols="60" name="activities" id="activities" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="weighing" class="form-label">Ponderación:*</label>
                <input type="number" name="weighing" id="weighing" class="form-control" step="0.01" min="0" max="100" onchange="ponderacion(this.value)" required/>
            </div>
            <div class="form-group">
                <label for="unit_measurement" class="form-label">Comentarios:*</label>
                <textarea rows="5" cols="60" name="comment" id="comment" class="form-control" required></textarea>
            </div>
           
    </div>
            <div class="card-footer">
                <p><b>Ponderación al momento:</b> {{$ponderacion}}%</p>
                <input type="hidden" name="suma" id="suma" value="{{$ponderacion}}">
                <div class="col-lg-6">
                    @include('includes.button-form-create')
                </div>
            </div>
        </form> 
</div>
@stop

@section('js')
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
   <script src="{{asset("assets/pages/scripts/objetives/ponderacion.js")}}" type="text/javascript"></script>
@stop