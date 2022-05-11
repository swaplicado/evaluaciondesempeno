<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use App\Models\Evaluation;
use App\Models\Year;

class assigntEvalController extends Controller
{
    public function index(){
        $users = \DB::table('users')
                    ->where(function ($query) {
                        $query->where('is_active', 1)
                              ->orWhere('is_active', NULL);
                    })
                    ->where(function ($query) {
                        $query->where('is_delete', 0)
                              ->orWhere('is_delete', NULL);
                    })
                    ->where('id', '!=', 1)
                    ->select('id','full_name')
                    ->orderBy('full_name')
                    ->get();

        return view('assigntEval.index',['users' => $users]);
    }

    public function storage(Request $request){
        try {
            DB::transaction(function () use ($request) {
                foreach($request->evaluando as $evaluado){
                    $eval = Evaluation::create([
                        'year_id' => session()->get('id_year'),
                        'user_id' => $evaluado,
                        'version' => 1,
                        'eval_user_id' => $request->evaluador,
                        'eval_status_id' => 1,
                        'is_deleted' => 0,
                        'created_by' => \Auth()->user()->id,
                        'updated_by' => \Auth()->user()->id
                    ]);
                }
            });
            $icon =  'success';
            $msg = 'Registros guardados con exitó';
        } catch (QueryException $e) {
            $icon =  'error';
            $msg = 'Error al guardar los registros';
        } catch (\Exception $e) {
            $icon =  'error';
            $msg = 'Error al guardar los registros';
        }

        return redirect(route('assignt_eval'))->with(['message' => $msg, 'icon' => $icon]);
    }
}
