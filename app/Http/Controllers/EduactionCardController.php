<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\beneficiarie;
use App\Models\Category;
use App\Models\Education_class;
use App\Models\EducationCard;
use App\Models\EducationFacility;
use App\Models\Member;
use App\Models\School;
use App\Models\Signature;
use App\Models\Staff;
use App\Models\Student;
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

        if ($request->filled('name')) {

            $name = trim($request->name);

            $queryBene->where(function ($q) use ($name) {
                $q->where('name', 'like', "{$name}%")
                    ->orWhere('gurdian_name', 'like', "{$name}%");
            });

            $queryMember->where(function ($q) use ($name) {
                $q->where('name', 'like', "{$name}%")
                    ->orWhere('gurdian_name', 'like', "{$name}%");
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

        $schools = $query->orderBy('id', 'asc')->get();

        return view('ngo.educationcard.school-list', compact('schools'));
    }

    public function AddClass()
    {
        $classes = Education_class::get();

        return view('ngo.educationcard.add-class', compact('classes'));
    }

    public function StoreClass(Request $request)
    {
        $request->validate([
            'class' => 'required',
        ]);

        Education_class::create([
            'class' => $request->class,
        ]);

        return redirect()->back()->with('success', 'Class Added Successfully.');
    }

    public function DeleteClass($id)
    {
        $class = Education_class::findorFail($id);
        $class->delete();

        return redirect()->back()->with('success', 'Class delete successfully.');
    }

    public function AddStudent()
    {
        $data = academic_session::get();
        return view('ngo.educationcard.add-student', compact('data'));
    }

    public function StoreStudent(Request $request)
    {
        $request->validate([
            'student_name'      => 'required|string|max:255',
        ]);

        Student::create([
            'student_name' => $request->student_name,
        ]);

        return redirect()->back()->with('success', 'Student Added Successfully.');
    }

    public function StudentList(Request $request)
    {
        $students = Student::query();

        if ($request->filled('registration_no')) {
            $students->where('registration_no', 'like', '%' . $request->registration_no . '%');
        }

        if ($request->filled('student_name')) {
            $students->where('student_name', 'like', '%' . $request->student_name . '%');
        }

        $students = $students->get();

        return view('ngo.educationcard.student-list', compact('students'));
    }

    public function GenerateEducationCard($id, $type)
    {
        if ($type === 'Beneficiaries') {
            $record = beneficiarie::where('status', 1)->findorFail($id);
        } else {
            $record = Member::where('status', 1)->findorFail($id);
        }

        // Generate next card number
        $prefix = '219EC';

        $last = EducationCard::where('educationcard_no', 'like', $prefix . '%')
            ->orderBy('educationcard_no', 'desc')
            ->value('educationcard_no');

        $number = $last ? intval(substr($last, strlen($prefix))) + 1 : 1;
        $educationcard_no = $prefix . str_pad($number, 7, '0', STR_PAD_LEFT);

        $schools = \App\Models\School::orderBy('school_name')->get();
        $students = \App\Models\Student::orderBy('student_name')->get();

        return view('ngo.educationcard.generate-card', compact('educationcard_no', 'record', 'schools', 'students'));
    }

    public function StoreEducationCard(Request $request)
    {
        $request->validate([
            'reg_id' => 'required|integer',
            'educationcard_no' => 'required|string|unique:education_cards,educationcard_no',
            'education_registration_date' => 'required|date',
            'students' => 'nullable|array',
            'students.*' => 'string',
            'school_name' => 'nullable|array',
            'school_name.*' => 'string',
        ]);

        $educationCard = EducationCard::create([
            'reg_id' => $request->reg_id,
            'educationcard_no' => $request->educationcard_no,
            'education_registration_date' => $request->education_registration_date,
            'students' => $request->students ?? [], // Simplified
            'school_name' => $request->school_name ?? [], // Simplified
            'status' => 1,
        ]);

        return redirect()
            ->route('eduaction.card.list')
            ->with('success', 'Education Card saved successfully.');
    }

    public function EditEducationCard($education_id)
    {
        $educationCard = EducationCard::with(['beneficiary', 'member'])->findOrFail($education_id);

        // Detect owner (Beneficiary or Member)
        $person = $educationCard->beneficiary ?? $educationCard->member;

        if (!$person) {
            abort(404, 'Person not found for this education card');
        }

        $schools  = School::orderBy('school_name')->get();
        $students = Student::orderBy('student_name')->get();

        return view('ngo.educationcard.edit-card', compact(
            'educationCard',
            'person',
            'schools',
            'students'
        ));
    }

    public function updateEducationCard(Request $request, $id)
    {
        $request->validate([
            'education_registration_date' => 'required|date',
            'students'        => 'nullable|array',
            'students.*'      => 'string',
            'school_name'     => 'nullable|array',
            'school_name.*'   => 'string',
        ]);

        $educationCard = EducationCard::findOrFail($id);

        $educationCard->update([
            'education_registration_date' => $request->education_registration_date,
            'students'    => $request->students ?? [],
            'school_name' => $request->school_name ?? [],
        ]);

        return redirect()
            ->route('eduaction.card.list')
            ->with('success', 'Education Card updated successfully.');
    }

    public function EducationCardList(Request $request)
    {
        /* ---------------- Base Queries ---------------- */

        $queryBene = beneficiarie::with(['educationCards' => function ($q) {
            $q->where('status', 1);
        }])
            ->where('status', 1)
            ->whereHas('educationCards', function ($q) {
                $q->where('status', 1);
            });

        $queryMember = Member::with(['educationCards' => function ($q) {
            $q->where('status', 1);
        }])
            ->where('status', 1)
            ->whereHas('educationCards', function ($q) {
                $q->where('status', 1);
            });

        /* ---------------- Session Filter ---------------- */

        if ($request->filled('session_filter')) {
            $queryBene->where('academic_session', $request->session_filter);
            $queryMember->where('academic_session', $request->session_filter);
        }

        /* ---------------- Education Card No ---------------- */

        if ($request->filled('educationcard_no')) {
            $cardNo = $request->educationcard_no;

            $queryBene->whereHas('educationCards', function ($q) use ($cardNo) {
                $q->where('educationcard_no', 'like', "%{$cardNo}%");
            });

            $queryMember->whereHas('educationCards', function ($q) use ($cardNo) {
                $q->where('educationcard_no', 'like', "%{$cardNo}%");
            });
        }

        /* ---------------- Application No ---------------- */

        if ($request->filled('application_no')) {
            $search = $request->application_no;

            $queryBene->where('application_no', 'like', "%{$search}%");
            $queryMember->where('application_no', 'like', "%{$search}%");
        }

        /* ---------------- Registration No ---------------- */

        if ($request->filled('registration_no')) {
            $search = $request->registration_no;

            $queryBene->where('registration_no', 'like', "%{$search}%");
            $queryMember->where('registration_no', 'like', "%{$search}%");
        }

        /* ---------------- Name / Guardian Name ---------------- */

        if ($request->filled('name')) {
            $name = $request->name;

            $queryBene->where(function ($q) use ($name) {
                $q->where('name', 'like', "%{$name}%")
                    ->orWhere('guardian_name', 'like', "%{$name}%");
            });

            $queryMember->where(function ($q) use ($name) {
                $q->where('name', 'like', "%{$name}%")
                    ->orWhere('guardian_name', 'like', "%{$name}%");
            });
        }

        /* ---------------- Block ---------------- */

        if ($request->filled('block')) {
            $queryBene->where('block', 'like', "%{$request->block}%");
            $queryMember->where('block', 'like', "%{$request->block}%");
        }

        /* ---------------- State ---------------- */

        if ($request->filled('state')) {
            $queryBene->where('state', $request->state);
            $queryMember->where('state', $request->state);
        }

        /* ---------------- District ---------------- */

        if ($request->filled('district')) {
            $queryBene->where('district', $request->district);
            $queryMember->where('district', $request->district);
        }

        /* ---------------- Fetch Data ---------------- */

        $beneficiaries = $queryBene->get();
        $members       = $queryMember->get();

        /* ---------------- Flatten (1 row per education card) ---------------- */

        $combined = collect()
            ->merge($beneficiaries)
            ->merge($members)
            ->flatMap(function ($item) {
                return $item->educationCards->map(function ($card) use ($item) {
                    return [
                        'person' => $item,
                        'card'   => $card,
                    ];
                });
            })
            ->sortBy(fn($row) => $row['card']->created_at)
            ->values();

        /* ---------------- Extra Data ---------------- */

        $data   = academic_session::all();
        $states = config('states');

        return view('ngo.educationcard.card-list', compact(
            'combined',
            'data',
            'states'
        ));
    }

    public function ShowEducationCard($id, $education_id)
    {
        // Try Beneficiarie first
        $record = beneficiarie::find($id);

        // If not found, try Member
        if (!$record) {
            $record = Member::find($id);
        }

        // If neither found
        if (!$record) {
            return redirect()->back()->with('error', 'Record not found.');
        }

        // Fetch ONE health card from hasMany relationship
        $educationCard = $record->educationCards()
            ->where('id', $education_id)
            ->first();

        if (!$educationCard) {
            return redirect()->back()->with('error', 'Education Card not found.');
        }
        $signatures = Signature::pluck('file_path', 'role');

        return view('ngo.educationcard.card', compact('record', 'educationCard', 'signatures'));
    }

    public function deleteEducationCard($education_id)
    {
        try {
            $educationCard = EducationCard::findOrFail($education_id);

            $educationCard->delete();

            return redirect()
                ->back()
                ->with('success', 'Education Card deleted successfully.');
        } catch (\Throwable $th) {
            return back()->withErrors([
                'error' => 'Failed to delete Education Card.'
            ]);
        }
    }

    public function EducationDemandList(Request $request)
    {
        /* ---------------- Base Queries ---------------- */

        $queryBene = beneficiarie::with(['educationCards' => function ($q) {
            $q->where('status', 1);
        }])
            ->where('status', 1)
            ->whereHas('educationCards', function ($q) {
                $q->where('status', 1);
            });

        $queryMember = Member::with(['educationCards' => function ($q) {
            $q->where('status', 1);
        }])
            ->where('status', 1)
            ->whereHas('educationCards', function ($q) {
                $q->where('status', 1);
            });

        /* ---------------- Session Filter ---------------- */

        if ($request->filled('session_filter')) {
            $queryBene->where('academic_session', $request->session_filter);
            $queryMember->where('academic_session', $request->session_filter);
        }

        /* ---------------- Education Card No ---------------- */

        if ($request->filled('educationcard_no')) {
            $cardNo = $request->educationcard_no;

            $queryBene->whereHas('educationCards', function ($q) use ($cardNo) {
                $q->where('educationcard_no', 'like', "%{$cardNo}%");
            });

            $queryMember->whereHas('educationCards', function ($q) use ($cardNo) {
                $q->where('educationcard_no', 'like', "%{$cardNo}%");
            });
        }

        /* ---------------- Application No ---------------- */

        if ($request->filled('application_no')) {
            $search = $request->application_no;

            $queryBene->where('application_no', 'like', "%{$search}%");
            $queryMember->where('application_no', 'like', "%{$search}%");
        }

        /* ---------------- Registration No ---------------- */

        if ($request->filled('registration_no')) {
            $search = $request->registration_no;

            $queryBene->where('registration_no', 'like', "%{$search}%");
            $queryMember->where('registration_no', 'like', "%{$search}%");
        }

        /* ---------------- Name / Guardian Name ---------------- */

        if ($request->filled('name')) {

            $name = trim($request->name);

            $queryBene->where(function ($q) use ($name) {
                $q->where('name', 'like', "{$name}%")
                    ->orWhere('gurdian_name', 'like', "{$name}%");
            });

            $queryMember->where(function ($q) use ($name) {
                $q->where('name', 'like', "{$name}%")
                    ->orWhere('gurdian_name', 'like', "{$name}%");
            });
        }

        /* ---------------- Block ---------------- */

        if ($request->filled('block')) {
            $queryBene->where('block', 'like', "%{$request->block}%");
            $queryMember->where('block', 'like', "%{$request->block}%");
        }

        /* ---------------- State ---------------- */

        if ($request->filled('state')) {
            $queryBene->where('state', $request->state);
            $queryMember->where('state', $request->state);
        }

        /* ---------------- District ---------------- */

        if ($request->filled('district')) {
            $queryBene->where('district', $request->district);
            $queryMember->where('district', $request->district);
        }

        /* ---------------- Fetch Data ---------------- */

        $beneficiaries = $queryBene->get();
        $members       = $queryMember->get();

        /* ---------------- Flatten (1 row per education card) ---------------- */

        $combined = collect()
            ->merge($beneficiaries)
            ->merge($members)
            ->flatMap(function ($item) {
                return $item->educationCards->map(function ($card) use ($item) {
                    return [
                        'person' => $item,
                        'card'   => $card,
                    ];
                });
            })
            ->sortBy(fn($row) => $row['card']->created_at)
            ->values();

        /* ---------------- Extra Data ---------------- */

        $data   = academic_session::all();
        $states = config('states');

        return view('ngo.educationcard.demand-list', compact(
            'combined',
            'data',
            'states'
        ));
    }

    public function DemandEducationFacility($id, $education_id)
    {
        // Try Beneficiarie first
        $record = beneficiarie::find($id);

        // If not found, try Member
        if (!$record) {
            $record = Member::find($id);
        }

        // If neither found
        if (!$record) {
            return redirect()->back()->with('error', 'Record not found.');
        }

        // Fetch ONE health card from hasMany relationship
        $educationCard = $record->educationCards()
            ->where('id', $education_id)
            ->first();

        if (!$educationCard) {
            return redirect()->back()->with('error', 'Education Card not found.');
        }
        $schools = School::get();
        $signatures = Signature::pluck('file_path', 'role');

        return view('ngo.educationcard.demand-facility', compact('record', 'educationCard', 'signatures', 'schools'));
    }

    public function StoreDemandFacility(Request $request)
    {
        $data = $request->validate([
            'reg_id' => 'required',
            'card_id' => 'required',
            'school'  => 'required',
            'fees_type' => 'required',
            // 'registration_no' => 'required',
            'fees_slip_no' => 'required',
            'fees_submit_date' => 'required|date',
            'fees_amount' => 'required|numeric',
            'slip' => 'nullable|file'
        ]);

        if ($request->hasFile('slip')) {
            $file = $request->file('slip');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('documents'), $filename);
            $data['slip'] = $filename;
        }
        $data['status'] = 'Pending';
        EducationFacility::create($data);

        return redirect()->route('eduaction.demand.list')->with('success', 'Education Demand Facility Added Successfully');
    }

    public function EditFacility(EducationFacility $facility)
    {
        $card = $facility->educationCard; // ✅ FIXED

        if (!$card) {
            return redirect()->back()->with('error', 'Education Card not found.');
        }

        $record = beneficiarie::find($card->reg_id)
            ?? Member::find($card->reg_id);

        if (!$record) {
            return redirect()->back()->with('error', 'Person not found.');
        }
        $schools = School::get();

        return view(
            'ngo.educationcard.edit-demand',
            compact('facility', 'card', 'record', 'schools')
        );
    }

    public function UpdateDemandFacility(Request $request, EducationFacility $facility)
    {
        $data = $request->validate([
            'reg_id'            => 'required',
            'card_id'           => 'required',
            'fees_type'         => 'required',
            'school'            => 'required',
            // 'registration_no'   => 'required',
            'fees_slip_no'      => 'required',
            'fees_submit_date'  => 'required|date',
            'fees_amount'       => 'required|numeric',
            'slip'              => 'nullable|file'
        ]);

        if ($request->hasFile('slip')) {

            if ($facility->slip && file_exists(public_path('documents/' . $facility->slip))) {
                unlink(public_path('documents/' . $facility->slip));
            }

            $file = $request->file('slip');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('documents'), $filename);

            $data['slip'] = $filename;
        }

        $facility->update($data);

        return redirect()->route('eduaction.demand.pending.list')->with('success', 'Education Demand Facility Updated Successfully');
    }

    public function DeleteDemandFacility($id)
    {
        $facility = EducationFacility::findOrFail($id);

        /* ---------- Delete Slip File ---------- */
        if ($facility->slip && file_exists(public_path('documents/' . $facility->slip))) {
            unlink(public_path('documents/' . $facility->slip));
        }

        /* ---------- Delete Record ---------- */
        $facility->delete();

        return redirect()->back()->with('success', 'Education Demand Facility Deleted Successfully');
    }

    public function ShowFacility(EducationFacility $facility)
    {
        $card = $facility->educationCard; // ✅ FIXED

        if (!$card) {
            return redirect()->back()->with('error', 'Education Card not found.');
        }

        $record = beneficiarie::find($card->reg_id)
            ?? Member::find($card->reg_id);

        if (!$record) {
            return redirect()->back()->with('error', 'Person not found.');
        }

        return view(
            'ngo.educationcard.show-demand-facility',
            compact('facility', 'card', 'record')
        );
    }

    public function EducationDemandPendingList(Request $request)
    {
        /* ---------- Education Card + Facility Constraint ---------- */

        $educationCardConstraint = function ($q) use ($request) {
            $q->where('status', 1)
                ->whereHas('educationFacilities', function ($ef) {
                    $ef->where('status', 'Pending');
                })
                ->with(['educationFacilities' => function ($ef) {
                    $ef->where('status', 'Pending');
                }]);

            if ($request->filled('educationcard_no')) {
                $q->where('educationcard_no', trim($request->educationcard_no));
            }
        };

        /* ---------- Base Queries ---------- */

        $queryBene = beneficiarie::with(['educationCards' => $educationCardConstraint])
            ->where('status', 1)
            ->whereHas('educationCards', $educationCardConstraint);

        $queryMember = Member::with(['educationCards' => $educationCardConstraint])
            ->where('status', 1)
            ->whereHas('educationCards', $educationCardConstraint);

        /* ---------- Filters (same as education demand) ---------- */

        if ($request->filled('session_filter')) {
            $queryBene->where('academic_session', $request->session_filter);
            $queryMember->where('academic_session', $request->session_filter);
        }

        if ($request->filled('application_no')) {
            $search = $request->application_no;

            $queryBene->where('application_no', 'like', "%{$search}%");
            $queryMember->where('application_no', 'like', "%{$search}%");
        }

        if ($request->filled('registration_no')) {
            $search = $request->registration_no;

            $queryBene->where('registration_no', 'like', "%{$search}%");
            $queryMember->where('registration_no', 'like', "%{$search}%");
        }

        if ($request->filled('name')) {

            $name = trim($request->name);

            $queryBene->where(function ($q) use ($name) {
                $q->where('name', 'like', "{$name}%")
                    ->orWhere('gurdian_name', 'like', "{$name}%");
            });

            $queryMember->where(function ($q) use ($name) {
                $q->where('name', 'like', "{$name}%")
                    ->orWhere('gurdian_name', 'like', "{$name}%");
            });
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

        /* ---------- Fetch Data ---------- */

        $beneficiaries = $queryBene->get();
        $members       = $queryMember->get();

        /* ---------- Flatten: Card + Facility ---------- */

        $combined = collect()
            ->merge($beneficiaries)
            ->merge($members)
            ->flatMap(function ($item) {
                return $item->educationCards->flatMap(function ($card) use ($item) {
                    return $card->educationFacilities->map(function ($facility) use ($item, $card) {
                        return [
                            'person'   => $item,
                            'card'     => $card,
                            'facility' => $facility,
                        ];
                    });
                });
            })
            ->sortBy(fn($row) => $row['facility']->created_at)
            ->values();

        /* ---------- Extra Data ---------- */

        $data   = academic_session::all();
        $states = config('states');
        $staff = Staff::get();
        return view(
            'ngo.educationcard.pending-facility-list',
            compact('combined', 'data', 'states', 'staff')
        );
    }

    public function InvetigationOfficerStore(Request $request, EducationFacility $facility)
    {
        $validated = $request->validate([
            // 'person_paying_bill'    => 'required|string|max:255',
            'investigation_officer' => 'required|string|max:255',
        ]);

        $facility->update([
            // 'person_paying_bill'    => $validated['person_paying_bill'],
            'investigation_officer' => $validated['investigation_officer'],
            'status'                => 'Investigation',
        ]);

        return redirect()
            ->route('education.list.Investigationfacility')
            ->with('success', 'Investigation Officer Selected successfully.');
    }

    public function InvetigationFacilityList(Request $request)
    {
        /* ---------- Education Card + Facility Constraint ---------- */
        $user = auth()->user();
        $isStaff = $user && $user->user_type === 'staff';

        $educationCardConstraint = function ($q) use ($request, $isStaff, $user) {

            $q->where('status', 1)
                ->whereHas('educationFacilities', function ($ef) use ($isStaff, $user) {

                    $ef->where('status', 'Investigation');

                    // 🔐 Staff can see only assigned investigations
                    if ($isStaff) {
                        $ef->where('investigation_officer', $user->email);
                    }
                })
                ->with(['educationFacilities' => function ($ef) use ($isStaff, $user) {

                    $ef->where('status', 'Investigation');

                    if ($isStaff) {
                        $ef->where('investigation_officer', $user->email);
                    }
                }]);

            if ($request->filled('educationcard_no')) {
                $q->where('educationcard_no', trim($request->educationcard_no));
            }
        };


        /* ---------- Base Queries ---------- */

        $queryBene = beneficiarie::with(['educationCards' => $educationCardConstraint])
            ->where('status', 1)
            ->whereHas('educationCards', $educationCardConstraint);

        $queryMember = Member::with(['educationCards' => $educationCardConstraint])
            ->where('status', 1)
            ->whereHas('educationCards', $educationCardConstraint);

        /* ---------- Filters (same as education demand) ---------- */

        if ($request->filled('session_filter')) {
            $queryBene->where('academic_session', $request->session_filter);
            $queryMember->where('academic_session', $request->session_filter);
        }

        if ($request->filled('application_no')) {
            $search = $request->application_no;

            $queryBene->where('application_no', 'like', "%{$search}%");
            $queryMember->where('application_no', 'like', "%{$search}%");
        }

        if ($request->filled('registration_no')) {
            $search = $request->registration_no;

            $queryBene->where('registration_no', 'like', "%{$search}%");
            $queryMember->where('registration_no', 'like', "%{$search}%");
        }

        if ($request->filled('name')) {

            $name = trim($request->name);

            $queryBene->where(function ($q) use ($name) {
                $q->where('name', 'like', "{$name}%")
                    ->orWhere('gurdian_name', 'like', "{$name}%");
            });

            $queryMember->where(function ($q) use ($name) {
                $q->where('name', 'like', "{$name}%")
                    ->orWhere('gurdian_name', 'like', "{$name}%");
            });
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

        /* ---------- Fetch Data ---------- */

        $beneficiaries = $queryBene->get();
        $members       = $queryMember->get();

        /* ---------- Flatten: Card + Facility ---------- */

        $combined = collect()
            ->merge($beneficiaries)
            ->merge($members)
            ->flatMap(function ($item) {
                return $item->educationCards->flatMap(function ($card) use ($item) {
                    return $card->educationFacilities->map(function ($facility) use ($item, $card) {
                        return [
                            'person'   => $item,
                            'card'     => $card,
                            'facility' => $facility,
                        ];
                    });
                });
            })
            ->sortBy(fn($row) => $row['facility']->created_at)
            ->values();

        /* ---------- Extra Data ---------- */

        $data   = academic_session::all();
        $states = config('states');
        $officer = Staff::get();
        return view(
            'ngo.educationcard.investigation-list',
            compact('combined', 'data', 'states', 'officer')
        );
    }

    public function InvestigationForm(EducationFacility $facility)
    {
        $card = $facility->educationCard; // ✅ FIXED

        if (!$card) {
            return redirect()->back()->with('error', 'Education Card not found.');
        }

        $record = beneficiarie::find($card->reg_id)
            ?? Member::find($card->reg_id);

        if (!$record) {
            return redirect()->back()->with('error', 'Person not found.');
        }
        $officer = Staff::get();
        $signatures = Signature::pluck('file_path', 'role');
        return view(
            'ngo.educationcard.investigation-form',
            compact('facility', 'card', 'record', 'officer', 'signatures')
        );
    }

    public function StoreInvestigationForm(Request $request, EducationFacility $facility)
    {
        $validated = $request->validate([
            'person_paying_amount'     => 'nullable|string|max:255',
            'account_no'             => 'nullable|string|max:50',
            'account_holder_name'    => 'nullable|string|max:255',
            'ifsc_code'              => 'nullable|string|max:20',
            'bank_name'              => 'nullable|string|max:255',
            'bank_branch'            => 'nullable|string|max:255',
            'account_holder_address' => 'nullable|string',
            // 'verify_officer'         => 'required|string|max:255',
            'investigation_proof'    => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        /* Handle photo upload (public/images) */
        if ($request->hasFile('investigation_proof')) {
            $file = $request->file('investigation_proof');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $validated['investigation_proof'] = $filename;
        }

        $facility->update([
            'person_paying_amount'     => $validated['person_paying_amount'] ?? null,
            'account_no'             => $validated['account_no'] ?? null,
            'account_holder_name'    => $validated['account_holder_name'] ?? null,
            'ifsc_code'              => $validated['ifsc_code'] ?? null,
            'bank_name'              => $validated['bank_name'] ?? null,
            'bank_branch'            => $validated['bank_branch'] ?? null,
            'account_holder_address' => $validated['account_holder_address'] ?? null,
            'investigation_proof'    => $validated['investigation_proof'] ?? null,
            'investigation_status'   => 1,
            'remark'                 => null,
        ]);

        return redirect()
            ->route('education.list.Investigationfacility')
            ->with('success', 'Investigation Form Send To Verification successfully.');
    }

    public function ShowInvestigationForm(EducationFacility $facility)
    {
        $card = $facility->educationCard; // ✅ FIXED

        if (!$card) {
            return redirect()->back()->with('error', 'Education Card not found.');
        }

        $record = beneficiarie::find($card->reg_id)
            ?? Member::find($card->reg_id);

        if (!$record) {
            return redirect()->back()->with('error', 'Person not found.');
        }
        $categories = Category::orderBy('category', 'asc')->pluck('category');
        return view(
            'ngo.educationcard.show-form',
            compact('facility', 'card', 'record', 'categories')
        );
    }

    public function VerifyOfficerStore(Request $request, EducationFacility $facility)
    {
        $validated = $request->validate([
            // 'person_paying_bill'    => 'required|string|max:255',
            'verify_officer' => 'required|string|max:255',
        ]);

        $facility->update([
            // 'person_paying_bill'    => $validated['person_paying_bill'],
            'verify_officer' => $validated['verify_officer'],
            'status'                => 'Verify',
        ]);

        return redirect()
            ->route('education.list.Verifyfacility')
            ->with('success', 'Verify Officer Selected successfully.');
    }

    public function VerifyFacilityList(Request $request)
    {
        /* ---------- Education Card + Facility Constraint ---------- */
        $user = auth()->user();
        $isStaff = $user && $user->user_type === 'staff';

        $educationCardConstraint = function ($q) use ($request, $isStaff, $user) {

            $q->where('status', 1)
                ->whereHas('educationFacilities', function ($ef) use ($isStaff, $user) {

                    $ef->where('status', 'Verify');

                    // 🔐 Staff can see only assigned investigations
                    if ($isStaff) {
                        $ef->where('investigation_officer', $user->email);
                    }
                })
                ->with(['educationFacilities' => function ($ef) use ($isStaff, $user) {

                    $ef->where('status', 'Verify');

                    if ($isStaff) {
                        $ef->where('investigation_officer', $user->email);
                    }
                }]);

            if ($request->filled('educationcard_no')) {
                $q->where('educationcard_no', trim($request->educationcard_no));
            }
        };


        /* ---------- Base Queries ---------- */

        $queryBene = beneficiarie::with(['educationCards' => $educationCardConstraint])
            ->where('status', 1)
            ->whereHas('educationCards', $educationCardConstraint);

        $queryMember = Member::with(['educationCards' => $educationCardConstraint])
            ->where('status', 1)
            ->whereHas('educationCards', $educationCardConstraint);

        /* ---------- Filters (same as education demand) ---------- */

        if ($request->filled('session_filter')) {
            $queryBene->where('academic_session', $request->session_filter);
            $queryMember->where('academic_session', $request->session_filter);
        }

        if ($request->filled('application_no')) {
            $search = $request->application_no;

            $queryBene->where('application_no', 'like', "%{$search}%");
            $queryMember->where('application_no', 'like', "%{$search}%");
        }

        if ($request->filled('registration_no')) {
            $search = $request->registration_no;

            $queryBene->where('registration_no', 'like', "%{$search}%");
            $queryMember->where('registration_no', 'like', "%{$search}%");
        }

        if ($request->filled('name')) {

            $name = trim($request->name);

            $queryBene->where(function ($q) use ($name) {
                $q->where('name', 'like', "{$name}%")
                    ->orWhere('gurdian_name', 'like', "{$name}%");
            });

            $queryMember->where(function ($q) use ($name) {
                $q->where('name', 'like', "{$name}%")
                    ->orWhere('gurdian_name', 'like', "{$name}%");
            });
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

        /* ---------- Fetch Data ---------- */

        $beneficiaries = $queryBene->get();
        $members       = $queryMember->get();

        /* ---------- Flatten: Card + Facility ---------- */

        $combined = collect()
            ->merge($beneficiaries)
            ->merge($members)
            ->flatMap(function ($item) {
                return $item->educationCards->flatMap(function ($card) use ($item) {
                    return $card->educationFacilities->map(function ($facility) use ($item, $card) {
                        return [
                            'person'   => $item,
                            'card'     => $card,
                            'facility' => $facility,
                        ];
                    });
                });
            })
            ->sortBy(fn($row) => $row['facility']->created_at)
            ->values();

        /* ---------- Extra Data ---------- */

        $data   = academic_session::all();
        $states = config('states');
        $officer = Staff::get();
        return view(
            'ngo.educationcard.verify-list',
            compact('combined', 'data', 'states', 'officer')
        );
    }

    public function InvestigationReject(Request $request, EducationFacility $facility)
    {
        if ($facility->status === 'Investigation') {
            $facility->status = 'Pending';
            $facility->remark = $request->remark;
            $facility->save();

            return redirect()
                ->route('education.list.Verifyfacility')
                ->with('success', 'Form rejected and moved to Pending successfully');
        }

        if ($facility->status === 'Verify') {
            $facility->status = 'Investigation';
            // $facility->investigation_status = 0;
            $facility->remark = $request->remark;
            $facility->save();

            return redirect()
                ->route('education.list.Verifyfacility')
                ->with('success', 'Form rejected and moved to Investigation successfully');
        }

        return redirect()
            ->back()
            ->with('error', 'Invalid facility status');
    }

    public function EditRejectForm(EducationFacility $facility)
    {
        $card = $facility->educationCard; // ✅ FIXED

        if (!$card) {
            return redirect()->back()->with('error', 'Education Card not found.');
        }

        $record = beneficiarie::find($card->reg_id)
            ?? Member::find($card->reg_id);

        if (!$record) {
            return redirect()->back()->with('error', 'Person not found.');
        }
        $officer = Staff::get();
        return view(
            'ngo.educationcard.reject-form',
            compact('facility', 'card', 'record', 'officer')
        );
    }

    public function UpdateInvestigationForm(Request $request, EducationFacility $facility)
    {
        $validated = $request->validate([
            'person_paying_amount'     => 'nullable|string|max:255',
            'account_no'               => 'nullable|string|max:50',
            'account_holder_name'      => 'nullable|string|max:255',
            'ifsc_code'                => 'nullable|string|max:20',
            'bank_name'                => 'nullable|string|max:255',
            'bank_branch'              => 'nullable|string|max:255',
            'account_holder_address'   => 'nullable|string',
            'investigation_proof'      => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        /* Handle photo upload */
        if ($request->hasFile('investigation_proof')) {
            $file = $request->file('investigation_proof');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);

            $validated['investigation_proof'] = $filename;
        }

        $facility->update([
            'person_paying_amount'     => $validated['person_paying_amount'] ?? $facility->person_paying_amount,
            'account_no'               => $validated['account_no'] ?? $facility->account_no,
            'account_holder_name'      => $validated['account_holder_name'] ?? $facility->account_holder_name,
            'ifsc_code'                => $validated['ifsc_code'] ?? $facility->ifsc_code,
            'bank_name'                => $validated['bank_name'] ?? $facility->bank_name,
            'bank_branch'              => $validated['bank_branch'] ?? $facility->bank_branch,
            'account_holder_address'   => $validated['account_holder_address'] ?? $facility->account_holder_address,
            'investigation_proof'      => $validated['investigation_proof'] ?? $facility->investigation_proof,
            'status'                   => 'Verify',
            'investigation_status'   => 1,
            'remark'                   => null, // reset remark after re-submission
        ]);

        return redirect()
            ->route('education.list.Investigationfacility')
            ->with('success', 'Investigation form updated and sent for verification successfully.');
    }

    public function VerifyInvestigationForm(Request $request, EducationFacility $facility)
    {
        $validated = $request->validate([
            'verify_proof'    => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        /* Handle photo upload (public/images) */
        if ($request->hasFile('verify_proof')) {
            $file = $request->file('verify_proof');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $validated['verify_proof'] = $filename;
        }

        $facility->update([
            'verify_proof'    => $validated['verify_proof'] ?? null,
            'status'                 => 'Approval',
        ]);

        return redirect()
            ->route('education.list.Verifyfacility')
            ->with('success', 'Verification Send To Director Successfully.');
    }

    public function ApprovalFacilityList(Request $request)
    {
        /* ---------- Education Card + Facility Constraint ---------- */


        $educationCardConstraint = function ($q) use ($request) {

            $q->where('status', 1)
                ->whereHas('educationFacilities', function ($ef) {
                    $ef->where('status', 'Approval');
                })
                ->with(['educationFacilities' => function ($ef) {
                    $ef->where('status', 'Approval');
                }]);

            if ($request->filled('educationcard_no')) {
                $q->where('educationcard_no', trim($request->educationcard_no));
            }
        };



        /* ---------- Base Queries ---------- */

        $queryBene = beneficiarie::with(['educationCards' => $educationCardConstraint])
            ->where('status', 1)
            ->whereHas('educationCards', $educationCardConstraint);

        $queryMember = Member::with(['educationCards' => $educationCardConstraint])
            ->where('status', 1)
            ->whereHas('educationCards', $educationCardConstraint);

        /* ---------- Filters (same as education demand) ---------- */

        if ($request->filled('session_filter')) {
            $queryBene->where('academic_session', $request->session_filter);
            $queryMember->where('academic_session', $request->session_filter);
        }

        if ($request->filled('application_no')) {
            $search = $request->application_no;

            $queryBene->where('application_no', 'like', "%{$search}%");
            $queryMember->where('application_no', 'like', "%{$search}%");
        }

        if ($request->filled('registration_no')) {
            $search = $request->registration_no;

            $queryBene->where('registration_no', 'like', "%{$search}%");
            $queryMember->where('registration_no', 'like', "%{$search}%");
        }

        if ($request->filled('name')) {

            $name = trim($request->name);

            $queryBene->where(function ($q) use ($name) {
                $q->where('name', 'like', "{$name}%")
                    ->orWhere('gurdian_name', 'like', "{$name}%");
            });

            $queryMember->where(function ($q) use ($name) {
                $q->where('name', 'like', "{$name}%")
                    ->orWhere('gurdian_name', 'like', "{$name}%");
            });
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

        /* ---------- Fetch Data ---------- */

        $beneficiaries = $queryBene->get();
        $members       = $queryMember->get();

        /* ---------- Flatten: Card + Facility ---------- */

        $combined = collect()
            ->merge($beneficiaries)
            ->merge($members)
            ->flatMap(function ($item) {
                return $item->educationCards->flatMap(function ($card) use ($item) {
                    return $card->educationFacilities->map(function ($facility) use ($item, $card) {
                        return [
                            'person'   => $item,
                            'card'     => $card,
                            'facility' => $facility,
                        ];
                    });
                });
            })
            ->sortBy(fn($row) => $row['facility']->created_at)
            ->values();

        /* ---------- Extra Data ---------- */

        $data   = academic_session::all();
        $states = config('states');
        $staff = Staff::get();
        return view(
            'ngo.educationcard.approval-list',
            compact('combined', 'data', 'states', 'staff')
        );
    }

    public function StoreFacilitiesStatus(Request $request, EducationFacility $facility)
    {
        $validated = $request->validate([
            'clearness_amount' => 'nullable|numeric',
            'work_category'    => 'required',
            'status' => 'required|in:Approve,Non-Budget,Demand-Pending,Reject',
            'reason' => 'nullable|string|required_if:status,Reject,Non-Budget,Demand-Pending',
        ]);

        $facility->update([
            'clearness_amount' => $validated['clearness_amount'] ?? null,
            'status' => $validated['status'],
            'work_category' => $validated['work_category'],
            'reason' => $validated['reason'] ?? null,
        ]);

        return redirect()
            ->route('education.list.Approvefacility')
            ->with('success', 'Health Facilities Status Update successfully.');
    }

    public function ApproveFacilityList(Request $request)
    {
        /* ---------- Education Card + Facility Constraint ---------- */


        $educationCardConstraint = function ($q) use ($request) {

            $q->where('status', 1)
                ->whereHas('educationFacilities', function ($ef) {
                    $ef->where('status', 'Approve');
                })
                ->with(['educationFacilities' => function ($ef) {
                    $ef->where('status', 'Approve');
                }]);

            if ($request->filled('educationcard_no')) {
                $q->where('educationcard_no', trim($request->educationcard_no));
            }
        };



        /* ---------- Base Queries ---------- */

        $queryBene = beneficiarie::with(['educationCards' => $educationCardConstraint])
            ->where('status', 1)
            ->whereHas('educationCards', $educationCardConstraint);

        $queryMember = Member::with(['educationCards' => $educationCardConstraint])
            ->where('status', 1)
            ->whereHas('educationCards', $educationCardConstraint);

        /* ---------- Filters (same as education demand) ---------- */

        if ($request->filled('session_filter')) {
            $queryBene->where('academic_session', $request->session_filter);
            $queryMember->where('academic_session', $request->session_filter);
        }

        if ($request->filled('application_no')) {
            $search = $request->application_no;

            $queryBene->where('application_no', 'like', "%{$search}%");
            $queryMember->where('application_no', 'like', "%{$search}%");
        }

        if ($request->filled('registration_no')) {
            $search = $request->registration_no;

            $queryBene->where('registration_no', 'like', "%{$search}%");
            $queryMember->where('registration_no', 'like', "%{$search}%");
        }

        if ($request->filled('name')) {

            $name = trim($request->name);

            $queryBene->where(function ($q) use ($name) {
                $q->where('name', 'like', "{$name}%")
                    ->orWhere('gurdian_name', 'like', "{$name}%");
            });

            $queryMember->where(function ($q) use ($name) {
                $q->where('name', 'like', "{$name}%")
                    ->orWhere('gurdian_name', 'like', "{$name}%");
            });
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

        /* ---------- Fetch Data ---------- */

        $beneficiaries = $queryBene->get();
        $members       = $queryMember->get();

        /* ---------- Flatten: Card + Facility ---------- */

        $combined = collect()
            ->merge($beneficiaries)
            ->merge($members)
            ->flatMap(function ($item) {
                return $item->educationCards->flatMap(function ($card) use ($item) {
                    return $card->educationFacilities->map(function ($facility) use ($item, $card) {
                        return [
                            'person'   => $item,
                            'card'     => $card,
                            'facility' => $facility,
                        ];
                    });
                });
            })
            ->sortBy(fn($row) => $row['facility']->created_at)
            ->values();

        /* ---------- Extra Data ---------- */

        $data   = academic_session::all();
        $states = config('states');
        $staff = Staff::get();
        return view(
            'ngo.educationcard.approve-list',
            compact('combined', 'data', 'states', 'staff')
        );
    }

    public function ShowFacilityForm(EducationFacility $facility)
    {
        $card = $facility->educationCard; // ✅ FIXED

        if (!$card) {
            return redirect()->back()->with('error', 'Education Card not found.');
        }

        $record = beneficiarie::find($card->reg_id)
            ?? Member::find($card->reg_id);

        if (!$record) {
            return redirect()->back()->with('error', 'Person not found.');
        }
        $officer = Staff::get();
        $signatures = Signature::pluck('file_path', 'role');
        return view(
            'ngo.educationcard.final-facility',
            compact('facility', 'card', 'record', 'officer', 'signatures')
        );
    }

    public function RejectFacilityList(Request $request)
    {
        /* ---------- Education Card + Facility Constraint ---------- */


        $educationCardConstraint = function ($q) use ($request) {

            $q->where('status', 1)
                ->whereHas('educationFacilities', function ($ef) {
                    $ef->where('status', 'Reject');
                })
                ->with(['educationFacilities' => function ($ef) {
                    $ef->where('status', 'Reject');
                }]);

            if ($request->filled('educationcard_no')) {
                $q->where('educationcard_no', trim($request->educationcard_no));
            }
        };



        /* ---------- Base Queries ---------- */

        $queryBene = beneficiarie::with(['educationCards' => $educationCardConstraint])
            ->where('status', 1)
            ->whereHas('educationCards', $educationCardConstraint);

        $queryMember = Member::with(['educationCards' => $educationCardConstraint])
            ->where('status', 1)
            ->whereHas('educationCards', $educationCardConstraint);

        /* ---------- Filters (same as education demand) ---------- */

        if ($request->filled('session_filter')) {
            $queryBene->where('academic_session', $request->session_filter);
            $queryMember->where('academic_session', $request->session_filter);
        }

        if ($request->filled('application_no')) {
            $search = $request->application_no;

            $queryBene->where('application_no', 'like', "%{$search}%");
            $queryMember->where('application_no', 'like', "%{$search}%");
        }

        if ($request->filled('registration_no')) {
            $search = $request->registration_no;

            $queryBene->where('registration_no', 'like', "%{$search}%");
            $queryMember->where('registration_no', 'like', "%{$search}%");
        }

        if ($request->filled('name')) {

            $name = trim($request->name);

            $queryBene->where(function ($q) use ($name) {
                $q->where('name', 'like', "{$name}%")
                    ->orWhere('gurdian_name', 'like', "{$name}%");
            });

            $queryMember->where(function ($q) use ($name) {
                $q->where('name', 'like', "{$name}%")
                    ->orWhere('gurdian_name', 'like', "{$name}%");
            });
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

        /* ---------- Fetch Data ---------- */

        $beneficiaries = $queryBene->get();
        $members       = $queryMember->get();

        /* ---------- Flatten: Card + Facility ---------- */

        $combined = collect()
            ->merge($beneficiaries)
            ->merge($members)
            ->flatMap(function ($item) {
                return $item->educationCards->flatMap(function ($card) use ($item) {
                    return $card->educationFacilities->map(function ($facility) use ($item, $card) {
                        return [
                            'person'   => $item,
                            'card'     => $card,
                            'facility' => $facility,
                        ];
                    });
                });
            })
            ->sortBy(fn($row) => $row['facility']->created_at)
            ->values();

        /* ---------- Extra Data ---------- */

        $data   = academic_session::all();
        $states = config('states');
        $staff = Staff::get();
        return view(
            'ngo.educationcard.reject-list',
            compact('combined', 'data', 'states', 'staff')
        );
    }

    public function NonBudgetFacilityList(Request $request)
    {
        /* ---------- Education Card + Facility Constraint ---------- */


        $educationCardConstraint = function ($q) use ($request) {

            $q->where('status', 1)
                ->whereHas('educationFacilities', function ($ef) {
                    $ef->where('status', 'Non-Budget');
                })
                ->with(['educationFacilities' => function ($ef) {
                    $ef->where('status', 'Non-Budget');
                }]);

            if ($request->filled('educationcard_no')) {
                $q->where('educationcard_no', trim($request->educationcard_no));
            }
        };



        /* ---------- Base Queries ---------- */

        $queryBene = beneficiarie::with(['educationCards' => $educationCardConstraint])
            ->where('status', 1)
            ->whereHas('educationCards', $educationCardConstraint);

        $queryMember = Member::with(['educationCards' => $educationCardConstraint])
            ->where('status', 1)
            ->whereHas('educationCards', $educationCardConstraint);

        /* ---------- Filters (same as education demand) ---------- */

        if ($request->filled('session_filter')) {
            $queryBene->where('academic_session', $request->session_filter);
            $queryMember->where('academic_session', $request->session_filter);
        }

        if ($request->filled('application_no')) {
            $search = $request->application_no;

            $queryBene->where('application_no', 'like', "%{$search}%");
            $queryMember->where('application_no', 'like', "%{$search}%");
        }

        if ($request->filled('registration_no')) {
            $search = $request->registration_no;

            $queryBene->where('registration_no', 'like', "%{$search}%");
            $queryMember->where('registration_no', 'like', "%{$search}%");
        }

        if ($request->filled('name')) {

            $name = trim($request->name);

            $queryBene->where(function ($q) use ($name) {
                $q->where('name', 'like', "{$name}%")
                    ->orWhere('gurdian_name', 'like', "{$name}%");
            });

            $queryMember->where(function ($q) use ($name) {
                $q->where('name', 'like', "{$name}%")
                    ->orWhere('gurdian_name', 'like', "{$name}%");
            });
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

        /* ---------- Fetch Data ---------- */

        $beneficiaries = $queryBene->get();
        $members       = $queryMember->get();

        /* ---------- Flatten: Card + Facility ---------- */

        $combined = collect()
            ->merge($beneficiaries)
            ->merge($members)
            ->flatMap(function ($item) {
                return $item->educationCards->flatMap(function ($card) use ($item) {
                    return $card->educationFacilities->map(function ($facility) use ($item, $card) {
                        return [
                            'person'   => $item,
                            'card'     => $card,
                            'facility' => $facility,
                        ];
                    });
                });
            })
            ->sortBy(fn($row) => $row['facility']->created_at)
            ->values();

        /* ---------- Extra Data ---------- */

        $data   = academic_session::all();
        $states = config('states');
        $staff = Staff::get();
        return view(
            'ngo.educationcard.non-budget',
            compact('combined', 'data', 'states', 'staff')
        );
    }
}
