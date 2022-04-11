<?php namespace App\SUtils;

use DB;
use App\SUtils\SEvaluatedEmployee;
use Carbon\Carbon;

class SEvaluated {
    //Tipo 1 empleados que calificas
    //Tipo 2 empleados que calificas y piramide hacia abajo
    //Tipo 3 Todos los empleados
    public static function getEmployees($id_user,$type)
    {
        switch($type){
            case 1:
                $employees = DB::table('evals')
                                    ->join('users', 'evals.user_id', '=', 'users.id')
                                    ->where('evals.eval_user_id',$id_user)
                                    ->where('evals.is_deleted',0)
                                    ->where('year_id',1)
                                    ->pluck('users.id')
                                    ->toArray();
                
                return $employees;
                break;
            case 2:
                $employees = DB::table('evals')
                                    ->join('users', 'evals.user_id', '=', 'users.id')
                                    ->where('evals.eval_user_id',$id_user)
                                    ->where('evals.is_deleted',0)
                                    ->where('year_id',1)
                                    ->pluck('users.id')
                                    ->toArray();

                $evaluated = SEvaluated::getEvaluatedOfEmployees($employees);
                
                return $evaluated;
                break;
            case 3:
                $employees = DB::table('evals')
                                    ->join('users', 'evals.user_id', '=', 'users.id')
                                    ->where('evals.is_deleted',0)
                                    ->where('year_id',1)
                                    ->pluck('users.id')
                                    ->toArray();
                
                return $employees;
                break;
        }

    }

    public static function getEvaluatedOfEmployees($employees){
        $lEmployees = [];
        $lEmployees = array_merge($lEmployees,$employees);

        foreach ($employees as $employee) {
            $evaluated = SEvaluated::getEvaluated($employee);
            if (count($evaluated) > 0) {
                $evaluatedEmployee = SEvaluated::getEvaluatedOfEmployees($evaluated);
                $lEmployees = array_merge($lEmployees, $evaluatedEmployee);
            }
        } 
        
        return array_unique($lEmployees);
    }

    public static function getEvaluated($idEmployee){
        $evaluated = DB::table('evals')
                            ->join('users', 'evals.user_id', '=', 'users.id')
                            ->where('evals.eval_user_id',$idEmployee)
                            ->where('evals.is_deleted',0)
                            ->where('year_id',1)
                            ->pluck('users.id')
                            ->toArray();
        
        return $evaluated;
    }

}

?>