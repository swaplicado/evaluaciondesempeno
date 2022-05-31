<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'num_employee',
        'department_id',
        'job_id',
        'password',
        'do_evaluation',
        'firt_name',
        'last_name',
        'full_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function department(){
        return $this->belongsTo('App\Models\Department','department_id');
    }

    public function job(){
        return $this->belongsTo('App\Models\Job','job_id');
    }

    public function eval(){
        return $this->hasMany('App\Models\Eval');
    }

    public function eval_status_log(){
        return $this->hasMany('App\Models\Eval_status_log');    
    }

    public function is_Admin(){
        $rol = \DB::table('user_rol')->where('user_id', auth()->user()->id)->value('rol_id');
        if($rol == 1){
            return true;
        }else{
            return false;
        }
    }

    public function check_year($id_year){
        $status = \DB::table('config_years')->where('id_year',$id_year)->value('status_id');
        if($status == 3){
            session()->put('status_year', 3);
            return true;
        }
        return false;
    }

    public function adminlte_desc(){

        return $this->department->name. ' - '. $this->job->name;
    }
    
    public function roles() {
        return $this->belongsToMany(Role::class, 'user_rol', 'user_id', 'rol_id');
    }
}
