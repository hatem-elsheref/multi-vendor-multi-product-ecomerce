<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ApproveThePlanEmail;
use App\Plan;
use Illuminate\Http\Request;
use App\Subscribe;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PlansOrderController extends Controller
{
    public function getAllSubscription(){
//        $users=Subscribe::select('id','user_id')->pluck('user_id','id')->toArray();
//        $users=array_keys(array_unique($users));
        $pending =$this->getCustomerWithPlansOrders(PENDING);
        $approved=$this->getCustomerWithPlansOrders(APPROVED);
        return view('admin.subscribers',compact('pending'))->with('approved',$approved);
    }

    public function approveThePlan(Request $request,$id){
        $item=Subscribe::findOrFail($id);
        if ($item->id != $request->id){
            fail("Invalid Order !!!");
            return redirect()->route('planOrders.index');
        }
        $item->status=APPROVED;
        $item->save();

        $user=$item->user;
        $user->plan_id=$item->plan_id;
        $user->role=SELLER;
        $user->plan_starting_date=now();
        $user->save();

        Subscribe::where('request_is_expired',false)->where('status',PENDING)->where('user_id',$user->id)->update(['request_is_expired'=>true]);
        success();




        // send Mail
        Mail::to($user->email)->send(new ApproveThePlanEmail($user,$item->plan));

        return redirect()->route('planOrders.index');
    }
    public function destroy($id){
        $item=Subscribe::findOrFail($id);
        $item->delete();
        success();
        return redirect()->route('planOrders.index');
    }


    private function getCustomerWithPlansOrders($status=null,$users=null){
        $data=Subscribe::with(['user','transaction','plan'])->where('request_is_expired',false)
            ->orderByDesc('created_at')->orderByDesc('user_id');
        if($users)
             $data=$data->whereIn('subscribes.id',$users);
        if ($status)
            $data=$data->where('status',$status);
        return $data->paginate(PAGINATION);
    }

}
