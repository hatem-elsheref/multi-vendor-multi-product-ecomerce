<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table='orders';
    protected $fillable=['first_name','last_name','company','country','method','gateway_transaction_checkout_id',
        'city','address','postcode','phone','email','user_id','status','total','seller_id','trace_code','shipping_time'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
    public function seller()
    {
        return $this->belongsTo('App\User','seller_id','id');
    }
    public function items()
    {
        return $this->hasMany('App\OrderItem','order_id','id');
    }
}
