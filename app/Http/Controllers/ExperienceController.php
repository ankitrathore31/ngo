<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\beneficiarie;
use App\Models\Beneficiarie_Survey;
use App\Models\ExperienceCertificate;
use App\Models\Member;
use App\Models\Signature;
use App\Models\Training_Beneficiarie;
use App\Models\Training_Center;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{


    public function GenrateExperience(Request $request)
    {
        $data = academic_session::all();
        $beneficiaries = beneficiarie::all();
        $members = Member::all();
        // $staff = Staff::all();
        $record = $beneficiaries->merge($members);
        $signatures = Signature::pluck('file_path', 'role');

        return view('ngo.experience.genrate-experience', compact('data', 'record', 'signatures'));
    }


    public function saveExperience(Request $request)
    {
        $request->validate([
            'academic_session' => 'nullable|string',
            'certiNo' => 'required|string',
            'date' => 'nullable|date',
            'fromDate' => 'nullable|date',
            'toDate' => 'nullable|date',
        ]);

        $certificate = ExperienceCertificate::updateOrCreate(
            ['certiNo' => $request->certiNo],
            [
                'academic_session' => $request->academic_session,
                'beneficiarie_id' => $request->beneficiarie_id,
                'date' => $request->date,
                'fromDate' => $request->fromDate,
                'toDate' => $request->toDate,
            ]
        );

        return back()->with('success', 'Certificate saved successfully!');
    }


    public function ExperienceCerti(Request $request)
    {
        $session = academic_session::all();

        // Base certificate query
        $query = ExperienceCertificate::query();

        if ($request->filled('session_filter')) {
            $query->where('academic_session', $request->session_filter);
        }

        $records = $query->orderBy('created_at', 'desc')->get();

        $filtered = $records->filter(function ($record) use ($request) {
            $person = beneficiarie::find($record->beneficiarie_id) ?? Member::find($record->beneficiarie_id);
            $record->person = $person;

            $matchesApp = $request->filled('application_no')
                ? str_contains($person->application_no ?? '', $request->application_no)
                : true;

            $matchesName = $request->filled('name')
                ? str_contains(strtolower($person->name ?? ''), strtolower($request->name))
                : true;

            return $matchesApp && $matchesName;
        });

        return view('ngo.experience.experience-list', [
            'session' => $session,
            'records' => $filtered,
        ]);
    }



    public function ExperienceCertificate($id)
    {

        $session = academic_session::all();
        $record = ExperienceCertificate::with('beneficiare')->find($id);
        $signatures = Signature::pluck('file_path', 'role');
        return view('ngo.experience.experience-certificate', compact('session', 'record', 'signatures'));
    }
}
