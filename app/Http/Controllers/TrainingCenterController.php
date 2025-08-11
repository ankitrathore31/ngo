<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\beneficiarie;
use App\Models\Beneficiarie_Survey;
use App\Models\Category;
use App\Models\Course;
use App\Models\ExperienceCertificate;
use App\Models\Member;
use App\Models\Signature;
use App\Models\Staff;
use App\Models\Training_Beneficiarie;
use App\Models\Training_Center;
use Illuminate\Http\Request;

class TrainingCenterController extends Controller
{
    public function Addcenter()
    {
        $session = academic_session::all();

        // Get last center_code from database
        $lastCenter = Training_Center::orderBy('id', 'desc')->first();

        if ($lastCenter && preg_match('/\d{4}TC(\d+)/', $lastCenter->center_code, $matches)) {
            $lastNumber = intval($matches[1]);
        } else {
            $lastNumber = 1; // Will make first generated = 2
        }

        // Increment and format
        $newNumber = $lastNumber + 1;
        $nextCenterCode = '3126TC' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        $states = config('states');
        $staff = Staff::get();

        return view('ngo.training.add-center', compact('session', 'nextCenterCode', 'states', 'staff'));
    }

    public function storeCenter(Request $request)
    {
        $request->validate([
            'session' => 'required',
            'center_name' => 'required|string',
            'village' => 'required|string',
            'area_type' => 'required|string',
            'post' => 'required|string',
            'block' => 'required|string',
            'district' => 'required|string',
            'state' => 'required|string',
            'incharge' => 'required|string',
        ]);

        // Get last center_code from database
        $lastCenter = Training_Center::orderBy('id', 'desc')->first();

        if ($lastCenter && preg_match('/\d{4}TC(\d+)/', $lastCenter->center_code, $matches)) {
            $lastNumber = intval($matches[1]);
        } else {
            $lastNumber = 1; // Will make first generated number = 2
        }

        // Increment and format
        $newNumber = $lastNumber + 1;
        $centerCode = '3126TC' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        Training_Center::create([
            'academic_session' => $request->session,
            'center_code' => $centerCode,
            'center_name' => $request->center_name,
            'center_address' => $request->village,
            'post' => $request->post,
            'block' => $request->block,
            'area_type' => $request->area_type,
            'district' => $request->district,
            'state' => $request->state,
            'incharge' => $request->incharge,
        ]);

        return redirect()->route('center-list')->with('success', 'Training center details saved successfully.');
    }

    public function CenterList(Request $request)
    {
        $query = Training_Center::query();

        if ($request->filled('session_filter')) {
            $query->where('session_date', $request->session_filter);
        }

        if ($request->filled('center_code')) {
            $query->where('center_code', $request->center_code);
        }

        if ($request->filled('center_name')) {
            $query->where('center_name', 'like', '%' . $request->center_name . '%');
        }

        $data = academic_session::all();
        $center = $query->orderBy('id', 'desc')->get(); // with pagination

        return view('ngo.training.center-list', compact('center', 'data'));
    }

    public function CenterListForbene(Request $request)
    {
        $query = Training_Center::query();

        if ($request->filled('session_filter')) {
            $query->where('session_date', $request->session_filter);
        }

        if ($request->filled('center_code')) {
            $query->where('center_code', $request->center_code);
        }

        if ($request->filled('center_name')) {
            $query->where('center_name', 'like', '%' . $request->center_name . '%');
        }

        $session = academic_session::all();
        $center = $query->orderBy('id', 'desc')->get();

        return view('ngo.training.list-center-for-bene', compact('center', 'session'));
    }

    public function Editcenter($id)
    {
        $center = Training_Center::find($id);
        $session = academic_session::all();
        $staff = Staff::get();
        return view('ngo.training.edit-center', compact('session', 'center', 'staff'));
    }

