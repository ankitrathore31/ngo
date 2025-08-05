<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function StoreEmail(Request $request){
        $validate = $request->validate([
            'email' => 'required|email',
            'name'  =>  'required|string',
            'subject'  =>  'required|string',
            'message'  =>  'required|string',
        ]);

        $email = Email::create($validate);
        $email->save();

        return redirect()->back()->with('success', 'Email Send Successfully.');
    }

    public function EmailList(){
        $email = Email::get();
        return view('ngo.email.email',compact('email'));
    }

    public function ViewEmail($id){
        $email = Email::findorFail($id);
        return view('ngo.email.view-email',compact('email'));
    }
}
