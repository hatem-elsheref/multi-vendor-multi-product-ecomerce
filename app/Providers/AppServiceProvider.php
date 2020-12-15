<?php

namespace App\Providers;

use App\Cart;
use App\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!request()->is('admin/*')){
            Paginator::defaultView('pagination::system');
            view()->composer('*', function ($view)
            {
                $categories=Category::with('products')->get();
                if (session()->has('cart'))
                    $cart=new Cart(session('cart')['items'],session('cart')['totalItems'],session('cart')['totalPrice']);
                else
                    $cart=new Cart();
                $view->with('categories', $categories)->with('cart',$cart);
            });

        }


    }
}
