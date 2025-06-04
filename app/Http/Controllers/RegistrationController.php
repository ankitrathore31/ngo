<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\beneficiarie;
use App\Models\Member;
use App\Models\academic_session;
use App\Models\Setting;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class RegistrationController extends Controller
{
    public function registration()
    {
        $states = config('states');
        $data = academic_session::all()->sortByDesc('session_date');
        Session::put('all_academic_session', $data);
        return view('ngo.registration.registration', compact('states', 'data'));
    }

    public function StoreRegistration(Request $request)
    {
        // die($request);
        // exit();
        $request->validate([
            'academic_session' => 'required',
            'application_date' => 'required|date',
            'reg_type' => 'required',
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|string|in:Male,Female,Other',
            'phone' => 'required|string|max:20',
            'gurdian_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'village' => 'nullable|string|max:255',
            'post' => 'required|string|max:255',
            'block' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'pincode' => 'nullable|string|max:10',
            'country' => 'required|string|max:100',
            'email' => 'nullable|email|max:255',
            'religion' => 'required|string|max:100',
            'religion_category' => 'required|string|max:100',
            'caste' => 'required|string|max:100',
            'image' => 'nullable|image|max:2048',
            'identity_type' => 'required|string|max:255',
            'identity_no' => 'required|string|max:255',
            'id_document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'occupation' => 'required|string|max:255',
            'eligibility' => 'nullable|string|max:100',
            'marital_status' => 'required|string|in:Married,Unmarried',
            'area_type' => 'required|string|in:Rular,Urban',
        ]);

        $data = $request->only([
            'academic_session',
            'application_date',
            'reg_type',
            'name',
            'dob',
            'gender',
            'phone',
            'gurdian_name',
            'mother_name',
            'village',
            'post',
            'block',
            'state',
            'district',
            'pincode',
            'country',
            'email',
            'religion',
            'religion_category',
            'caste',
            'identity_type',
            'identity_no',
            'occupation',
            'eligibility',
            'marital_status',
            'area_type',
            'help_needed',

        ]);

        $data['status'] = 0;
        $prefix = '2191000';

        // Get the latest application_no starting with the prefix
        $latest = beneficiarie::where('application_no', 'LIKE', $prefix . '%')
            ->orderBy('application_no', 'desc')
            ->first();

        if ($latest) {
            // Extract the numeric sequence after the prefix
            $last_sequence = (int)substr($latest->application_no, strlen($prefix));
            $sequence_number = $last_sequence + 1;
        } else {
            // First record starts at 60
            $sequence_number = 60;
        }

        // Generate the new application number
        $data['application_no'] = $prefix . str_pad($sequence_number, 3, '0', STR_PAD_LEFT);


        try {
            if (!empty($data['application_date'])) {
                $data['application_date'] = Carbon::parse($data['application_date'])->format('Y-m-d');
            }

            if (!empty($data['dob'])) {
                $data['dob'] = Carbon::parse($data['dob'])->format('Y-m-d');
            }
        } catch (\Exception $e) {
            return back()->withErrors(['date_error' => 'Invalid date format for Application Date or Date of Birth.']);
        }

        if ($request->reg_type === 'Beneficiaries') {

            // Handle profile image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('benefries_images'), $imageName);
                $data['image'] = $imageName;
            }

            // Handle ID document upload
            if ($request->hasFile('id_document')) {
                $idDoc = $request->file('id_document');
                $idDocName = time() . '_iddoc.' . $idDoc->getClientOriginalExtension();
                $idDoc->move(public_path('benefries_images'), $idDocName);
                $data['id_document'] = $idDocName;
            }

            beneficiarie::create($data);
        } else if ($request->reg_type === 'Member') {
            Member::create($data);
        }

        return redirect()->route('pending-registration')->with('success', 'Registration saved successfully.');
    }

    public function editRegistration($id)
    {

        $beneficiarie = beneficiarie::find($id);
        $data = academic_session::all();
        Session::put('all_academic_session', $data);
        return view('ngo.registration.edit-reg', compact('beneficiarie', 'data'));
    }

    public function UpdateRegistration(Request $request, $id)
    {

        $data = $request->only([
            'academic_session',
            'application_date',
            'reg_type',
            'name',
            'dob',
            'gender',
            'phone',
            'gurdian_name',
            'mother_name',
            'village',
            'post',
            'block',
            'state',
            'district',
            'pincode',
            'country',
            'email',
            'religion',
            'religion_category',
            'caste',
            'identity_type',
            'identity_no',
            'occupation',
            'eligibility',
            'marital_status',
            'area_type',
            'help_needed',
        ]);

        // Handle file uploads
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('benefries_images'), $imageName);
            $data['image'] = $imageName;
        }

        if ($request->hasFile('id_document')) {
            $idDocName = time() . '_iddoc.' . $request->id_document->extension();
            $request->id_document->move(public_path('benefries_images'), $idDocName);
            $data['id_document'] = $idDocName;
        }

        try {
            if (!empty($data['application_date'])) {
                $data['application_date'] = Carbon::parse($data['application_date'])->format('Y-m-d');
            }

            if (!empty($data['dob'])) {
                $data['dob'] = Carbon::parse($data['dob'])->format('Y-m-d');
            }
        } catch (\Exception $e) {
            return back()->withErrors(['date_error' => 'Invalid date format for Application Date or Date of Birth.']);
        }

        // Update the existing record based on reg_type
        if ($request->reg_type === 'Beneficiaries') {
            beneficiarie::where('id', $id)->update($data);
        } else if ($request->reg_type === 'Member') {
            Member::where('id', $id)->update($data);
        }

        return redirect()->route('pending-registration')->with('success', 'Registration updated successfully.');
    }

    public function viewRegistration($id)
    {

        $beneficiarie = beneficiarie::find($id);
        return view('ngo.registration.view-reg', compact('beneficiarie'));
    }

    public function pendingRegistration(Request $request)
    {
        $queryBene = beneficiarie::where('status', 0);
        $queryMember = Member::where('status', 0);

        if ($request->filled('session_filter')) {
            $queryBene->where('academic_session', $request->session_filter);
            $queryMember->where('academic_session', $request->session_filter);
        }

        if ($request->filled('application_no')) {
            $queryBene->where('application_no', $request->application_no);
            $queryMember->where('application_no', $request->application_no);
        }

        if ($request->filled('name')) {
            $queryBene->where('name', 'like', '%' . $request->name . '%');
            $queryMember->where('name', 'like', '%' . $request->name . '%');
        }

        $pendingbene = $queryBene->get();
        $pendingmemeber = $queryMember->get();
        $combined = $pendingbene->merge($pendingmemeber);
        $data = academic_session::all();

        return view('ngo.registration.pending-reg-list', compact('data', 'pendingbene', 'pendingmemeber', 'combined'));
    }

    public function approveRegistration(Request $request)
    {
        $queryBene = beneficiarie::where('status', 1);
        $queryMember = Member::where('status', 1);

        if ($request->filled('session_filter')) {
            $queryBene->where('academic_session', $request->session_filter);
            $queryMember->where('academic_session', $request->session_filter);
        }

        if ($request->filled('application_no')) {
            $queryBene->where('application_no', $request->application_no);
            $queryMember->where('application_no', $request->application_no);
        }

        if ($request->filled('name')) {
            $queryBene->where('name', 'like', '%' . $request->name . '%');
            $queryMember->where('name', 'like', '%' . $request->name . '%');
        }

        $approvebeneficiarie = $queryBene->get();
        $approvemember = $queryMember->get();
        $data = academic_session::all();
        $combined = $approvebeneficiarie->merge($approvemember);
        return view('ngo.registration.apporve-reg-list', compact('data', 'approvebeneficiarie', 'approvemember', 'combined'));
    }

    public function approveStatus(Request $request, $id)
    {
        $request->validate([
            'registration_date' => 'required',
        ]);

        $beneficiarie = beneficiarie::find($id);
        if ($beneficiarie && $beneficiarie->reg_type === 'Beneficiaries') {
            $beneficiarie->status = 1;
            $prefix = '2192000';

            $latest = beneficiarie::where('registration_no', 'LIKE', $prefix . '%')
                ->orderBy('registration_no', 'desc')
                ->first();

            if ($latest) {
                $last_sequence = (int)substr($latest->registration_no, strlen($prefix));
                $sequence_number = $last_sequence + 1;
            } else {
                $sequence_number = 55;
            }

            $beneficiarie->registration_no = $prefix . str_pad($sequence_number, 3, '0', STR_PAD_LEFT);
            $beneficiarie->registration_date = Carbon::parse($request->input('registration_date'));
            $beneficiarie->survey_status = 0;
            $beneficiarie->save();

            return redirect()->route('approve-registration')->with('success', 'Beneficiarie approved successfully.');
        }

        $member = Member::find($id);
        if ($member && $member->reg_type === 'Member') {
            $member->status = 1;
            $prefix = '2192000';
            $sequence_number = 55;
            $member->registration_no = $prefix . str_pad($sequence_number, 3, '0', STR_PAD_LEFT);
            $member->registration_date = Carbon::parse($request->input('registration_date'));
            $member->save();

            return redirect()->back()->with('success', 'Member approved successfully.');
        }

        return redirect()->back()->with('error', 'Record not found or unknown type.');
    }


    public function showApporveReg($id)
    {

        $beneficiarie = beneficiarie::where('status', 1)->find($id);

        return view('ngo.registration.show-apporve-reg', compact('beneficiarie'));
    }
    public function editApproveRegistration($id)
    {

        $beneficiarie = beneficiarie::find($id);
        $data = academic_session::all();
        Session::put('all_academic_session', $data);
        return view('ngo.registration.edit-apporve-reg', compact('beneficiarie', 'data'));
    }

    public function UpdateApporveRegistration(Request $request, $id)
    {

        $data = $request->only([
            'academic_session',
            'application_date',
            'reg_type',
            'name',
            'dob',
            'gender',
            'phone',
            'gurdian_name',
            'mother_name',
            'village',
            'post',
            'block',
            'state',
            'district',
            'pincode',
            'country',
            'email',
            'religion',
            'religion_category',
            'caste',
            'identity_type',
            'identity_no',
            'occupation',
            'eligibility',
            'marital_status',
            'area_type',
            'help_needed',
        ]);

        // Handle file uploads
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('benefries_images'), $imageName);
            $data['image'] = $imageName;
        }

        if ($request->hasFile('id_document')) {
            $idDocName = time() . '_iddoc.' . $request->id_document->extension();
            $request->id_document->move(public_path('benefries_images'), $idDocName);
            $data['id_document'] = $idDocName;
        }

        try {
            if (!empty($data['application_date'])) {
                $data['application_date'] = Carbon::parse($data['application_date'])->format('Y-m-d');
            }

            if (!empty($data['dob'])) {
                $data['dob'] = Carbon::parse($data['dob'])->format('Y-m-d');
            }
        } catch (\Exception $e) {
            return back()->withErrors(['date_error' => 'Invalid date format for Application Date or Date of Birth.']);
        }

        // Update the existing record based on reg_type
        if ($request->reg_type === 'Beneficiaries') {
            beneficiarie::where('id', $id)->update($data);
        } else if ($request->reg_type === 'Member') {
            Member::where('id', $id)->update($data);
        }

        return redirect()->route('pending-registration')->with('success', 'Registration updated successfully.');
    }

    public function pendingStatus($id)
    {
        $beneficiarie = beneficiarie::find($id);
        if ($beneficiarie && $beneficiarie->reg_type === 'Beneficiaries') {
            $beneficiarie->status = 0;
            $beneficiarie->save();

            return redirect()->back()->with('success', 'Beneficiarie Pending successfully.');
        }


        $member = Member::find($id);
        if ($member && $member->reg_type === 'Member') {
            $member->status = 0;
            $member->save();

            return redirect()->back()->with('success', 'Member Pending successfully.');
        }

        return redirect()->back()->with('error', 'Record not found or unknown type.');
    }




    public function deleteRegistrationPage($id)
    {

        $beneficiarie = beneficiarie::find($id);
        return view('ngo.registration.delete-reg', compact('beneficiarie'));
    }

    public function deleteRegistration(Request $request, $id)
    {
        $beneficiarie = beneficiarie::find($id);
        if (!$beneficiarie) {
            return redirect()->back()->with('error', 'Record not found.');
        }

        // Validate reason
        $request->validate([
            'reason' => 'required|string',
            'delete_date',
        ]);


        $beneficiarie->delete_reason = $request->input('reason');
        $beneficiarie->delete_date = Carbon::parse($request->input('delete_date'));
        $beneficiarie->save();


        $beneficiarie->delete();

        return redirect()->route('recover')->with('success', 'Registration deleted successfully.');
    }

    public function recover()
    {
        $deletedBeneficiaries = beneficiarie::onlyTrashed()->get();
        return view('ngo.registration.recover-reg', compact('deletedBeneficiaries'));
    }

    public function recoverItem($id)
    {
        $beneficiarie = beneficiarie::onlyTrashed()->find($id);

        if (!$beneficiarie) {
            return redirect()->route('recover')->with('error', 'Record not found in deleted items.');
        }

        // Restore the record
        $beneficiarie->restore();

        return redirect()->route('recover')->with('success', 'Beneficiary recovered successfully.');
    }

    public function onlineregistration()
    {
        $enabled = Setting::getValue('online_registration_enabled', '0');

        if ($enabled !== '1') {
            // Return error view with message
            $error = 'Online registration facility is not available, please contact your concerned institution';
            return view('home.registration.error', compact('error'));
        }

        $states = config('states');
        $data = academic_session::all()->sortByDesc('session_date');
        Session::put('all_academic_session', $data);

        return view('home.registration.add-registration', compact('states', 'data'));
    }

    public function onlineStoreRegistration(Request $request)
    {
        // die($request);
        // exit();
        $request->validate([
            'academic_session' => 'required',
            'application_date' => 'required|date',
            'reg_type' => 'required',
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|string|in:Male,Female,Other',
            'phone' => 'required|string|max:20',
            'gurdian_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'village' => 'nullable|string|max:255',
            'post' => 'required|string|max:255',
            'block' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'pincode' => 'nullable|string|max:10',
            'country' => 'required|string|max:100',
            'email' => 'nullable|email|max:255',
            'religion' => 'required|string|max:100',
            'religion_category' => 'required|string|max:100',
            'caste' => 'required|string|max:100',
            'image' => 'nullable|image|max:2048',
            'identity_type' => 'required|string|max:255',
            'identity_no' => 'required|string|max:255',
            'id_document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'occupation' => 'required|string|max:255',
            'eligibility' => 'nullable|string|max:100',
            'marital_status' => 'required|string|in:Married,Unmarried',
            'area_type' => 'required|string|in:Rular,Urban',
        ]);

        $data = $request->only([
            'academic_session',
            'application_date',
            'reg_type',
            'name',
            'dob',
            'gender',
            'phone',
            'gurdian_name',
            'mother_name',
            'village',
            'post',
            'block',
            'state',
            'district',
            'pincode',
            'country',
            'email',
            'religion',
            'religion_category',
            'caste',
            'identity_type',
            'identity_no',
            'occupation',
            'eligibility',
            'marital_status',
            'area_type',
            'help_needed',

        ]);

        $data['status'] = 0;
        $prefix = '2191000';

        // Get the latest application_no starting with the prefix
        $latest = beneficiarie::where('application_no', 'LIKE', $prefix . '%')
            ->orderBy('application_no', 'desc')
            ->first();

        if ($latest) {
            // Extract the numeric sequence after the prefix
            $last_sequence = (int)substr($latest->application_no, strlen($prefix));
            $sequence_number = $last_sequence + 1;
        } else {
            // First record starts at 60
            $sequence_number = 60;
        }

        // Generate the new application number
        $data['application_no'] = $prefix . str_pad($sequence_number, 3, '0', STR_PAD_LEFT);


        try {
            if (!empty($data['application_date'])) {
                $data['application_date'] = Carbon::parse($data['application_date'])->format('Y-m-d');
            }

            if (!empty($data['dob'])) {
                $data['dob'] = Carbon::parse($data['dob'])->format('Y-m-d');
            }
        } catch (\Exception $e) {
            return back()->withErrors(['date_error' => 'Invalid date format for Application Date or Date of Birth.']);
        }

        // if ($request->hasFile('image')) {
        //     $imageName = time() . '.' . $request->image->extension();
        //     $request->image->move(public_path('benefries_images'), $imageName);
        //     $data['image'] = $imageName;
        // }

        // if ($request->hasFile('id_document')) {
        //     $idDocName = time() . '_iddoc.' . $request->id_document->extension();
        //     $request->id_document->move(public_path('benefries_images'), $idDocName);
        //     $data['id_document'] = $idDocName;
        // }

        if ($request->reg_type === 'Beneficiaries') {
            // Handle profile image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('benefries_images'), $imageName);
                $data['image'] = $imageName;
            }

            // Handle ID document upload
            if ($request->hasFile('id_document')) {
                $idDoc = $request->file('id_document');
                $idDocName = time() . '_iddoc.' . $idDoc->getClientOriginalExtension();
                $idDoc->move(public_path('benefries_images'), $idDocName);
                $data['id_document'] = $idDocName;
            }
            $beneficiarie = beneficiarie::create($data);
        } else if ($request->reg_type === 'Member') {
            Member::create($data);
        }

        return view('home.registration.success-registration', compact('beneficiarie'))->with('success', 'Registration saved successfully.');
    }

    public function onlineregistrationSetting()
    {
        $enabled = Setting::getValue('online_registration_enabled', '0') === '1';
        return view('ngo.registration.online-reg-setting', compact('enabled'));
    }

    public function toggleSetting(Request $request)
    {
        $status = $request->has('registration_enabled') ? '1' : '0';
        Setting::setValue('online_registration_enabled', $status);

        return redirect()->back()->with('success', 'Registration setting updated.');
    }
}
