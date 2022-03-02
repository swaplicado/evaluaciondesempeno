<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $table = 'config_scores';
    protected $primaryKey = 'id_score';

    public function evaluation(){
        return $this->hasMany('App\Models\Evaluation');
    }

    public function objetive(){
        return $this->hasMany('App\Models\Objetive');
    }
}
