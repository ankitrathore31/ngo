<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\beneficiarie;
use App\Models\Member;
use App\Models\School;
use Illuminate\Http\Request;

class EduactionCardController extends Controller
{
    public function RegList(Request $request)
    {
        $queryBene = beneficiarie::where('status', 1);
        $queryMember = Member::where('status', 1);

        if ($request->filled('session_filter')) {
            $queryBene->where('academic_session', $request->session_filter);
            $queryMember->where('academic_session', $request->session_filter);
        }

        // Application / Registration Number Search
        if ($request->filled('application_no')) {
            $search = $request->application_no;

            $queryBene->where(function ($q) use ($search) {
                $q->where('application_no', 'like', "%$search%")
                    ->orWhere('registration_no', 'like', "%$search%");
            });

            $queryMember->where(function ($q) use ($search) {
                $q->where('application_no', 'like', "%$search%")
                    ->orWhere('registration_no', 'like', "%$search%");
            });
        }

        // Mobile / Identity Number Search
        if ($request->filled('identity_no')) {
            $identity = $request->identity_no;

            $queryBene->where(function ($q) use ($identity) {
                $q->where('phone', 'like', "%$identity%")
                    ->orWhere('identity_no', 'like', "%$identity%");
            });

            $queryMember->where(function ($q) use ($identity) {
                $q->where('phone', 'like', "%$identity%")
                    ->orWhere('identity_no', 'like', "%$identity%");
            });
        }

        if ($request->filled('reg_type')) {
            $queryBene->where('reg_type', $request->reg_type);
            $queryMember->where('reg_type', $request->reg_type);
        }

        if ($request->filled('block')) {
            $queryBene->where('block', 'like', "%{$request->block}%");
            $queryMember->where('block', 'like', "%{$request->block}%");
        }

        if ($request->filled('state')) {
            $queryBene->where('state', $request->state);
            $queryMember->where('state', $request->state);
        }

        if ($request->filled('district')) {
            $queryBene->where('district', $request->district);
            $queryMember->where('district', $request->district);
        }

        $approvebeneficiarie = $queryBene->orderBy('created_at', 'asc')->get();
        $approvemember = $queryMember->orderBy('created_at', 'asc')->get();

        $combined = $approvebeneficiarie->merge($approvemember)->sortBy('created_at');

        $data = academic_session::all();
        $states = config('states');

        return view('ngo.educationcard.reg-list', compact(
            'data',
            'approvebeneficiarie',
            'approvemember',
            'combined',
            'states'
        ));
    }

