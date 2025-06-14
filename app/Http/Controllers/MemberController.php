<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\beneficiarie;
use App\Models\Member;
use App\Models\academic_session;
use App\Models\Setting;
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
            'receipt_no' =>'required',
        ]);

        $member = Member::find($request->member_id);
        $member->position_type = $request->position_type;
        $member->position = $request->position;
        $member->receipt_no = $request->receipt_no;
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

        return view('ngo.member.member-certificate', compact('record'));
    }
}
