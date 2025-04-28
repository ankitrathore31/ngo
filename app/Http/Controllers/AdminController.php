<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Auth;
use App\Models\User;
use App\Models\Ngo;
use Carbon\Carbon;

class AdminController extends Controller
{
    // public function login(Request $request){
    //     $credentials= $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);
    //     if (Auth::attempt($credentials)){
    //         return view('admin.AdminDashboard');
    //     }
    // }

    public function addngo(){
        return view('admin.ngo.add-ngo');
    }

    public function ngolist(){
        // $user = User::get();
        $ngo = Ngo::get();
        $inactiveNgo = Ngo::where('status', 0)->count();
        return view('admin.AdminDashboard', compact('ngo','inactiveNgo')); 
    }
}
