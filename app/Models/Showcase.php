<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Showcase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'tagline',  
        'thumbnail',
        'about',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
