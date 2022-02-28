@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Objetivos</h1>
@stop

@section('content')
@include('includes.mensaje')
    <div class="card">
        <input type="hidden" id="id_empleado" name="id_empleado" value="{{$user}}">
        <input type="hidden" id="anio" name="anio" value="2021">
        <input type="hidden" id="evaluacion" name="evaluacion" value="{{$evaluacion[0]->id_eval}}">
        <div class="card-header">
            @if(count($evaluacion) > 0)
                @switch($evaluacion[0]->eval_status_id)
                    @case(1)
                        <button onclick="window.location.href='{{route('crear_objetivo', ['id' => $evaluacion[0]->id_eval])}}'" class="btn btn-success" id="crear" name="crear">
                            <i class="fa fa-fw fa-plus-circle"></i> Nuevo
                        </button>
                        @break
                    @case(2)
                        <button onclick="window.location.href='{{route('crear_objetivo', ['id' => $evaluacion[0]->id_eval])}}'" class="btn btn-success" id="crear" name="crear" disabled="disabled">
                            <i class="fa fa-fw fa-plus-circle"></i> Nuevo
                        </button>
                        @break
                    @case(3)
                        <button onclick="window.location.href='{{route('crear_objetivo', ['id' => $evaluacion[0]->id_eval])}}'" class="btn btn-success" id="crear" name="crear" >
                            <i class="fa fa-fw fa-plus-circle"></i> Nuevo
                        </button>
                        @break
                    @case(4)
                        <button onclick="window.location.href='{{route('crear_objetivo', ['id' => $evaluacion[0]->id_eval])}}'" class="btn btn-success" id="crear" name="crear" disabled="disabled">
                            <i class="fa fa-fw fa-plus-circle"></i> Nuevo
                        </button>
                        @break
                    @default
                        
                @endswitch
            @else
                <button onclick="window.location.href='{{route('crear_objetivo')}}'" class="btn btn-success" id="crear" name="crear">
                    <i class="fa fa-fw fa-plus-circle"></i> Nuevo
                </button>
                
            @endif
        </div>
        <div class="card-body">
            <?php $ponderacion = 0; ?>
            <table id="indicators" class="table table-stripped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Objetivo</th>
                        <th>Ponderación</th>
                        <th>Calificación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $contador = 0 ?>
                    @foreach ($datas as $data)
                        <?php $contador++ ?>
                        <tr>
                            <td>{{$contador}}</td>
                            <td>{{$data->name}}</td>
                            <td>{{$data->weighing}}%</td>
                            @if($data->score_id != null)
                                <td>{{$data->score}}</td>
                            @else
                                <td>Sin calificación</td>
                            @endif
                            <td>
                                @if ( $evaluacion[0]->eval_status_id == 1 || $evaluacion[0]->eval_status_id == 3)
                                    <a href="{{route('editar_objetivo', ['id' => $data->id_objetive])}}" class="btn btn-primary" id="edicion" title="Modificar este registro">
                                        <i class="fa fa-fw fa-wrench"></i>
                                    </a>
                                    <form action="{{route('eliminar_objetivo', ['id' => $data->id_objetive])}}" class="d-inline form-eliminar" method="POST">
                                        @csrf @method("delete")
                                        <button type="submit" class="btn btn-primary" id="eliminacion" title="Eliminar este registro">
                                            <i class="fa fa-fw fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                            <?php 
                            $ponderacion = $ponderacion + $data->weighing; 
                            ?>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr style="height:2px;width:100%;text-align:left;margin-left:0">
            <input type="hidden" value={{$ponderacion}} id="ponderacion" name="ponderacion">
        </div>
        <div class="card-footer border-success text-muted ">
            <p style="font-size:20px;"><b>Ponderación total:</b> {{$ponderacion}}%</p>
            @switch($evaluacion[0]->eval_status_id)
                    @case(1)
                        <p style="font-size:20px;"><b>Estatus evaluación:</b> <span class="badge badge-primary">Definiendo objetivos</span> <span class="badge badge-secondary">Evaluando objetivos</span> <span class="badge badge-secondary">Objtivos evaluados</span></p>
                        @break
                    @case(2)
                        <p style="font-size:20px;"><b>Estatus evaluación:</b> <span class="badge badge-secondary">Definiendo objetivos</span> <span class="badge badge-primary">Evaluando objetivos</span> <span class="badge badge-secondary">Objtivos evaluados</span></p>
                        @break
                    @case(3)
                        <p style="font-size:20px;"><b>Estatus evaluación:</b> <span class="badge badge-secondary">Definiendo objetivos</span> <span class="badge badge-secondary">Evaluando objetivos</span> <span class="badge badge-secondary">Objtivos evaluados</span></p>
                        @break
            @endswitch
            @if($evaluacion[0]->comment != null)
                <p style="font-size:20px;" class="card-text"><b>Comentario más reciente:</b><input class="form-control" type="text" value="{{$evaluacion[0]->comment}}" disabled="disabled"></p>
            @else
                <p style="font-size:20px;" class="card-text"><b>Comentario más reciente:</b><input class="form-control" type="text" value="Sin comentarios" disabled="disabled"></p>
            @endif

            @switch($evaluacion[0]->eval_status_id)
                    @case(1)
                        <button type="button" class="btn btn-warning float-right" onclick="agregar()" id="enviar" name="enviar">
                            <i class="fa fa-fw fa-share"></i> Enviar a evaluador
                        </button>
                        @break
                    @case(2)
                        <button type="button" class="btn btn-warning float-right" onclick="agregar()" id="enviar" name="enviar" disabled="disabled">
                            <i class="fa fa-fw fa-share"></i> Enviar a evaluador
                        </button>
                        @break
                    @case(3)
                        <button type="button" class="btn btn-warning float-right" onclick="agregar()" id="enviar" name="enviar" disabled="disabled">
                            <i class="fa fa-fw fa-share"></i> Enviar a evaluador
                        </button>
                        @break
            @endswitch
        </div>

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
   <script src="{{asset("assets/pages/scripts/objetives/revision.js")}}" type="text/javascript"></script>
   <script src="{{asset("assets/pages/scripts/objetives/index.js")}}" type="text/javascript"></script>
@stop