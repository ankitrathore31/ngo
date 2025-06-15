<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\beneficiarie;
use App\Models\Member;
use App\Models\academic_session;
use App\Models\Setting;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            // common rules
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
            'help_needed' => 'nullable|string|max:255', // default as optional
        ]);

        $validator->sometimes('help_needed', 'required|string|max:255', function ($input) {
            return $input->reg_type === 'Beneficiaries';
        });

        $validator->validate();



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

        if ($request->reg_type === 'Beneficiaries') {
            $prefix = '2191000';
            $latestBeneficiary = beneficiarie::where('application_no', 'LIKE', $prefix . '%')
                ->orderBy('application_no', 'desc')
                ->first();

            $lastSequenceBeneficiary = $latestBeneficiary
                ? (int)substr($latestBeneficiary->application_no, strlen($prefix))
                : 0;

            $sequence_number = $lastSequenceBeneficiary + 1;

            $data['application_no'] = $prefix . str_pad($sequence_number, 3, '0', STR_PAD_LEFT);

            // Handle profile image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('beneficiaries_images'), $imageName);
                $data['image'] = $imageName;
            }

            // Handle ID document upload
            if ($request->hasFile('id_document')) {
                $idDoc = $request->file('id_document');
                $idDocName = time() . '_iddoc.' . $idDoc->getClientOriginalExtension();
                $idDoc->move(public_path('beneficiaries_images'), $idDocName);
                $data['id_document'] = $idDocName;
            }

            beneficiarie::create($data);
        } else if ($request->reg_type === 'Member') {
            $prefix = '2191000';
            $latestMember = Member::where('application_no', 'LIKE', $prefix . '%')
                ->orderBy('application_no', 'desc')
                ->first();

            $lastSequenceMember = $latestMember
                ? (int)substr($latestMember->application_no, strlen($prefix))
                : 0;

            $sequence_number = $lastSequenceMember + 1;

            $data['application_no'] = $prefix . str_pad($sequence_number, 3, '0', STR_PAD_LEFT);

            // Handle profile image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('member_images'), $imageName);
                $data['image'] = $imageName;
            }

            // Handle ID document upload
            if ($request->hasFile('id_document')) {
                $idDoc = $request->file('id_document');
                $idDocName = time() . '_iddoc.' . $idDoc->getClientOriginalExtension();
                $idDoc->move(public_path('member_images'), $idDocName);
                $data['id_document'] = $idDocName;
            }

            Member::create($data);
        }


        return redirect()->route('pending-registration')->with('success', 'Registration saved successfully.');
    }

    public function editRegistration($id, $type)
    {
        if ($type === 'Member') {
            $record = Member::findOrFail($id);
        } else {
            $record = beneficiarie::findOrFail($id);
        }

        $data = academic_session::all();
        Session::put('all_academic_session', $data);

        return view('ngo.registration.edit-reg', compact('record', 'data', 'type'));
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
            // Handle new profile image upload (if any)
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_image'; // Add extension if needed
                $image->move(public_path('benefries_images'), $imageName);
                $data['image'] = $imageName;

                // Optional: delete old image
                // if ($imageName->image && file_exists(public_path('benefries_images/' . $data->image))) {
                //     unlink(public_path('benefries_images/' . $data->image));
                // }
            }

            // Handle new ID document upload (if any)
            if ($request->hasFile('id_document')) {
                $idDoc = $request->file('id_document');
                $idDocName = time() . '_iddoc'; // Add extension if needed
                $idDoc->move(public_path('benefries_images'), $idDocName);
                $data['id_document'] = $idDocName;

                // Optional: delete old ID document
                // if ($record->id_document && file_exists(public_path('benefries_images/' . $record->id_document))) {
                //     unlink(public_path('benefries_images/' . $record->id_document));
                // }
            }
            beneficiarie::where('id', $id)->update($data);
        } else if ($request->reg_type === 'Member') {
            Member::where('id', $id)->update($data);
        }

        return redirect()->route('pending-registration')->with('success', 'Registration updated successfully.');
    }

    public function viewRegistration($id, $type)
    {
        if ($type === 'Beneficiaries') {
            $record = beneficiarie::where('status', 0)->findorFail($id);
        } else {
            $record = Member::where('status', 0)->findorFail($id);
        }
        return view('ngo.registration.view-reg', compact('record'));
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

        $pendingbene = $queryBene->orderBy('created_at', 'asc')->get();
        $pendingmemeber = $queryMember->orderBy('created_at', 'asc')->get();
        $combined = $pendingbene->merge($pendingmemeber)->sortBy('created_at');
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

        $approvebeneficiarie = $queryBene->orderBy('created_at', 'asc')->get();
        $approvemember = $queryMember->orderBy('created_at', 'asc')->get();

        $data = academic_session::all();
        $combined = $approvebeneficiarie->merge($approvemember)->sortBy('created_at');
        return view('ngo.registration.apporve-reg-list', compact('data', 'approvebeneficiarie', 'approvemember', 'combined'));
    }

    public function approveStatus(Request $request, $type, $id)
    {
        $request->validate([
            'registration_date' => 'required|date',
        ]);

        if ($type === 'Beneficiaries') {
            $beneficiarie = beneficiarie::find($id);
            if (!$beneficiarie) {
                return back()->with('error', 'Beneficiarie not found.');
            }

            $beneficiarie->status = 1;
            $prefix = '2192000';

            $latest = beneficiarie::where('registration_no', 'LIKE', $prefix . '%')
                ->orderBy('registration_no', 'desc')
                ->first();

            $last_sequence = $latest ? (int)substr($latest->registration_no, strlen($prefix)) : 54;
            $sequence_number = $last_sequence + 1;

            $beneficiarie->registration_no = $prefix . str_pad($sequence_number, 3, '0', STR_PAD_LEFT);
            $beneficiarie->registration_date = Carbon::parse($request->registration_date);
            $beneficiarie->survey_status = 0;
            $beneficiarie->save();

            return redirect()->route('approve-registration')->with('success', 'Beneficiarie approved successfully.');
        } elseif ($type === 'Member') {
            $member = Member::find($id);
            if (!$member) {
                return back()->with('error', 'Member not found.');
            }

            $prefix = '2192000';

            $latest = Member::where('registration_no', 'LIKE', $prefix . '%')
                ->orderBy('registration_no', 'desc')
                ->first();

            $last_sequence = $latest ? (int)substr($latest->registration_no, strlen($prefix)) : 54;
            $sequence_number = $last_sequence + 1;

            $member->status = 1;
            $member->registration_no = $prefix . str_pad($sequence_number, 3, '0', STR_PAD_LEFT);
            $member->registration_date = Carbon::parse($request->registration_date);
            $member->save();

            return redirect()->route('approve-registration')->with('success', 'Member approved successfully.');
        }

        return redirect()->back()->with('error', 'Unknown registration type.');
    }


    public function showApporveReg($id, $type)
    {
        if ($type === 'Beneficiaries') {
            $record = beneficiarie::where('status', 1)->findorFail($id);
        } else {
            $record = Member::where('status', 1)->findorFail($id);
        }
        return view('ngo.registration.show-apporve-reg', compact('record'));
    }

    public function editApproveRegistration($id, $type)
    {

        if ($type === 'Member') {
            $record = Member::findOrFail($id);
        } else {
            $record = beneficiarie::findOrFail($id);
        }

        $data = academic_session::all();
        Session::put('all_academic_session', $data);

        return view('ngo.registration.edit-apporve-reg', compact('record', 'data', 'type'));
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
            // Handle new profile image upload (if any)
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_image'; // Add extension if needed
                $image->move(public_path('benefries_images'), $imageName);
                $data['image'] = $imageName;

                // Optional: delete old image
                // if ($record->image && file_exists(public_path('benefries_images/' . $record->image))) {
                //     unlink(public_path('benefries_images/' . $record->image));
                // }
            }

            // Handle new ID document upload (if any)
            if ($request->hasFile('id_document')) {
                $idDoc = $request->file('id_document');
                $idDocName = time() . '_iddoc'; // Add extension if needed
                $idDoc->move(public_path('benefries_images'), $idDocName);
                $data['id_document'] = $idDocName;

                // Optional: delete old ID document
                // if ($record->id_document && file_exists(public_path('benefries_images/' . $record->id_document))) {
                //     unlink(public_path('benefries_images/' . $record->id_document));
                // }
            }
            beneficiarie::where('id', $id)->update($data);
        } else if ($request->reg_type === 'Member') {
            // Handle new profile image upload (if any)
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_image'; // Add extension if needed
                $image->move(public_path('member_images'), $imageName);
                $data['image'] = $imageName;

                // Optional: delete old image
                // if ($record->image && file_exists(public_path('benefries_images/' . $record->image))) {
                //     unlink(public_path('benefries_images/' . $record->image));
                // }
            }

            // Handle new ID document upload (if any)
            if ($request->hasFile('id_document')) {
                $idDoc = $request->file('id_document');
                $idDocName = time() . '_iddoc'; // Add extension if needed
                $idDoc->move(public_path('member_images'), $idDocName);
                $data['id_document'] = $idDocName;

                // Optional: delete old ID document
                // if ($record->id_document && file_exists(public_path('benefries_images/' . $record->id_document))) {
                //     unlink(public_path('benefries_images/' . $record->id_document));
                // }
            }
            Member::where('id', $id)->update($data);
        }

        return redirect()->route('approve-registration')->with('success', 'Registration updated successfully.');
    }

    public function pendingStatus($type, $id)
    {
        if ($type === 'Beneficiaries') {
            $beneficiarie = Beneficiarie::find($id);

            if ($beneficiarie) {
                $beneficiarie->status = 0;
                $beneficiarie->save();

                return redirect()->back()->with('success', 'Beneficiarie marked as pending successfully.');
            }
        }

        if ($type === 'Member') {
            $member = Member::find($id);

            if ($member) {
                $member->status = 0;
                $member->save();

                return redirect()->back()->with('success', 'Member marked as pending successfully.');
            }
        }

        return redirect()->back()->with('error', 'Record not found or type is invalid.');
    }

    public function deleteRegistrationPage($id, $type)
    {

        if ($type === 'Beneficiaries') {
            $record = beneficiarie::find($id);
        } else {
            $record = Member::find($id);
        }
        return view('ngo.registration.delete-reg', compact('record'));
    }

    public function deleteRegistration(Request $request, $id, $type)
    {
        // Validate delete reason and date
        $request->validate([
            'reason' => 'required|string',
            'delete_date' => 'required|date',
        ]);

        // Find the record based on type
        if ($type === 'Beneficiaries') {
            $record = beneficiarie::find($id);
        } else if ($type === 'Member') {
            $record = Member::find($id);
        } else {
            return redirect()->back()->with('error', 'Invalid type provided.');
        }

        if (!$record) {
            return redirect()->back()->with('error', 'Record not found.');
        }

        // Update delete reason and date before deletion
        $record->delete_reason = $request->input('reason');
        $record->delete_date = Carbon::parse($request->input('delete_date'));
        $record->save();

        // Soft delete the record (ensure your model uses SoftDeletes)
        $record->delete();

        return redirect()->route('recover')->with('success', ucfirst($type) . ' registration deleted successfully.');
    }

    //   public function deleteAppRegistrationPage($id, $type)
    // {

    //     if ($type === 'Beneficiaries') {
    //         $record = beneficiarie::where('status', 0)->findorFail($id);
    //     } else {
    //         $record = Member::where('status', 0)->findorFail($id);
    //     }
    //     return view('ngo.registration.delete-reg', compact('record'));
    // }

    public function recover(Request $request)
    {
        $queryBene = beneficiarie::onlyTrashed();
        $queryMember = Member::onlyTrashed();

        // Apply filters
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

        $deletedBeneficiaries = $queryBene->get();
        $deletedMembers = $queryMember->get();
        $combined = $deletedBeneficiaries->merge($deletedMembers);
        $data = academic_session::all();

        return view('ngo.registration.recover-reg', compact('combined', 'deletedBeneficiaries', 'deletedMembers', 'data'));
    }


    public function recoverItem($id, $type)
    {
        if ($type === 'Beneficiaries') {
            $record = beneficiarie::onlyTrashed()->find($id);
        } elseif ($type === 'Member') {
            $record = Member::onlyTrashed()->find($id);
        } else {
            return redirect()->route('recover')->with('error', 'Invalid type provided.');
        }

        if (!$record) {
            return redirect()->route('recover')->with('error', 'Record not found in deleted items.');
        }

        // Restore the soft-deleted record
        $record->restore();

        return redirect()->route('recover')->with('success', ucfirst($type) . ' recovered successfully.');
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
        $validator = Validator::make($request->all(), [
            // common rules
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
            'help_needed' => 'nullable|string|max:255', // default as optional
        ]);

        // Conditionally require help_needed if reg_type is 'Beneficiaries'
        $validator->sometimes('help_needed', 'required|string|max:255', function ($input) {
            return $input->reg_type === 'Beneficiaries';
        });

        $validator->validate(); // Run validation

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

        if ($request->reg_type === 'Beneficiaries') {
            $prefix = '2191000';
            $latestBeneficiary = beneficiarie::where('application_no', 'LIKE', $prefix . '%')
                ->orderBy('application_no', 'desc')
                ->first();

            $lastSequenceBeneficiary = $latestBeneficiary
                ? (int)substr($latestBeneficiary->application_no, strlen($prefix))
                : 0;

            $sequence_number = $lastSequenceBeneficiary + 1;

            $data['application_no'] = $prefix . str_pad($sequence_number, 3, '0', STR_PAD_LEFT);

            // Handle profile image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('beneficiaries_images'), $imageName);
                $data['image'] = $imageName;
            }

            // Handle ID document upload
            if ($request->hasFile('id_document')) {
                $idDoc = $request->file('id_document');
                $idDocName = time() . '_iddoc.' . $idDoc->getClientOriginalExtension();
                $idDoc->move(public_path('beneficiaries_images'), $idDocName);
                $data['id_document'] = $idDocName;
            }

            $record =  beneficiarie::create($data);
        } else if ($request->reg_type === 'Member') {
            $prefix = '2191000';
            $latestMember = Member::where('application_no', 'LIKE', $prefix . '%')
                ->orderBy('application_no', 'desc')
                ->first();

            $lastSequenceMember = $latestMember
                ? (int)substr($latestMember->application_no, strlen($prefix))
                : 0;

            $sequence_number = $lastSequenceMember + 1;

            $data['application_no'] = $prefix . str_pad($sequence_number, 3, '0', STR_PAD_LEFT);

            // Handle profile image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('member_images'), $imageName);
                $data['image'] = $imageName;
            }

            // Handle ID document upload
            if ($request->hasFile('id_document')) {
                $idDoc = $request->file('id_document');
                $idDocName = time() . '_iddoc.' . $idDoc->getClientOriginalExtension();
                $idDoc->move(public_path('member_images'), $idDocName);
                $data['id_document'] = $idDocName;
            }

            $record = Member::create($data);
        }


        return view('home.registration.success-registration', compact('record'))->with('success', 'Registration saved successfully.');
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
