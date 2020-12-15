<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Plan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class PlanController extends Controller
{

    public function index(){
        $users=User::where('role',SELLER)->count();
        $plans=Plan::with(['users'=>function($query){
            $query->count();
        }])->orderByDesc('id')->get();
//        dd($plans[1]->users->count());
        return view('admin.plans.index',compact('plans'))->with('users',$users);
    }

    public function create(){
        return view('admin.plans.create');
    }

    public function store(Request $request){
        $request->validate([
            'name'  =>'required|string|max:191|unique:plans,name',
            'period'=>['required','numeric',Rule::in([1,2,3,4,5,6,7,8,9,10,11,12])],
            'price' =>'required|numeric'
        ]);
        $plan=Plan::create($request->except('_token'));
        if ($plan)
            success();
        else
            fail();
        return redirect()->route('plans.index');

    }

    public function edit($plan){
        // check if the plan exist or not
        $plan=Plan::findOrFail($plan);
        /// plan not founded
        if (!$plan){
            fail("Not Found Plan ...");
            return redirect()->route('plans.index');
        }
        return view('admin.plans.edit',compact('plan'));
    }

    public function update(Request $request,$plan){
        // check if the plan exist or not
        $plan=Plan::findOrFail($plan);
        /// plan not founded
        if (!$plan){
            fail("Not Found Plan ...");
            return redirect()->route('plans.index');
        }
        $request->validate([
            'name'=>['required','string','max:191',Rule::unique('plans','name')->ignore($plan->id)],
            'period'=>['required','numeric',Rule::in([1,2,3,4,5,6,7,8,9,10,11,12])],
            'price' =>'required|numeric'
        ]);
        if ( $plan->update($request->except(['_token','_method'])))
            success();
        else
            fail();
        return redirect()->route('plans.index');
    }

    public function destroy($plan){
        // check if the plan exist or not
        $plan=Plan::with(['users'])->findOrFail($plan);
        /// plan not founded
        if (!$plan){
            fail("Not Found Plan ...");
        }
        //plan founded and has user in it so that stop the operation
        if ($plan->users->count() > 0){
            fail("Can\' Remove This Plan ...");
        }else{
            $plan->delete();
        }
        return redirect()->route('plans.index');
    }
}
