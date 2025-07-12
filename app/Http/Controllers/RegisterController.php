<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Show the registration form (basic info only).
     */
    public function register()
    {
        return view('pages.register');
    }

    /**
     * Handle registration form submission.
     * Validate and store data in session, then redirect to OTP verification.
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RegisterRequest $request)
    {
        // The RegisterRequest handles validation
        $validated = $request->validated();
        // Store registration data in session (do not create user yet)
        session(['pending_registration' => $validated]);
        // Redirect to OTP verification page
        return redirect()->route('otp.verification')->with('success', 'Silakan verifikasi nomor handphone Anda.');
    }
}
 