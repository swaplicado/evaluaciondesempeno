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
                <div class="card-header">{{ __('Registrar colaborador') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('guardar_global_user') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Colaborador:') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" v-model="selCol" id="colaborador" name="colaborador" required>
                                    <option v-for="colab in lColab" :value="colab.id_global_user">@{{colab.full_name}}</option>
                                </select>
                            </div>
                            <input type="hidden" name="global" id="global" value="{{json_encode($uGlobales)}}">
                        </div>
                        <div class="form-group row ">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-primary" id="seleccionar" onclick="llenar()">Seleccionar</button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Usuario:') }}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="us" id="us" value="" disabled autofocus>
                                <input id="fus" type="hidden" name="fus">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombres:') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" id="name" value="" disabled autofocus>
                                <input id="fname" type="hidden" name="fname">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="apellidos" class="col-md-4 col-form-label text-md-right">{{ __('Apellidos:') }}</label>

                            <div class="col-md-6">
                                <input id="apellidos" type="text" class="form-control" name="apellidos" id="apellidos" value="" disabled autofocus>
                                <input id="fapellidos" type="hidden" name="fapellidos">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="numEmpl" class="col-md-4 col-form-label text-md-right">{{ __('Numero de empleado:') }}</label>

                            <div class="col-md-6">
                                <input id="numEmpl" type="number" class="form-control" name="numEmpl" id="numEmpl" value="" disabled autofocus>
                                <input id="fnumEmpl" type="hidden" name="fnumEmpl">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dept" class="col-md-4 col-form-label text-md-right">{{ __('Departamento:') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" v-model="selDept" @change="setJobs()" id="dept" name="dept" disabled>
                                    <option v-for="dept in lDepartments" :value="dept.id_department">@{{dept.name}}</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="job" class="col-md-4 col-form-label text-md-right">{{ __('Puesto:') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" id="job" name="job" :disabled="isDisabled">
                                    <option v-for="job in lJobs" :value="job.id_job">@{{job.name}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo:') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" id="email" value="" disabled>
                                <input id="femail" type="hidden" name="femail">
                            </div>
                        </div>
                        <input id="fpass" type="hidden" name="fpass">
                        <input id="fglobal" type="hidden"   name="fglobal">
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button disabled type="submit" id="guardar" class="btn btn-primary" onclick="this.form.submit();">
                                    {{ __('Registrar') }}
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
    <script src="{{ asset("js/vue.js") }}" type="text/javascript"></script>
    <script>
        function GlobalData () {
        this.lDepartments = <?php echo json_encode($departments) ?>;
        this.lJobs = <?php echo json_encode($jobs) ?>;
        this.lColab = <?php echo json_encode($uGlobales) ?>;
        }
        var oData = new GlobalData();
    </script>
    <script src="{{ asset("assets/pages/scripts/users/registryGlobalUsers.js") }}" type="text/javascript"></script>
    <script src="{{ asset("assets/pages/scripts/users/userGlobal.js") }}" type="text/javascript"></script>
@stop