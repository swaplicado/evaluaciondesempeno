<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $table = 'evals';
    protected $primaryKey = 'id_eval';
    
    protected $fillable = [
        'year_id',
        'user_id',
        'version', 
        'eval_user_id',
        'comment',
        'eval_status_id',
        'score',
        'score_id',
        'is_deleted',
        'created_by',
        'updated_by'
    ];

    public function year(){
        return $this->belongsTo('App\Models\Year','year_id');
    }

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    public function eval_status(){
        return $this->belongsTo('App\Models\Eval_status','eval_status_id');
    }
    
    public function score(){
        return $this->belongsTo('App\Models\Score','score_id');
    }

    public function eval_score_log(){
        return $this->hasMany('App\Models\Eval_score_log');
    }

    public function objetive(){
        return $this->hasMany('App\Models\Objetive');
    }
}
