<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    // Handle login request
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            session(['admin_id' => $admin->id]);
            return redirect()->route('admin.dashboard')->with('success', 'Login successful!');
        }

        return redirect()->back()->withErrors(['username' => 'Invalid credentials'])->withInput();
    }

    // Handle logout request
    public function logout()
    {
        session()->forget('admin_id');
        return redirect()->route('admin.login')->with('success', 'Logout successful!');
    }
}
