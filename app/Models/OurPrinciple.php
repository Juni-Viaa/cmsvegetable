<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class OurPrinciple extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'principle_id';
    
    protected $fillable = [
        'name',
        'subtitle',
        'thumbnail',
        'icon',
        'created_by'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        return asset('images/no-image.png');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
