<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderContacts;
use App\Plan;
use App\Product;
use App\Subscribe;
use App\User;
use Cassandra\Custom;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $this->user=auth()->user();
        if ($this->user->role === ADMIN){
            return view('admin.index',$this->adminIndexData());
        }elseif ($this->user->role === SELLER){
            return view('admin.seller.index',$this->sellerIndexData());
        }else{
            abort(403);
        }
    }
    private function adminIndexData(){
        $data=[];
        $data['customers']  =User::where('role',CUSTOMER)->count();
        $data['sellers']    =User::where('role',SELLER)->count();
        $data['category']   =Category::get()->count();
        $data['products']   =Product::count();
        $data['plans']      =Plan::count();
        $data['plan_orders']=Subscribe::count();

        $data['daily_orders']=Order::whereDay('created_at',now())->count();
        $data['price_of_total_products']=Order::whereMonth('created_at',now())->sum('total');
        $data['price_of_daily_orders']=Order::whereDay('created_at',now())->where('status',DELIVERED)->sum('total');
        $data['shipped_orders']=Order::where('status',SHIPPED)->count();
        $data['pending_orders']=Order::where('status',PENDING)->count();
        $data['delivered_orders']=Order::where('status',DELIVERED)->count();
        return $data;
    }
    public function sellerIndexData(){
        $user=auth()->user();
        $data=[];
        $data['category']   =Category::get()->count();
        $data['products']   =Product::where('user_id',$user->id)->count();
        $data['daily_orders']=Order::whereDay('created_at',now())->where('seller_id',$user->id)->where('seller_id',$user->id)->count();
        $data['price_of_total_products']=Order::whereMonth('created_at',now())->where('seller_id',$user->id)->select('total')->sum('total');
        $data['price_of_daily_orders']=Order::whereDay('created_at',now())->where('seller_id',$user->id)->where('status',DELIVERED)->sum('total');
        $data['shipped_orders']=Order::where('status',SHIPPED)->where('seller_id',$user->id)->count();
        $data['pending_orders']=Order::where('status',PENDING)->where('seller_id',$user->id)->count();
        $data['delivered_orders']=Order::where('status',DELIVERED)->where('seller_id',$user->id)->count();

        return $data;
    }
}
