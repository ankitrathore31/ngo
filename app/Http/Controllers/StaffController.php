<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\Position;
use App\Models\Sallary;
use App\Models\Signature;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function PositionList(){
        $position = Position::orderBy('position', 'asc')->get();

        return view('ngo.staff.position-list',compact('position'));
    }

    public function addPosition(){
        return view('ngo.staff.add-position');
    }

    public function StorePosition(Request $request){
        $validate = $request->validate([
            'position' => 'required|string',
        ]);

        $position = Position::create($validate);
        $position->save();

        return redirect()->back()->with('success', 'Position added successfully. ');
    }

    public function DeletePosition($id){

        $position = Position::findorFail($id);
        $position->delete();

        return redirect()->back()->with('success', 'Position delete successfully. ');
    }

    public function addstaff()
    {
        $data = academic_session::all();
        $lastStaff = \App\Models\Staff::orderBy('id', 'desc')->first();

        if ($lastStaff && preg_match('/(\d+SC)(\d+)/', $lastStaff->staff_code, $matches)) {
            $prefix = $matches[1]; // e.g. "3126SC"
            $lastNumber = (int) $matches[2]; // e.g. "0043" → 43
            $newNumber = $lastNumber + 1;
        } else {
            $prefix = '3126SC';
            $newNumber = 43; // starting number if no staff exists
        }

        $nextStaffCode = $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        $position = Position::orderBy('position', 'asc')->get();
        return view('ngo.staff.add-staff', compact('data', 'nextStaffCode','position'));
    }

    public function StoreStaff(Request $request)
    {
        $request->validate([
            'application_date' => 'required|date',
            'joining_date' => 'required|date',
            'session' => 'required|string',
            'staff_code' => 'required|string|unique:staff,staff_code',
            'email' => 'required|string|unique:staff,email',
            'position' => 'required|string',
            'name' => 'required|string',
            'dob' => 'required|date',
            'gender' => 'required|string',
            'marital_status' => 'required|string',
            'village' => 'required|string',
            'post' => 'required|string',
            'area_type' => 'required|string',
            'block' => 'required|string',
            'state' => 'required|string',
            'district' => 'required|string',
            'pincode' => 'required|numeric',
            'country' => 'required|string',
            'phone' => 'required|string',
            'caste' => 'required|string',
            'caste_category' => 'required|string',
            'religion' => 'required|string',
            'occupation' => 'required|string',
            'identity_type' => 'required|string',
            'identity_no' => 'required|string',
            'eligibility' => 'required|string',
            'password' => 'required|string|min:6',
            'staff_permissions' => 'nullable|array',
            'image' => 'nullable|image',
            'id_document' => 'nullable|file',
            'experience_document' => 'nullable|file',
            'marksheet' => 'nullable|file',
        ]);

        // Find the last staff record
        $lastStaff = \App\Models\Staff::orderBy('id', 'desc')->first();

        if ($lastStaff && preg_match('/(\d+SC)(\d+)/', $lastStaff->staff_code, $matches)) {
            $prefix = $matches[1]; // e.g. "3126SC"
            $lastNumber = (int) $matches[2]; // e.g. "0043" → 43
            $newNumber = $lastNumber + 1;
        } else {
            $prefix = '3126SC';
            $newNumber = 43;
        }

        $staff = new Staff();
        $staff->application_date = $request->application_date;
        $staff->joining_date = $request->joining_date;
        $staff->academic_session = $request->session;
        $staff->staff_code = $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        $staff->position = $request->position;
        $staff->name = $request->name;
        $staff->dob = $request->dob;
        $staff->gender = $request->gender;
        $staff->gurdian_name = $request->father_name;
        $staff->marital_status = $request->marital_status;
        $staff->village = $request->village;
        $staff->post = $request->post;
        $staff->area_type = $request->area_type;
        $staff->block = $request->block;
        $staff->state = $request->state;
        $staff->district = $request->district;
        $staff->pincode = $request->pincode;
        $staff->country = $request->country;
        $staff->email = $request->email;
        $staff->phone = $request->phone;
        $staff->caste = $request->caste;
        $staff->caste_category = $request->caste_category;
        $staff->religion = $request->religion;
        $staff->occupation = $request->occupation;
        $staff->identity_type = $request->identity_type;
        $staff->identity_no = $request->identity_no;
        $staff->eligibility = $request->eligibility;
        $staff->degree = $request->degree;
        $staff->experience = $request->experience;
        $staff->permissions = json_encode($request->staff_permissions ?? []);
        $staff->password = $request->password;

        // Ensure the 'public/images' folder exists or create it manually
        $destination = public_path('images');

        if ($request->hasFile('image')) {
            $imageName = time() . '_image.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($destination, $imageName);
            $staff->image = 'images/' . $imageName;
        }

        if ($request->hasFile('id_document')) {
            $idName = time() . '_id.' . $request->file('id_document')->getClientOriginalExtension();
            $request->file('id_document')->move($destination, $idName);
            $staff->id_document = 'images/' . $idName;
        }

        if ($request->hasFile('experience_document')) {
            $expName = time() . '_exp.' . $request->file('experience_document')->getClientOriginalExtension();
            $request->file('experience_document')->move($destination, $expName);
            $staff->experience_document = 'images/' . $expName;
        }

        if ($request->hasFile('marksheet')) {
            $markName = time() . '_mark.' . $request->file('marksheet')->getClientOriginalExtension();
            $request->file('marksheet')->move($destination, $markName);
            $staff->marksheet = 'images/' . $markName;
        }
        $staff->save();

        // fees save 


        $user = new User();
        $user->name = $staff->name;
        $user->email = $staff->email;
        $user->phone_number = $staff->phone;
        $user->password = Hash::make($request->password);
        $user->user_type = 'staff';
        $user->save();

        return redirect()->route('staff-list')->with('success', 'Staff added successfully!');
    }

    public function EditStaff($id)
    {
        $staff = Staff::findOrFail($id);
        $data = academic_session::all();
        $states = config('states');
        $existingPermissions = json_decode($staff->permissions ?? '[]', true);
        $position = Position::orderBy('position', 'asc')->get();
        return view('ngo.staff.edit-staff', compact('data', 'states', 'staff', 'existingPermissions','position'));
    }

    public function UpdateStaff(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $request->validate([
            'application_date' => 'required|date',
            'joining_date' => 'required|date',
            'session' => 'required|string',
            'staff_code' => 'required|string|unique:staff,staff_code,' . $staff->id,
            'email' => 'required|string|unique:staff,email,' . $staff->id,
            'position' => 'required|string',
            'name' => 'required|string',
            'dob' => 'required|date',
            'gender' => 'required|string',
            'marital_status' => 'required|string',
            'village' => 'required|string',
            'post' => 'required|string',
            'area_type' => 'required|string',
            'block' => 'required|string',
            'state' => 'required|string',
            'district' => 'required|string',
            'pincode' => 'required|numeric',
            'country' => 'required|string',
            'phone' => 'required|string',
            'caste' => 'required|string',
            'caste_category' => 'required|string',
            'religion' => 'required|string',
            'occupation' => 'required|string',
            'identity_type' => 'required|string',
            'identity_no' => 'required|string',
            'eligibility' => 'required|string',
            'password' => 'nullable|string|min:6',
            'staff_permissions' => 'nullable|array',
            'image' => 'nullable|image',
            'id_document' => 'nullable|file',
            'experience_document' => 'nullable|file',
            'marksheet' => 'nullable|file',
        ]);

        $staff->application_date = $request->application_date;
        $staff->joining_date = $request->joining_date;
        $staff->academic_session = $request->session;
        $staff->staff_code = $request->staff_code;
        $staff->position = $request->position;
        $staff->name = $request->name;
        $staff->dob = $request->dob;
        $staff->gender = $request->gender;
        $staff->gurdian_name = $request->father_name;
        $staff->marital_status = $request->marital_status;
        $staff->village = $request->village;
        $staff->post = $request->post;
        $staff->area_type = $request->area_type;
        $staff->block = $request->block;
        $staff->state = $request->state;
        $staff->district = $request->district;
        $staff->pincode = $request->pincode;
        $staff->country = $request->country;
        $staff->email = $request->email;
        $staff->phone = $request->phone;
        $staff->caste = $request->caste;
        $staff->caste_category = $request->caste_category;
        $staff->religion = $request->religion;
        $staff->occupation = $request->occupation;
        $staff->identity_type = $request->identity_type;
        $staff->identity_no = $request->identity_no;
        $staff->eligibility = $request->eligibility;
        $staff->degree = $request->degree;
        $staff->experience = $request->experience;
        $staff->permissions = json_encode($request->staff_permissions ?? []);

        $destination = public_path('images');

        // IMAGE
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($staff->image && file_exists(public_path($staff->image))) {
                unlink(public_path($staff->image));
            }

            $imageName = time() . '_image.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($destination, $imageName);
            $staff->image = 'images/' . $imageName;
        }

        // ID DOCUMENT
        if ($request->hasFile('id_document')) {
            if ($staff->id_document && file_exists(public_path($staff->id_document))) {
                unlink(public_path($staff->id_document));
            }

            $idName = time() . '_id.' . $request->file('id_document')->getClientOriginalExtension();
            $request->file('id_document')->move($destination, $idName);
            $staff->id_document = 'images/' . $idName;
        }

        // EXPERIENCE DOCUMENT
        if ($request->hasFile('experience_document')) {
            if ($staff->experience_document && file_exists(public_path($staff->experience_document))) {
                unlink(public_path($staff->experience_document));
            }

            $expName = time() . '_exp.' . $request->file('experience_document')->getClientOriginalExtension();
            $request->file('experience_document')->move($destination, $expName);
            $staff->experience_document = 'images/' . $expName;
        }

        // MARKSHEET
        if ($request->hasFile('marksheet')) {
            if ($staff->marksheet && file_exists(public_path($staff->marksheet))) {
                unlink(public_path($staff->marksheet));
            }

            $markName = time() . '_mark.' . $request->file('marksheet')->getClientOriginalExtension();
            $request->file('marksheet')->move($destination, $markName);
            $staff->marksheet = 'images/' . $markName;
        }

        // Update user if email is linked
        $user = User::where('email', $staff->email)->first();
        if ($user) {
            $user->name = $staff->name;
            $user->email = $staff->email;
            $user->phone_number = $staff->phone;

            if ($request->password) {
                $user->password = Hash::make($request->password);
                $staff->password = $request->password;
            }

            $user->save();
        }

        $staff->save();

        return redirect()->route('staff-list')->with('success', 'Staff updated successfully!');
    }

    public function staffList(Request $request)
    {
        $data = academic_session::all();
        $staffquery = Staff::query();

        if ($request->filled('session_filter')) {
            $staffquery->where('academic_session', $request->session_filter);
        }

        if ($request->filled('application_no')) {
            $staffquery->where('application_no', $request->application_no);
        }

        if ($request->filled('name')) {
            $staffquery->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('block')) {
            $staffquery->where('block', 'like', '%' . $request->block . '%');
        }

        if ($request->filled('state')) {
            $staffquery->where('state', $request->state);
        }

        if ($request->filled('district')) {
            $staffquery->where('district', $request->district);
        }

        $staff = $staffquery->orderBy('created_at', 'asc')->get();
        $states = config('states');
        return view('ngo.staff.staff-list', compact('states', 'data', 'staff'));
    }

    public function DeleteStaff($id)
    {
        $staff = Staff::findOrFail($id);

        // Delete related user (if any)
        $user = User::where('email', $staff->email)->first();
        if ($user) {
            $user->delete();
        }

        // Optionally delete files (if needed)
        $fileFields = ['image', 'id_document', 'experience_document', 'marksheet'];
        foreach ($fileFields as $field) {
            if (!empty($staff->$field) && file_exists(public_path($staff->$field))) {
                unlink(public_path($staff->$field));
            }
        }

        $staff->delete();

        return redirect()->route('staff-list')->with('success', 'Staff deleted successfully!');
    }


    public function ViewStaff($id)
    {
        $record = Staff::findorFail($id);
        $signatures = Signature::pluck('file_path', 'role');
        return view('ngo.staff.view-staff', compact('record', 'signatures'));
    }

    public function staffListLetter(Request $request)
    {
        $data = academic_session::all();
        $staffquery = Staff::query();

        if ($request->filled('session_filter')) {
            $staffquery->where('academic_session', $request->session_filter);
        }

        if ($request->filled('application_no')) {
            $staffquery->where('application_no', $request->application_no);
        }

        if ($request->filled('name')) {
            $staffquery->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('block')) {
            $staffquery->where('block', 'like', '%' . $request->block . '%');
        }

        if ($request->filled('state')) {
            $staffquery->where('state', $request->state);
        }

        if ($request->filled('district')) {
            $staffquery->where('district', $request->district);
        }

        $staff = $staffquery->orderBy('created_at', 'asc')->get();
        $states = config('states');
        return view('ngo.staff.staff-list-letter', compact('states', 'data', 'staff'));
    }

    public function ViewAppointment($id)
    {
        $staff = Staff::findorFail($id);
        $salary = Sallary::where('position', $staff->position)->first();
        $signatures = Signature::pluck('file_path', 'role');
        return view('ngo.staff.appointment-letter', compact('staff', 'signatures', 'salary'));
    }
}
