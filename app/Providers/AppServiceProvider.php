<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        \Gate::define('isAdmin', function($user){
            $rol = DB::table('user_rol')->where('user_id',$user->id)->get();

            return $rol[0]->rol_id == 1;     
        });

        \Gate::define('doEvaluation', function($user){
            return $user->do_evaluation == 1;
        });
    }
}
