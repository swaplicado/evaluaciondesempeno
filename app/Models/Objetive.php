<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Objetive extends Model
{
    protected $table = 'objetives';
    protected $primaryKey = 'id_objetive';

    public function evaluation(){
        return $this->belongsTo('App\Models\Evaluation','eval_id');
    }

    public function score(){
        return $this->belongsTo('App\Models\Score','score_id');
    }
}
