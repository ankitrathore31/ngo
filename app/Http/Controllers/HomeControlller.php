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
        $activity = Activity::orderBy('activity_no', 'asc')->get();
        return view('home.activity.SocialActivity',compact('activity'));
    }

    public function viewreport($id){
        $activity = Activity::findOrFail($id);
       
        return view('home.activity.ViewActivity',compact('activity'));
    }

    public function servicepage(){
        return view ('home.service');
    }

    public function aboutpage(){
        return view ('home.about_us');
    }

    public function eventpage(){
        return view ('home.event');
    }

    public function projectpage(){
        return view ('home.project');
    }

    public function newspage(){
        return view ('home.newspaper');
    }

    public function certificatepage(){
        return view ('home.certification');
    }

    public function rewardpage(){
        return view ('home.reward');
    }

    public function donatepage(){
        return view ('home.donation.donate');
    }

    public function contactpage(){
        return view ('home.contact');
    }

    public function helpeducation(){
        return view ('home.donation.help-education');
    }

    public function helpclothe(){
        return view ('home.donation.help-clothe');
    }

    public function helpfood(){
        return view('home.donation.help-food');
    }

    public function helpenvironment(){
        return view('home.donation.help-environment');
    }

    public function notice(){
        return view('home.notice');
    }
}