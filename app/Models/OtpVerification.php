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
        'is_verified',
        'attempts'
    ];

    protected $dates = ['expires_at'];

    public function isExpired()
    {
        return $this->expires_at < Carbon::now();
    }

    public function canAttempt()
    {
        return $this->attempts < 3;
    }

    public function incrementAttempts()
    {
        $this->increment('attempts');
    }
}
