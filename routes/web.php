<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace'=>'Front'],function (){
    Route::get('/', 'HomeController@index')->name('website');
    Route::get('/subscribe-to-plan/{plan}', 'IndexController@subscribeView')->name('checkout.plan.show')->middleware('auth');
    Route::post('/subscribe-to-plan/{plan}', 'IndexController@checkoutPlan')->name('checkout.plan')->middleware('auth');
    Route::post('/check-before-subscribe-to-plan', 'IndexController@ConfirmToChangeThePlan')->name('checkout.confirm');
    Route::post('/subscribe-to-our-news-letter', 'IndexController@newsLetter')->name('news_letter');

    // ORDERS AND CART AND TRACK ORDER ADN PAYMENT ADN RATE

    Route::post('/rate-product/{product}', 'IndexController@rateProduct')->name('product.rate')->middleware('auth');



    // tracking
    Route::get('/track-your-order', 'HomeController@trackView')->name('trace');
    Route::post('/track-your-order', 'HomeController@track')->name('trace.search');

    // for my account
    Route::get('/account', 'AccountController@viewProfile')->name('account')->middleware('auth');
    Route::put('/update-my-account-information', 'AccountController@updateInformation')->name('account.information')->middleware('auth');
    Route::put('/reset-my-account-password', 'AccountController@resetPassword')->name('account.password')->middleware('auth');



    Route::get('/contact', 'PageController@contactView')->name('contact');
    Route::post('/contact', 'PageController@contact')->name('contact.send');
    Route::post('/contact-seller', 'PageController@contactSeller')->name('contact.seller')->middleware('auth');
    Route::get('/about', 'PageController@aboutView')->name('about');
    Route::get('/shop', 'ShopController@shopView')->name('shop');
    Route::get('/search-by-keyword', 'ShopController@searchByKeyWork')->name('keyword.search');
    Route::get('/search-by-price', 'ShopController@searchByPrice')->name('price.search');
    Route::get('/category/{category}', 'ShopController@searchByCategory')->name('category.search');
    Route::get('/product-details/{slug}', 'ShopController@searchByProductSlug')->name('product.details');
    Route::get('/add-product-to-cart/{slug}', 'ShopController@addToCart')->name('cart.add');
    Route::get('/remove-product-from-cart/{slug}', 'ShopController@removeFromCart')->name('cart.remove');
    Route::post('/update-cart', 'ShopController@updateCart')->name('cart.update');
    Route::get('/cart', 'ShopController@cartView')->name('cart.view');
    Route::get('/checkout', 'ShopController@checkoutOrderView')->name('cart.checkout.view')->middleware('auth');
    Route::post('/checkout', 'ShopController@checkoutOrder')->name('checkout.product')->middleware('auth');

});

Auth::routes();
