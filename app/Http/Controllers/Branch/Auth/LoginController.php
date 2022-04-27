<?php

namespace App\Http\Controllers\Branch\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:branch', ['except' => ['logout']]);
    }

    public function login()
    {
        return view('branch-views.auth.login');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (auth('branch')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->route('branch.dashboard');
        }

        return redirect()->back()->withInput($request->only('email', 'remember'))
            ->withErrors(['Credentials does not match.']);
    }

    public function logout(Request $request)
    {
        auth()->guard('branch')->logout();
        return redirect()->route('branch.auth.login');
    }
}
