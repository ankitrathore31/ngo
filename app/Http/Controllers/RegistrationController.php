<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\beneficiarie;
use App\Models\Member;
use Carbon\Carbon;

class RegistrationController extends Controller
{
    public function registration()
    {
        $states = config('states');
        return view('ngo.registration.registration', compact('states'));
    }

    public function StoreRegistration(Request $request)
    {
        // die($request);
        // exit();
        $request->validate([
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

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('member_images'), $imageName);
            $data['image'] = $imageName;
        }

        if ($request->hasFile('id_document')) {
            $idDocName = time() . '_iddoc.' . $request->id_document->extension();
            $request->id_document->move(public_path('benefries_images'), $idDocName);
            $data['id_document'] = $idDocName;
        }

        if ($request->reg_type === 'Beneficiaries') {
            beneficiarie::create($data);
        } else if ($request->reg_type === 'Member') {
            Member::create($data);
        }

        return redirect()->route('pending-registration')->with('success', 'Registration saved successfully.');
    }

    public function pendingRegistration()
    {

        $pendingbene = beneficiarie::where('status', 0)->get();
        $pendingmemeber = Member::where('status', 0)->get();
        return view('ngo.registration.pending-reg-list', compact('pendingbene', 'pendingmemeber'));
    }

    public function approveStatus(Request $request, $id)
    {
        $request->validate([
            'registration_date' => 'required|date_format:d-m-Y',
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
            $beneficiarie->registration_date = Carbon::createFromFormat('d-m-Y', $request->registration_date)->toDateString();
            $beneficiarie->save();

            return redirect()->route('approve-registration')->with('success', 'Beneficiarie approved successfully.');
        }

        $member = Member::find($id);
        if ($member && $member->reg_type === 'Member') {
            $member->status = 1;
            $prefix = '2192000';
            $sequence_number = 55;
            $member->registration_no = $prefix . str_pad($sequence_number, 3, '0', STR_PAD_LEFT);
            $member->registration_date = Carbon::createFromFormat('d-m-Y', $request->registration_date)->format('Y-m-d');
            $member->save();

            return redirect()->back()->with('success', 'Member approved successfully.');
        }

        return redirect()->back()->with('error', 'Record not found or unknown type.');
    }



    public function approveRegistration()
    {
        $approvebeneficiarie = beneficiarie::where('status', 1)->get();
        $approvegmemeber = Member::where('status', 1)->get();
        return view('ngo.registration.apporve-reg-list', compact('approvebeneficiarie', 'approvegmemeber'));
    }

    public function pendingStatus($id)
    {
        $beneficiarie = beneficiarie::find($id);
        if ($beneficiarie && $beneficiarie->reg_type === 'beneficiaries') {
            $beneficiarie->status = 0;
            $beneficiarie->save();

            return redirect()->back()->with('success', 'Beneficiarie approved successfully.');
        }

        // If not found, try member
        $member = Member::find($id);
        if ($member && $member->reg_type === 'member') {
            $member->status = 0;
            $member->save();

            return redirect()->back()->with('success', 'Member approved successfully.');
        }

        return redirect()->back()->with('error', 'Record not found or unknown type.');
    }

    public function viewRegistration($id)
    {

        $beneficiarie = beneficiarie::find($id);
        return view('ngo.registration.view-reg', compact('beneficiarie'));
    }

    public function editRegistration($id)
    {

        $beneficiarie = beneficiarie::find($id);
        return view('ngo.registration.edit-reg', compact('beneficiarie'));
    }

    public function deleteRegistration($id)
    {
        $beneficiarie = beneficiarie::find($id);

        if (!$beneficiarie) {
            return redirect()->back()->with('error', 'Record not found.');
        }

        // Delete image from storage
        // if ($beneficiarie->image && File::exists(public_path('uploads/beneficiaries/' . $beneficiarie->image))) {
        //     File::delete(public_path('uploads/beneficiaries/' . $beneficiarie->image));
        // }

        // Delete the database record
        $beneficiarie->delete();

        return redirect()->back()->with('success', 'Registration deleted successfully.');
    }
}
