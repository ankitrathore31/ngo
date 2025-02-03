<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;

class HomeControlller extends Controller
{
    public function home(){
        return view('home.welcome');
    }

    public function activitypage(){
        $activity = Activity::get();
        return view('home.activity.SocialActivity',compact('activity'));
    }

    public function viewhomeactivity(){
        $activity = Activity::get();
        return view('home.activity.ViewActivity',compact('activity'));
    }
}