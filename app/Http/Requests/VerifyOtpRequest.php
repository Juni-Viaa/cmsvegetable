<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Handles validation for verifying OTP (phone number and OTP code).
 */
class VerifyOtpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
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

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'phone_number.required' => 'Phone number is required.',
            'phone_number.regex' => 'Invalid phone number format. Use +62xxxxxxxxxx.',
            'phone_number.max' => 'Phone number is too long.',
            'otp_code.required' => 'OTP code is required.',
            'otp_code.size' => 'OTP code must be 6 digits.',
            'otp_code.regex' => 'OTP code must be numeric.',
        ];
    }

    /**
     * Return a JSON response on validation failure.
     * The 'message' will be the first error message for user clarity.
     */
    protected function failedValidation(Validator $validator)
    {
        $firstError = collect($validator->errors()->all())->first() ?: 'Validation failed.';
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => $firstError,
            'errors' => $validator->errors(),
        ], 422));
    }
} 