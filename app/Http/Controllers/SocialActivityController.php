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
            'program_name' => 'required|string|max:255',
            'program_category' => 'required|string|max:255',
            'program_date' => 'required|date',
            'program_time' => 'required|date_format:H:i',
            'program_address' => 'required|string',
            'program_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('program_image')) {
            $imagePath = $request->file('program_image')->store('program_images', 'public');
        }

        $activity = new Activity;
        $activity->program_name = $request->program_name;
        $activity->program_category = $request->program_category;
        $activity->program_date = $request->program_date;
        $activity->program_time = $request->program_time;
        $activity->program_address = $request->program_address;
        if ($request->hasFile('program_image')) {
            $file = $request->file('program_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('program_images'), $filename); 
            $activity->program_image = $filename;
        }
        $activity->save();

        return redirect()->route('activitylist')->with('success', 'Program registered successfully!');
    }

    public function editactivity($id){
        $activity = Activity::find($id);
        return view('admin.activity.editactivity',compact('activity'));
    }

    public function updateactivity(Request $request, $id){
        // dd($request);
        $activity = Activity::find($id);
        $activity->program_name = $request->program_name;
        $activity->program_category = $request->program_category;
        $activity->program_date = $request->program_date;
        $activity->program_time = $request->program_time;
        $activity->program_address = $request->program_address;
        if ($request->hasFile('program_image')) {
            $file = $request->file('program_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('program_images'), $filename); 
            $activity->program_image = $filename;
        }
        $activity->save();

        return redirect()->route('activitylist')->with('success', 'Program update sccessfully');
    }

    public function removeactivity($id)
    {
        $activity= Activity::find($id);

        if ($activity) {
            $destination = 'program_images/' . $activity->program_image;
           
            $activity->delete();
            return redirect()->back()->with('Success', ' Deleted Successfully!');
        } else {
            return redirect()->back()->with('Error', ' Not Available!');
        }
    }
}


