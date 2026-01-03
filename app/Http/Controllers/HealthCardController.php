<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\beneficiarie;
use App\Models\Disease;
use App\Models\HealthCard;
use App\Models\Hospital;
use App\Models\Member;
use App\Models\Signature;
use Illuminate\Http\Request;

class HealthCardController extends Controller
{
    public function AddDisease()
    {
        $diseases = Disease::orderBy('disease', 'ASC')->get();
        return view('ngo.healthcard.add-disease', compact('diseases'));
    }

    public function StoreDisease(Request $request)
    {
        $request->validate([
            'disease' => 'required|string|max:255'
        ]);

        // Prevent duplicate disease entry
        $exists = Disease::where('disease', $request->disease)->exists();

        if ($exists) {
            return redirect()->back()
                ->withErrors(['disease' => 'This disease already exists.'])
                ->withInput();
        }

        Disease::create([
            'disease' => $request->disease
        ]);

        return redirect()->back()->with('success', 'Disease added successfully.');
    }

    public function DestroyDisease($id)
    {
        Disease::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Disease deleted successfully.');
    }
    public function ListHospital()
    {
        $hospitals = Hospital::orderBy('hospital_name', 'ASC')->get();
        return view('ngo.healthcard.hospital-list', compact('hospitals'));
    }
    public function AddHospital()
    {
        // Get last hospital code
        $lastHospital = Hospital::orderBy('id', 'desc')->first();

        if ($lastHospital) {
            $lastNumber = intval(substr($lastHospital->hospital_code, 6));
            $nextCode = '219HC' . str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $nextCode = '219HC00001';
        }

        $hospitals = Hospital::orderBy('hospital_name', 'asc')->get();

        return view('ngo.healthcard.add-hospital', compact('hospitals', 'nextCode'));
    }
    public function StoreHospital(Request $request)
    {
        $request->validate([
            'hospital_name' => 'required|string|max:255',
            'contact_number' => 'nullable|digits_between:10,12',
            'registration_date' => 'nullable|date',
            'gst_document' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'license_document' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'operator_degree_document' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'operator_aadhar_document' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        ]);

        // Generate Hospital Code
        $last = \App\Models\Hospital::orderBy('id', 'desc')->first();
        $nextCode = $last
            ? '219HC' . str_pad((int)substr($last->hospital_code, 6) + 1, 5, '0', STR_PAD_LEFT)
            : '219HC00001';

        $data = $request->only([
            'hospital_name',
            'address',
            'contact_number',
            'operator_name',
            'registration_date',
            'status',
            'operator_aadhar',
            'operator_degree',
            'gst_no',
            'license_no'
        ]);

        $data['hospital_code'] = $nextCode;

        // Uploads
        foreach (
            [
                'gst_document',
                'license_document',
                'operator_degree_document',
                'operator_aadhar_document'
            ] as $file
        ) {
            if ($request->hasFile($file)) {
                $data[$file] = $request->file($file)->store("documents", "public");
            }
        }

        \App\Models\Hospital::create($data);

        return redirect()->back()->with('success', 'Hospital added successfully.');
    }

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

