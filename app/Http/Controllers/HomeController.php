<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $config = \App\SUtils\SConfiguration::getConfigurations();
        $fecha = $config->date;
        $limite = Carbon::parse($fecha)->endOfDay();
        $actual = Carbon::now();
        $diferencia = $limite->diffInDays($actual);
        if($actual->greaterThan($limite)){
            $diferencia = -1;
        }
        $tipo = 0;
        if($diferencia > 0){
            $tipo = 1;
        }elseif($diferencia == 0){
            $tipo = 2;
        }else{
            $tipo = 3;
        }
        
        return view('home')->with('diferencia',$diferencia)->with('tipo',$tipo)->with('limite',$limite);
    }
}
