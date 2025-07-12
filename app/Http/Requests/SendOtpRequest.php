<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Handles validation for sending OTP (phone number input).
 */
class SendOtpRequest extends FormRequest
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
                'unique:users,phone_number',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'phone_number.required' => 'Phone number is required.',
            'phone_number.regex' => 'Invalid phone number format. Use +62xxxxxxxxxx.',
            'phone_number.max' => 'Phone number is too long.',
            'phone_number.unique' => 'This phone number is already registered.',
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