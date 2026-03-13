<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'user_type' => ['required']
        ]);


        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            'user_type' => $request->user_type
        ], $request->remember)) {

            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->user_type == 'Admin') {
                return redirect('/admin');
            } elseif ($user->user_type == 'ngo') {
                return redirect()->route('ngo');
            } elseif ($user->user_type == 'staff') {
                return redirect()->route('staff');
            } elseif ($user->user_type == 'member') {
                return redirect()->route('member');
            } elseif ($user->user_type == 'union') {
                return redirect()->route('union');
            }
        }

        return back()->withErrors([
            'email' => 'Invalid credentials'
        ])->withInput();
    }



    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
