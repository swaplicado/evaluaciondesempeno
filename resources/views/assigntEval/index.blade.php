@extends('adminlte::page')

@section('title', 'Evaluación desempeño ' . $year)

@section('content_header')
    <h1>Asignar evaluador</h1>
@stop
@section('content')
    <div class="card" id="assigntEval">
        <form id="myForm" action="{{route('assignt_eval_save')}}" id="form-general" class="form-horizontal" method="POST" autocomplete="off">
            <div class="card-body">
                @csrf
                <div class="form-group">
                    <label for="miSelect" class="form-label">Elige evaluador:*</label>
                    <select id="miSelect" style="width: 300px;" name="evaluador"></select>
                </div>
                <div class="form-group">
                    <label for="evalSelect" class="form-label">Elige evaluando:*</label>
                    <select id="evalSelect" style="width: 300px;" name="evaluando[]" multiple="multiple"></select>
                </div>
            </div>
        <table id="datatable" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="background-color: #9C9C9C;">Evaluador:</th>
                </tr>
                <tr>
                    <th>@{{eval[0].text}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="background-color: #cfcfcf;"><b>Evaluando:</b></td>
                </tr>
                <tr v-for="ev in lEval">
                    <td>@{{ev.text}}</td>
                </tr>
            </tbody>
        </table>
        <div class="col-lg-12">
            <div style="float: right;">
                <button class="btn btn-success" id="save" name="save" type="" onclick="this.disabled=true; $('#myForm').submit();">Guardar</button>
            </div>
        </div>
    </form>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    <link href="https://rawgit.com/select2/select2/master/dist/css/select2.min.css" rel="stylesheet"/>
@stop

@section('js')
    
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
   <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
   <script src="{{ asset("js/vue.js") }}" type="text/javascript"></script>
   <script src="https://rawgit.com/select2/select2/master/dist/js/select2.js"></script>
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
   <script>
    function GlobalData () {
        this.Users = <?php echo json_encode($users) ?>;
    }
    var oData = new GlobalData();

    </script>
    <script src="{{ asset("assets/pages/scripts/assigntEval/assigntEval.js") }}" type="text/javascript"></script>
   <script>
    $(document).ready(function() {
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
    } );
   </script>
   <script src="{{asset("assets/pages/scripts/reports/controlreport.js")}}" type="text/javascript"></script>
   <script src="{{asset("assets/pages/scripts/objetives/index.js")}}" type="text/javascript"></script>
@stop