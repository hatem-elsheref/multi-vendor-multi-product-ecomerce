<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Mail\SupportMail;
use App\OrderContacts;
use App\Rules\ValidateEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderContactController extends Controller
{
    public function index(){
        $contacts=OrderContacts::with(['user','relatedOrder','relatedOrder.items','relatedOrder.items.product'])->whereIn('status',['unread','read'])
            ->orderByDesc('id')->get();
        $data=[];
        foreach ($contacts as $contact){
            if($contact->relatedOrder->seller->id != auth()->id() ){
                array_push($data);
            }
        }
        return view('admin.seller.messages.index',['contacts'=>collect($data)]);
    }
    public function reply(Request $request){
        $request->validate([
            'email'  =>['required','email',new ValidateEmail()],
            'subject'=>'required',
            'message'=>'required'
        ]);
        Mail::to($request->email)->send(new SupportMail($request->subject,$request->message));
        success("Mail Sent Successfully !!");
        return redirect()->route('order_contact.index');
    }

    public function destroy($id){
        $contact=OrderContacts::findOrFail($id);
        $contact->delete();
        success();
        return redirect()->route('order_contact.index');
    }
    public function update($id){
        $contact=OrderContacts::findOrFail($id);
        if ($contact->status == 'read')
            $contact->status='unread';
        else
            $contact->status='read';

        $contact->save();
        success();
        return redirect()->route('order_contact.index');
    }
}
