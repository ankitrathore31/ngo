<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Models\academic_session;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class SocialActivityController extends Controller
{
    public function activitylist(Request $request)
    {
        $query = Activity::query();

        if ($request->session_filter) {
            $query->where('academic_session', $request->session_filter);
        }


        if ($request->category_filter) {
            $query->where('program_category', $request->category_filter);
        }

        if ($request->address_filter && strlen($request->address_filter) >= 4) {
            $query->where('program_address', 'like', '%' . $request->address_filter . '%');
        }


        $activity = $query->orderBy('program_date', 'asc')->get();
        return view('ngo.activity.activitylist', compact('activity'));
    }


    public function addactivity()
    {
        $data = academic_session::all()->sortByDesc('session_date');
        Session::put('all_academic_session', $data);
        $category = Category::orderBy('category', 'asc')->get();
        return view('ngo.activity.addactivity', compact('data','category'));
    }

    public function saveactivity(Request $request)
    {
        $request->validate([
            // 'activity_no' => 'required',
            'program_name' => 'required|string|max:255',
            'program_category' => 'required|string|max:255',
            'program_date' => 'required|date',
            'program_session' => 'required',
            'program_time' => 'required|date_format:H:i',
            'program_address' => 'required|string',
            'program_report' => 'required|string',
            'program_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:25600',
        ], [
            'program_image.image' => 'The uploaded file must be an image.',
            'program_image.mimes' => 'Only jpeg, png, jpg, gif, and svg formats are allowed.',
            'program_image.max' => 'The image size must not exceed 25MB.',
        ]);

        // die($request->program_time);
        // exit();

        $imagePath = null;
        if ($request->hasFile('program_image')) {
            $imagePath = $request->file('program_image')->store('program_images', 'public');
        }

        $activity = new Activity;
        // $activity->activity_no = $request->activity_no;
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

    public function editactivity($id)
    {
        $activity = Activity::find($id);
        $data = academic_session::all();
        Session::put('all_academic_session', $data);
        return view('ngo.activity.editactivity', compact('activity', 'data'));
    }

    public function updateactivity(Request $request, $id)
    {
        $activity = Activity::find($id);

        // $activity->activity_no = $request->activity_no;
        $activity->program_name = $request->program_name;
        $activity->program_category = $request->program_category;
        $activity->program_date = $request->program_date;
        $activity->academic_session = $request->program_session;
        $activity->program_time = $request->program_time;
        $activity->program_address = $request->program_address;
        $activity->program_report = $request->program_report;


        if ($request->hasFile('program_image')) {
            // Optional: Delete old image
            if ($activity->program_image && file_exists(public_path('program_images/' . $activity->program_image))) {
                unlink(public_path('program_images/' . $activity->program_image));
            }

            // Upload new image
            $file = $request->file('program_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('program_images'), $filename);
            $activity->program_image = $filename;
        }


        $activity->save();

        return redirect()->route('activitylist')->with('success', 'Program updated successfully');
    }

    public function removeactivity($id)
    {
        $activity = Activity::find($id);

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

    public function eventlist(Request $request)
    {
        $query = Event::query();

        if ($request->session_filter) {
            $query->where('academic_session', $request->session_filter);
        }

        if ($request->category_filter) {
            $query->where('event_category', $request->category_filter);
        }

        $event = $query->orderBy('event_date', 'asc')->get();
        return view('ngo.event.event-list', compact('event'));
    }

    public function addevent()
    {
        $data = academic_session::all()->sortByDesc('session_date');
        Session::put('all_academic_session', $data);
        return view('ngo.event.add-event', compact('data'));
    }

    public function saveEvent(Request $request)
    {
        $request->validate([
            'event' => 'required|string|max:255',
            'event_category' => 'required|string|max:255',
            'event_date' => 'required|date',
            'event_session' => 'required',
            'event_time' => 'required|date_format:H:i',
            'event_address' => 'required|string',
            'event_report' => 'required|string',
            'event_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:25600',
        ], [
            'event_image.image' => 'The uploaded file must be an image.',
            'event_image.mimes' => 'Only jpeg, png, jpg, gif, and svg formats are allowed.',
            'event_image.max' => 'The image size must not exceed 25MB.',
        ]);

        $imagePath = null;
        if ($request->hasFile('event_image')) {
            $imagePath = $request->file('event_image')->store('program_images', 'public');
        }

        $event = new Event;
        $event->event = $request->event;
        $event->event_category = $request->event_category;
        $event->event_date = $request->event_date;
        $event->academic_session = $request->event_session;
        $event->event_time = $request->event_time;
        $event->event_address = $request->event_address;
        $event->event_report = $request->event_report;
        if ($request->hasFile('event_image')) {
            $file = $request->file('event_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('program_images'), $filename);
            $event->event_image = $filename;
        }
        $event->save();

        return redirect()->route('event-list')->with('success', 'Event Save successfully!');
    }

    public function removeEvent($id)
    {
        $event = Event::find($id);

        if ($event) {
            $destination = 'program_images/' . $event->event_image;

            $event->delete();
            return redirect()->back()->with('Success', 'Event Deleted');
        } else {
            return redirect()->back()->with('Error', 'Event Not Found');
        }
    }

    public function viewEvent($id)
    {

        $event = Event::find($id);

        return view('ngo.event.view-event', compact('event'));
    }

    public function editEvent($id)
    {

        $event = Event::find($id);
        $data = academic_session::all();
        return view('ngo.event.edit-event', compact('data', 'event'));
    }

    public function updateEvent(Request $request, $id)
    {

        $event = Event::find($id);
        $event->event = $request->event;
        $event->event_category = $request->event_category;
        $event->event_date = $request->event_date;
        $event->academic_session = $request->event_session;
        $event->event_time = $request->event_time;
        $event->event_address = $request->event_address;
        $event->event_report = $request->event_report;

        if ($request->hasFile('event_image')) {

            if ($event->event_image && file_exists(public_path('program_images/' . $event->event_image))) {
                unlink(public_path('program_images/' . $event->event_image));
            }


            $file = $request->file('event_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('program_images'), $filename);
            $event->event_image = $filename;
        }

        $event->save();

        return redirect()->route('event-list')->with('success', 'Event Update successfully!');
    }

    public function CategoryList(Request $request)
    {
        $query = Category::query();

        if ($request->name) {
            $query->where('category', 'like', '%' . $request->name . '%');
        }


        $category = $query->orderBy('created_at', 'asc')->get();
        return view('ngo.activity.category-list', compact('category'));
    }


    public function AddCategory()
    {
        return view('ngo.activity.work-category');
    }

    public function StoreCategory(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
        ]); 

        $category = new Category;
        $category->category = $request->category;
        $category->save();

        return redirect()->route('category.list')->with('success', 'Category Added Successfully! ');
    }

     public function DeleteCategory($id)
    {
 
        $category = Category::findorFail($id);
        $category->delete();

        return redirect()->back()->with('success', 'Category Deleted Successfully! ');
    }
}