    public function Addschool()
    {
        // Get last school code
        $lastSchool = School::orderBy('id', 'desc')->first();

        if ($lastSchool) {
            $lastNumber = intval(substr($lastSchool->school_code, 5)); // after 219SC
            $nextCode = '219SC' . str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $nextCode = '219SC00001';
        }

        $schools = School::orderBy('school_name', 'asc')->get();
        return view('ngo.educationcard.add-school', compact('nextCode'));
    }
    public function StoreSchool(Request $request)
    {
        $request->validate([
            'school_code' => 'required',
            'registration_date' => 'nullable|date',
            'school_name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'principal_name' => 'nullable|string|max:255',
            'affiliation_board' => 'nullable|string|max:255',
            'registration_no' => 'nullable|string|max:255',
            'principal_aadhar' => 'nullable|string|max:20',

            'registration_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'affiliation_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'principal_appointment_letter' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'principal_aadhar_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png',

            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->except([
            'registration_certificate',
            'affiliation_certificate',
            'principal_appointment_letter',
            'principal_aadhar_document',
        ]);

        $uploadPath = public_path('documents');

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Upload files
        if ($request->hasFile('registration_certificate')) {
            $file = $request->file('registration_certificate');
            $filename = 'reg_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $data['registration_certificate'] = 'documents/' . $filename;
        }

        if ($request->hasFile('affiliation_certificate')) {
            $file = $request->file('affiliation_certificate');
            $filename = 'aff_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $data['affiliation_certificate'] = 'documents/' . $filename;
        }

        if ($request->hasFile('principal_appointment_letter')) {
            $file = $request->file('principal_appointment_letter');
            $filename = 'appoint_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $data['principal_appointment_letter'] = 'documents/' . $filename;
        }

        if ($request->hasFile('principal_aadhar_document')) {
            $file = $request->file('principal_aadhar_document');
            $filename = 'aadhaar_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $data['principal_aadhar_document'] = 'documents/' . $filename;
        }

        School::create($data);

        return redirect()->route('list.school')->with('success', 'School saved successfully');
    }

     public function EditSchool($id)
    {
        $school = School::findOrFail($id);
        return view('ngo.educationcard.edit-school', compact('school'));
    }

    
    public function UpdateSchool(Request $request, $id)
    {
        $school = School::findOrFail($id);

        $request->validate([
            'registration_date' => 'nullable|date',
            'school_name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'principal_name' => 'nullable|string|max:255',
            'affiliation_board' => 'nullable|string|max:255',
            'registration_no' => 'nullable|string|max:255',
            'principal_aadhar' => 'nullable|string|max:20',

            'registration_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'affiliation_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'principal_appointment_letter' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'principal_aadhar_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png',

            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->except([
            'registration_certificate',
            'affiliation_certificate',
            'principal_appointment_letter',
            'principal_aadhar_document',
        ]);

        $uploadPath = public_path('documents');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Update files (delete old + upload new)
        if ($request->hasFile('registration_certificate')) {
            if ($school->registration_certificate && file_exists(public_path($school->registration_certificate))) {
                unlink(public_path($school->registration_certificate));
            }
            $file = $request->file('registration_certificate');
            $name = 'reg_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $name);
            $data['registration_certificate'] = 'documents/' . $name;
        }

        if ($request->hasFile('affiliation_certificate')) {
            if ($school->affiliation_certificate && file_exists(public_path($school->affiliation_certificate))) {
                unlink(public_path($school->affiliation_certificate));
            }
            $file = $request->file('affiliation_certificate');
            $name = 'aff_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $name);
            $data['affiliation_certificate'] = 'documents/' . $name;
        }

        if ($request->hasFile('principal_appointment_letter')) {
            if ($school->principal_appointment_letter && file_exists(public_path($school->principal_appointment_letter))) {
                unlink(public_path($school->principal_appointment_letter));
            }
            $file = $request->file('principal_appointment_letter');
            $name = 'appoint_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $name);
            $data['principal_appointment_letter'] = 'documents/' . $name;
        }

        if ($request->hasFile('principal_aadhar_document')) {
            if ($school->principal_aadhar_document && file_exists(public_path($school->principal_aadhar_document))) {
                unlink(public_path($school->principal_aadhar_document));
            }
            $file = $request->file('principal_aadhar_document');
            $name = 'aadhaar_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $name);
            $data['principal_aadhar_document'] = 'documents/' . $name;
        }

        $school->update($data);

        return redirect()->route('list.school')->with('success', 'School updated successfully');
    }

    public function DeleteSchool($id)
    {
        $school = School::findOrFail($id);

        // delete documents
        $files = [
            $school->registration_certificate,
            $school->affiliation_certificate,
            $school->principal_appointment_letter,
            $school->principal_aadhar_document,
        ];

        foreach ($files as $file) {
            if ($file && file_exists(public_path($file))) {
                unlink(public_path($file));
            }
        }

        $school->delete();

        return redirect()->back()->with('success', 'School deleted successfully');
    }

    public function SchoolList(Request $request)
    {
        $query = School::query();

        if ($request->filled('school_name')) {
            $query->where('school_name', 'like', '%' . $request->school_name . '%');
        }

        if ($request->filled('school_code')) {
            $query->where('school_code', 'like', '%' . $request->school_code . '%');
        }

        $schools = $query->orderBy('id', 'desc')->get();

        return view('ngo.educationcard.school-list', compact('schools'));
    }
}
