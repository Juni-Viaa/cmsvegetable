<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register()
    {
        return view('pages.register');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'username'   => 'required|string|max:255|unique:users,username',
            'password'   => 'required|string|min:6|confirmed',
        ]);

        // Simpan user baru
        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'username'   => $validated['username'],
            'password'   => Hash::make($validated['password']),
        ]);

        \Log::info('Check $user instance:', [
        'user_object' => $user,
        'user_id' => $user->id,
        ]);

        // Simpan ID user ke sesi agar bisa diakses di register2
        session(['register_user_id' => $user->user_id]);

        

        return redirect('/register2')->with('success', 'Akun berhasil dibuat! Silakan lanjut isi nomor handphone');
    }
}
 