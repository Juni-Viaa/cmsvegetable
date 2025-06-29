<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OtpCode;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class RegisterController3 extends Controller
{
    public function register3()
    {
        return view('pages.register3');
    }

    public function verifyOtp(Request $request)
    {
        // Validasi OTP dari form
        $request->validate([
            'otp' => 'required|digits:4',
        ]);

        // Ambil user_id dari session
        $userId = session('register_user_id');

        Log::info('Verifikasi OTP:', [
            'otp' => $request->otp,
            'user_id' => $userId
        ]);

        if (!$userId) {
            return redirect('/register')->with('error', 'Session tidak ditemukan. Silakan ulangi proses.');
        }

        // Cari kode OTP di database
        $otpRecord = OtpCode::where('user_id', $userId)
            ->where('otp_code', $request->otp)
            ->where('expires_at', '>', Carbon::now())
            ->latest()
            ->first();

        // Jika OTP tidak cocok
        if (!$otpRecord) {
            return back()->with('error', 'Kode OTP salah atau sudah kedaluwarsa.');
        }

        // OTP valid, bisa lanjut ke tahap selanjutnya
        return redirect('/')->with('success', 'Verifikasi berhasil!');
    }
}
