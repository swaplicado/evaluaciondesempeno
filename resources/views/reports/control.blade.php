@extends('adminlte::page')

@section('title', 'Evaluación Desempeño 2021')

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
        <form action="{{route('reporte_control_generar')}}" id="form-general" class="form-horizontal" method="POST" autocomplete="off">
            <div class="card-body">           
                
                    @csrf
                    <input type="hidden" name="user_id" id="user_id" value="{{$id_user}}">
                    <input type="hidden" name="type" id="type" value="{{$type}}">
 
                    <div class="form-group">
                        <label for="cars" class="form-label">Elige año evaluación:*</label>
                            
                        <select class="form-control" id="anio" name="anio" required>
                            <option value="">Seleccione año</option>
                            <option value="1" selected>2021</option>   
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="cars" class="form-label">Elige departamento:*</label>
                            
                        <select class="form-control" id="dept" name="dept" required>
                            <option value="0">Todos los departamentos</option>
                            @for($i = 0 ; count($depatments) > $i ; $i++)
                                <option value="{{$depatments[$i]->id_department}}">{{$depatments[$i]->name}}</option>
                            @endfor
                        </select>
                    </div>

            </div>
            <div class="card-footer">
                <div class="col-lg-6">
                    <button class="btn btn-warning" id="generar" name="generar" type="submit">Generar</button>
                </div>
            </div>
        </form> 
        
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    
    
@stop

@section('js')
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
   <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

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