<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    protected $table = 'config_years';
    protected $primaryKey = 'id_year';

    protected $fillable = [
        'year',
        'status_id',
        'config',
        'is_deleted', 
        'created_by',
        'updated_by'
    ];

    public function indicator(){
        return $this->hasMany('App\Models\Indicator');
    }

    public function indicator_status_log(){
        return $this->hasMany('App\Models\Indicator_status_log');    
    }
}
