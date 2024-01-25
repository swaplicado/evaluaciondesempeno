@extends('adminlte::page')

@section('title', 'Evaluación desempeño ' . $year)

@section('content_header')
    <h1>Cambio contraseña</h1>
@stop

@section("js")
    <script>
    function mostrarContrasena(){
        var tipo = document.getElementById("password");
        if(tipo.type == "password"){
            tipo.type = "text";
        }else{
            tipo.type = "password";
        }
    }
  </script>
@stop
@section('content')
@include('includes.mensaje')
    <div class="card">
        <div class="card-body">
            <form action="{{route('actualizar_contraseña', ['id' => $data->id])}}" id="form-general" class="form-horizontal" method="POST" autocomplete="off">
                @csrf @method("put")
                
                @include('user.formChange')
                
                <div class="card-footer">
                    <div class="col-lg-6">
                        @include('includes.button-form-create')
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop