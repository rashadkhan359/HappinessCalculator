<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthenticateController extends Controller
{
    public function loginView()
    {
        return view('admin.auth.login');
    }

    public function loginPost(Request $request)
    {
        Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => 'required',
        ])->validate();

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return back()->with('error', 'Invalid email or password.');
        }

        $user = User::where('email', $request->email)->first();
        if ($user->role_id != 1) {
            Auth::logout();
            return back()->with('error', 'Access Denied.');
        }

        return redirect()->route('admin.dashboard');
    }

    public function logout()
	{
        Auth::logout();
        Session::flush();
        return redirect()->route('admin.login');
	}

}
