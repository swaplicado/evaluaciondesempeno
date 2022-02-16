<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    protected $table = 'config_years';
    protected $primaryKey = 'id_year';

    public function indicator(){
        return $this->hasMany('App\Models\Indicator');
    }

    public function indicator_status_log(){
        return $this->hasMany('App\Models\Indicator_status_log');    
    }
}
