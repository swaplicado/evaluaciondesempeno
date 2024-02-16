@extends('adminlte::page')

@section('title', 'Evaluación desempeño ' . $year)

@section('content_header')
    <h1>Registrar usuarios</h1>
@stop
@section('content')
<div class="container" id="appRegister">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('guardar_user') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Nombres:</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="apellidos" class="col-md-4 col-form-label text-md-right">{{ __('Apellidos:') }}</label>

                            <div class="col-md-6">
                                <input id="apellidos" type="text" class="form-control @error('apellidos') is-invalid @enderror" name="apellidos" value="{{ old('apellidos') }}" required autocomplete="apellidos" autofocus>

                                @error('apellidos')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="numEmpl" class="col-md-4 col-form-label text-md-right">{{ __('Numero de empleado:') }}</label>

                            <div class="col-md-6">
                                <input id="numEmpl" type="number" class="form-control @error('numEmpl') is-invalid @enderror" name="numEmpl" value="{{ old('numEmpl') }}" required autocomplete="numEmpl" autofocus>

                                @error('numEmpl')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dept" class="col-md-4 col-form-label text-md-right">{{ __('Departamento:') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" v-model="selDept" @change="setJobs()" id="dept" name="dept" required>
                                    <option v-for="dept in lDepartments" :value="dept.id_department">@{{dept.name}}</option>
                                </select>

                                @error('dept')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="job" class="col-md-4 col-form-label text-md-right">{{ __('Puesto:') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" id="job" name="job" required>
                                    <option v-for="job in lJobs" :value="job.id_job">@{{job.name}}</option>
                                </select>

                                @error('job')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address:') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password:') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                <input class="form-check-input" type="checkbox" id="checkbox" style="display: none;">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <label class="form-check-label" for="checkbox" style="float: right;">
                                <span class="fa fa-eye-slash" id="checkIcon"></span>
                            </label>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password:') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" onclick="this.form.submit(); this.disabled=true;">
                                    {{ __('Register') }}
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
    <script>
        $(document).ready(function(){
            $('#checkbox').on('change', function(){
                $('#password').attr('type',$('#checkbox').prop('checked')==true?"text":"password");
                $('#password-confirm').attr('type',$('#checkbox').prop('checked')==true?"text":"password");
                document.getElementById("checkIcon").className = $('#checkbox').prop('checked')==true?"fa fa-eye":"fa fa-eye-slash";
            });
        });
    </script>
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
    <script src="{{ asset("js/vue.js") }}" type="text/javascript"></script>
    <script>
        function GlobalData () {
        this.lDepartments = <?php echo json_encode($departments) ?>;
        this.lJobs = <?php echo json_encode($jobs) ?>;
        }
        var oData = new GlobalData();
    </script>
    <script src="{{ asset("assets/pages/scripts/users/registryUsers.js") }}" type="text/javascript"></script>
@stop