<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductRate extends Model
{
    protected $table='product_rates';
    protected $fillable=[
        'user_id','product_id','quality_rate','price_rate','value_rate','summary'
    ];

    public function product(){
        return $this->belongsTo('App\Product','product_id','id');
    }
    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
}
