<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class CustomerController extends Controller
{
    public function index(Request $request){
        $customers=User::with(['plan'])->where('role',CUSTOMER)->where(function ($query) use($request){
            $query->when($request->search,function ($q) use ($request){
                $q->where('name','like','%'.$request->search.'%')
                    ->orWhere('email','like','%'.$request->search.'%');
            });
        })->orderByDesc('id')->paginate(PAGINATION);

        return view('admin.customers-view',compact('customers'));
    }

    public function update(Request $request,$custo){
        $customer=User::where('id',$custo)->firstOrFail();
        if ($request->id == $customer->id){
            if ($customer->status === 'blocked'){
                $customer->status='unblocked';
                $customer->save();
            }else{
                $customer->status='blocked';
                $customer->save();
            }
            success();
            return redirect()->back();
        }
        fail();
        return redirect()->back();
    }


}
