@extends('adminlte::page')

@section('title', 'Evaluación desempeño ' . $year)

@section('content_header')
    <h1>Años evaluación</h1>
@stop
@section('content')
<div class="card" id="evalYears">

    <!-- Modal -->
    <div id="fmodal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@{{Year}}</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{route('evalYear_update')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <select class="form-control" name="status">
                            <option value="2" :selected="2 == Status">Abierto</option>
                            <option value="3" :selected="3 == Status">Cerrado</option>
                        </select>
                        <input type="hidden" :value="idYear" name="idYear">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="this.form.submit(); this.disabled=true;">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <form id="myForm" action="{{route('evalYear_save')}}" class="form-horizontal" method="POST" autocomplete="off">
        <div class="card-body">
            @csrf
            <div class="col-md-12 col-md-offset-1">
                <label style = "float: left; height: 100%;">Selecciona año:</label>
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" class="yearpicker" value="" name="year">
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-primary" onclick="this.form.submit(); this.disabled=true;">pasar a calendario</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <table id="datatable" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Año</th>
                <th>Estatus</th>
                <th>config</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="y in years">
                <td>@{{y.year}}</td>
                <td>@{{y.status}}</td>
                <td>
                    <a href="#" data-toggle="modal" data-target="#fmodal" 
                        v-on:click="setYear(y.id_year, y.year, y.status_id)">
                        <span class="fa fa-cog"></span>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{asset('assets/yearPicker/yearpicker.css')}}">
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset("js/vue.js") }}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{asset('assets/yearPicker/yearpicker.js')}}" async></script>

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
    <script>
        function GlobalData () {
           this.years = <?php echo json_encode($years) ?>;
        }
        var oData = new GlobalData();
    </script>
    <script src="{{ asset("assets/pages/scripts/evalYears/evalYears.js") }}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            max_year = oData.years[0]['year'];
            for (let i = 0; i < oData.years.length; i++) {
                if(max_year < oData.years[i]['year']){
                    max_year = oData.years[i]['year'];
                }
            }
            $('.yearpicker').yearpicker({
                startYear: max_year + 1,
            });

            $('#indicators').DataTable({
                "language": {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
                "colReorder": true,
                "dom": 'Bfrtip',
                "lengthMenu": [
                    [ 10, 25, 50, 100, -1 ],
                    [ 'Mostrar 10', 'Mostrar 25', 'Mostrar 50', 'Mostrar 100', 'Mostrar todo' ]
                ],

            });
        });
    </script>
@stop