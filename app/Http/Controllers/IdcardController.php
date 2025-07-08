<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\beneficiarie;
use App\Models\Member;
use App\Models\Signature;
use Illuminate\Http\Request;

class IdcardController extends Controller
{
    public function MemberIdcard(Request $request)
    {
        $queryMember = Member::where('status', 1);

        if ($request->filled('session_filter')) {
            $queryMember->where('academic_session', $request->session_filter);
        }

        if ($request->filled('application_no')) {
            $queryMember->where('application_no', $request->application_no);
        }

        if ($request->filled('name')) {
            $queryMember->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('block')) {
            $queryMember->where('block', 'like', '%' . $request->block . '%');
        }

        if ($request->filled('state')) {
            $queryMember->where('state', $request->state);
        }

        if ($request->filled('district')) {
            $queryMember->where('district', $request->district);
        }

        $member = $queryMember->orderBy('created_at', 'asc')->get();
        $data = academic_session::all();
        $states = config('states');
        $signatures = Signature::pluck('file_path', 'role');
        return view('ngo.idcard.member-idcard', compact('data', 'member','states','signatures'));
    }

     public function BeneficiaryIdcard(Request $request)
    {
        $queryMember = beneficiarie::where('status', 1);

        if ($request->filled('session_filter')) {
            $queryMember->where('academic_session', $request->session_filter);
        }

        if ($request->filled('application_no')) {
            $queryMember->where('application_no', $request->application_no);
        }

        if ($request->filled('name')) {
            $queryMember->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('block')) {
            $queryMember->where('block', 'like', '%' . $request->block . '%');
        }

        if ($request->filled('state')) {
            $queryMember->where('state', $request->state);
        }

        if ($request->filled('district')) {
            $queryMember->where('district', $request->district);
        }

        $beneficiary = $queryMember->orderBy('created_at', 'asc')->get();
        $data = academic_session::all();
        $states = config('states');
        $signatures = Signature::pluck('file_path', 'role');
        return view('ngo.idcard.beneficiary-idcard', compact('data', 'beneficiary','states','signatures'));
    }
}
