<?php

namespace App\Http\Middleware;

use Closure;

class AdminAndSellerMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @param null $admin
     * @param null $seller
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle($request, Closure $next,$admin=null,$seller=null)
    {
        if ($admin and $seller){
            if (auth()->user()->role === $admin or auth()->user()->role === $seller)
                return $next($request);
            else
                toast('Your Can\'t Access This Content','error');
                return redirect()->route('website');
        }elseif($admin and ! $seller){
            if (auth()->user()->role === $admin)
                return $next($request);
            else
                toast('Your Can\'t Access This Content','error');
                return redirect()->route('website');
        }elseif ($seller and !$admin){
            if (auth()->user()->role === $seller)
                return $next($request);
            else
                toast('Your Can\'t Access This Content','error');
                return redirect()->route('website');
        }else
            toast('Your Can\'t Access This Content','error');
            return redirect()->route('website');


    }
}
