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

    protected $primaryKey = 'comment_id';

    protected $fillable = [
        'content',
        'target_type',
        'target_id', 
        'user_id',
        'parent_id'
    ];

    protected $casts = [
    'target_type' => TargetType::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

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
        return $this->hasMany(Comment::class, 'parent_id')->with('user');
    }
}
