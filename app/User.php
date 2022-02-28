<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    public function adminlte_desc(){

        return $this->department->name. ' - '. $this->job->name;
    }
}
