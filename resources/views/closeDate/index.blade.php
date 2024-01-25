@extends('adminlte::page')

@section('title', 'Evaluación desempeño ' . $year)

@section('content_header')
    <link rel="shortcut icon" href="{{ asset('favicons/icono.png') }}" />
    <h1><b>Configuración fecha de cierre</b> </h1>
    <h5>La fecha limite actual es: <b>{{$limite}}</b>.</h5>
@stop

@section('content')
<div class="card">
    <form id="myForm" action="{{$route}}" class="form-horizontal" method="POST" autocomplete="off">
        <div class="card-body">
            @csrf
            <div class="col-md-12 col-md-offset-1">
                <label style = "float: left; height: 100%;">Selecciona fecha de cierre:</label>
                <div class="row">
                    <div class="col-md-2">
                        <input type="date" value="" name="date">
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-primary" onclick="this.form.submit(); this.disabled=true;">Guardar fecha de cierre</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@stop

@section('css')
    
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('message'))
     <script>
         msg = "<?php echo session('message'); ?>";
         myIcon = "<?php echo session('icon'); ?>";

         Swal.fire({
             icon: myIcon,
             title: msg
         });
     </script>
 @endif
@stop