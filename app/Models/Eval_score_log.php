<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eval_score_log extends Model
{
    protected $table = 'eval_scores_log';
    protected $primaryKey = 'id_score';

    public function eval(){
        return $this->belongsTo('App\Models\Eval','eval_id');
    }
}
