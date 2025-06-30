<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\beneficiarie;
use App\Models\Member;
use App\Models\academic_session;
use App\Models\Activity;
use App\Models\Setting;
use App\Models\Signature;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    public function addmemberlist()
    {
        $member = Member::where('status', 1)
            ->whereNull('position')
            ->get();
        return view('ngo.member.add-member-list', compact('member'));
    }

    public function showMember($id)
    {
        $record = Member::where('status', 1)->find($id);

        return view('ngo.member.view-member', compact('record'));
    }

    public function savePosition(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'position_type' => 'required',
            'position' => 'required',
            'working_area' => 'required',
        ]);

        $member = Member::find($request->member_id);
        $member->position_type = $request->position_type;
        $member->position = $request->position;
        $member->working_area = $request->working_area;
        $member->save();

        return redirect()->route('member-list')->with('success', 'Positon Successfully Added');
    }

    public function memberPostionlist()
    {
        $member = Member::where('status', 1)
            ->whereNotNull('position')
            ->get();
        return view('ngo.member.member-position-list', compact('member'));
    }

    public function memberList()
    {
        $member = Member::where('status', 1)
            ->get();
        return view('ngo.member.member-list', compact('member'));
    }

    public function showMemberPosition($id)
    {
        $record = Member::where('status', 1)->find($id);

        return view('ngo.member.view-member-position', compact('record'));
    }

    public function MemberCerti($id)
    {
        $record = Member::where('status', 1)
            ->whereNotNull('position')
            ->find($id);
        
        $signatures = Signature::pluck('file_path', 'role');
        return view('ngo.member.member-certificate', compact('record','signatures'));
    }

    public function MemberLetter($id)
    {
        $record = Member::where('status', 1)
            // ->whereNotNull('position')
            ->find($id);

        return view('ngo.member.member-letter', compact('record'));
    }

    public function Memberactivitylist(Request $request)
    {
        $query = Activity::query();

        if ($request->session_filter) {
            $query->where('academic_session', $request->session_filter);
        }


        if ($request->category_filter) {
            $query->where('program_category', $request->category_filter);
        }

        $activity = $query->orderBy('program_date', 'asc')->where('activity_by', 'Member')->get();
        return view('ngo.member.member-activity-list', compact('activity'));
    }

    public function addmemberactivity()
    {
        $data = academic_session::all()->sortByDesc('session_date');
        Session::put('all_academic_session', $data);
        return view('ngo.member.add-member-activity', compact('data'));
    }

    public function saveMemberactivity(Request $request)
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
        $activity->activity_by = 'Member';
        if ($request->hasFile('program_image')) {
            $file = $request->file('program_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('program_images'), $filename);
            $activity->program_image = $filename;
        }
        $activity->save();

        return redirect()->route('member-activitylist')->with('success', 'Member Program registered successfully!');
    }


    public function MemberActivityCerti($id, $category)
    {
        $record = Member::
            where('status', 1)
            ->find($id);
        
        dd($record);

        return view('ngo.member.activity-certificate', compact('record', 'category'));
    }
}