    public function updateCenter(Request $request, $id)
    {
        $center = Training_Center::findOrFail($id);

        $center->update([
            'academic_session' => $request->session,
            'center_code' => $request->center_code,
            'center_name' => $request->center_name,
            'center_address' => $request->village,
            'post' => $request->post,
            'block' => $request->block,
            'area_type' => $request->area_type,
            'district' => $request->district,
            'state' => $request->state,
            'incharge' => $request->incharge,
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
        $category = Category::orderBy('category', 'asc')->get();
        $course = Course::orderBy('course', 'asc')->get();

        return view('ngo.training.taining-demand-bene', compact('session', 'record', 'centers', 'category', 'course'));
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

    public function ApproveBeneForTraining(Request $request, $center_code)
    {
        $session = academic_session::all();
        $queryBene = Training_Beneficiarie::with(['center', 'beneficiare'])
            ->where('center_code', $center_code);

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
        return view('ngo.training.view-bene', compact('session', 'record', 'center'));
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

    public function GenrateTrainingCertificate($id, $center_code)
    {

        $session = academic_session::all();
        $record = Training_Beneficiarie::with(['center', 'beneficiare'])->find($id);
        $center = Training_Center::where('center_code', $center_code)->first();
        $lastCertificate = Training_Beneficiarie::orderBy('id', 'desc')->value('certificate_no');

        $prefix = '219TC';
        $startNumber = 355;

        if ($lastCertificate) {
            $lastNumber = (int)substr($lastCertificate, strlen($prefix));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = $startNumber;
        }
        $nextCertificateNo = $prefix . str_pad($nextNumber, 7, '0', STR_PAD_LEFT);
        $lastBeneficiary = Training_Beneficiarie::orderBy('id', 'desc')->first();

        if ($lastBeneficiary) {
            $lastRoll = (int) $lastBeneficiary->roll_no;
            $nextRoll = str_pad($lastRoll + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextRoll = '001';
        }
        return view('ngo.training.genrate-training-certificate', compact('session', 'record', 'center', 'nextCertificateNo','nextRoll'));
    }

    public function SaveGenrateTrainingCertificate(Request $request)
    {
        $validated = $request->validate([
            'roll_no'       => 'required|numeric',
            'certificate_no'  => 'nullable|string',
            'grade'         => 'nullable|string|max:100',
            'talent'        => 'nullable|string|max:255',
            'issue_date'    => 'required|date',
        ]);

        $lastCertificate = Training_Beneficiarie::orderBy('id', 'desc')->value('certificate_no');
        $prefix = '219TC';
        $startNumber = 355;
        if ($lastCertificate) {
            $lastNumber = (int)substr($lastCertificate, strlen($prefix));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = $startNumber;
        }
        $nextCertificateNo = $prefix . str_pad($nextNumber, 7, '0', STR_PAD_LEFT);

        $lastBeneficiary = Training_Beneficiarie::orderBy('id', 'desc')->first();

        if ($lastBeneficiary) {
            // Increment last roll number
            $lastRoll = (int) $lastBeneficiary->roll_no;
            $newRoll = str_pad($lastRoll + 1, 3, '0', STR_PAD_LEFT);
        } else {
            // Start from 001 if no records
            $newRoll = '001';
        }

        $certificate = Training_Beneficiarie::where('beneficiarie_id', $request->beneficiarie_id)
            ->where('id', $request->id)
            ->first();

        if (!$certificate) {
            $certificate = new Training_Beneficiarie();
            $certificate->beneficiarie_id = $request->beneficiarie_id;
            $certificate->record_id = $request->id;
        }

        $certificate->roll_no = $newRoll;
        $certificate->certificate_no = $nextCertificateNo;
        $certificate->grade = $request->grade;
        $certificate->talent = $request->talent;
        $certificate->issue_date = $request->issue_date;

        $certificate->save();
        return redirect()->back()->with([
            'success' => 'Training Certificate saved successfully.',
            'next_certificate' => $nextCertificateNo
        ]);
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
        $signatures = Signature::pluck('file_path', 'role');
        return view('ngo.training.training-bene-certificate', compact('session', 'record', 'center', 'signatures'));
    }
}
