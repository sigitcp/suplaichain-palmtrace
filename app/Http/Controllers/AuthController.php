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

            // arahkan ke dashboard sesuai role
            switch ($user->role_id) {
                case 1:
                    return redirect()->route('admin.dashboard.index');
                case 2:
                    return redirect()->route('petani.dashboard.index');
                case 3:
                    return redirect()->route('pengepul.dashboard.index');
                case 4:
                    return redirect()->route('pks.dashboard.index');
                case 5:
                    return redirect()->route('refinery.peta.index');
                default:
                    Auth::logout();
                    return back()->withErrors(['username' => 'Role tidak dikenali!']);
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
