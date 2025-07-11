<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    //
    protected $fillable = [
        'phone_number',
        'otp_code',
        'expires_at',
        'is_used'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean'
    ];

    // Check if OTP is still valid
    public function isValid()
    {
        return !$this->is_used && $this->expires_at > Carbon::now();
    }

    // Mark OTP as used
    public function markAsUsed()
    {
        $this->is_used = true;
        $this->save();
    }
}
