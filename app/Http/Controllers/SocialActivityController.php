<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SocialActivityController extends Controller
{
    public function activitylist(){
        $activity = Activity::orderBy('activity_no', 'asc')->get();
        return view ('ngo.activity.activitylist',compact('activity'));
    }

    public function addactivity(){
        return view ('ngo.activity.addactivity');
    }

    public function saveactivity(Request $request){
        $request->validate([
            'activity_no' => 'required',
            'program_name' => 'required|string|max:255',
            'program_category' => 'required|string|max:255',
            'program_date' => 'required|date',
            'program_session' => 'required',
            'program_time' => 'required|date_format:H:i',
            'program_address' => 'required|string',
            'program_report' => 'required|string',
            'program_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('program_image')) {
            $imagePath = $request->file('program_image')->store('program_images', 'public');
        }

        $activity = new Activity;
        $activity->activity_no = $request->activity_no;
        $activity->program_name = $request->program_name;
        $activity->program_category = $request->program_category;
        $activity->program_date = $request->program_date;
        $activity->academic_session = $request->program_session;
        $activity->program_time = $request->program_time;
        $activity->program_address = $request->program_address;
        $activity->program_report = $request->program_report;
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
        return view('ngo.activity.editactivity',compact('activity'));
    }

    public function updateactivity(Request $request, $id){
        // dd($request);
        $activity = Activity::find($id);
        $activity->activity_no = $request->activity_no;
        $activity->program_name = $request->program_name;
        $activity->program_category = $request->program_category;
        $activity->program_date = $request->program_date;
        $activity->academic_session = $request->program_session;
        $activity->program_time = $request->program_time;
        $activity->program_address = $request->program_address;
        $activity->program_report = $request->program_report;
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

    public function viewactivity($id)
    {
        $activity = Activity::find($id);
        return view('ngo.activity.viewactivity', compact('activity'));
    }
}


