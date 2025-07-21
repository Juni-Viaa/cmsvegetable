<?php

namespace App\Http\Controllers;

use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\SendOtpRequest;
use App\Http\Requests\VerifyOtpRequest;

class OtpVerificationController extends Controller
{
    private $otpService;

    /**
     * Inject OtpService.
     * @param OtpService $otpService
     */
    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Show the OTP verification view (phone + OTP input).
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('pages.otp-verification');
    }

    /**
     * Handle phone number submission and send OTP.
     * Stores phone number in session for later use.
     * @param SendOtpRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendOtp(SendOtpRequest $request): JsonResponse
    {
        $phoneNumber = $request->input('phone_number');
        // Store phone number in session for later user creation
        session(['pending_registration_phone' => $phoneNumber]);
        $result = $this->otpService->sendOtp($phoneNumber);
        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /**
     * Handle OTP verification. If valid, create user and mark phone as verified.
     * Clears session after registration.
     * @param VerifyOtpRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyOtp(VerifyOtpRequest $request): JsonResponse
    {
        $phoneNumber = $request->input('phone_number');
        $otpCode = $request->input('otp_code');
        $result = $this->otpService->verifyOtp($phoneNumber, $otpCode);

        if ($result['success']) {
            $data = session('pending_registration');
            $phone = session('pending_registration_phone');
            if (!$data || !$phone) {
                return response()->json(['success' => false, 'message' => 'Registration data not found. Please restart the process.'], 400);
            }
            // Create user and mark phone as verified
            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name'  => $data['last_name'],
                'username'   => $data['username'],
                'password'   => Hash::make($data['password']),
                'phone_number' => $phone,
                'phone_verified_at' => now(),
            ]);
            // Clear session
            session()->forget(['pending_registration', 'pending_registration_phone']);
            return response()->json(['success' => true, 'message' => 'Registration successful! Please log in.']);
        } else {
            return response()->json(['success' => false, 'message' => $result['message']], 400);
        }
    }
}