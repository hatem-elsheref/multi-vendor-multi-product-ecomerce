<?php
// some general constants
use App\ProductRate;

define('PAGINATION',12);
define('TOP',10);
define('DEFAULT_PRODUCT','default-product.png');
define('COD','COD');
define('GATEWAY','GATEWAY');
define('PENDING','pending');
define('APPROVED','approved');
define('SHIPPED','shipped');
define('DELIVERED','delivered');
define('COUPON',false);
define('SHIPPING',true);
define('SHIPPING_COST',14);


// the three (3) main roles in system
define('ADMIN','admin');
define('SELLER','seller');
define('CUSTOMER','customer');

// the prefix of admin panel
define('ADMIN_PREFIX','admin');

// function to active the current url
if (!function_exists('inTheCurrentRoute')){
    function inTheCurrentRoute($route,$other=null){
        if (request()->is('admin/'.$route) or request()->is('admin/'.$other) ){
            return  'active';
        }else{
            return (\Illuminate\Support\Facades\Route::getCurrentRoute()->getName() === $route)? 'active':'';
        }

    }
}

// function to toast success
if (!function_exists('success')){
    function success($message='Success Operation'){
        toast($message,'success');
    }
}
// function to toast fail
if (!function_exists('fail')){
    function fail($message='Failed Operation'){
        toast($message,'error');
    }
}

// function return basic and static Attributes
if (!function_exists('unitsAvailable')){
    function unitsAvailable(){
        return ['G','KG','Ton','M','CM'];
    }
}

// function return basic and static Attributes
if (!function_exists('sizesAvailable')){
    function sizesAvailable(){
        return [
            'CLOTHES'=>['S','M','L','XL','2XL','3XL'],
            'SHOES'  =>['39','40','41','42','43','44','45'],
            'FOODS'  =>['SMALL','MEDIUM','LARGE'],
            'SCREENS'=>[5,7,9,11,13,15,17,19,21,23,25,27,29,30,32,34,36,40,45,47,49,51,52,55,60,65,70],
//            'WIDTH|HEIGHT|LENGTH'=>['METER','CENTI METER'],

        ];
    }
}


// function return basic and static Attributes
if (!function_exists('colorsAvailable')){
    function colorsAvailable(){
        return [
            'White'  =>'#FFFFFF'    ,
            'Silver' =>'#C0C0C0',
            'Gray'   =>'#808080',
            'Black'  =>'#000000',
            'Red'    =>'#FF0000',
            'Maroon' =>'#800000',
            'Yellow' =>'#FFFF00',
            'Olive'  =>'#808000',
            'Lime'   =>'#00FF00',
            'Green'  =>'#008000',
            'Aqua'   =>'#00FFFF',
            'Teal'   =>'#008080',
            'Blue'   =>'#0000FF',
            'Navy'   =>'#000080',
            'Fuchsia'=>'#FF00FF',
            'Purple' =>'#800080',
        ];
    }
}


// get All Countries
if (!function_exists('countries')) {
    function countries(){
        return \Illuminate\Support\Facades\DB::table('countries')->select('name')->get();
    }
}

// check if the user is allowed
if (!function_exists('validateTheUserPlan')) {
    function validateTheUserPlan($plan){
        return \Illuminate\Support\Facades\DB::table('countries')->select('name')->get();
    }
}


// check if the user make review to a given product or not
if (!function_exists('ifCustomerHasReview')) {
    function ifCustomerHasReview($product){
        if (auth()->check()){
            $item=ProductRate::where('user_id',auth()->id())->where('product_id',$product->id)->first();
            if ($item)
                return $item;
            return false;
        }else{
            return  false;
        }
    }
}

// calculate the product total rate
if (!function_exists('getProductRate')) {
    function getProductRate($product,$by='quality_rate'){
        $data=[1=>0,2=>0,3=>0,4=>0,5=>0];
        $total=0;
        $rates=$product->rates->groupBy($by)->toArray();
        foreach ($rates as $index => $values){
            $data[$index]=count($values);
            $total+=count($values);
        }
        if ($total == 0)
            return  0;

        return round((($data[1]*1)+($data[2]*2)+($data[3]*3)+($data[4]*4)+($data[5]*5))/$total);
    }
}




// calculate the cart cost and shipping
if (!function_exists('getTotalCost')) {
    function getTotalCost($cartTotalPrice){
        if (SHIPPING)
            return (SHIPPING_COST*$cartTotalPrice)+$cartTotalPrice;
        else
            return $cartTotalPrice;
    }
}
