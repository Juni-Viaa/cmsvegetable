<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OtpCode;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class RegisterController2 extends Controller
{
    public function register2()
    {
        Log::info('Step 2 - Masuk halaman register2', [
            'register_user_id' => session('register_user_id'),
        ]);

        return view('pages.register2');
    }

    public function store2(Request $request)
    {
        // Validasi nomor HP
        $request->validate([
            'phone' => 'required|string|max:20|unique:users,phone_number',
        ]);

        $userId = session('register_user_id');

        if (!$userId) {
            return redirect('/register')->with('error', 'Silakan isi data tahap 1 terlebih dahulu.');
        }

        try {
            $user = User::findOrFail($userId);

            // Update nomor HP
            $user->update([
                'phone_number' => $request->phone,
            ]);

            // Buat OTP 4 digit
            $otp = rand(1000, 9999);

            // Simpan ke tabel otp_codes
            OtpCode::create([
                'user_id'    => $user->user_id,
                'otp_code'   => $otp,
                'expires_at' => Carbon::now()->addMinutes(5),
            ]);

            // Format nomor: 08xxx → 628xxx
            $phone = preg_replace('/^0/', '62', $user->phone_number);

            // Ambil token dari config
            $token = config('services.fonnte.token');

            // Kirim pesan lewat API Fonnte
            $response = Http::withToken($token)->post('https://api.fonnte.com/send', [
                'target'  => $phone,
                'message' => "Kode OTP kamu adalah *$otp*.\nBerlaku selama 5 menit.",
            ]);

            // Cek status pengiriman
            if (!$response->successful()) {
                Log::error('Gagal mengirim OTP via Fonnte', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return back()->with('error', 'Gagal mengirim kode OTP ke WhatsApp Anda.');
            }

            Log::info('OTP berhasil dikirim ke WhatsApp', [
                'user_id' => $user->user_id,
                'phone'   => $phone,
                'otp'     => $otp,
            ]);

            return redirect('/register3')->with('success', 'Kode OTP telah dikirim ke WhatsApp Anda.');
        } catch (\Exception $e) {
            Log::error('Kesalahan saat proses OTP:', [
                'error' => $e->getMessage(),
            ]);
            return back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }
}
