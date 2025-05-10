<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Ngo;
use App\Models\User;
use App\Models\academic_session;
use Illuminate\Support\Facades\Session;

class NgoController extends Controller
{

    public function boot()
    {
        View::composer('ngo.header.NgoHeader', function ($view) {
            $view->with('all_sessions', academic_session::orderBy('session_date', 'desc')->get());
        });
    }
    public function savengo(Request $request)
    {
        $request->validate([
            'established_date' => 'required|date',
            'ngo_name' => 'required|string|max:255',
            'founder_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:ngos,email',
            'phone_number' => 'required|string|max:10|unique:ngos,phone_number',
            'address' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'pin_code' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'post' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'package' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'email.unique' => 'This email is already registered with another account.',
            'phone_number.unique' => 'This number is already registered with another account.',
        ]);


        $ngo = new Ngo;

        $ngo->established_date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->established_date)->format('Y-m-d');
        $ngo->ngo_name = $request->ngo_name;
        $ngo->founder_name = $request->founder_name;
        $ngo->email = $request->email;
        $ngo->phone_number = $request->phone_number;
        $ngo->address = $request->address;
        $ngo->state = $request->state;
        $ngo->pin_code = $request->pin_code;
        $ngo->country = $request->country;
        $ngo->post = $request->post;
        $ngo->district = $request->district;
        $ngo->package = $request->package;
        $ngo->password = Hash::make($request->password);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $ngo->logo = $filename;
        }

        $ngo->save();

        $user = new User;

        $user->name = $request->ngo_name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->password = Hash::make($request->password);
        $user->user_type = 'ngo';

        $user->save();

        return redirect()->back()->with('success', 'NGO created successfully!');
    }

    public function toggleStatus($id)
    {
        $ngo = Ngo::findOrFail($id);


        $ngo->status = $ngo->status == 1 ? 0 : 1;
        $ngo->save();

        return redirect()->back()->with('success', 'NGO status updated successfully.');
    }

    public function editngo($id)
    {
        $ngo = Ngo::find($id);
        return view('admin.ngo.edit-ngo', compact('ngo'));
    }

    public function updatengo(Request $request, $id)
    {
        $request->validate([
            'established_date' => 'required|date',
            'ngo_name' => 'required|string|max:255',
            'founder_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:ngos,email' . $id,
            'phone_number' => 'required|string|max:10|unique:ngos,phone_number' . $id,
            'address' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'pin_code' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'post' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'package' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'email.unique' => 'This email is already registered with another account.',
            'phone_number.unique' => 'This number is already registered with another account.',
        ]);


        $ngo = Ngo::find($id);

        $ngo->established_date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->established_date)->format('Y-m-d');
        $ngo->ngo_name = $request->ngo_name;
        $ngo->founder_name = $request->founder_name;
        $ngo->email = $request->email;
        $ngo->phone_number = $request->phone_number;
        $ngo->address = $request->address;
        $ngo->state = $request->state;
        $ngo->pin_code = $request->pin_code;
        $ngo->country = $request->country;
        $ngo->post = $request->post;
        $ngo->district = $request->district;
        $ngo->package = $request->package;
        $ngo->password = Hash::make($request->password);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $ngo->logo = $filename;
        }

        $ngo->save();

        // $user = User::find();

        // $user->name = $request->ngo_name;
        // $user->email = $request->email;
        // $user->phone_number = $request->phone_number;
        // $user->password = Hash::make($request->password);
        // $user->user_type = 'ngo';

        // $user->save();

        return redirect()->back()->with('success', 'NGO update successfully!');
    }
}
