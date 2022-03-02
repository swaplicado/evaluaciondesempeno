<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evaluation;
use App\Models\Objetive;
use App\User;
use App\Models\Year;
use App\Models\Objetive_status_log;
use App\Models\Score;
use DB;
use App\SUtils\SEval;
use App\SUtils\SObjetive;

class ObjetiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $year = 1;
        $user = auth()->id();
        $evaluacion = Evaluation::where('is_deleted',0)->where('user_id',$user)->where('year_id',$year)->get();
        
        $datas = Objetive::where('eval_id',$evaluacion[0]->id_eval)->where('is_deleted',0)->get();
        $evaluacion->each(function($datas){
            $datas->eval_status;
        });
        
        return view('eval.index', compact('datas'))->with('user',$user)->with('evaluacion',$evaluacion);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $datas = Objetive::where('eval_id',$id)->where('is_deleted',0)->get();
        $ponderacion = 0;
        for($i = 0 ; count($datas) > $i ; $i++){
            $ponderacion = $ponderacion + $datas[$i]->weighing;
        }

        $year = Year::where('is_deleted','0')->orderBy('year','ASC')->pluck('id_year','year');
        return view('eval.create')->with('years',$year)->with('id',$id)->with('ponderacion',$ponderacion);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $objetive = new Objetive();
        $objetive->name = $request->name;
        $objetive->eval_id = $request->id;
        $objetive->activities = $request->activities;
        $objetive->comment = $request->comment;
        $objetive->weighing = $request->weighing;
        $objetive->is_deleted = 0;
        $objetive->created_by = auth()->id();
        $objetive->updated_by = auth()->id();

        $objetive->save();

        return redirect('objetive')->with('mensaje','Objetivo fue creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $objetivo = Objetive::findOrFail($id);
        $datas = Objetive::where('eval_id',$objetivo->eval_id)->where('is_deleted',0)->get();
        $ponderacion = 0;
        for($i = 0 ; count($datas) > $i ; $i++){
            $ponderacion = $ponderacion + $datas[$i]->weighing;
        }

        $year = Year::where('is_deleted','0')->orderBy('year','ASC')->pluck('id_year','year');

        return view('eval.edit')->with('years',$year)->with('id',$id)->with('ponderacion',$ponderacion)->with('objetivo',$objetivo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $objetivo = Objetive::findOrFail($id);
        $objetivo->name = $request->name;
        $objetivo->activities = $request->activities;
        $objetivo->comment = $request->comment;
        $objetivo->weighing = $request->weighing;

        $objetivo->updated_by = auth()->id();

        $objetivo->save();

        return redirect('objetive')->with('mensaje','Objetivo fue editado con éxito');   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
            $indicator = Objetive::find($id);
            $indicator->is_deleted = 1;
            $indicator->save();
            return response()->json(['mensaje' => 'ok']);
    }

    public function send_to_aprove(Request $request){
        $evaluacion = Evaluation::findOrFail($request->evaluacion);
        $evaluacion->eval_status_id = 2;
        $evaluacion->updated_by = auth()->id();
        $evaluacion->save();

        $status_log = new Objetive_status_log();
        $status_log->eval_id = $request->evaluacion;
        $status_log->eval_status_id = 2;

        $status_log->created_by = auth()->id();
        $status_log->updated_by = auth()->id();
        $status_log->save();
        $data = 1;
        return response()->json(array($data));   
    }
    
    public function list_objetives(Request $request){
        $id_user = auth()->id();
        $user = User::findOrFail($id_user);
        $empleados = DB::select("SELECT ev.id_eval AS id_eval, ev.year_id AS year_id, ev.comment AS comment, users.full_name AS name, sys_eval_status.name AS status_name, ev.eval_status_id AS eval_status_id, ev.score_id AS score_id  FROM evals ev INNER JOIN users ON ev.user_id = users.id INNER JOIN sys_eval_status ON ev.eval_status_id = sys_eval_status.id_eval_status WHERE user_id IN (SELECT user_id FROM evals WHERE eval_user_id = ".$user->id.") AND version = (SELECT MAX(version) FROM evals WHERE user_id = ev.user_id)");  
        
        $objetiveArray = [];
        $evalArray = [];

        for( $i = 0 ; count($empleados) > $i ; $i++ ){
            $objetivos = Objetive::where('eval_id',$empleados[$i]->id_eval)->where('is_deleted',0)->get();
            
            for( $j = 0 ; count($objetivos) > $j ; $j++ ){
                $objetiveRow = new SObjetive();
                $objetiveRow->nameObj = $objetivos[$j]->name;
                $objetiveRow->activitiesObj = $objetivos[$j]->activities;
                $objetiveRow->commentObj = $objetivos[$j]->comment;
                $objetiveRow->weighing = $objetivos[$j]->weighing;

                $objetiveArray[$j] = $objetiveRow;
            }

            $evalRow = new SEval();
            $evalRow->eval_id = $empleados[$i]->id_eval;
            $evalRow->user_name = $empleados[$i]->name;
            $evalRow->year_id = $empleados[$i]->year_id;
            $evalRow->comment = $empleados[$i]->comment;
            $evalRow->eval_status_id = $empleados[$i]->eval_status_id;
            $evalRow->eval_status_name = $empleados[$i]->status_name;
            $evalRow->score_id = $empleados[$i]->score_id;
            $evalRow->objetives = $objetiveArray;
            
            $evalArray[$i] = $evalRow;
        }

        $scores = Score::where('is_deleted','0')->orderBy('id_score','ASC')->pluck('id_score','name');


        return view('eval.list', compact('evalArray'))->with('scores',$scores);
        
    }

    public function refuse_evaluation(Request $request){

        $evaluacion = Evaluation::findOrFail($request->id_evaluacion);

        //crear la nueva versión de la evaluación
        $clonEvaluacion = new Evaluation();

        $clonEvaluacion->year_id = $evaluacion->year_id;
        $clonEvaluacion->user_id = $evaluacion->user_id;
        $clonEvaluacion->version = $evaluacion->version + 1;
        $clonEvaluacion->eval_user_id = $evaluacion->eval_user_id;
        $clonEvaluacion->comment = $request->comentario;
        $clonEvaluacion->eval_status_id = 1;
        $clonEvaluacion->score = $evaluacion->score;
        $clonEvaluacion->score_id = $evaluacion->score_id;
        $clonEvaluacion->is_deleted = 0;
        $clonEvaluacion->created_by = auth()->id();
        $clonEvaluacion->updated_by = auth()->id();
        $clonEvaluacion->save(); 



        //se mete al log lo sucedido

        $status_log = new Objetive_status_log();
        $status_log->eval_id = $clonEvaluacion->id_eval;
        $status_log->eval_status_id = 1;

        $status_log->created_by = auth()->id();
        $status_log->updated_by = auth()->id();
        $status_log->save();
        $data = 1;
        return response()->json(array($data));
    }
}
