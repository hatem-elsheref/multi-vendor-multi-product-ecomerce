<?php
// for the product
Route::group(['prefix'=>''],function (){
    // to control the available products
    Route::resource('/product','ProductController');
    Route::get('/product-classification','ProductController@classify')->name('product.classify');
});
// for the Orders
Route::group(['prefix'=>'orders'],function (){
    Route::get('/new','OrderController@pending')->name('orders.pending');
    Route::get('/shipping','OrderController@shipped')->name('orders.shipping');
    Route::get('/delivered','OrderController@delivered')->name('orders.delivered');
    Route::delete('/delete-the-order/{id}','OrderController@destroy')->name('orders.destroy');
    Route::post('/approve-the-order-shipped/{id}','OrderController@orderShipped')->name('orders.approve');
    Route::post('/approve-the-order-delivered/{id}','OrderController@orderDelivered')->name('orders._delivered');
});
Route::group(['prefix'=>'clients-messages'],function (){
    // to view the clients messages and support
    Route::get('/all','OrderContactController@index')->name('order_contact.index');
    // to reply to the customer problem
    Route::post('/reply','OrderContactController@reply')->name('order_contact.reply');
    // to destroy the message
    Route::delete('/delete/{contact}','OrderContactController@destroy')->name('order_contact.destroy');
    // to update the status of the message  (read/unread)
    Route::get('/mark-as-read/{contact}','OrderContactController@update')->name('order_contact.update');
});
