<?php

namespace App\Http\Controllers;

use App\Models\beneficiarie;
use App\Models\Beneficiarie_Survey;
use App\Models\Donation;
use App\Models\donor_data;
use App\Models\Member;
use App\Models\Signature;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Exists;

class CertificateController extends Controller
{
    public function SearchCerti()
    {
        return view('home.certificate.search-certi');
    }

    public function memberSearch(Request $request)
    {
        $request->validate([
            'application_no' => 'required',
            'dob' => 'required|date',
        ]);

        $member = Member::where('application_no', $request->application_no)
            ->whereDate('dob', $request->dob)
            ->first();

        $signatures = Signature::pluck('file_path', 'role');

        if (!$member) {

            return back()->withErrors(['application_no' => 'Member not found.']);
        }
        if (is_null($member->position)) {
            return back()->withErrors(['application_no' => 'Your application is still pending.']);
        }
        return view('home.certificate.member-certi', compact('member', 'signatures'));
    }


    public function beneficiarySearch(Request $request)
    {
        $request->validate([
            'application_no' => 'required',
            'dob' => 'required|date',
        ]);

        $bene = beneficiarie::where('application_no', $request->application_no)
            ->whereDate('dob', $request->dob)
            ->first();

        if ($bene) {
            $surveys = Beneficiarie_Survey::where('beneficiarie_id', $bene->id)
                ->where('facilities_status', 1)
                ->where('status', 'Distributed')
                ->get();

            $signatures = Signature::pluck('file_path', 'role');

            return view('home.certificate.bene-certi', compact('bene', 'surveys', 'signatures'));
        } else {
            return back()->withErrors(['application_no' => 'Beneficiary not found']);
        }
    }

    public function donorSearch(Request $request)
    {
        $request->validate([
            'mobile' => 'required',
        ]);

        $donor = Donation::where('mobile', $request->mobile)->first()
            ?? donor_data::where('mobile', $request->mobile)->first();

        $signatures = Signature::pluck('file_path', 'role');

        if ($donor) {
            return view('home.certificate.donor-certi', compact('donor', 'signatures'));
        } else {
            return back()->withErrors(['mobile' => 'Donor not found']);
        }
    }
}
