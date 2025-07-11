<?php

namespace App\Http\Controllers;

use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\SendOtpRequest;
use App\Http\Requests\VerifyOtpRequest;

class OtpVerificationController extends Controller
{
    private $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    // Send OTP
    public function sendOtp(SendOtpRequest $request): JsonResponse
    {
        $phoneNumber = $request->input('phone_number');
        
        $result = $this->otpService->sendOtp($phoneNumber);
        
        return response()->json($result, $result['success'] ? 200 : 400);
    }

    // Verify OTP
    public function verifyOtp(VerifyOtpRequest $request): JsonResponse
    {
        $phoneNumber = $request->input('phone_number');
        $otpCode = $request->input('otp_code');
        
        $result = $this->otpService->verifyOtp($phoneNumber, $otpCode);
        
        return response()->json($result, $result['success'] ? 200 : 400);
    }
}