        return view('ngo.healthcard.reg-list', compact(
            'data',
            'approvebeneficiarie',
            'approvemember',
            'combined',
            'states'
        ));
    }

    public function GenerateHealthCard($id, $type)
    {
        if ($type === 'Beneficiaries') {
            $record = beneficiarie::where('status', 1)->findorFail($id);
        } else {
            $record = Member::where('status', 1)->findorFail($id);
        }
        $signatures = Signature::pluck('file_path', 'role');
        $hospitals = \App\Models\Hospital::orderBy('hospital_name')->get();
        $diseases  = \App\Models\Disease::orderBy('disease')->get();

        $lastCard = \App\Models\HealthCard::orderBy('id', 'desc')->first();

        $nextNumber = $lastCard
            ? intval(substr($lastCard->healthcard_no, -8)) + 1
            : 1;

        $nextCard = '219HCN' . str_pad($nextNumber, 8, '0', STR_PAD_LEFT);


        return view('ngo.healthcard.generate-card', compact('record', 'signatures', 'hospitals', 'diseases', 'nextCard'));
    }
    public function StoreHealthCard(Request $request)
    {
        $request->validate([
            'hospital_name' => 'required',
            'reg_id'    => 'required',
            'diseases' => 'required|array|min:1',
            'Health_registration_date' => 'required|date',
        ]);

        \App\Models\HealthCard::create([
            'reg_id' => $request->reg_id,
            'healthcard_no' => $request->healthcard_no,
            'hospital_name' => $request->hospital_name,
            'diseases' => $request->diseases,
            'Health_registration_date' => $request->Health_registration_date,
            'status'   => '1',
        ]);

        return redirect()->back()->with('success', 'Health card created successfully.');
    }
    public function EditHealthCard($health_id)
    {
        $healthcard = HealthCard::with(['beneficiary', 'member'])->findOrFail($health_id);

        // Detect owner (Beneficiary or Member)
        $person = $healthcard->beneficiary ?? $healthcard->member;

        if (!$person) {
            abort(404, 'Person not found for this health card');
        }

        $hospitals = Hospital::orderBy('hospital_name')->get();
        $diseases  = Disease::orderBy('disease')->get();

        return view('ngo.healthcard.edit-card', compact(
            'healthcard',
            'person',
            'hospitals',
            'diseases'
        ));
    }
    public function UpdateHealthCard(Request $request, $health_id)
    {
        $request->validate([
            'Health_registration_date' => 'required|date',
            'hospital_name'            => 'required|string',
            'diseases'                 => 'required|array',
            'diseases.*'               => 'string'
        ]);

        $healthcard = HealthCard::findOrFail($health_id);

        $healthcard->update([
            'Health_registration_date' => $request->Health_registration_date,
            'hospital_name'            => $request->hospital_name,
            'diseases'                 => $request->diseases,
        ]);


        return redirect()->back()->with('success', 'Health Card updated successfully');
    }
    public function CardList(Request $request)
    {
        $queryBene = beneficiarie::with(['healthCard' => function ($q) {
            $q->where('status', 1);
        }])
            ->where('status', 1)
            ->whereHas('healthCard', function ($q) {
                $q->where('status', 1);
            });

        $queryMember = Member::with(['healthCard' => function ($q) {
            $q->where('status', 1);
        }])
            ->where('status', 1)
            ->whereHas('healthCard', function ($q) {
                $q->where('status', 1);
            });

        if ($request->filled('session_filter')) {
            $queryBene->where('academic_session', $request->session_filter);
            $queryMember->where('academic_session', $request->session_filter);
        }

        if ($request->filled('application_no')) {
            $search = $request->application_no;

            $queryBene->where(
                fn($q) =>
                $q->where('application_no', 'like', "%$search%")
                    ->orWhere('registration_no', 'like', "%$search%")
            );

            $queryMember->where(
                fn($q) =>
                $q->where('application_no', 'like', "%$search%")
                    ->orWhere('registration_no', 'like', "%$search%")
            );
        }

        if ($request->filled('identity_no')) {
            $identity = $request->identity_no;

            $queryBene->where(
                fn($q) =>
                $q->where('phone', 'like', "%$identity%")
                    ->orWhere('identity_no', 'like', "%$identity%")
            );

            $queryMember->where(
                fn($q) =>
                $q->where('phone', 'like', "%$identity%")
                    ->orWhere('identity_no', 'like', "%$identity%")
            );
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

        $beneficiaries = $queryBene->get();
        $members = $queryMember->get();

        /* FLATTEN: one row per health card */
        $combined = collect()
            ->merge($beneficiaries)
            ->merge($members)
            ->flatMap(function ($item) {
                return $item->healthCard->map(function ($card) use ($item) {
                    return [
                        'person' => $item,
                        'card'   => $card
                    ];
                });
            })
            ->sortBy(fn($row) => $row['card']->created_at)
            ->values();

        $data = academic_session::all();
        $states = config('states');

        return view('ngo.healthcard.card-list', compact(
            'combined',
            'data',
            'states'
        ));
    }

    public function ShowHealthCard($id, $health_id)
    {
        // Try Beneficiarie first
        $record = Beneficiarie::find($id);

        // If not found, try Member
        if (!$record) {
            $record = Member::find($id);
        }

        // If neither found
        if (!$record) {
            return redirect()->back()->with('error', 'Record not found.');
        }

        // Fetch ONE health card from hasMany relationship
        $healthCard = $record->healthCard()
            ->where('id', $health_id)
            ->first();

        if (!$healthCard) {
            return redirect()->back()->with('error', 'Health Card not found.');
        }

        return view('ngo.healthcard.card', compact('record', 'healthCard'));
    }
}
