<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evaluation;
use App\Models\Objetive;
use App\User;
use App\Models\Year;
use App\Models\Objetive_status_log;
use DB;

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
        $datas = Objetive::where('eval_id',$id)->get();
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
        $datas = Objetive::where('eval_id',$objetivo->eval_id)->get();
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
}
