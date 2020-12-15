<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table='order_items';
    protected $fillable=['product_id','order_id','quantity'];
    public function order(){
        return $this->belongsTo('App\Order','order_id','id');
    }
    public function product(){
        return $this->belongsTo('App\Product','product_id','id');
    }
}
