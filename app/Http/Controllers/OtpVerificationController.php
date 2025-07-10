<?php

namespace App\Http\Controllers;

use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OtpVerificationController extends Controller
{
    private $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function sendOtp(Request $request): JsonResponse
    {
        $request->validate([
            'phone_number' => 'required|string|regex:/^\+62[0-9]{9,13}$/'
        ]);

        $result = $this->otpService->generateOtp($request->phone_number);

        return response()->json($result, $result['success'] ? 200 : 400);
    }

    public function verifyOtp(Request $request): JsonResponse
    {
        $request->validate([
            'phone_number' => 'required|string|regex:/^\+62[0-9]{9,13}$/',
            'otp_code' => 'required|string|size:6'
        ]);

        $result = $this->otpService->verifyOtp(
            $request->phone_number,
            $request->otp_code
        );

        return response()->json($result, $result['success'] ? 200 : 400);
    }
}