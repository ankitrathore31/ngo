<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function addstaff(){
        $data = academic_session::all();
        return view('ngo.staff.add-staff', compact('data'));
    }

    public function storeStaff(Request $request){

        $request->validate([
            'session' => 'required|date',
            'application_date' => 'required|date',
            'joining_date' => 'required|date',
            'staff_code' => 'required',
            'position' => 'required',
            'name' => 'required',
            'dob' => 'required',
            'gender' => 'required|string|Male,Female,Other',
            'staff_code' => 'required',
        ]);
    }

    public function staffList(){
        $data = academic_session::all();
        return view('ngo.staff.staff-list', compact('data'));
    }
}
