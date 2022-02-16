<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class   Objetive_status_log extends Model
{
    protected $table = 'objetives_status_log';
    protected $primaryKey = 'id_bin';

    public function year(){
        return $this->belongsTo('App\Models\Year','year_id');
    }

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    public function eval_status(){
        return $this->belongsTo('App\Models\Eval_status','eval_status_id');    
    }
}
