@extends('adminlte::page')

@section('title', 'Evaluación desempeño ' . $year)

@section('content_header')
    @if( $type == 1)
        <h1>Seguimiento mis colaboradores directos</h1>
    @elseif($type == 2)
        <h1>Seguimiento todos mis colaboradores</h1>
    @else
        <h1>Seguimiento todos los colaboradores</h1>
    @endif
@stop

@section('content')
@include('includes.mensaje')
    <div class="card">
        <div class="card-header">
            <button onclick="window.location.href='{{route('reporte_control', ['id' => $type])}}'" class="btn btn-info" id="crear" name="crear">
                <i class="fa fa-fw fa-share "></i> Regresar
            </button> 
        </div>
        <div class="card-body">
            <?php $ponderacion = 0; ?>
            <table id="datatable" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th># empleado</th>
                        <th>Colaborador</th>
                        <th>Evaluador</th>
                        <th>Depto. colaborador</th>
                        <th>Objetivos cap.</th>
                        <th>Objetivos eval.</th>
                        <th>Calificación</th>
                        <th># cap. objs.</th>
                        <th># eval. objs.</th>

                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0 ; count($employeesArray) > $i ; $i++)
                        <tr>
                            <td>{{$employeesArray[$i]->num_employee}}</td>
                            <td>{{$employeesArray[$i]->name_employee}}</td>
                            <td>{{$employeesArray[$i]->boss_employee}}</td>
                            <td>{{$employeesArray[$i]->depto_employee}}</td>
                            @if($employeesArray[$i]->objetives == 1)
                                <td>Capturados</td>
                            @else
                                <td>Sin capturar</td>
                            @endif
                            
                            @if($employeesArray[$i]->evaluation == 1)
                                <td>Realizada</td>
                            @else
                                <td>Pendiente</td>
                            @endif 
                            @if($employeesArray[$i]->calificacion != 0)
                                <td>{{$employeesArray[$i]->calificacion}}</td>
                            @else
                                <td>Sin calificación</td>
                            @endif
                            <td>{{$employeesArray[$i]->num_obj}}</td>
                            <td>{{$employeesArray[$i]->num_calif}}</td>

                        </tr>
                    @endfor
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
                ]
        });    
    });
   </script>
   <script src="{{asset("assets/pages/scripts/objetives/revision.js")}}" type="text/javascript"></script>
   <script src="{{asset("assets/pages/scripts/objetives/index.js")}}" type="text/javascript"></script>
@stop