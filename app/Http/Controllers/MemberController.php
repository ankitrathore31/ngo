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
    public function memberlist()
    {
        $member = Member::where('status', 1)
            // ->where('survey_status', 0)
            ->get();
        return view('ngo.member.add-member-list', compact('member'));
    }
}
