@extends('adminlte::page')

@section('title', 'Evaluación Desempeño 2021')

@section('content_header')
    @if ($isDirector == true)
        <h1>Objetivos de mis colaboradores</h1>
    @else
        <h1>Objetivos de mis colaboradores directos</h1>
    @endif
    
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="accordion" id="accordionExample">
                <?php $contadorEmpleados = 0; ?>
                @foreach ($evalArray as $eval)
                {{--se utiliza la variable para checar si se colocan los botones de comentario --}}
                    <?php $hay_indicador = 0; $total = 0; $num_obj = 0;?>
                    <div class="card">
                        <div class="card-header" id="heading{{$contadorEmpleados}}">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{$contadorEmpleados}}" aria-expanded="true" aria-controls="collapse{{$contadorEmpleados}}">
                                    @if($eval->eval_status_id == 1)
                                        <span class="badge badge-primary"><i class="fa fa-list" aria-hidden="true"></i></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$eval->user_name}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{count($eval->objetives)}} 
                                    @elseif($eval->eval_status_id == 2)
                                        <span class="badge badge-primary"><i class="fa fa-search" aria-hidden="true"></i></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$eval->user_name}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{count($eval->objetives)}} 
                                    @else
                                        <span class="badge badge-primary"><i class="fa fa-check" aria-hidden="true"></i></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$eval->user_name}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{count($eval->objetives)}} 
                                    @endif
                                </button>
                                
                            </h2>
                        </div>
                        <?php $cadenaObjetivos = ""; ?>
                        <?php $numeroObjetivo = 0 ; ?>
                        @foreach($eval->objetives as $objetive)
                        <?php $hay_indicador = 1; $num_obj++;?>
                        <?php $numeroObjetivo++ ; ?>
                        @if ($cadenaObjetivos == "")
                            <?php $cadenaObjetivos = "calificacion_nueva".$objetive->id_obj ?> 
                        @else
                            <?php $cadenaObjetivos = $cadenaObjetivos.",calificacion_nueva".$objetive->id_obj ?> 
                        @endif
                                <div id="collapse{{$contadorEmpleados}}" class="collapse" aria-labelledby="heading{{$contadorEmpleados}}" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="card">
                                            <div class="card-header">
                                            {{$numeroObjetivo . ".- " . $objetive->nameObj}}
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text"><b>Actividades:</b> {{$objetive->activitiesObj}}</p>
                                                <p class="card-text"><b>Ponderación:</b> {{$objetive->weighing}} %</p> <input type="hidden" id="pon{{$objetive->id_obj}}" name="pon{{$objetive->id_obj}}" value="{{$objetive->weighing}}">
                                                <p class="card-text"><b>Comentario:</b> {{$objetive->commentObj}} </p>
                                                @if($objetive->score_id == null)
                                                    <p class="card-text"><b>Calificación:</b> <select disabled id="calificacion_nueva{{$objetive->id_obj}}" onchange="evaluar({{$eval->eval_id.','.$objetive->id_obj}})"><option selected value="0">0 - Sin calificar</option> @foreach($scores as $score => $index) <option value="{{ $index }}"> {{$index.' - '.$score}}</option> @endforeach </select></p>
                                                    <p class="card-text"><b>Calificación ponderada:</b> <input type="text" disabled id="calificacion_pon{{$objetive->id_obj}}" value="0.0"></p>
                                                    <input type="hidden" id="calificacion_anterior{{$objetive->id_obj}}" name="calificacion_anterior{{$objetive->id_obj}}" value="0">
                                                @else
                                                    <p class="card-text"><b>Calificación:</b> <select disabled id="calificacion_nueva{{$objetive->id_obj}}" onchange="evaluar({{$eval->eval_id.','.$objetive->id_obj}})"><option value="0">0 - Sin calificar</option> @foreach($scores as $score => $index) @if( $objetive->score_id == $index) <option selected value="{{ $index }}"> {{$index.' - '.$score}}</option> @else <option value="{{ $index }}"> {{$index.' - '.$score}}</option> @endif @endforeach </select></p>
                                                    <?php $ponderacion = $objetive->weighing / 100; $ponderacion = $ponderacion * $objetive->score_id; ?>
                                                    <p class="card-text"><b>Calificación ponderada:</b> <input type="text" disabled id="calificacion_pon{{$objetive->id_obj}}" value="{{ $ponderacion }}"></p>
                                                    <input type="hidden" id="calificacion_anterior{{$objetive->id_obj}}" name="calificacion_anterior{{$objetive->id_obj}}" value="{{$objetive->score_id}}">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @endforeach

                        @if($hay_indicador == 1)
                            <div id="collapse{{$contadorEmpleados}}" class="collapse" aria-labelledby="heading{{$contadorEmpleados}}" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="card">
                                        <div class="card-body">
                                            <input type="hidden" id="num{{$eval->eval_id}}" name="num{{$eval->eval_id}}" value="{{$num_obj}}">
                                            @if($eval->score_id == null)
                                                <p class="card-text">Evaluación sin redondear: <input class='form-control' type="number" value="0" id="sinr{{$eval->eval_id}}" name="sinr{{$eval->eval_id}}" readonly></p>
                                                <p class="card-text">Evaluación final: <input class='form-control' type="number" value="0" id="total{{$eval->eval_id}}" name="total{{$eval->eval_id}}" readonly></p>
                                                <p class="card-text">Evaluación obtenida:<input class="form-control" type="text" value="Sin calificar" id="califnombre{{$eval->eval_id}}" readonly></p>
                                                <p class="card-text">Comentarios: <input class='form-control' type="text" id="comentarios{{$eval->eval_id}}" name="comentarios{{$eval->eval_id}}" value="{{$eval->comment}}" readonly> </p>
                                                <button type="button" class="btn btn-info check_year" onclick="recalif({{$eval->eval_id}})" id="ini{{$eval->eval_id}}" name="ini{{$eval->eval_id}}">
                                                    Iniciar evaluación
                                                </button>
                                                <button type="button" class="btn btn-success check_year" onclick="aprobar({{$eval->eval_id}})" id="apro{{$eval->eval_id}}" name="apro{{$eval->eval_id}}" disabled>
                                                    Terminar evaluación
                                                </button>
                                                <button type="button" class="btn btn-danger check_year" onclick="desblo({{$eval->eval_id}})" id="desbloquear{{$eval->eval_id}}" name="desbloquear{{$eval->eval_id}}">
                                                    Rechazar objetivos
                                                </button>
                                                <button type="button" class="btn btn-danger check_year" onclick="rechazar({{$eval->eval_id}})" id="recha{{$eval->eval_id}}" name="recha{{$eval->eval_id}}" disabled>
                                                    Regresar objetivos
                                                </button>
                                                <button type="button" class="btn btn-warning check_year" onclick="recalif({{$eval->eval_id}})" id="recalif{{$eval->eval_id}}" name="recalif{{$eval->eval_id}}" disabled>
                                                    Volver a evaluar
                                                </button> 
                                                <button type="button" class="btn btn-secondary check_year" onclick="can({{$eval->eval_id}})" id="cancel{{$eval->eval_id}}" name="cancel{{$eval->eval_id}}"disabled>
                                                    Abortar evaluación
                                                </button> 
                                                <input type="hidden" id="havescore{{$eval->eval_id}}" name="havescore{{$eval->eval_id}}" value="0">
                                            @else
                                                <p class="card-text">Evaluación sin redondear: <input class='form-control' type="number" value="{{$eval->score}}" id="sinr{{$eval->eval_id}}" name="sinr{{$eval->eval_id}}" readonly></p>
                                                <p class="card-text">Evaluación final: <input class='form-control' type="number" value="{{$eval->score_id}}" id="total{{$eval->eval_id}}" name="total{{$eval->eval_id}}" readonly></p>
                                                @if($eval->score_id == 1)
                                                    <p class="card-text">Evaluación obtenida:<input class="form-control" type="text" value="{{$scoreName[0]->name}}" id="califnombre{{$eval->eval_id}}" readonly></p>
                                                @elseif($eval->score_id == 2)
                                                    <p class="card-text">Evaluación obtenida:<input class="form-control" type="text" value="{{$scoreName[1]->name}}" id="califnombre{{$eval->eval_id}}" readonly></p>
                                                @elseif($eval->score_id  == 3)
                                                    <p class="card-text">Evaluación obtenida:<input class="form-control" type="text" value="{{$scoreName[2]->name}}" id="califnombre{{$eval->eval_id}}" readonly></p>
                                                @else
                                                    <p class="card-text">Evaluación obtenida:<input class="form-control" type="text" value="{{$scoreName[3]->name}}" id="califnombre{{$eval->eval_id}}" readonly></p>
                                                @endif
                                                <p class="card-text">Comentarios: <input class='form-control' type="text" id="comentarios{{$eval->eval_id}}" name="comentarios{{$eval->eval_id}}" value="{{$eval->comment}}" readonly>  </p>
                                                <button type="button" class="btn btn-info check_year" onclick="recalif({{$eval->eval_id}})" id="ini{{$eval->eval_id}}" name="ini{{$eval->eval_id}}" disabled>
                                                    Iniciar evaluación
                                                </button>
                                                <button type="button" class="btn btn-success check_year" onclick="aprobar({{$eval->eval_id}})" id="apro{{$eval->eval_id}}" name="apro{{$eval->eval_id}}" disabled>
                                                    Terminar evaluación
                                                </button>
                                                <button type="button" class="btn btn-danger check_year" onclick="desblo({{$eval->eval_id}})" id="desbloquear{{$eval->eval_id}}" name="desbloquear{{$eval->eval_id}}">
                                                    Rechazar objetivos
                                                </button>
                                                <button type="button" class="btn btn-danger check_year" onclick="rechazar({{$eval->eval_id}})" id="recha{{$eval->eval_id}}" name="recha{{$eval->eval_id}}" disabled>
                                                    Regresar objetivos
                                                </button>
                                                <button type="button" class="btn btn-warning check_year" onclick="recalif({{$eval->eval_id}})" id="recalif{{$eval->eval_id}}" name="recalif{{$eval->eval_id}}">
                                                    Volver a evaluar
                                                </button> 
                                                <button type="button" class="btn btn-secondary check_year" onclick="can({{$eval->eval_id}})" id="cancel{{$eval->eval_id}}" name="cancel{{$eval->eval_id}}"disabled>
                                                    Abortar evaluación
                                                </button> 
                                                <input type="hidden" id="havescore{{$eval->eval_id}}" name="havescore{{$eval->eval_id}}" value="1">
                                            @endif
                                            
                                            <input type="hidden" id="arreglo{{$eval->eval_id}}" name="arreglo{{$eval->eval_id}}" value="{{$cadenaObjetivos}}">
                                             
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>    
                    <?php $contadorEmpleados++; ?> 
                @endforeach
                
                
            </div>
    </div>
@stop

@section('css')
    
@stop

@section('js')
    <script src="{{asset("assets/pages/scripts/score/acciones.js")}}" type="text/javascript"></script>
    <script src="{{asset("assets/pages/scripts/score/evaluar.js")}}" type="text/javascript"></script>  
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
@stop