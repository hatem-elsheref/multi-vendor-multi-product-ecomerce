<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table='transactions';
    protected $fillable=['first_name','last_name','company','country','method','gateway_transaction_checkout_id',
    'city','address','postcode','phone','email','user_id','plan_id','total'];
    protected function user()
    {
        $this->belongsTo('App\User','user_id','id');
    }
    protected function plan()
    {
        $this->belongsTo('App\Plan','plan_id','id');
    }
}
