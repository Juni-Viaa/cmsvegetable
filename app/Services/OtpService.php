<?php

namespace App\Services;

use App\Models\OtpVerification;
use App\Services\WhatsAppService;
use Carbon\Carbon;

class OtpService
{
    private $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    public function generateOtp($phoneNumber)
    {
        // Hapus OTP lama untuk nomor ini
        OtpVerification::where('phone_number', $phoneNumber)
            ->where('is_verified', false)
            ->delete();

        // Generate OTP 6 digit
        $otpCode = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        // Simpan ke database
        $otp = OtpVerification::create([
            'phone_number' => $phoneNumber,
            'otp_code' => $otpCode,
            'expires_at' => Carbon::now()->addMinutes(5), // Berlaku 5 menit
            'attempts' => 0
        ]);

        // Kirim WhatsApp
        $message = "Kode OTP Anda adalah: $otpCode\n\nKode ini berlaku selama 5 menit.\n\nJangan bagikan kode ini kepada siapa pun.";
        
        $result = $this->whatsAppService->sendMessage($phoneNumber, $message);

        return [
            'success' => $result['success'],
            'otp_id' => $otp->id,
            'message' => $result['success'] ? 'OTP berhasil dikirim' : 'Gagal mengirim OTP',
            'error' => $result['error'] ?? null
        ];
    }

    public function verifyOtp($phoneNumber, $otpCode)
    {
        $otp = OtpVerification::where('phone_number', $phoneNumber)
            ->where('is_verified', false)
            ->latest()
            ->first();

        if (!$otp) {
            return [
                'success' => false,
                'message' => 'OTP tidak ditemukan'
            ];
        }

        if ($otp->isExpired()) {
            return [
                'success' => false,
                'message' => 'OTP telah kadaluarsa'
            ];
        }

        if (!$otp->canAttempt()) {
            return [
                'success' => false,
                'message' => 'Terlalu banyak percobaan. Silakan minta OTP baru'
            ];
        }

        if ($otp->otp_code !== $otpCode) {
            $otp->incrementAttempts();
            return [
                'success' => false,
                'message' => 'Kode OTP salah'
            ];
        }

        // OTP benar
        $otp->update(['is_verified' => true]);

        return [
            'success' => true,
            'message' => 'OTP berhasil diverifikasi'
        ];
    }
}