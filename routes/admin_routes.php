<?php

// for the  product
Route::group(['prefix'=>'product'],function (){
    // to view the available plans
    Route::get('/all','ProductController@getAllProductsToAdmin')->name('products.all');
    Route::get('/{slug}/details','ProductController@show')->name('products.show');
});
// for the  plans
Route::group(['prefix'=>'plan'],function (){
    // to view the available plans
    Route::get('/all','PlanController@index')->name('plans.index');
    // to add new plan
    Route::get('/create','PlanController@create')->name('plans.create');
    // to store the new plan
    Route::post('/create','PlanController@store')->name('plans.store');
    // to edit plan
    Route::get('/edit/{plan}','PlanController@edit')->name('plans.edit');
    // to update the plan
    Route::put('/update/{plan}','PlanController@update')->name('plans.update');
    // to destroy the plan
    Route::delete('/delete/{plan}','PlanController@destroy')->name('plans.destroy');
});
// for the  plan-orders
Route::group(['prefix'=>'plan-orders'],function (){
    // to view the available request plans
    Route::get('/all','PlansOrderController@getAllSubscription')->name('planOrders.index');
    // to approve the order
    Route::post('/approve/{id}','PlansOrderController@approveThePlan')->name('planOrders.approve');
    // to cancel the order
    Route::delete('/delete/{id}','PlansOrderController@destroy')->name('planOrders.destroy');
});
// for the  sellers
Route::group(['prefix'=>'seller'],function (){
    // to view the sellers
    Route::get('/all','SellerController@index')->name('seller.index');
    // to view the seller products
    Route::get('/products/{seller}','SellerController@products')->name('seller.products');
    // to update the seller (block or not)
    Route::put('/update/{seller}/blocking','SellerController@updateStatus')->name('seller.update.status');
    // to update the seller (best seller or not)
    Route::put('/update/{seller}/selling','SellerController@updateSelling')->name('seller.update.selling');
});
// for the  customer
Route::group(['prefix'=>'customer'],function (){
    // to view the customer
    Route::get('/all','CustomerController@index')->name('customer.index');
    // to update the customer
    Route::put('/update/{customer}','CustomerController@update')->name('customer.update');
});
// for the category
Route::group(['prefix'=>'category'],function (){
    // to view the available categories
    Route::get('/all','CategoryController@index')->name('category.index');
    // to edit category
    Route::get('/edit/{cat}','CategoryController@edit')->name('category.edit');
    // to update the category
    Route::put('/update/{cat}','CategoryController@update')->name('category.update');
    // to destroy the category
    Route::delete('/delete/{cat}','CategoryController@destroy')->name('category.destroy');
});

Route::group(['prefix'=>'contacts'],function (){
    // to view the clients messages and support
    Route::get('/all','ContactController@index')->name('contact.index');
    // to reply to the customer problem
    Route::post('/reply','ContactController@reply')->name('contact.reply');
    // to destroy the message
    Route::delete('/delete/{contact}','ContactController@destroy')->name('contact.destroy');
    // to update the status of the message  (read/unread)
    Route::get('/mark-as-read/{contact}','ContactController@update')->name('contact.update');
});

