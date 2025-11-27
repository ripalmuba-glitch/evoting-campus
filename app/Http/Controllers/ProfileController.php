<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        // Cek jika user admin, tampilkan layout admin. Jika voter, layout app.
        $layout = $user->role == 'admin' ? 'layouts.admin' : 'layouts.app';
        return view('profile.edit', compact('user', 'layout'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed', // Confirmed butuh input name="password_confirmation"
        ]);

        $user->name = $request->name;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save(); // Simpan perubahan (save() tersedia di Model User)

        return back()->with('status', 'Profil berhasil diperbarui!');
    }
}
