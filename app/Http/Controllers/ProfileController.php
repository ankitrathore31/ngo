<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function ChangePassword()
    {
        return view('ngo.profile.change-password');
    }
    public function UpdatePass(Request $request)
    {
        $validated = $request->validate([
            'new_password' => 'required|string|min:8|confirmed'
        ]);

        $user = Auth::user();

        // Update password in users table
        $user->password = Hash::make($request->new_password);
        $user->save();

        // If user_type is staff, also update password in staff model
        if ($user->user_type === 'staff' && $user->staff) {
            $user->staff->password = Hash::make($request->new_password);
            $user->staff->save();
        }

        return back()->with('success', 'Password changed successfully.');
    }
}
