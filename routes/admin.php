<?php
use \Illuminate\Support\Facades\Route;
// this routes related to the admin and seller
Route::group(['prefix'=>ADMIN_PREFIX,'middleware'=>['auth:web']],function(){
    // for both admin and seller
    Route::group(['middleware'=>'dashboard:'.ADMIN.','.SELLER],function (){
        // for the index of dashboard for both admin and seller
        Route::get('/','AdminController@index')->name('dashboard');

        // for the  account/profile
        Route::group(['prefix'=>'account'],function (){
            // to view the available plans
            Route::get('/view','AccountController@viewProfile')->name('account.view');
            // to add new plan
            Route::put('/edit-information','AccountController@updateInformation')->name('account.update');
            // to reset the current auth user (admin-seller) plan
            Route::put('/reset-password','AccountController@resetPassword')->name('account.reset');
        });

        // for the category
        Route::group(['prefix'=>'category'],function (){
            // to view the available categories
            Route::get('/show','CategoryController@show')->name('category.show');
            // to add new category
            Route::get('/create','CategoryController@create')->name('category.create');
            // to store the new category
            Route::post('/create','CategoryController@store')->name('category.store');
        });

    });
    // for admin only
    Route::group(['middleware'=>['dashboard:'.ADMIN]],function (){
        require_once 'admin_routes.php';
    });
    // for seller only
    Route::group(['middleware'=>['dashboard:'.SELLER]],function (){
        require_once 'seller_routes.php';
    });


});
