<?php

namespace App\Services;

use App\Models\OtpVerification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OtpService
{
    private $twilioSid;
    private $twilioToken;
    private $twilioWhatsappFrom;

    public function __construct()
    {
        $this->twilioSid = config('services.twilio.sid');
        $this->twilioToken = config('services.twilio.token');
        $this->twilioWhatsappFrom = config('services.twilio.whatsapp_from');
    }

    // Generate and send OTP
    public function sendOtp($phoneNumber)
    {
        try {
            // Check if phone number is valid
            if (!$this->isValidPhoneNumber($phoneNumber)) {
                return [
                    'success' => false,
                    'message' => 'Nomor telepon tidak valid. Gunakan format +62xxxxxxxxxx'
                ];
            }

            // Delete old OTPs for this phone number
            OtpVerification::where('phone_number', $phoneNumber)->delete();

            // Generate 6-digit OTP
            $otpCode = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

            // Save OTP to database (expires in 5 minutes)
            $otp = OtpVerification::create([
                'phone_number' => $phoneNumber,
                'otp_code' => $otpCode,
                'expires_at' => Carbon::now()->addMinutes(5),
                'is_used' => false
            ]);

            // Send OTP via WhatsApp
            $message = "Kode OTP Anda: {$otpCode}\n\nKode berlaku 5 menit.\nJangan bagikan kode ini ke siapa pun.";
            
            $result = $this->sendWhatsAppMessage($phoneNumber, $message);

            if ($result['success']) {
                Log::info('OTP sent successfully', ['phone' => $phoneNumber, 'otp_id' => $otp->id]);
                
                return [
                    'success' => true,
                    'message' => 'OTP berhasil dikirim ke WhatsApp Anda',
                    'otp_id' => $otp->id,
                    'expires_at' => $otp->expires_at->format('Y-m-d H:i:s')
                ];
            } else {
                // Delete OTP if sending failed
                $otp->delete();
                
                return [
                    'success' => false,
                    'message' => 'Gagal mengirim OTP: ' . $result['message']
                ];
            }

        } catch (\Exception $e) {
            Log::error('OTP send failed', ['error' => $e->getMessage(), 'phone' => $phoneNumber]);
            
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ];
        }
    }

    // Verify OTP
    public function verifyOtp($phoneNumber, $otpCode)
    {
        try {
            // Find the latest OTP for this phone number
            $otp = OtpVerification::where('phone_number', $phoneNumber)
                     ->where('otp_code', $otpCode)
                     ->where('is_used', false)
                     ->orderBy('created_at', 'desc')
                     ->first();

            if (!$otp) {
                return [
                    'success' => false,
                    'message' => 'Kode OTP tidak valid atau sudah digunakan'
                ];
            }

            // Check if OTP is expired
            if ($otp->expires_at < Carbon::now()) {
                return [
                    'success' => false,
                    'message' => 'Kode OTP sudah expired. Silakan minta kode baru.'
                ];
            }

            // Mark OTP as used
            $otp->markAsUsed();

            Log::info('OTP verified successfully', ['phone' => $phoneNumber, 'otp_id' => $otp->id]);

            return [
                'success' => true,
                'message' => 'OTP berhasil diverifikasi',
                'verified_at' => Carbon::now()->format('Y-m-d H:i:s')
            ];

        } catch (\Exception $e) {
            Log::error('OTP verification failed', ['error' => $e->getMessage(), 'phone' => $phoneNumber]);
            
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ];
        }
    }

    // Send WhatsApp message via Twilio
    private function sendWhatsAppMessage($phoneNumber, $message)
    {
        try {
            $url = "https://api.twilio.com/2010-04-01/Accounts/{$this->twilioSid}/Messages.json";
            
            $response = Http::asForm()
                ->withBasicAuth($this->twilioSid, $this->twilioToken)
                ->post($url, [
                    'From' => "whatsapp:{$this->twilioWhatsappFrom}",
                    'To' => "whatsapp:{$phoneNumber}",
                    'Body' => $message
                ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'WhatsApp message sent successfully'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to send WhatsApp message: ' . $response->body()
                ];
            }

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'WhatsApp service error: ' . $e->getMessage()
            ];
        }
    }

    // Validate phone number format
    private function isValidPhoneNumber($phoneNumber)
    {
        return preg_match('/^\+62[0-9]{9,13}$/', $phoneNumber);
    }
}