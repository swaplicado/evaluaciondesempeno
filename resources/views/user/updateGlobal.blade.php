@extends('adminlte::page')

@section('title', 'Evaluación desempeño ' . $year)

@section('content_header')
    <h1>Modificar usuario</h1>
@stop
@section('content')
<div class="container" id="appRegister">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modificar') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('modificar_global_user') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Nombre:') }}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="full" id="full" value="{{$user->full_name}}" disabled>
                            </div>
                        </div>
                        @if($rol->rol_id  == 1)
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo:') }}</label>

                                <div class="col-md-6">
                                    <input type="email" required  class="form-control" name="email" id="email" value="{{$user->email}}">
                                </div>
                            </div>
                        @endif
                        @if($rol->rol_id == 1)
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Usuario:') }}</label>

                                <div class="col-md-6">
                                    <input type="text" required class="form-control" name="us" id="us" value="{{$user->name}}" >
                                </div>
                            </div>
                        @endif
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña anterior:') }}</label>

                            <div class="col-md-6">
                                <input type="password" required class="form-control" name="prevpass" id="prevpass" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña nueva:') }}</label>

                            <div class="col-md-6">
                                <input type="password" required class="form-control" name="newpass" id="newpass" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar contraseña:') }}</label>

                            <div class="col-md-6">
                                <input type="password" required class="form-control" name="newpass1" id="newpass1" value="">
                            </div>
                        </div>
                        <input type="hidden" class="form-control" name="pass" id="pass" value="{{$user->password}}">
                        <input type="hidden" class="form-control" name="id_user" id="id_user"  value="{{$user->id}}">
                        <input type="hidden" class="form-control" name="rol" id="rol" value="{{$rol->rol_id}}">
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" id="actualizar" class="btn btn-primary" onclick="this.form.submit();">
                                    {{ __('Actualizar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset("js/vue.js") }}" type="text/javascript"></script>
    <script src="{{ asset("assets/pages/scripts/users/registryGlobalUsers.js") }}" type="text/javascript"></script>
    <script src="{{ asset("assets/pages/scripts/users/userGlobal.js") }}" type="text/javascript"></script>
@stop