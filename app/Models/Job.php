<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'jobs';
    protected $primaryKey = 'id_job';

    public function department(){
        return $this->belongsTo('App\Models\Department','department_id');
    }

    public function user(){
        return $this->hasMany('App\User');
    }
}
