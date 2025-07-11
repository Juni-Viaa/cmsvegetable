<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'phone_number.required' => 'Nomor telepon wajib diisi',
            'phone_number.regex' => 'Format nomor telepon tidak valid. Gunakan +62xxxxxxxxxx',
            'phone_number.max' => 'Nomor telepon terlalu panjang',
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