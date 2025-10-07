<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $users = User::with('role')->get();

        return view('admin.user.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username'  => 'required|unique:users,username',
            'phone'     => 'required',
            'role_id'   => 'required|exists:roles,id',
            'password'  => 'required|min:5|confirmed',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'verified'  => 'nullable|boolean',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('profile_photos', 'public');
        }

        User::create([
            'username' => $request->username,
            'phone'    => $request->phone,
            'role_id'  => $request->role_id,
            'verified' => $request->boolean('verified'), // ✅ lebih aman
            'password' => Hash::make($request->password),
            'foto'     => $fotoPath,
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'username'  => 'required|unique:users,username,' . $user->id,
            'phone'     => 'required',
            'role_id'   => 'required|exists:roles,id',
            'password'  => 'nullable|min:5|confirmed',
            'verified'  => 'nullable|boolean',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['username', 'phone', 'role_id']);
        $data['verified'] = $request->boolean('verified'); // ✅ aman

        // password update opsional
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // handle foto
        if ($request->hasFile('foto')) {
            // hapus foto lama jika ada
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }
            $data['foto'] = $request->file('foto')->store('profile_photos', 'public');
        }

        $user->update($data);

        return redirect()->back()->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
        }
        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus');
    }
}
