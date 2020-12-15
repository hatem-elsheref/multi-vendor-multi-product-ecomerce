<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Rules\ValidateEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function viewProfile(){
        $my_orders_pending=auth()->user()->orders->where('status',PENDING);
        $my_orders_shipped=auth()->user()->orders->where('status',SHIPPED);
        return view('front.pages.profile',compact('my_orders_pending'))->with('my_orders_shipped',$my_orders_shipped);
    }
    public function updateInformation(Request $request){
        $user=auth()->user();
        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'image' => ['image', 'max:2000','mimes:jpg,png,jpeg,webp'],
            'stock' => ['string', 'max:255',Rule::requiredIf($user->role == SELLER)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users','email')->ignore($user->id),new ValidateEmail()]
        ]);
        if ($request->hasFile('image')){
            if ($user->image != 'uploads/users/default-user.png'){
                Storage::disk('my_desk')->delete($user->image);
            }
            $parentPath='uploads/users';
            $file=$request->file('image');
            $image=$this->generateName($user,$file);
            $file->move($parentPath,$image);
            $user->image=$parentPath.'/'.$image;
        }

        $user->name =$request->name;
        $user->email=$request->email;
        $user->name=$request->name;
        if ($user->role == SELLER)
            $user->stock=$request->stock;


        $user->save();
        success();
        auth()->loginUsingId($user->id);
        return redirect()->back();
    }

    private function generateName($user,$file){
        return Str::slug($user->name).'-'.time().'.'.$file->getClientOriginalExtension();
    }
    public function resetPassword(Request $request){
       $request->validate([
           'old_password' => ['required', 'string', 'min:8'],
           'password' => ['required', 'string', 'min:8', 'confirmed']  ]);

       $user=auth()->user();
       if (Hash::check($request->old_password,$user->password)){
           $user->password=Hash::make($request->password);
           $user->save();
           auth()->loginUsingId($user->id);
           success();
           return redirect()->back();
       }else{
           return redirect()->back()->withInput()->withErrors(['old_password'=>'Invalid Old Password']);
       }
    }
}
