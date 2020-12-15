<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $table='products';
    protected $fillable= ['user_id','name','model','category_id','description','price','qty','colors','sizes','slug','quality_rate','price_rate','value_rate'];

    public function category(){
        return $this->belongsTo('App\Category','category_id','id');
    }
    public function stock(){
        return $this->belongsTo('App\User','user_id','id');
    }
    public function mainImage(){
         return uploadedAssets($this->images->first()->src);
    }
    public function images(){
        return $this->hasMany('App\Image','product_id','id');
    }
    public function avilableQuantity(){
            if($this->qty === 0){
                return 'Out Of The Stock';
            }
            return  $this->qty . 'Available';
    }

    public function slug(){
        $this->slug= Str::slug(strtolower($this->name.' '.$this->id),'-');
        $this->save();
    }

    public function rates(){
        return $this->hasMany('App\ProductRate','product_id','id');
    }



}
