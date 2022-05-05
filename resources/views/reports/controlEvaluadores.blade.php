@extends('adminlte::page')

@section('title', 'Evaluación Desempeño 2021')

@section('content_header')
    <h1>Seguimiento Evaluadores</h1>
@stop

@section('content')
@include('includes.mensaje')
    <div class="card">
        <div class="card-body">
            <table id="datatable" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Evaluador</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($evaluadores as $eval)
                        <tr>
                            <td>{{$eval->eval_name}}</td>
                            <td>{{$eval->col_name}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/dt/datatables.css") }}">
@stop

@section('js')
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script src="{{ asset("assets/dt/datatables.js") }}" type="text/javascript"></script>

   <script>
    $(document).ready(function() {
        $('#datatable').DataTable({
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
            "columnDefs": [
                { "visible": false, "targets": [0] }
            ],
            "dom": 'Bfrtip',
            "lengthMenu": [
                [ 10, 25, 50, 100, -1 ],
                [ 'Mostrar 10', 'Mostrar 25', 'Mostrar 50', 'Mostrar 100', 'Mostrar todo' ]
            ],
            "buttons": [
                    'pageLength',
                    {
                        extend: 'copy',
                        text: 'Copiar'
                    }, 
                    'csv', 
                    'excel', 
                    {
                        extend: 'print',
                        text: 'Imprimir'
                    }
                ],
            "drawCallback": function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;
    
                api.column(0, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="group"><td colspan="2" style="background-color: #9C9C9C;"><b>Evaluador: </b>'+group+'</td></tr>'
                        );
    
                        last = group;
                    }
                } );
            }
        });    
    });
   </script>
   <script src="{{asset("assets/pages/scripts/objetives/revision.js")}}" type="text/javascript"></script>
   <script src="{{asset("assets/pages/scripts/objetives/index.js")}}" type="text/javascript"></script>
@stop