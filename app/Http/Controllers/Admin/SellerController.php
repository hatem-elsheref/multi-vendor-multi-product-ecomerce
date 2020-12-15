<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use App\User;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function index(Request $request){
        $sellers=User::with(['plan'])->where('role',SELLER)->where(function ($query) use($request){
            $query->when($request->search,function ($q) use ($request){
                $q->where('name','like','%'.$request->search.'%')
                    ->orWhere('stock','like','%'.$request->search.'%')
                    ->orWhere('plan_id',$request->search)
                    ->orWhere('email','like','%'.$request->search.'%');
            });
        })->orderByDesc('id')->paginate(PAGINATION);

        return view('admin.sellers-view',compact('sellers'));
    }

    public function products(Request $request,$seller){
        $products=Product::with(['stock','category','images'])->where('user_id',$seller)->where(function ($query) use($request){
            $query->when($request->search,function ($q) use ($request){
                $q->where('name','like','%'.$request->search.'%')
                    ->orWhere('model','like','%'.$request->search.'%')
                    ->orWhere('description','like','%'.$request->search.'%');
            });
        })->orderByDesc('id')->paginate(PAGINATION);

        return view('admin.seller.products.search-custom',compact('products'));
    }

    public function updateStatus(Request $request,$sell){
        $seller=User::where('id',$sell)->firstOrFail();
        if ($request->id == $seller->id){
            if ($seller->status === 'blocked'){
                $seller->status='unblocked';
                $seller->save();
            }else{
                $seller->status='blocked';
                $seller->save();
            }
            success();
            return redirect()->back();
        }
        fail();
        return redirect()->back();
    }

    public function updateSelling(Request $request,$sell){
        $seller=User::where('id',$sell)->firstOrFail();
        if ($request->id == $seller->id){
            if ($seller->is_best_seller){
                $seller->is_best_seller=false;
                $seller->save();
            }else{
                $seller->is_best_seller=true;
                $seller->save();
            }
            success();
            return redirect()->back();
        }
        fail();
        return redirect()->back();
    }
}
