<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Department;
use App\Models\Year;
use App\SUtils\SEvaluated;
use App\SUtils\SEvaluatedEmployee;
use DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Reporte para llevar un control de las evaluaciones.
     *
     * @param  int  $type
     * 1 se mostraran las personas que califica ese usuario
     * 2 se mostraran las personas a las que califica el usuario y las personas a las que califican las personas que calificas
     * 3 se mostraran todas las personas
     *
     * @return \Illuminate\Http\Response
     */
    public function control_report($type){
        //sacas el usuario que se esta utilizando
        $id_user = auth()->id();
        $user = User::findOrFail($id_user);


        /* Se quita porque no es necesario servia para sacar empleados y deptos que veria el usuario.

        //sacas los empleados dependiendo del tipo
        //$employees = SEvaluated::getEmployees( $user->id, $type );
        //$deptArray = [];
        //for( $i = 0 ; count($employees) > $i ; $i++){
            //$deptArray [$i] = $employees[$i]->department_id;  
        //}
        
        //sacas los deptos.
        $departments = Department::whereIn('id_department', $deptArray)->get();

        */

        //sacas los deptos.
        $departments = Department::where('is_delete', 0)->orderBy('name')->get();

        //saca el año
        $anio = Year::where('is_deleted',0)->get();
        
        return view('reports.control')->with('depatments',$departments)->with('type',$type)->with('id_user',$id_user);
    }

    public function control_report_gen(Request $request){
        $employees_id = SEvaluated::getEmployees( $request->user_id, $request->type ); 
        if($request->dept == 0){

            $employees = DB::table('evals')
                            ->join('users AS colaboradores', 'evals.user_id', '=', 'colaboradores.id')
                            ->join('users AS evaluador', 'evals.eval_user_id', '=', 'evaluador.id')
                            ->join('ext_departments', 'colaboradores.department_id', '=', 'ext_departments.id_department')
                            ->join('sys_eval_status', 'sys_eval_status.id_eval_status', '=', 'evals.eval_status_id')
                            ->whereIn('evals.user_id',$employees_id)
                            ->where('evals.is_deleted',0)
                            ->where('colaboradores.do_evaluation',1)
                            ->where('year_id',1)
                            ->orderBy('evals.version','DESC')
                            ->select('evals.id_eval AS ideval','colaboradores.full_name AS colaborador', 'colaboradores.num_employee AS numero', 'evaluador.full_name AS evaluador', 'ext_departments.name AS department', 'sys_eval_status.id_eval_status AS status', 'evals.score_id AS score','evals.version AS version')
                            ->get();
        }else{

            $employees = DB::table('evals')
                            ->join('users AS colaboradores', 'evals.user_id', '=', 'colaboradores.id')
                            ->join('users AS evaluador', 'evals.eval_user_id', '=', 'evaluador.id')
                            ->join('ext_departments', 'colaboradores.department_id', '=', 'ext_departments.id_department')
                            ->join('sys_eval_status', 'sys_eval_status.id_eval_status', '=', 'evals.eval_status_id')
                            ->whereIn('evals.user_id',$employees_id)
                            ->where('evals.is_deleted',0)
                            ->where('year_id',1)
                            ->where('colaboradores.do_evaluation',1)
                            ->where('colaboradores.department_id',$request->dept)
                            ->orderBy('evals.version','DESC')
                            ->select('evals.id_eval AS ideval','colaboradores.full_name AS colaborador', 'colaboradores.num_employee AS numero', 'evaluador.full_name AS evaluador', 'ext_departments.name AS department', 'sys_eval_status.id_eval_status AS status', 'evals.score_id AS score','evals.version AS version')
                            ->get();
        }
        //$employees = DB::select("SELECT users.num_employee AS num_employee, users.full_name AS name, ju.full_name AS boss_name, ext_departments.name AS department, sys_eval_status.name AS status_name FROM evals ev INNER JOIN users ON ev.user_id = users.id INNER JOIN sys_eval_status ON ev.eval_status_id = sys_eval_status.id_eval_status INNER JOIN users ju ON ju.id = ev.eval_user_id INNER JOIN ext_departments ON ext_department.id = users.department_id WHERE user_id IN (SELECT user_id FROM evals WHERE eval_user_id = ".$user->id.") AND version = (SELECT MAX(version) FROM evals WHERE user_id = ev.user_id) AND user_id IN ");
        
        $employeesArray = [];
        $contador_empleados = 0;

        for($i = 0 ; count($employees) > $i ; $i++){
            if( $i > 0 ){
                if( $employees[ $i ]->numero != $employees[ $i-1 ]->numero){
                    

                    $calificacion = DB::table('eval_scores_log')
                                        ->where('eval_id',$employees[$i]->ideval)
                                        ->count();

                    $userRow = new SEvaluatedEmployee();
                    $userRow->num_employee = $employees[ $i ]->numero;
                    $userRow->name_employee = $employees[ $i ]->colaborador;
                    $userRow->boss_employee = $employees[ $i ]->evaluador;
                    $userRow->depto_employee = $employees[ $i ]->department;
                    $userRow->calificacion = $employees[ $i ]->score;
                    $userRow->num_obj = $employees[ $i ]->version;
                    $userRow->num_calif = $calificacion;

                    if($employees[ $i ]->status > 1){
                        $userRow->num_obj = $employees[ $i ]->version;
                    }else{
                        $userRow->num_obj = $employees[ $i ]->version - 1;    
                    }

                    if($employees[$i]->status > 1){
                        $userRow->objetives = 1;    
                    }else{
                        $userRow->objetives = 0;
                    }

                    if($employees[$i]->status > 2){
                        $userRow->evaluation = 1;    
                    }else{
                        $userRow->evaluation = 0;
                    }
                      
                    $employeesArray[$contador_empleados] = $userRow; 

                    $contador_empleados++;
                }   
            }else{

                if( $employees[ $i ]->numero != $employees[ $i-1 ]->numero){

                    $calificacion = DB::table('eval_scores_log')
                                            ->where('eval_id',$employees[$i]->ideval)
                                            ->count();

                    $userRow = new SEvaluatedEmployee();
                    $userRow->num_employee = $employees[ $i ]->numero;
                    $userRow->name_employee = $employees[ $i ]->colaborador;
                    $userRow->boss_employee = $employees[ $i ]->evaluador;
                    $userRow->depto_employee = $employees[ $i ]->department;
                    $userRow->calificacion = $employees[ $i ]->score;

                    if($employees[ $i ]->status > 1){
                        $userRow->num_obj = $employees[ $i ]->version;
                    }else{
                        $userRow->num_obj = $employees[ $i ]->version - 1;    
                    }

                    $userRow->num_calif = $calificacion;

                    if($employees[$i]->status > 1){
                        $userRow->objetives = 1;    
                    }else{
                        $userRow->objetives = 0;
                    }

                    if($employees[$i]->status > 2){
                        $userRow->evaluation = 1;    
                    }else{
                        $userRow->evaluation = 0;
                    }
                    
                    $employeesArray[$contador_empleados] = $userRow;  
                    
                    $contador_empleados++;
                }
            }
            
        }

        return view('reports.controlgen')->with('employees',$employees)->with('employeesArray',$employeesArray)->with('type',$request->type);
    }
}
