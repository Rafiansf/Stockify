<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            $role = strtolower(Auth::user()->role);

            // Redirect berdasarkan peran (role)
            if ($role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }

            if (in_array($role, ['manager', 'manager_gudang'])) {
                return redirect()->intended(route('manager.dashboard'));
            }

            if (in_array($role, ['staff', 'staff_gudang'])) {
                return redirect()->intended(route('staff.dashboard'));
            }

            // Jika role tidak dikenali oleh sistem
            Auth::logout();
            return back()->withErrors([
                'email' => 'Peran akun Anda tidak valid.',
            ]);
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}