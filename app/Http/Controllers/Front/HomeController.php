<?php

namespace App\Http\Controllers\Front;

use App\Category;
use App\Order;
use App\Product;
use App\Plan;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $products=Product::with(['stock','category','images'])->orderByDesc('id')->take(TOP)->get();
        $latestCategories=Category::whereHas('products')->with(['products','products.stock','products.category','products.images'])->orderByDesc('id')->take(6)->get();
        $plans=Plan::all();
        $bestSellers=User::where('role',SELLER)->where('status','unblocked')->where('is_best_seller',true)->get();
        $data['products']=$products;
        $data['latestCategories']=$latestCategories;
        $data['plans']=$plans;
        $data['bestSellers']=$bestSellers;
        return view('front.index',$data);
    }

    public function trackView(){
        return view('front.pages.trace');
    }

    public function track(Request $request){
        if (!($request->has('code') and !empty($request->code)) )
            return redirect()->back()->with('response',['message'=>'Please Enter Valid Trace Code !!','type'=>'danger']);

        $order=Order::with(['items','items.product'])->where('trace_code',$request->code)->first();
        if (!$order){
            return redirect()->back()->with('response',['message'=>'Undefined Trace Code !!','type'=>'danger']);
        }
         return view('front.pages.trace',compact('order'));


    }
}
