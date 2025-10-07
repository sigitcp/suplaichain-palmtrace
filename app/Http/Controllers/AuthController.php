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
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string|min:5',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // cek role
            if ($user->role_id == 1) {
                return "Login berhasil sebagai ADMIN dengan username: " . $user->username;
            } elseif ($user->role_id == 2) {
                return "Login berhasil sebagai PETANI dengan username: " . $user->username;
            } elseif ($user->role_id == 3) {
                return "Login berhasil sebagai PENGEPUL dengan username: " . $user->username;
            }
        }

        return back()->withErrors([
            'username' => 'Username atau password salah!',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }
}
