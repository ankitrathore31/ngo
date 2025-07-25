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


    public function GenrateLetter(Request $request)
    {
        $data = academic_session::all();
        $beneficiaries = beneficiarie::all();
        $members = Member::all();
        $record = $beneficiaries->merge($members);
        $signatures = Signature::pluck('file_path', 'role');
        return view('ngo.letter.genrate-letter', compact('data', 'record', 'signatures'));
    }


    public function saveLetter(Request $request)
    {
        $request->validate([
            'academic_session' => 'string',
            'letterNo' => 'required|string',
            'date' => 'nullable|date',
            'to' => 'required',
            'subject' => 'required',
            'letter' => 'required',
            'toaddress' => 'required',
        ]);

        ExperienceCertificate::create([
            'academic_session' => $request->session,
            'letterNo' => $request->letterNo,
            'date' => $request->date,
            'fromDate' => $request->fromDate,
            'toDate' => $request->toDate,
            'to' => $request->to,
            'toaddress' => $request->toaddress,
            'subject' => $request->subject,
            'letter' => $request->letter,
        ]);

        return redirect()->route('letter-list')->with('success', 'Letter saved successfully!');
    }

    public function editLetter($id)
    {
        $data = academic_session::all();
        $letter = ExperienceCertificate::find($id);
        return view('ngo.letter.edit-letter', compact('data', 'letter'));
    }

    public function updateLetter(Request $request, $id)
    {
        $request->validate([
            'academic_session' => 'string',
            'letterNo' => 'required|string',
            'date' => 'nullable|date',
            'to' => 'required',
            'subject' => 'required',
            'letter' => 'required',
            'toaddress' => 'required',
        ]);

        // Fetch the ExperienceCertificate instance
        $letter = ExperienceCertificate::findOrFail($id);

        // Update the attributes
        $letter->update([
            'academic_session' => $request->academic_session,
            'letterNo' => $request->letterNo,
            'date' => $request->date,
            'to' => $request->to,
            'toaddress' => $request->toaddress,
            'subject' => $request->subject,
            'letter' => $request->letter,
        ]);

        return redirect()->route('letter-list')->with('success', 'Letter updated successfully!');
    }


    public function deleteLetter($id)
    {

        $letter = ExperienceCertificate::find($id);
        $letter->delete();
        return back()->with('success', 'Letter Deleted successfully!');
    }

    public function LetterCerti(Request $request)
    {
        $session = academic_session::all();

        // Base certificate query
        $query = ExperienceCertificate::query();

        if ($request->filled('session_filter')) {
            $query->where('academic_session', $request->session_filter);
        }

        $record = $query->orderBy('created_at', 'desc')->get();

        $filtered = $record->filter(function ($record) use ($request) {

            $matchesApp = $request->filled('letterNo')
                ? str_contains($person->letterNo ?? '', $request->letterNo)
                : true;

            $matchesName = $request->filled('to')
                ? str_contains(strtolower($person->to ?? ''), strtolower($request->to))
                : true;

            return $matchesApp && $matchesName;
        });

        return view('ngo.letter.letter-list', [
            'session' => $session,
            'record' => $filtered,
        ]);
    }



    public function LetterCertificate($id)
    {

        $session = academic_session::all();
        $record = ExperienceCertificate::find($id);
        $signatures = Signature::pluck('file_path', 'role');
        return view('ngo.letter.letter', compact('session', 'record', 'signatures'));
    }
}
