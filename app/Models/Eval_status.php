<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eval_status extends Model
{
    protected $table = 'sys_eval_status';
    protected $primaryKey = 'id_eval_status';

    public function eval(){
        return $this->hasMany('App\Models\Eval');
    }

    public function objetive_status_log(){
        return $this->hasMany('App\Models\Objetive_status_log');    
    }
}
