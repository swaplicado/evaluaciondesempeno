<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username(){
        return 'name';
    }

    public function showLoginForm(){
        $years = \DB::table('config_years')->where('is_deleted',0)->select('id_year','year')->get();
        $current_year = $years->where('year',date('Y'))->first();
        return view('auth.login', ['years' => $years, 'current_year' => $current_year]);
    }

    public function authenticate(Request $request)
    {
        $values = json_decode($request->year);
        $request->validate([
            'name' => 'required', 
            'password' => 'required'
        ]);
        if (Auth::attempt(['name' => $request->name, 'password' => $request->password])) {
            $existEval = \DB::table('evals')
                            ->where([
                                ['user_id',Auth()->user()->id],
                                ['year_id',$values->id_year],
                                ['is_deleted',0]
                                ])
                            ->first();
                            
            if(is_null($existEval) && !(auth()->user()->is_Admin())){
                Auth::logout();
                // return $this->sendFailedLoginResponse($request);
                return redirect('login')->withErrors(['year' => ['No existen evaluaciones para el año seleccionado.']]);
            }else{
                $status = \DB::table('config_years')->where([['is_deleted',0],['id_year',$values->id_year]])->value('status_id');
                $allYears = \DB::table('config_years')->where('is_deleted',0)->select('id_year','year','status_id')->get();
                session(['id_year' => $values->id_year, 'year' => $values->year, 'status_year' => $status, 'allYears' => $allYears]);
                return redirect()->intended('home');
            }
        } else {
            return $this->sendFailedLoginResponse($request);
        }
    }
}
