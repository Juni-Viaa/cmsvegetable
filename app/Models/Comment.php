<?php

namespace App\Models;

use App\Enums\TargetType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    //
    use HasFactory, SoftDeletes;
    protected $table = 'comments';

    protected $fillable = [
    'content', 
    'user_id',
    'target_id',
    'target_type',
    'product_id',
    'blog_id', 
    'parent_id',
    ];

    protected $casts = [
    'target_type' => TargetType::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the parent target model (morphable relationship).
     *
     * This method defines a polymorphic relationship, allowing the comment
     * to belong to different types of models (e.g., Post, Video, etc.).
     */
    public function target()
    {
        return $this->morphTo();
    }
    
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
