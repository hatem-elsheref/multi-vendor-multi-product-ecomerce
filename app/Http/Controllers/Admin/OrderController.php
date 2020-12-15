<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ShippingMail;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{

    private function getOrderes($status){
        $orders=Order::query();
        $orders->where('status',$status)->where('seller_id',auth()->id())->with(['user','items','items.product']);
        return $orders->orderByDesc('id');
    }
    public function pending(){
        $orders=$this->getOrderes(PENDING)->paginate(PAGINATION);

        return view('admin.seller.orders.index',compact('orders'))->with('type','Pending');
    }
    public function shipped(){
        $orders=$this->getOrderes(SHIPPED)->paginate(PAGINATION);
        return view('admin.seller.orders.index',compact('orders'))->with('type','Shipped');
    }
    public function delivered(){
        $orders=$this->getOrderes(DELIVERED)->paginate(PAGINATION);
        return view('admin.seller.orders.index',compact('orders'))->with('type','Delivered');
    }

    public function orderShipped($id,Request $request){
       $request->validate([
           'time_to_shipping'=>'required|numeric|min:1'
       ]);

       $order=Order::with(['user','seller','items','items.product'])->findOrFail($id);
       $order->status=SHIPPED;
       $order->shipping_time=$request->time_to_shipping;
       $order->save();


        foreach ($order->items as $item){
           $product=$item->product;
           $product->qty=$product->qty-$item->quantity;
           $product->save();
       }

       Mail::to($order->user->email)->send(new ShippingMail($order,$request->time_to_shipping));
       success();
       return redirect()->back();

    }

    public function orderDelivered($id){
        $order=Order::findOrFail($id);
        $order->status=DELIVERED;
        $order->save();
        success();
        return redirect()->back();
    }
    public function destroy($id){
        $order=Order::findOrFail($id);
        $order->delete();
        success();
        return redirect()->back();
    }
}

