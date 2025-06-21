<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\beneficiarie;
use App\Models\Beneficiarie_Survey;
use App\Models\Training_Beneficiarie;
use App\Models\Training_Center;
use Illuminate\Http\Request;

class TrainingCenterController extends Controller
{
    public function Addcenter()
    {

        $session = academic_session::all();

        return view('ngo.training.add-center', compact('session'));
    }

    public function storeCenter(Request $request)
    {
        $request->validate([
            'session' => 'required',
            'center_code' => 'required|string',
            'center_name' => 'required|string',
            'center_address' => 'required|string',
        ]);

        Training_Center::create([
            'academic_session' => $request->session,
            'center_code' => $request->center_code,
            'center_name' => $request->center_name,
            'center_address' => $request->center_address,
        ]);

        // Optionally, redirect back or do something else after saving
        return redirect()->route('center-list')->with('success', 'Training center details saved successfully.');
    }

    public function CenterList(Request $request)
    {
        $query = Training_Center::query();

        // Filtering logic
        if ($request->filled('session_filter')) {
            $query->where('session_date', $request->session_filter);
        }

        if ($request->filled('center_code')) {
            $query->where('center_code', $request->center_code);
        }

        if ($request->filled('center_name')) {
            $query->where('center_name', 'like', '%' . $request->center_name . '%');
        }

        // Get distinct sessions for filter dropdown
        $data = academic_session::all();

        // Get filtered list
        $center = $query->orderBy('id', 'desc')->paginate(10); // with pagination

        return view('ngo.training.center-list', compact('center', 'data'));
    }

    public function Editcenter($id)
    {
        $center = Training_Center::find($id);
        $session = academic_session::all();

        return view('ngo.training.edit-center', compact('session', 'center'));
    }

    public function updateCenter(Request $request, $id)
    {
        $center = Training_Center::findOrFail($id);

        $center->update([
            'academic_session' => $request->session,
            'center_code' => $request->center_code,
            'center_name' => $request->center_name,
            'center_address' => $request->center_address,
        ]);

        return redirect()->route('center-list')->with('success', 'Training center details updated successfully.');
    }

    public function Deletecenter($id)
    {

        $center = Training_Center::find($id);
        $center->delete();

        return redirect()->back()->with('success', 'Training center deleted successfully.');
    }

    public function AddBeneForCenter(Request $request)
    {

        $session = academic_session::all();

        $queryBene = beneficiarie::where('status', 1);

        if ($request->filled('session_filter')) {
            $queryBene->where('academic_session', $request->session_filter);
        }

        if ($request->filled('application_no')) {
            $queryBene->where('application_no', $request->application_no);
        }

        if ($request->filled('name')) {
            $queryBene->where('name', 'like', '%' . $request->name . '%');
        }

        $record = $queryBene->orderBy('created_at', 'asc')->get();
        $centers = Training_Center::select('center_name', 'center_code', 'center_address')->get();


        return view('ngo.training.taining-demand-bene', compact('session', 'record', 'centers'));
    }

    public function storeTrainingDemand(Request $request)
    {
        $validated = $request->validate([
            'center_code' => 'required|string|max:255',
            'facilities_category' => 'required|string',
            'training_course' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'duration' => 'nullable|string|max:100',
        ]);

        $training = new Training_Beneficiarie();
        $training->beneficiarie_id = $request->beneficiarie_id;
        $training->center_code = $request->center_code;
        $training->facilities_category = $request->facilities_category;
        $training->training_course = $request->training_course;
        $training->start_date = $request->start_date;
        $training->end_date = $request->end_date;
        $training->duration = $request->duration;
        $training->save();

        return redirect()->back()->with('success', 'Training demand saved successfully!');
    }

