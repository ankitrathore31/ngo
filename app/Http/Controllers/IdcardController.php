<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\beneficiarie;
use App\Models\Donation;
use App\Models\donor_data;
use App\Models\Member;
use App\Models\Signature;
use App\Models\Staff;
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
        return view('ngo.idcard.member-idcard', compact('data', 'member', 'states', 'signatures'));
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
        return view('ngo.idcard.beneficiary-idcard', compact('data', 'beneficiary', 'states', 'signatures'));
    }

    public function DonorIdcard(Request $request)
    {
        $online = donor_data::where('status', 'Successful');

        if ($request->filled('name')) {
            $online->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('session_filter')) {
            $online->where('academic_session', $request->session_filter);
        }
        if ($request->filled('block')) {
            $online->where('block', 'like', '%' . $request->block . '%');
        }

        if ($request->filled('state')) {
            $online->where('state', $request->state);
        }

        if ($request->filled('district')) {
            $online->where('district', $request->district);
        }

        // Apply filters to Donation (offline donations)
        $offline = Donation::query();

        if ($request->filled('name')) {
            $offline->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('session_filter')) {
            $offline->where('academic_session', $request->session_filter);
        }
        if ($request->filled('block')) {
            $offline->where('block', 'like', '%' . $request->block . '%');
        }

        if ($request->filled('state')) {
            $offline->where('state', $request->state);
        }

        if ($request->filled('district')) {
            $offline->where('district', $request->district);
        }

        // Get both collections and merge
        $donations = $online->get()->merge($offline->get());

        // Optional: sort the merged collection (e.g., by date)
        $donations = $donations->sortByDesc('created_at'); // or any other column you have

        // For academic session dropdown
        $data = academic_session::all();
        $states = config('states');
        $signatures = Signature::pluck('file_path', 'role');
        return view('ngo.idcard.donor-idcard', compact('data', 'donations', 'states', 'signatures'));
    }

    public function StaffIdcard(Request $request)
    {
        $query = Staff::query();

        if ($request->filled('session_filter')) {
            $query->where('academic_session', $request->session_filter);
        }

        if ($request->filled('staff_code')) {
            $query->where('staff_code', $request->staff_code);
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('block')) {
            $query->where('block', 'like', '%' . $request->block . '%');
        }

        if ($request->filled('state')) {
            $query->where('state', $request->state);
        }

        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }

        $staff = $query->orderBy('created_at', 'asc')->get();
        $data = academic_session::all();
        $states = config('states');
        $signatures = Signature::pluck('file_path', 'role');
        return view('ngo.idcard.staff-idcard', compact('data', 'staff', 'states', 'signatures'));
    }
}
