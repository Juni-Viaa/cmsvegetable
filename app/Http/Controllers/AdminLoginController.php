<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('pages.loginadmin');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = DB::table('users')
            ->where('username', $request->username)
            ->where('role', 'admin')
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Session::put('admin_logged_in', true);
            Session::put('admin_id', $user->user_id);
            Session::put('admin_username', $user->username);

            return redirect('admin');
        }

        return redirect()->back()->with('error', 'Login gagal. Cek username atau password.');
    }

    public function logout()
    {
        Session::forget('admin_logged_in');
        Session::forget('admin_id');
        Session::forget('admin_username');

        return redirect()->route('admin.login')->with('success', 'Anda telah logout.');
    }
}