    public function ApproveBeneForTraining(Request $request)
    {
        $session = academic_session::all();

        $queryBene = Training_Beneficiarie::with(['center', 'beneficiare']);

        if ($request->filled('session_filter')) {
            $queryBene->where('academic_session', $request->session_filter);
        }

        if ($request->filled('application_no')) {
            $queryBene->whereHas('beneficiare', function ($q) use ($request) {
                $q->where('application_no', $request->application_no);
            });
        }

        if ($request->filled('name')) {
            $queryBene->whereHas('beneficiare', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        $record = $queryBene->orderBy('created_at', 'asc')->get();

        return view('ngo.training.training-approve-bene-list', compact('session', 'record'));
    }

    public function ShowApproveBeneTraining($id, $center_code)
    {
        $session = academic_session::all();
        $record = Training_Beneficiarie::with(['center', 'beneficiare'])->findOrFail($id);
        $center = Training_Center::where('center_code', $center_code)->first();
        return view('ngo.training.view-bene', compact('session', 'record','center'));
    }

    public function GenrateTrainingCerti(Request $request)
    {
        $session = academic_session::all();

        $queryBene = Training_Beneficiarie::with(['center', 'beneficiare']);

        if ($request->filled('session_filter')) {
            $queryBene->where('academic_session', $request->session_filter);
        }

        if ($request->filled('application_no')) {
            $queryBene->whereHas('beneficiare', function ($q) use ($request) {
                $q->where('application_no', $request->application_no);
            });
        }

        if ($request->filled('name')) {
            $queryBene->whereHas('beneficiare', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        $record = $queryBene->orderBy('created_at', 'asc')->get();

        return view('ngo.training.generate-certificate-list', compact('session', 'record'));
    }

    public function GenrateTrainingCertificate($id,$center_code)
    {

        $session = academic_session::all();
        $record = Training_Beneficiarie::with(['center', 'beneficiare'])->find($id);
        $center = Training_Center::where('center_code', $center_code)->first();
        return view('ngo.training.genrate-training-certificate', compact('session', 'record','center'));
    }

    public function SaveGenrateTrainingCertificate(Request $request)
    {


        // Validate input
        $validated = $request->validate([
            'roll_no'       => 'required|numeric',
            'certificate_no'  => 'nullable|string|max:255',
            'grade'         => 'nullable|string|max:100',
            'talent'        => 'nullable|string|max:255',
            'issue_date'    => 'required|date',
        ]);

        // Check if record exists for update
        $certificate = Training_Beneficiarie::where('beneficiarie_id', $request->beneficiarie_id)
            ->where('id', $request->id)
            ->first();

        if (!$certificate) {
            $certificate = new Training_Beneficiarie();
            $certificate->beneficiarie_id = $request->beneficiarie_id;
            $certificate->record_id = $request->id;
        }

        // Assign fields from form
        $certificate->roll_no = $request->roll_no;
        $certificate->certificate_no = $request->certificate_no;
        $certificate->grade = $request->grade;
        $certificate->talent = $request->talent;
        $certificate->issue_date = $request->issue_date;

        // Save to DB
        $certificate->save();

        return redirect()->back()->with('success', 'Training Certificate saved successfully.');
    }

    public function TrainingCerti(Request $request)
    {
        $session = academic_session::all();

        $queryBene = Training_Beneficiarie::with(['center', 'beneficiare']);

        if ($request->filled('session_filter')) {
            $queryBene->where('academic_session', $request->session_filter);
        }

        if ($request->filled('application_no')) {
            $queryBene->whereHas('beneficiare', function ($q) use ($request) {
                $q->where('application_no', $request->application_no);
            });
        }

        if ($request->filled('name')) {
            $queryBene->whereHas('beneficiare', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        $record = $queryBene->orderBy('created_at', 'asc')->get();

        return view('ngo.training.training-bene-certificate-list', compact('session', 'record'));
    }

    public function TrainingCertificate($id, $center_code)
    {

        $session = academic_session::all();
        $record = Training_Beneficiarie::with(['center', 'beneficiare'])->find($id);
        $center = Training_Center::where('center_code', $center_code)->first();
        return view('ngo.training.training-bene-certificate', compact('session', 'record','center'));
    }
}
