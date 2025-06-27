<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;

    protected $table = 'blogs';

    protected $primaryKey = 'blog_id';

    protected $fillable = [
        'title', 
        'content', 
        'image_path', 
        'category_id', 
        'created_by'
    ];

    public function related()
    {
        return Blog::where('category_id', $this->category_id)
            ->where('blog_id', '!=', $this->blog_id)
            ->take(3)
            ->get();
    }

    public function category()
    {
    return $this->belongsTo(Category::class, 'category_id');
    }

    public function comments() {
        return $this->morphMany(Comment::class, 'target');
    }
}
