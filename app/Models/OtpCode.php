<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OtpCode extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'otp_code', 'expires_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
