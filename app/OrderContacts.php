<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderContacts extends Model
{
    protected $table='order_contacts';
    protected $fillable=['email','subject','message','status','order','user_id'];
    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
    public function relatedOrder()
    {
        return $this->belongsTo('App\Order','order','id');
    }
}
