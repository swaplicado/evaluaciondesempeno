<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'user_rol';
    protected $primarykey = 'id';

    protected $fillable = ['user_id', 'rol_id'];

    public function roles(){
        return $this->hasMany('App\Role', 'id')->get();
    }
}
