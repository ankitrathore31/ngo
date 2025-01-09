<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Auth;

class AdminController extends Controller
{
    public function login(Request $request){
        $credentials= $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials)){
            return view('');
        }
    }
}
