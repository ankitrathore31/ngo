<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\beneficiarie;
use App\Models\KycVerification;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class KycController extends Controller
{
    public function BeneficiarieListForKyc(Request $request)
    {
        $queryBene = beneficiarie::where([
            ['status', '=', 1],
            ['kyc_status', '=', 0],
        ]);

        if ($request->filled('session_filter')) {
            $queryBene->where('academic_session', $request->session_filter);
        }

        // Application / Registration Number Search
        if ($request->filled('application_no')) {
            $search = $request->application_no;

            $queryBene->where(function ($q) use ($search) {
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
        }


        if ($request->filled('block')) {
            $queryBene->where('block', 'like', "%{$request->block}%");
        }

        if ($request->filled('state')) {
            $queryBene->where('state', $request->state);
        }

        if ($request->filled('district')) {
            $queryBene->where('district', $request->district);
        }

        $beneficiarie = $queryBene->orderBy('created_at', 'asc')->get();


        $data = academic_session::all();
        $states = config('states');

        return view('ngo.kyc.list', compact(
            'data',
            'beneficiarie',
            'states'
        ));
    }

    public function BeneficiarieKyc($id)
    {
        $record = beneficiarie::findOrFail($id);
        $staffs = Staff::get();
        return view('ngo.kyc.kyc', compact('record', 'staffs'));
    }

    public function StoreKyc(Request $request, $id)
    {
        // Normalize Aadhaar (remove spaces)
        $aadhaar = str_replace(' ', '', $request->aadhaar_no);

        // Rule 1: One KYC per Beneficiary
        if (KycVerification::where('beneficiarie_id', $id)->exists()) {
            return back()
                ->withInput()
                ->with('error', 'KYC already exists for this beneficiary.');
        }

        // Rule 2: Aadhaar must be unique
        if (KycVerification::where('aadhaar_no', $aadhaar)->exists()) {
            return back()
                ->withInput()
                ->with('error', 'This Aadhaar number is already used for another beneficiary.');
        }
        $beneficiary = beneficiarie::findOrFail($id);
        if ($beneficiary->identity_type === 'Aadhar Card') {
            $reqAadhar =  $beneficiary->identity_no;

            if ($aadhaar !== $reqAadhar) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Beneficiary Aadhaar No does not match Kyc Aadhaar No.'
                    );
            }
        }

        $request->validate([
            'aadhaar_no'    => 'required|string|max:14',
            'aadhaar_front' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'aadhaar_back'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'staff'         => 'required',
            'verified_at'   =>  'required|date',
        ]);

        $data = [
            'beneficiarie_id' => $id,
            'aadhaar_no'      => $aadhaar,
            'verified_by'     => $request->staff,
            'verified_at'     => $request->verified_at,
        ];

        $path = public_path('documents');
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        if ($request->hasFile('aadhaar_front')) {
            $file = $request->file('aadhaar_front');
            $name = 'aadhaar_front_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($path, $name);
            $data['aadhaar_front'] = 'documents/' . $name;
        }

        if ($request->hasFile('aadhaar_back')) {
            $file = $request->file('aadhaar_back');
            $name = 'aadhaar_back_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($path, $name);
            $data['aadhaar_back'] = 'documents/' . $name;
        }

        KycVerification::create($data);
        beneficiarie::where('id', $id)->update(['kyc_status' => 1]);

        return redirect()
            ->route('list.pending.kyc')
            ->with('success', 'KYC submitted successfully.');
    }

    public function EditBeneficiarieKyc($id, $kyc_id)
    {
        $record = beneficiarie::findOrFail($id);
        $kyc = KycVerification::findOrFail($kyc_id);
        $staffs = Staff::get();
        return view('ngo.kyc.edit-kyc', compact('record', 'kyc', 'staffs'));
    }

    public function UpdateKyc(Request $request, $id)
    {
        $kyc = KycVerification::findOrFail($id);

        $aadhaar = str_replace(' ', '', $request->aadhaar_no);

        // Aadhaar unique except current record
        if (
            KycVerification::where('aadhaar_no', $aadhaar)
            ->where('id', '!=', $id)
            ->exists()
        ) {
            return back()->with('error', 'Aadhaar already exists.');
        }

        $request->validate([
            'aadhaar_no'    => 'required|string|max:14',
            'aadhaar_front' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'aadhaar_back'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'staff'         => 'required',
            'verified_at'   => 'required|date',
        ]);

        $data = [
            'aadhaar_no'  => $aadhaar,
            'verified_by' => $request->staff,
            'verified_at' => $request->verified_at,
        ];

        $path = public_path('documents');
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        if ($request->hasFile('aadhaar_front')) {
            $file = $request->file('aadhaar_front');
            $name = 'aadhaar_front_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($path, $name);
            $data['aadhaar_front'] = 'documents/' . $name;
        }

        if ($request->hasFile('aadhaar_back')) {
            $file = $request->file('aadhaar_back');
            $name = 'aadhaar_back_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($path, $name);
            $data['aadhaar_back'] = 'documents/' . $name;
        }

        $kyc->update($data);

        return redirect()
            ->route('list.pending.kyc')
            ->with('success', 'KYC updated successfully.');
    }

    public function deleteKyc($id)
    {
        // Find KYC
        $kyc = KycVerification::where('beneficiarie_id', $id)->firstOrFail();

        // ✅ Delete files if exist
        if ($kyc->aadhaar_front && File::exists(public_path($kyc->aadhaar_front))) {
            File::delete(public_path($kyc->aadhaar_front));
        }

        if ($kyc->aadhaar_back && File::exists(public_path($kyc->aadhaar_back))) {
            File::delete(public_path($kyc->aadhaar_back));
        }

        // ✅ Delete KYC record
        $kyc->delete();

        // ✅ Update beneficiary KYC status
        beneficiarie::where('id', $id)->update([
            'kyc_status' => 0
        ]);

        return redirect()
            ->back()
            ->with('success', 'KYC deleted successfully.');
    }


    public function PendingKycList(Request $request)
    {
        $query = beneficiarie::with(['kyc'])
            ->whereHas('kyc', function ($q) {
                $q->where('status', 'pending');
            });

        // Academic Session
        if ($request->filled('session_filter')) {
            $query->where('academic_session', $request->session_filter);
        }

        // Application / Registration No
        if ($request->filled('application_no')) {
            $search = $request->application_no;
            $query->where(function ($q) use ($search) {
                $q->where('application_no', 'like', "%{$search}%")
                    ->orWhere('registration_no', 'like', "%{$search}%");
            });
        }

        // Mobile / Identity No
        if ($request->filled('identity_no')) {
            $identity = $request->identity_no;
            $query->where(function ($q) use ($identity) {
                $q->where('phone', 'like', "%{$identity}%")
                    ->orWhereHas('kycVerification', function ($k) use ($identity) {
                        $k->where('aadhaar_no', 'like', "%{$identity}%");
                    });
            });
        }

        // Location Filters
        foreach (['block', 'state', 'district'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->$field);
            }
        }

        $beneficiarie = $query->orderBy('created_at', 'desc')->get();

        $data   = academic_session::all();
        $states = config('states');

        return view('ngo.kyc.pending-list', compact(
            'data',
            'states',
            'beneficiarie'
        ));
    }

    public function ApproveKycList(Request $request)
    {
        $query = beneficiarie::with(['kyc'])
            ->whereHas('kyc', function ($q) {
                $q->where('status', 'approved');
            });

        // Academic Session
        if ($request->filled('session_filter')) {
            $query->where('academic_session', $request->session_filter);
        }

        // Application / Registration No
        if ($request->filled('application_no')) {
            $search = $request->application_no;
            $query->where(function ($q) use ($search) {
                $q->where('application_no', 'like', "%{$search}%")
                    ->orWhere('registration_no', 'like', "%{$search}%");
            });
        }

        // Mobile / Identity No
        if ($request->filled('identity_no')) {
            $identity = $request->identity_no;
            $query->where(function ($q) use ($identity) {
                $q->where('phone', 'like', "%{$identity}%")
                    ->orWhereHas('kycVerification', function ($k) use ($identity) {
                        $k->where('aadhaar_no', 'like', "%{$identity}%");
                    });
            });
        }

        // Location Filters
        foreach (['block', 'state', 'district'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->$field);
            }
        }

        $beneficiarie = $query->orderBy('created_at', 'asc')->get();

        $data   = academic_session::all();
        $states = config('states');

        return view('ngo.kyc.approve-list', compact(
            'data',
            'states',
            'beneficiarie'
        ));
    }

    public function StoreKycStatus(Request $request, $id)
    {
        $kyc = KycVerification::findOrFail($id);

        $kyc->status = 'approved'; // or 1 if using numeric status
        $kyc->save();

        return redirect()
            ->route('list.approve.kyc')
            ->with('success', 'KYC approved successfully.');
    }

    public function ShowKyc($id, $kyc_id)
    {
        $record = beneficiarie::findOrFail($id);
        $kyc = KycVerification::findOrFail($kyc_id);

        return view('ngo.kyc.show-kyc', compact('record', 'kyc'));
    }
}
