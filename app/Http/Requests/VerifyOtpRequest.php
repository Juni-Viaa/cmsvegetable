<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class VerifyOtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone_number' => [
                'required',
                'string',
                'regex:/^\\+62[0-9]{9,13}$/',
                'max:20',
            ],
            'otp_code' => [
                'required',
                'string',
                'size:6',
                'regex:/^[0-9]{6}$/',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'phone_number.required' => 'Nomor telepon wajib diisi',
            'phone_number.regex' => 'Format nomor telepon tidak valid',
            'otp_code.required' => 'Kode OTP wajib diisi',
            'otp_code.size' => 'Kode OTP harus 6 digit',
            'otp_code.regex' => 'Kode OTP hanya boleh berisi angka',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validasi gagal',
            'errors' => $validator->errors(),
        ], 422));
    }
} 