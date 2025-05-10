<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Auth;
use App\Models\User;
use App\Models\Ngo;
use App\Models\academic_session;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AdminController extends Controller
{
    // public function login(Request $request){
    //     $credentials= $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);
    //     if (Auth::attempt($credentials)){
    //         return view('admin.AdminDashboard');
    //     }
    // }

    public function addngo()
    {
        return view('admin.ngo.add-ngo');
    }

    public function ngolist()
    {
        // $user = User::get();
        $ngo = Ngo::get();
        $inactiveNgo = Ngo::where('status', 0)->count();
        return view('admin.AdminDashboard', compact('ngo', 'inactiveNgo'));
    }

    public function sessionlist()
    {
        $data = academic_session::all();
        Session::put('all_academic_session', $data);
        return view('admin.session.session-list', compact('data'));
    }

    public function addsession()
    {
        return view('admin.session.add-session');
    }



    public function SaveSession(Request $request)
    {
        $request->validate([
            'session' => ['required', 'regex:/^\d{4}-\d{2}$/', 'unique:academic_sessions,session_date'],
        ]);



        // Create and save the session
        $session = new academic_session;
        $session->session_date = $request->session;
        $session->status = 1;
        $session->save();

        // Update session list in session storage
        Session::put('all_academic_session', academic_session::all());

        return redirect()->route('add-session')->with('Success','session "'.$session->session_date.  '"created successfully!');
    }

    public function editsession($id)
    {
        $session = academic_session::findOrFail($id);
        return view('admin.session.edit-session', compact('session'));
    }

    public function updatesession(Request $request, $id)
    {
        // Validate the session format and uniqueness (excluding the current record)
        $request->validate([
            'session' => ['required', 'regex:/^\d{4}-\d{2}$/', 'unique:academic_sessions,session_date,' . $id],
        ]);

        // Find the session to update
        $session = academic_session::findOrFail($id);

        // Update the session
        $session->session_date = $request->session;
        $session->status = 1;
        $session->save();

        // Update session list in session storage
        Session::put('all_academic_session', academic_session::all());

        return redirect()->route('session-list')->with('Success', 'Session "' . $request->session . '" updated successfully!');
    }

    public function deletesession($id)
{
    $session = academic_session::findOrFail($id);
    $session->delete();

    // Update session list in session storage
    Session::put('all_academic_session', academic_session::all());

    return redirect()->back()->with('Success', 'Session "' . $session->session_date . '" deleted successfully!');
}
}
