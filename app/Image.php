<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $timestamps=false;
    protected $table='images';
    protected $fillable=['src','product_id'];

    public function product(){
        return $this->belongsTo('App\Product','product_id','id');
    }

    public function src(){
        return uploadedAssets($this->src);
    }
}
