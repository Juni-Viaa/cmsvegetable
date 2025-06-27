<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    
    use HasFactory, SoftDeletes;

    protected $table = 'categories';

    protected $primaryKey = 'category_id';

    protected $fillable = [
        'category_name',
        'category_type',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'category_id');
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'category_id');
    }
}
