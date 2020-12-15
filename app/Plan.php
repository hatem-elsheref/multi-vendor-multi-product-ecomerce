<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable=['name','price','period'];
    protected $table='plans';
    public function users(){
        return $this->hasMany('App\User','plan_id','id');
    }

}
