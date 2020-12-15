<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(){
        return view('front.pages.auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->status === 'blocked'){
            Auth::logout();
            toast('Your Account Has Been Blocked By System','error');
            return redirect()->route('website');
        }
        else{
            $user=auth()->user();
            if ($user->role === SELLER){
                // if the starting date + the plan period in months less than the current date (now =>allow )
                // else disable or prevent him from accessing the dashboard with message to renew the the plan
                if (Carbon::now()->subMonths($user->plan->period)->greaterThan($user->plan_starting_date)){
                    Auth::logout();
                    toast('Your Plan Has Been Finished Renew It To Be Able To Access','error');
                    return redirect()->route('website');
                }
            }
        }
    }
}
