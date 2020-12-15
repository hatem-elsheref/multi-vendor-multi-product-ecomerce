<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','image','role','plan_id','status','plan_starting_date','stock','is_best_seller'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

//    public function getImageAttribute($value){
//        return uploadedAssets($value);
//    }
    public function plan(){
        return $this->belongsTo('App\Plan','plan_id','id');
    }
    public function products(){
        return $this->hasMany('App\Product','user_id','id');
    }
    public function transactions(){
        return $this->hasMany('App\Transaction','user_id','id');
    }
    public function orders(){
        return $this->hasMany('App\Order','user_id','id');
    }
}
