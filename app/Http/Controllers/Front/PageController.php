<?php

namespace App\Http\Controllers\Front;

use App\Contact;
use App\Http\Controllers\Controller;
use App\OrderContacts;
use App\Rules\ValidateEmail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    public function aboutView(){
        return view('front.pages.about');
    }

    public function contactView(){
        return view('front.pages.contact');
    }

    public function contact(Request $request){
        $request->validate([
            'first_name'=>'required|string|max:191',
            'last_name' =>'required|string|max:191',
            'email'     =>['required','email','max:191',new ValidateEmail()],
            'website'   =>['nullable','url','max:191'],
            'subject'   =>'required|string|max:191',
            'message'   =>'required|string',
        ]);

        Contact::create($request->except(['_token']));
        success();
        return redirect()->back()->with('response',['type'=>'success','message'=>'Message Sent Successfully']);
    }

    public function contactSeller(Request $request){
        $request->validate([
            'email'     =>['required','email','max:191',new ValidateEmail()],
            'subject'   =>'required|string|max:191',
            'message'   =>'required|string',
            'order'     =>['required','numeric',Rule::exists('orders','id')],
        ]);
        $validatedData=$request->except(['_token']);
        $validatedData['user_id']=auth()->id();
        $validatedData['order']=$request->order;
        OrderContacts::create($validatedData);
        success();
        return redirect()->back()->with('response',['type'=>'success','message'=>'Message Sent Successfully']);
    }
}
