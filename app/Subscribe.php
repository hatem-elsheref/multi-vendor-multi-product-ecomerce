<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    protected $table='subscribes';
    protected $fillable=['user_id','plan_id','transaction_id','status','request_is_expired'];

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
    public function plan(){
        return $this->belongsTo('App\Plan','plan_id','id');
    }
    public function transaction(){
        return $this->belongsTo('App\Transaction','transaction_id','id');
    }
}
