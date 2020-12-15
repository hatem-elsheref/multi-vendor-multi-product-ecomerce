<?php

namespace App\Http\Controllers\Front;

use App\Cart;
use App\Category;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderItem;
use App\Product;
use App\Rules\ValidateEmail;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    public function shopView(){
//        $products=Product::with(['rates','stock','category','images'])->orderByDesc('id')->paginate(PAGINATION);
        $products=Product::with(['stock','category','images'])->orderByDesc('id')->paginate(PAGINATION);

        return view('front.shop',compact('products'));
    }

    public function searchByCategory($categoryName){
        $category=Category::where('name',$categoryName)->firstOrFail();
//        $products=Product::with(['rates','stock','category','images'])->where('category_id',$category->id)->orderByDesc('id')->paginate(PAGINATION);
        $products=Product::with(['stock','category','images'])->where('category_id',$category->id)->orderByDesc('id')->paginate(PAGINATION);
        return view('front.shop',compact('products'));
    }

    public function searchByKeyWork(Request $request){
//        $products=Product::with(['rates','stock','category','images'])
        $products=Product::with(['stock','category','images'])
            ->where('name','like','%'.$request->q.'%')
            ->orWhere('model','like','%'.$request->q.'%')
            ->orWhere('slug','like','%'.$request->q.'%')
            ->orWhere('description','like','%'.$request->q.'%')
            ->orWhere('price',$request->q)
            ->orderByDesc('id')->paginate(PAGINATION);
        return view('front.shop',compact('products'));
    }

    public function searchByPrice(Request $request){
        if (!empty($request->price)){
            $price=$request->price;
            $price=explode('-',$price);
            $minPrice=str_replace('$','',$price[0]);
            $maxPrice=str_replace('$','',$price[1]);
//            $products=Product::with(['rates','stock','category','images'])->whereBetween('price',[$minPrice,$maxPrice])->orderByDesc('id')->paginate(PAGINATION);
            $products=Product::with(['stock','category','images'])->whereBetween('price',[$minPrice,$maxPrice])->orderByDesc('id')->paginate(PAGINATION);
            return view('front.shop',compact('products'));
        }

        return redirect()->back();
    }

    public function searchByProductSlug($slug){
//        $product=Product::with(['rates','stock','category','images'])->where('slug',$slug)->firstOrFail();
        $product=Product::with(['stock','category','images'])->where('slug',$slug)->firstOrFail();
        $relatedProducts=Product::with(['stock','category','images'])->where('category_id',$product->category_id)->take(TOP)->get();
        return view('front.details',compact('product'))->with('relatedProducts',$relatedProducts);
    }

    public function addToCart($productSlug,Request $request){

        if (session()->has('cart')){
            $cart=new Cart(session('cart')['items'],session('cart')['totalItems'],session('cart')['totalPrice']);
        }else{
            $cart=new Cart([],0,0);
        }

        $product=Product::where('slug',$productSlug)->firstOrFail();
        if ($request->has('qty') and is_numeric($request->qty) and $request->qty > 0 and $request->qty <= $product->qty){
            $cart->certainQuantity=$request->qty;
        }
        if ($product->qty >0){
            if ($cart->addToCart($product)){
                session()->forget('cart');
                session()->put('cart',['items'=>$cart->getItems(),'totalPrice'=>$cart->getTotalPrice(),'totalItems'=>$cart->getTotalItems()]);
                success('Product Added To Cart Successfully !!');
            }
            else
                fail('Failed To Add The Product To Cart !!');
        }else{
            fail('Sorry This Product Out Of Stock !!');
        }

        return redirect()->back();
    }

    public function removeFromCart($productSlug){
        if (session()->has('cart')){
            $product=Product::where('slug',$productSlug)->firstOrFail();
            $cart=new Cart(session('cart')['items'],session('cart')['totalItems'],session('cart')['totalPrice']);
            if ($cart->removeFromCart($product)){
                session()->forget('cart');
                session()->put('cart',['items'=>$cart->getItems(),'totalPrice'=>$cart->getTotalPrice(),'totalItems'=>$cart->getTotalItems()]);
                success('Product Removed From Cart Successfully !!');
            }else{
                fail('Product Not Exist In Cart  !!');
            }
        }else{
            fail('Sorry This Cart Is Empty !!');
        }

        return redirect()->back();
    }

    public function updateCart(Request $request){
        $request->all([
            'product'=>'required|array',
            'product.*'=>'required|numeric',
        ]);
       $products=Product::whereIn('id',array_keys($request->product))->get();
       $cartSession=session()->get('cart');
       $cart=new Cart($cartSession['items'],$cartSession['totalItems'],$cartSession['totalPrice']);
       foreach ($products as $product){
           $cart->removeFromCart($product);
       }
        foreach ($products as $product){
            $cart->certainQuantity=$request->product[$product->id];
            $cart->addToCart($product);
        }
        session()->forget('cart');
        session()->put('cart',['items'=>$cart->getItems(),'totalPrice'=>$cart->getTotalPrice(),'totalItems'=>$cart->getTotalItems()]);
        success('Cart Updated Successfully !!');
        return redirect()->back();
    }
    public function cartView(){
        return view('front.cart');
    }

    public function checkoutOrderView(){
        return view('front.checkout-product');
    }
    public function checkoutOrder(Request $request){
        $request->validate([
            'first_name' =>'required|string|max:191',
            'last_name'  =>'required|string|max:191',
            'company'    =>'required|string|max:191',
            'country'    =>'required|string|exists:countries,name',
            'address'    =>'required|string|max:191',
            'city'       =>'required|string|max:191',
            'postcode'   =>'required|numeric',
            'phone'      =>'required|numeric',
            'email'      =>['required','email','max:191',new ValidateEmail()],
            'gateway'    =>'required|in:cod,gateway'
        ]);

        $validatedData=$request->except(['_token']);
        $validatedData['status'] =PENDING;
        $validatedData['user_id']=auth()->id();


        $cartSession=session()->get('cart');
        $cart=new Cart($cartSession['items'],$cartSession['totalItems'],$cartSession['totalPrice']);
        $ids=array_column($cart->getItems(),'id');
        $products=Product::whereIn('id',$ids)->get();
        $validatedData['total']=getTotalCost($cart->getTotalPrice());


        $sellers=[];
        foreach ($products as $product)
            array_push($sellers,$product->user_id);
        $sellers=array_unique($sellers);


        foreach ($sellers as $seller){
            $validatedData['seller_id']=$seller;
            $validatedData['trace_code']=uniqid(config('app.name').'_',true);
            $order=Order::create($validatedData);

            $sellerProducts=$products->where('user_id',$seller);

            foreach ($sellerProducts as $product){
                OrderItem::create([
                    'order_id'  =>$order->id,
                    'product_id'=>$product->id,
                    'quantity'  =>$this->getTheQuantity($cart,$product->id)
                ]);
            }
        }

        $message='Order Requested Successfully Wait The Seller To Approve The Request !!';
        success($message);
        session()->forget('cart');
        return redirect()->back()->with('response',['type'=>'success','message'=>$message]);

//        if ($order){
//           foreach ($products as $product){
//               OrderItem::create([
//                   'order_id'  =>$order->id,
//                   'product_id'=>$product->id,
//                   'quantity'  =>$this->getTheQuantity($cart,$product->id)
//            ]);
//           }
//           $message='Order Requested Successfully Wait The Seller To Approve The Request !!';
//           success($message);
//           session()->forget('cart');
//            return redirect()->back()->with('response',['type'=>'success','message'=>$message]);
//        }else{
//            return redirect()->back()->with('response',['type'=>'danger','message'=>'Invalid Operation']);
//        }

    }

    private function getTheQuantity($products,$id){
        return collect($products->getItems())->where('id',$id)->pluck('qty')->toArray()[0];
    }

}
