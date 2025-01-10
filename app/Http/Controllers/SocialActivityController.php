<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class SocialActivityController extends Controller
{
    public function activitylist(){
        $activity = Activity::get();
        return view ('admin.activity.activitylist',compact('activity'));
    }

    public function addactivity(){
        return view ('admin.activity.addactivity');
    }

    public function saveactivity(Request $request){
        $request->validate([
            'programName' => 'required|string|max:255',
            'programCategory' => 'required|string|max:255',
            'programDate' => 'required|date',
            'programTime' => 'required|date_format:H:i',
            'programAddress' => 'required|string',
            'programImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('programImage')) {
            $imagePath = $request->file('programImage')->store('program_images', 'public');
        }

        $activity = new Activity;
        $activity->program_name = $request->programName;
        $activity->program_category = $request->programCategory;
        $activity->program_date = $request->programDate;
        $activity->program_time = $request->programTime;
        $activity->program_address = $request->programAddress;
        if ($request->hasFile('programImage')) {
            $file = $request->file('programImage');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('program_images'), $filename); 
            $activity->program_image = $filename;
        }
        $activity->save();

        return redirect()->route('activitylist')->with('success', 'Program registered successfully!');
    }
}


